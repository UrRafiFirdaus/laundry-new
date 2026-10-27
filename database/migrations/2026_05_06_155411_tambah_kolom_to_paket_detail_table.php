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
        Schema::table('paket_detail', function (Blueprint $table) {
            $table->integer('harga')->after('id_kategori');
            $table->float('berat_minimal')->after('harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paket_detail', function (Blueprint $table) {
            $table->dropColumn([
                'harga',
                'berat_minimal'
            ]);
        });
    }
};
