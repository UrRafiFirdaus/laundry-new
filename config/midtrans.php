<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Kredensial Midtrans
    |--------------------------------------------------------------------------
    | Ambil dari dashboard Midtrans -> Settings -> Access Keys.
    | Sandbox dan Production punya key yang BERBEDA.
    */
    'merchant_id'   => env('MIDTRANS_MERCHANT_ID'),
    'client_key'    => env('MIDTRANS_CLIENT_KEY'),
    'server_key'    => env('MIDTRANS_SERVER_KEY'),

    // false = Sandbox (uji coba), true = Production (uang asli)
    'is_production' => (bool) env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized'  => true,
    'is_3ds'        => true,

    /*
    |--------------------------------------------------------------------------
    | Masa berlaku tagihan (menit)
    |--------------------------------------------------------------------------
    | Jika tagihan kedaluwarsa, tombol "Bayar" akan otomatis membuat tagihan baru.
    */
    'qris_expiry_minutes' => (int) env('MIDTRANS_QRIS_EXPIRY', 60),
    'va_expiry_minutes'   => (int) env('MIDTRANS_VA_EXPIRY', 1440), // 24 jam
];
