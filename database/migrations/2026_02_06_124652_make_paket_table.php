<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paket', function (Blueprint $table) {
            $table -> increments('id_paket'); //auto increment
            $table -> string('kode_paket') -> nullable();
            $table -> unsignedInteger('id_customer')->nullable(); //foreign key
            $table -> float('berat_total');
            $table -> integer('total_harga');
            $table -> enum('status_pembayaran', ['belum dibayar', 'sudah dibayar']) -> default('belum dibayar');
            $table -> enum('tipe_pengambilan', ['ambil ditempat', 'diantar']) -> default('diantar');
            $table -> enum('status_paket', [
                'menunggu antrian',
                'diproses',
                'siap diambil',
                'sedang diantar',
                'diterima'
            ])-> default('menunggu antrian');
            $table -> text('telepon')->nullable();
            $table -> text('alamat')->nullable();            
            $table -> integer('id_user');
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket');
    }
};
