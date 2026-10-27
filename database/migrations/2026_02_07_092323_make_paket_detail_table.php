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
        Schema::create('paket_detail', function (Blueprint $table){
            $table -> increments('id_paket_detail');
            $table -> unsignedInteger('id_paket');
            $table -> unsignedInteger('id_kategori'); //foreign key
            $table -> timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExits('paket_detail');
    }
};
