<?php

namespace App\Http\Controllers;

use App\Models\{
    Kategori,
    Customer,
    Paket,
    PaketDetail,
};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaketDetailController extends Controller
{
    public function index() {
        $kategori = Kategori::all(); 
        
        $customer = Customer::all();

        $type = DB::select(" SHOW COLUMNS FROM paket WHERE Field = 'tipe_pengambilan'")[0]->Type;
        preg_match("/^enum\((.*)\)$/", $type, $matches);
        $tipePengambilan = str_getcsv($matches[1], ',', "'");

        $type = DB::select("SHOW COLUMNS FROM paket WHERE Field = 'status_pembayaran'")[0]->Type;
        preg_match("/^enum\((.*)\)$/", $type, $matches);
        $statusPembayaran = str_getcsv($matches[1], ',', "'");
        


        if ($id_paket = session('id_paket')) {
            $paket = Paket::find($id_paket);
            $customerSelected = $paket -> customer ?? new Customer();

            return view('paketdetail.index', compact('kategori', 'tipePengambilan', 'statusPembayaran', 'customer', 'id_paket', 'paket', 'customerSelected'));
        } else {
            if (auth()->user()->level == 1){
                return redirect() ->route('transaksi.baru');
            } else {
                return redirect() -> route('home');
            }
        }
    }

    public function create() {
        
    }

    public function data($id)
    {
        $detail = PaketDetail::with('kategori')
            ->where('id_paket', $id)
            ->get();

        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['id_kategori']     = '<span class="label label-success">'
                                . optional($item->kategori)->id_kategori ?? '-' .
                                '</span>';
            $row['nama_kategori']   = optional($item->kategori)->nama_kategori ?? '-';
            $row['harga']           = 'Rp. '. format_uang($item->harga);
            $row['berat_minimal']   = optional($item->kategori)->berat_minimal . 'Kg';
            $row['aksi']            = '<div class="btn-group">
                                        <button onclick="deleteData(`'. route('paketdetail.destroy', $item->id_paket_detail) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                        </div>';
            $data[] = $row;
        }
        $data[] = [
            'id_kategori' => '
                <div class="total hide">'. $total .'</div>
                <div class="total_item hide">'. $total_item .'</div>',
            'nama_kategori'         => '',
            'harga'                 => '',
            'berat_minimal'         => '',
            'aksi'                  => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'id_kategori'])
            ->make(true);
    }

    public function store(Request $request) {
        $kategori = Kategori::where('id_kategori', $request->id_kategori)->first();
        if (! $kategori) {
            return response()->json('Data gagal disimpan', 400);
        }
        $detail = new PaketDetail();
        $detail->   id_paket        = $request        ->id_paket;
        $detail->   id_kategori     = $kategori       ->id_kategori;
        $detail->   harga           = $kategori       ->harga;
        $detail->   berat_minimal   = $kategori       ->berat_minimal;
        $detail ->  id_user         = auth()->id();
        $detail->save();

        return response()->json('Data berhasil disimpan', 200);

    }

    public function destroy($id) {
        $detail = PaketDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }


   
} 




