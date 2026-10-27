<?php

namespace App\Http\Controllers;

use App\Models\{
    Kategori,
    Customer,
    Paket,
    User,
};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index () {
        $kategori = Kategori::count();
        $customer = Customer::count();
        $paket = Paket::whereIn('status_paket', [
            'menunggu antrian',
            'diproses',
            'siap diambil',
            'sedang diantar'
        ])->count();
        $user = User::count();


        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');


        $data_tanggal = array();
        $data_pendapatan = array();


        while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
            $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

            $pendapatan = Paket::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('total_harga');

            $data_pendapatan[] += $pendapatan;

            $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
        }


        if (auth() -> user() -> level == 1) {
            return view('admin.dashboard', compact('kategori', 'customer', 'paket', 'user', 'tanggal_awal', 'tanggal_akhir', 'data_tanggal', 'data_pendapatan'));
        } else {
            return view('kasir.dashboard');
        }

    }
}
