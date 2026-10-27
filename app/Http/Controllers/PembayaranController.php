<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Pembayaran;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class PembayaranController extends Controller
{
    public function __construct(private MidtransService $midtrans)
    {
    }

    /**
     * Dipanggil tombol "Bayar" di halaman Cek Status.
     * Mengembalikan snap_token untuk membuka popup Midtrans Snap.
     */
    public function snap(string $kode_paket)
    {
        $paket = Paket::with('customer')->where('kode_paket', $kode_paket)->firstOrFail();

        if ($paket->status_pembayaran === 'sudah dibayar') {
            return response()->json(['paid' => true]);
        }

        try {
            $pembayaran = $this->midtrans->buatSnapToken($paket);
        } catch (Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['paid' => false, 'snap_token' => $pembayaran->snap_token]);
    }

    /**
     * Dipanggil JavaScript setelah popup Snap ditutup / pembayaran dilakukan.
     * Selain membaca database, juga menanyakan langsung ke Midtrans sehingga status
     * tetap ter-update walaupun webhook belum bisa masuk (mis. di localhost).
     */
    public function status(string $kode_paket)
    {
        $paket = Paket::where('kode_paket', $kode_paket)->firstOrFail();

        if ($paket->status_pembayaran === 'sudah dibayar') {
            return response()->json(['paid' => true, 'status' => Pembayaran::SETTLEMENT]);
        }

        $pembayaran = Pembayaran::where('id_paket', $paket->id_paket)
            ->orderByDesc('id_pembayaran')
            ->first();

        if ($pembayaran) {
            $pembayaran = $this->midtrans->sinkron($pembayaran);
            $paket->refresh();
        }

        return response()->json([
            'paid'   => $paket->status_pembayaran === 'sudah dibayar',
            'status' => $pembayaran->status ?? 'none',
        ]);
    }

    /**
     * Webhook (HTTP Notification) dari Midtrans.
     * URL: POST {APP_URL}/api/midtrans/notification
     */
    public function notifikasi(Request $request)
    {
        $payload = $request->all();

        if (! $this->midtrans->signatureValid($payload)) {
            Log::warning('Midtrans notifikasi: signature tidak valid', ['ip' => $request->ip()]);
            return response()->json(['message' => 'Signature tidak valid'], 403);
        }

        $pembayaran = Pembayaran::where('order_id', $payload['order_id'])->first();

        if (! $pembayaran) {
            return response()->json(['message' => 'Order tidak dikenal, diabaikan']);
        }

        $this->midtrans->terapkanStatus($pembayaran, $payload);

        return response()->json(['message' => 'OK']);
    }
}
