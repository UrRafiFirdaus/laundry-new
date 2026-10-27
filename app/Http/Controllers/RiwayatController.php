<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Paket,
    PaketDetail,
};

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('riwayat.index');
    }
    public function data() {
        $paket = Paket::with(['customer', 'detail.kategori'])
            ->where('status_paket', 'diterima') 
            ->orderBy('id_paket', 'desc')
            ->get();
        return datatables()
            ->of($paket)
            ->addIndexColumn()
            ->addColumn('tanggal', function($paket) {
                return  tanggal_indonesia($paket->created_at, false) . ' - ' . $paket->created_at->format('H:i');
            })
            ->addColumn('kode_paket', function($paket){
                return '<span class="label label-default">'. $paket -> kode_paket .'</span>'; 
            })
            ->addColumn('nama_customer', function($paket){
                return optional($paket->customer)->nama_customer ?? '-';
            })
            ->addColumn('nama_kategori', function ($paket){
                if ($paket->detail->count() > 0) {
                    return $paket->detail
                        ->pluck('kategori.nama_kategori')
                        ->implode(', ');
                }
                return '-';
            })
            ->addColumn('berat_total', function($paket){
                return $paket -> berat_total . ' Kg';
            })
            ->addColumn('total_harga', function($paket){
                return 'Rp. ' . format_uang($paket -> total_harga);
            })
            ->addColumn('status_pembayaran', function($paket){
                return $paket -> status_pembayaran;
            })
            ->addColumn('tipe_pengambilan', function($paket){
                return $paket -> tipe_pengambilan;
            })
            ->addColumn('status_paket', function($paket) {
                return $paket -> status_paket;
            })
            ->addColumn('aksi', function($paket) {
                return '
                <div class="btn-group">
                    <button onclick="showDetail(`'. route('paketbaru.show', $paket-> id_paket) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                    <button onclick="deleteData(`'. route('paketbaru.destroy', $paket -> id_paket) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    <!--<button onclick="" class="btn btn-xs btn-info btn-flat"><i class="fa fa-print"> Cetak Struk</i></button>-->
                </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_paket'])
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function notaKecil() {
        $paket = Paket::find(session('id_paket'));
        if (! paket) {
            abort(404);
        }
        $detail = PaketDetail::with('kategori')
            ->where('id_paket', session('id_paket'))
            ->get();
        return view('riwayat.nota_kecil', compact('paket', 'detail'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $paket = Paket::find($id);

        $paket -> delete();
        return response(null, 204);
    }
}
