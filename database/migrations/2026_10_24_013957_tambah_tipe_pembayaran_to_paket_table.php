<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paket', function (Blueprint $table) {
            // tunai | qris | bca_va | bni_va | bri_va | permata_va | mandiri_va | cimb_va
            $table->string('tipe_pembayaran', 20)->nullable()->after('status_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('paket', function (Blueprint $table) {
            $table->dropColumn('tipe_pembayaran');
        });
    }
};
