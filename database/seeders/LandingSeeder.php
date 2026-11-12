<?php

namespace Database\Seeders;

use App\Models\LandingLayanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (LandingLayanan::count() > 0) {
            return;
        }

        $data = [
            ['Cuci Bersih', 'Pakaian bersih, segar, dan harum setiap hari. Dicuci dengan proses yang tepat agar kembali nyaman dipakai.', 'Mulai Rp 6.000 / Kg'],
            ['Cuci + Setrika', 'Bersih sekaligus rapi. Serahkan urusan mencuci dan menyetrika kepada kami.', 'Mulai Rp 8.000 / Kg'],
            ['Setrika Saja', 'Punya cucian bersih yang butuh dirapikan? Kami setrika hingga licin dan siap pakai.', 'Mulai Rp 5.000 / Kg'],
            ['Laundry Express', 'Butuh cepat? Selesai dalam hitungan jam dengan kualitas tetap terjaga.', 'Hubungi kami'],
        ];

        foreach ($data as $i => [$judul, $isi, $harga]) {
            LandingLayanan::create([
                'judul' => $judul, 'deskripsi' => $isi, 'harga_label' => $harga,
                'urutan' => $i + 1, 'aktif' => true,
            ]);
        }
    }
}
