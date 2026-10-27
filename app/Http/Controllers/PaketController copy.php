<?php

namespace App\Http\Controllers;

use App\Models\{
    Paket,
    Kategori,
    PaketDetail,
};
use PDF;

/*use App\Models\Setting;*/
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index() {
        $kategori = Kategori::all();

        return view('paket.index', compact('kategori'));
    }

    public function data() {
        $paket = Paket::with(['customer', 'detail.kategori'])
            ->whereNotNull('kode_paket')
            ->where('status_paket', '!=', 'diterima')
            ->orderBy('id_paket', 'desc')
            ->get();
        return datatables()
            ->of($paket)
            ->addIndexColumn()
            ->addColumn('select_all', function ($paket) {
                return '
                    <input type="checkbox" name="id_paket[]" value="'. $paket->id_paket .'">
                ';
            })
            ->addColumn('kode_paket', function($paket){
                if (
                    $paket->status_paket == 'menunggu antrian' ||
                    $paket->status_paket == 'diproses'
                ) {
                    $label = 'label-primary';
                } elseif (
                    $paket->status_paket == 'siap diambil' ||
                    $paket->status_paket == 'sedang diantar'
                ) {
                    $label = 'label-success';
                } else {
                    $label = 'label-default';
                }
                return '<span class="label '. $label .'">'. $paket -> kode_paket .'</span>';

            })
            ->addColumn('nama_customer', function($paket){
                return optional($paket->customer)->nama_customer ?? '-';
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
            ->addColumn('telepon', function($paket){
                return $paket -> telepon;
            })
            ->addColumn('alamat', function($paket){
                return $paket -> alamat;
            })
            ->addColumn('nama_kategori', function ($paket){
                if ($paket->detail->count() > 0) {
                    return $paket->detail
                        ->pluck('kategori.nama_kategori')
                        ->implode(', ');
                }
                return '-';
            })
            ->addColumn('aksi', function($paket) {
                return '
                <div class="btn-group">
                    <button type"button" onclick="showDetail(`'. route('paketbaru.show', $paket-> id_paket) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                    <button type"button" onclick="deleteData(`'. route('paketbaru.destroy', $paket -> id_paket) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    <button type"button" onclick="editForm(`'. route('paketbaru.edit', $paket-> id_paket) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type"button" onclick="updateStatus(`'. route('paketbaru.proses', $paket->id_paket) .'`, `'. $this->nextStatusLabel($paket) .'`)" class="btn btn-xs btn-primary btn-flat">'. $this -> nextStatusLabel($paket) .'</button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_paket', 'select_all'])
            ->make(true);
    }

    private function nextStatusLabel($paket) {
        if ($paket->tipe_pengambilan == 'ambil ditempat') {

            switch ($paket->status_paket) {
                case 'menunggu antrian':
                    return 'Proses';
                case 'diproses':
                    return 'Siap Diambil';
                case 'siap diambil':
                    return 'Selesaikan';
                default:
                    return 'Selesai';
            }
        } else {
            switch ($paket->status_paket) {
                case 'menunggu antrian':
                    return 'Proses';
                case 'diproses':
                    return 'Antar';
                case 'sedang diantar':
                    return 'Selesaikan';
                default:
                    return 'Selesai';
            }
        }
    }

    public function proses($id) {
        $paket = Paket::findOrFail($id);

        if ($paket->tipe_pengambilan == 'ambil ditempat') {
            switch ($paket->status_paket) {
                case 'menunggu antrian':
                    $paket->status_paket = 'diproses';
                    break;
                case 'diproses':
                    $paket->status_paket = 'siap diambil';
                    break;
                case 'siap diambil':
                    $paket->status_paket = 'diterima';
                    break;
            }
        } else {
            switch ($paket->status_paket) {
                case 'menunggu antrian':
                    $paket->status_paket = 'diproses';
                    break;
                case 'diproses':
                    $paket->status_paket = 'sedang diantar';
                    break;
                case 'sedang diantar':
                    $paket->status_paket = 'diterima';
                    break;
            }
        }
        $paket->update();
        return response()->json('Status diupdate', 200);
    }

    public function create() {
        Paket ::whereNull('kode_paket')
            ->where('berat_total', 0)
            ->where('total_harga', 0)
            ->where('id_user', auth()->id())
            ->doesntHave('detail')
            ->delete();

        $paket = new Paket();
        $paket -> kode_paket = null;
        $paket -> id_customer = null;
        $paket -> berat_total = 0;
        $paket -> total_harga = 0;
        $paket -> status_pembayaran = "belum dibayar";
        $paket -> tipe_pengambilan = "diantar";
        $paket -> status_paket = "menunggu antrian";
        $paket -> telepon = null;
        $paket -> alamat = null;
        $paket -> id_user = auth()->id();
        $paket -> save();

        session(['id_paket' => $paket -> id_paket]);
        return redirect()-> route('transaksi.index');

    }

    public function store(Request $request) {
        $tanggal = now() -> format('Ymd');
        $paket = Paket::findOrFail($request->id_paket);
        $lastPaket = Paket::whereDate('created_at', now()->toDateString())
            ->whereNotNull('kode_paket')
            ->orderBy('kode_paket', 'desc')
            ->first();

        if ($lastPaket) {
            $lastNumber = (int) substr($lastPaket->kode_paket, -2);
            $newNumber = $lastNumber +1;
        } else {
            $newNumber = 1;
        }

       $kode = 'P' . $tanggal . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
       $paket -> kode_paket         = $kode;
       $paket -> id_customer        = $request -> id_customer;
       $paket -> berat_total        = $request -> berat_total;
       $paket -> total_harga        = $request -> total_harga;
       $paket -> status_pembayaran  = $request -> status_pembayaran;
       $paket -> tipe_pengambilan   = $request -> tipe_pengambilan;
       $paket -> status_paket       = $request -> status_paket;
       $paket -> telepon            = $request -> telepon;
       $paket -> alamat             = $request -> alamat;
       $paket -> update();

       $detail = PaketDetail::where('id_paket', $paket -> id_paket)-> get();
       foreach ($detail as $item) {
        $kategori = Kategori::find($item -> id_kategori);
        $kategori -> update();
       }
       return redirect() -> route('transaksi.selesai');
    }

    public function complete() {

    }
    public function show($id) {
        $detail = PaketDetail::with(['kategori', 'paket.user']) -> where('id_paket', $id) -> get();
        return datatables()
        -> of ($detail)
        ->addIndexColumn()
        ->addColumn('nama_kategori', function ($detail){
            return optional($detail->kategori)->nama_kategori ?? '-';
        })
        ->addColumn('berat_minimal', function ($detail) {
            return optional($detail->kategori)-> berat_minimal . ' Kg';
        })
        ->addColumn('harga', function ($detail) {
            return 'Rp. ' . format_uang($detail->harga);
        })
        ->addColumn('tipe_pengambilan', function ($detail) {
            return optional($detail->paket)->tipe_pengambilan ?? '-';
        })
        ->addColumn('telepon', function ($detail) {
            return optional($detail->paket)->telepon ?? '-';
        })
        ->addColumn('alamat', function ($detail) {
            return optional($detail->paket)->alamat ?? '-';
        })
        ->addColumn('kasir', function ($detail) {
            return optional(optional($detail->paket)->user)->name ?? '-';
        })
        ->rawColumns([])
        ->make(true);

    }

    public function edit($id){
        $paket = Paket::find($id);

        return response()->json($paket);
    }

    public function selesai() {
        return view('paket.selesai');
    }

    public function update(Request $request, $id) {

        $paket = Paket::findOrFail($id);
        $paket -> update($request->all());

        return response() -> json([
            'success' => true,
            'message' => 'Data berhasil di edit!'
        ], 200);
    }

    public function destroy($id) {
        $paket = Paket::findOrFail($id);
        PaketDetail::where('id_paket', $paket->id_paket)->delete();

        $paket -> delete();
        return response(null, 203);
    }

    public function cetakKode(Request $request) {
        $datapaket = array();
        foreach ($request -> id_paket as $id) {
            $paket = Paket::find($id);
            $datapaket[] = $paket;
        }

        $no = 0;
        $pdf = PDF::loadView('paket.barcode', compact('datapaket', 'no'));
        $pdf -> setPaper('a3', 'portrait');
        return $pdf -> stream('paket.pdf');

    }
}


