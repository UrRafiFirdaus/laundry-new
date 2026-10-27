<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PembayaranController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createCharge(Request $request) {
        $params = [
            'transaksi_detail' => [
                'order_id' => rand(),
                'gross_amount' => $request->amount,
            ],
            'customer_detail' => [
                'kode_customer' => $request -> kode_customer,
                'nama_customer' => $request -> nama_customer,
            ],
        ];
        $snapToken = Snap::getSnapToken($params);
        return response() -> json($snapToken);
    }

    public function createRefund(Request $request) {
        $params = [
            'transaksi_detail' => rand(),
            'kembalian' => $request -> amount,
        ]; 
    }
    
}

