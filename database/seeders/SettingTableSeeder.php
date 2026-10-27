<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('setting')->insert([
            'id_setting' => 1,
            'nama_perusahaan' => 'Hamidah Laundry',
            'alamat' => 'Jl. Sekarputih, Desa. Kedundung, RT. 04 RW. 01, Kec. Magersari',
            'telepon' => '081234779987',
            'email' => 'hamidahlaundry@gmail.com',
            'tipe_nota' => 1, // kecil
            'path_logo' => '/img/logo.png',
        ]);
    }
}
