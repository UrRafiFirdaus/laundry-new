<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->increments('id_pembayaran');
            $table->unsignedInteger('id_paket')->index();

            $table->string('order_id')->unique();         // order_id yang dikirim ke Midtrans
            $table->string('transaction_id')->nullable(); // id transaksi dari Midtrans
            $table->string('tipe', 20);                   // qris | bca_va | bni_va | ...
            $table->string('payment_type', 30);           // qris | bank_transfer | echannel
            $table->string('bank', 20)->nullable();

            $table->string('va_number')->nullable();      // nomor VA (BCA/BNI/BRI/Permata/CIMB)
            $table->string('biller_code')->nullable();    // Mandiri Bill: kode perusahaan
            $table->string('bill_key')->nullable();       // Mandiri Bill: kode bayar

            $table->text('qr_string')->nullable();        // isi QRIS (dirender jadi gambar)
            $table->text('qr_url')->nullable();           // URL gambar QR dari Midtrans

            $table->integer('gross_amount');
            // pending | settlement | expire | cancel | deny | failure
            $table->string('status', 20)->default('pending');
            $table->dateTime('expiry_time')->nullable();
            $table->dateTime('paid_at')->nullable();

            $table->longText('raw_response')->nullable(); // jejak respons Midtrans (debug)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
