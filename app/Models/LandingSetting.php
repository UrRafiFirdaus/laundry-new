<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class LandingSetting extends Model
{
    protected $table = 'landing_setting';
    protected $guarded = [];

    /** Nilai bawaan - dipakai jika admin belum mengisi / mengosongkan. */
    public const DEFAULTS = [
        // Hero / banner
        'hero_badge'        => 'Laundry Kiloan & Satuan Terpercaya',
        'hero_judul'        => 'Pakaian Bersih, Wangi, dan Rapi — Tanpa Repot',
        'hero_subjudul'     => 'Serahkan cucian Anda kepada kami. Proses teliti, hasil bersih, dan status cucian bisa dilacak kapan saja secara online.',
        'hero_tombol_teks'  => 'Cek Status Laundry',
        'hero_tombol_link'  => '/status',
        'hero_tombol2_teks' => 'Lihat Layanan',
        'hero_tombol2_link' => '#layanan',
        'hero_gambar'       => null,
        'hero_overlay'      => '55',   // 0 - 90 (persen gelap)
        'warna_utama'       => '#0ea5e9',

        // Statistik
        'stat1_angka' => '1000+', 'stat1_label' => 'Pelanggan Puas',
        'stat2_angka' => '24 Jam', 'stat2_label' => 'Layanan Express',
        'stat3_angka' => '100%',  'stat3_label' => 'Wangi & Higienis',

        // Proses
        'proses_judul'    => 'Bagaimana Proses Kami?',
        'proses_subjudul' => 'Cepat, Mudah, Praktis, & Terpercaya',
        'langkah1_judul'  => 'Kami Terima Laundry Anda',
        'langkah1_isi'    => 'Bawa laundry Anda ke tempat kami. Kami mencatat dengan teliti agar setiap cucian mendapat penanganan yang tepat.',
        'langkah2_judul'  => 'Kami Proses Laundry Anda',
        'langkah2_isi'    => 'Cucian diproses dengan cermat sesuai layanan yang dipilih untuk menjaga kebersihan dan kenyamanannya.',
        'langkah3_judul'  => 'Laundry Siap Diambil',
        'langkah3_isi'    => 'Cucian siap diambil dalam kondisi bersih dan rapi. Pantau statusnya kapan saja lewat website kami.',

        // Layanan
        'layanan_judul'    => 'Layanan Kami',
        'layanan_subjudul' => 'Pilih layanan yang sesuai dengan kebutuhan Anda',

        // Tentang kami
        'tentang_judul'  => 'Tentang Kami',
        'tentang_isi'    => "Kami hadir sebagai solusi praktis untuk menjaga laundry Anda tetap bersih, harum, dan nyaman digunakan. Kami berkomitmen memberikan pelayanan terbaik dengan mengutamakan kebersihan dan kualitas hasil cucian.\n\nDengan pelayanan yang ramah dan proses pengerjaan yang teliti, kami membantu Anda menghemat waktu dan tenaga agar dapat lebih fokus pada aktivitas sehari-hari. Kepuasan Anda adalah prioritas kami.",
        'tentang_gambar' => null,
        'tentang_poin'   => "Pakaian dicuci terpisah sesuai jenis\nDeterjen & pewangi berkualitas\nPengerjaan tepat waktu\nStatus cucian bisa dilacak online",
        'visi'           => 'Menjadi layanan laundry pilihan utama yang dikenal bersih, rapi, dan terpercaya.',
        'misi'           => "Menjaga kualitas dan kebersihan setiap cucian\nMemberi pelayanan yang ramah dan cepat\nMemanfaatkan teknologi agar pelanggan mudah memantau cucian",

        // Halaman login
        'login_judul'    => 'Selamat Datang Kembali',
        'login_subjudul' => 'Masuk untuk mengelola transaksi dan layanan laundry.',
        'login_gambar'   => null,

        // CTA & kontak
        'cta_judul'       => 'Butuh Bantuan?',
        'cta_isi'         => 'Kami siap melayani Anda sepenuh hati.',
        'cta_tombol_teks' => 'Hubungi via WhatsApp',
        'jam_operasional' => 'Senin - Sabtu: 07.00 - 20.00',
        'whatsapp'        => null,   // jika kosong memakai nomor telepon dari Settings
        'instagram'       => null,
        'facebook'        => null,
        'tiktok'          => null,
        'maps_embed'      => null,   // URL embed Google Maps (src dari iframe)
    ];

    /** Semua pengaturan sebagai array (default + data DB). */
    public static function allKeyed(): array
    {
        return Cache::rememberForever('landing_setting_all', function () {
            $db = static::query()->pluck('value', 'key')->toArray();
            $out = self::DEFAULTS;
            foreach ($db as $k => $v) {
                if ($v !== null && $v !== '') {
                    $out[$k] = $v;
                }
            }
            return $out;
        });
    }

    public static function get(string $key, $default = null)
    {
        return static::allKeyed()[$key] ?? $default;
    }

    public static function setMany(array $data): void
    {
        foreach ($data as $k => $v) {
            if (!array_key_exists($k, self::DEFAULTS)) {
                continue;
            }
            static::updateOrCreate(['key' => $k], ['value' => $v]);
        }
        static::flush();
    }

    /** Link WhatsApp: pakai nomor khusus WA, kalau kosong pakai telepon dari Settings. */
    public static function waLink(?string $fallbackPhone = null, string $pesan = 'Halo, saya ingin bertanya tentang layanan laundry.'): ?string
    {
        $nomor = preg_replace('/\D+/', '', (string) (static::get('whatsapp') ?: $fallbackPhone));
        if ($nomor === '') {
            return null;
        }
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        } elseif (str_starts_with($nomor, '8')) {
            $nomor = '62' . $nomor;
        }

        return 'https://wa.me/' . $nomor . '?text=' . rawurlencode($pesan);
    }

    public static function flush(): void
    {
        Cache::forget('landing_setting_all');
    }
}

