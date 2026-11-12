<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\{
    Setting,
    LandingSetting,
    LandingLayanan,
    Paket,
};
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(){
        $setting = Setting::first();
        $landing = LandingSetting::allKeyed();
        $layanan = LandingLayanan::tampil()->get();
        return view('landing.content', compact('setting', 'landing', 'layanan'));
    }

    public function status() {
        $setting = Setting::first();
        $landing = LandingSetting::allKeyed();
        return view('landing.status', compact('setting', 'landing'));
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

        $landing = LandingSetting::allKeyed();
        return view('landing.status', compact('paket', 'setting', 'landing'));
    }

    public function about(){
        $setting = Setting::first();
        $landing = LandingSetting::allKeyed();
        return view('landing.about', compact('setting', 'landing'));
    }

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

