<?php

namespace App\Services;

use App\Models\Paket;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use RuntimeException;

class MidtransService
{
    /** Pilihan tipe pembayaran di form paket baru. */
    public const METODE = [
        'tunai'    => ['label' => 'Tunai'],
        'nontunai' => ['label' => 'Non Tunai'],
    ];

    public function __construct()
    {
        Config::$serverKey    = (string) config('midtrans.server_key');
        Config::$isProduction = (bool) config('midtrans.is_production');
        Config::$isSanitized  = (bool) config('midtrans.is_sanitized');
        Config::$is3ds        = (bool) config('midtrans.is_3ds');
    }

    /* ------------------------------------------------------------------ */
    /*  Helper statis                                                      */
    /* ------------------------------------------------------------------ */

    public static function label(?string $tipe): string
    {
        if ($tipe === null || $tipe === '') {
            return '-';
        }
        return $tipe === 'tunai' ? 'Tunai' : 'Non Tunai';
    }

    /** Semua selain tunai dibayar lewat Midtrans (nilai lama seperti qris/bca_va ikut dianggap non tunai). */
    public static function perluMidtrans(?string $tipe): bool
    {
        return $tipe !== null && $tipe !== '' && $tipe !== 'tunai';
    }

    /* ------------------------------------------------------------------ */
    /*  Snap token                                                         */
    /* ------------------------------------------------------------------ */

    /** Tagihan Snap yang masih berlaku untuk paket ini (jika ada). */
    public function tagihanAktif(Paket $paket): ?Pembayaran
    {
        return Pembayaran::where('id_paket', $paket->id_paket)
            ->whereNotNull('snap_token')
            ->where('status', Pembayaran::PENDING)
            ->where(function ($q) {
                $q->whereNull('expiry_time')->orWhere('expiry_time', '>', now());
            })
            ->orderByDesc('id_pembayaran')
            ->first();
    }

    /**
     * Ambil snap token yang masih berlaku, atau buat baru di Midtrans.
     * Token yang sama dipakai ulang sehingga customer bisa membuka lagi popup (mis. untuk melihat nomor VA).
     *
     * @throws RuntimeException  pesan sudah aman ditampilkan ke pengguna
     */
    public function buatSnapToken(Paket $paket): Pembayaran
    {
        if ($paket->status_pembayaran === 'sudah dibayar') {
            throw new RuntimeException('Paket ini sudah dibayar.');
        }
        if (! self::perluMidtrans($paket->tipe_pembayaran)) {
            throw new RuntimeException('Pembayaran tunai dilakukan langsung di kasir.');
        }
        if (! config('midtrans.server_key')) {
            Log::error('MIDTRANS_SERVER_KEY belum diisi di .env');
            throw new RuntimeException('Pembayaran online belum dikonfigurasi. Hubungi kasir.');
        }

        // Kunci baris paket supaya dua klik bersamaan tidak membuat dua tagihan.
        return DB::transaction(function () use ($paket) {
            Paket::whereKey($paket->id_paket)->lockForUpdate()->first();

            if ($aktif = $this->tagihanAktif($paket)) {
                return $aktif;
            }

            $jumlah = (int) round($paket->total_harga);
            if ($jumlah < 1) {
                throw new RuntimeException('Total harga paket tidak valid.');
            }

            $orderId = $paket->kode_paket . '-' . strtoupper(Str::random(5));

            $params = [
                'transaction_details' => [
                    'order_id'     => $orderId,
                    'gross_amount' => $jumlah,
                ],
                'item_details' => [[
                    'id'       => (string) $paket->kode_paket,
                    'price'    => $jumlah,
                    'quantity' => 1,
                    'name'     => 'Laundry ' . $paket->kode_paket,
                ]],
                'customer_details' => [
                    'first_name' => optional($paket->customer)->nama_customer ?: 'Customer',
                ],
            ];
            if (! empty($paket->telepon)) {
                $params['customer_details']['phone'] = $paket->telepon;
            }

            try {
                $token = Snap::getSnapToken($params);
            } catch (\Throwable $e) {
                Log::error('Midtrans Snap gagal', ['paket' => $paket->kode_paket, 'message' => $e->getMessage()]);
                throw new RuntimeException(
                    config('app.debug')
                        ? 'Midtrans: ' . $e->getMessage()
                        : 'Pembayaran belum dapat dibuat. Silakan coba lagi atau hubungi kasir.',
                    0,
                    $e
                );
            }

            return Pembayaran::create([
                'id_paket'     => $paket->id_paket,
                'order_id'     => $orderId,
                'snap_token'   => $token,
                'tipe'         => $paket->tipe_pembayaran,
                'payment_type' => 'snap', // diperbarui saat customer memilih metode (dari notifikasi/cek status)
                'gross_amount' => $jumlah,
                'status'       => Pembayaran::PENDING,
                // Snap token berlaku 24 jam secara default; dibuat sedikit lebih singkat agar aman.
                'expiry_time'  => now()->addHours(23),
            ]);
        });
    }

    /* ------------------------------------------------------------------ */
    /*  Status & notifikasi                                                */
    /* ------------------------------------------------------------------ */

    /** Tanya langsung ke Midtrans status terbaru (polling & cadangan webhook). */
    public function sinkron(Pembayaran $pembayaran): Pembayaran
    {
        if (! $pembayaran->isPending()) {
            return $pembayaran;
        }

        try {
            $data = json_decode(json_encode(Transaction::status($pembayaran->order_id)), true);
            if (is_array($data)) {
                $this->terapkanStatus($pembayaran, $data);
            }
        } catch (\Throwable $e) {
            // 404 = customer belum memilih metode bayar di Snap (transaksi belum ada di Midtrans). Wajar.
            if (! str_contains($e->getMessage(), '404')) {
                Log::warning('Midtrans cek status gagal: ' . $e->getMessage(), ['order_id' => $pembayaran->order_id]);
            }
        }

        return $pembayaran->fresh();
    }

    /** Terapkan status dari Midtrans (webhook ATAU cek status). Aman dipanggil berulang. */
    public function terapkanStatus(Pembayaran $pembayaran, array $data): void
    {
        $status = $data['transaction_status'] ?? null;
        if (! $status) {
            return;
        }
        $fraud = $data['fraud_status'] ?? null;

        DB::transaction(function () use ($pembayaran, $data, $status, $fraud) {
            $p = Pembayaran::whereKey($pembayaran->getKey())->lockForUpdate()->first();
            if (! $p) {
                return;
            }

            if (isset($data['gross_amount']) && (int) round((float) $data['gross_amount']) !== (int) $p->gross_amount) {
                Log::warning('Midtrans: gross_amount tidak cocok', ['order_id' => $p->order_id, 'data' => $data]);
                return;
            }

            if ($p->isPaid()) {
                return; // yang sudah lunas tidak diturunkan lagi
            }
            if ($status === 'pending' && ! $p->isPending()) {
                return; // notifikasi pending yang telat tidak boleh menimpa expire/cancel
            }

            $dibayar = $status === 'settlement' || ($status === 'capture' && $fraud === 'accept');

            if (! empty($data['transaction_id'])) {
                $p->transaction_id = $data['transaction_id'];
            }
            if (! empty($data['payment_type'])) {
                $p->payment_type = $data['payment_type']; // qris, bank_transfer, gopay, dst.
            }
            if (! empty($data['va_numbers'][0])) {
                $p->bank      = $data['va_numbers'][0]['bank'] ?? $p->bank;
                $p->va_number = $data['va_numbers'][0]['va_number'] ?? $p->va_number;
            }

            if ($dibayar) {
                $p->status  = Pembayaran::SETTLEMENT;
                $p->paid_at = ! empty($data['settlement_time'])
                    ? Carbon::parse($data['settlement_time'], 'Asia/Jakarta')->setTimezone(config('app.timezone'))
                    : now();
            } else {
                $p->status = $status; // pending | expire | cancel | deny | failure
            }
            $p->save();

            if ($dibayar) {
                Paket::whereKey($p->id_paket)->update(['status_pembayaran' => 'sudah dibayar']);
            }
        });

        $pembayaran->refresh();
    }

    /** Verifikasi signature_key notifikasi Midtrans. */
    public function signatureValid(array $payload): bool
    {
        foreach (['order_id', 'status_code', 'gross_amount', 'signature_key'] as $k) {
            if (empty($payload[$k]) || ! is_scalar($payload[$k])) {
                return false;
            }
        }

        $expected = hash(
            'sha512',
            $payload['order_id'] . $payload['status_code'] . $payload['gross_amount'] . config('midtrans.server_key')
        );

        return hash_equals($expected, (string) $payload['signature_key']);
    }
}
