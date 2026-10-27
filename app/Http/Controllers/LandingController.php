<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Paket;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(){
        $setting = Setting::first();
        return view('landing.content', compact('setting'));
    }

    public function status() {
        $setting = Setting::first();
        return view('landing.status', compact('setting'));
    }

    public function cekStatus(Request $request) {
        $setting = Setting::first();
        $paket = Paket::with(['customer', 'kategori'])
            ->where('kode_paket', $request->kode_paket)
            ->first();

        if (!$paket) {
            return redirect()
                ->back()
                ->with('error', 'Kode paket tidak ditemukan');
        }

        return view('landing.status', compact('paket', 'setting'));
    }

    public function about(){
        $setting = Setting::first();
        return view('landing.about', compact('setting'));
    }

    /*public function cekStatus(Request $request)
    {
        $setting = Setting::first();

        $paket = Paket::with(['customer', 'kategori'])
            ->where('kode_paket', $request->kode_paket)
            ->first();

        if (!$paket) {
            return redirect()
                ->back()
                ->with('error', 'Kode paket tidak ditemukan');
        }

        return view('landing.status', compact('paket', 'setting'));
    }*/
}
