<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index() {
        return view('customer.index');
    }
    public function store(Request $request) {
        $customer = Customer::latest()->first() ?? new Customer();
        $request['kode_customer'] = 'CS'. tambah_nol_didepan((int)$customer->id_customer+1, 6);

        $customer = Customer::create($request  -> all());
        return response()->json('Data customer baru telah disimpan!', 200);

    }
    public function data() {
        $customer = Customer::orderBy('id_customer', 'desc') -> get();
        return datatables()
            -> of($customer)
            -> addIndexColumn()
            -> addColumn('select_all', function($customer) {
                return '
                    <input type="checkbox" name="id_customer[]" value="'. $customer -> id_customer.'" >
                ';
            })
            ->addColumn('kode_customer', function($customer) {
                return '<span class="label label-success">'. $customer-> kode_customer .'</span>';
            })
            ->addColumn('nama_customer', function($customer) {
                return $customer-> nama_customer ;
            })
            ->addColumn('telepon', function($customer) {
                return $customer-> telepon ;
            })
            ->addColumn('alamat', function($customer) {
                return $customer -> alamat ;
            })
            -> addColumn('aksi', function($customer){
                return '
                 <div class="btn-group">
                    <button onclick="editForm(`'. route('customer.update', $customer->id_customer) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`'. route('customer.destroy', $customer->id_customer) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            }) -> rawColumns(['aksi', 'select_all', 'kode_customer'])
            -> make(true);
    }
    public function show($id) {
        $customer = Customer::find($id);
        return response()-> json($customer);
    }
    public function update (Request $request, $id) {
        $customer = Customer::find($id);
        $customer -> nama_customer = $request -> nama_customer;
        $customer -> telepon = $request -> telepon;
        $customer -> alamat = $request -> alamat;
        $customer -> update();
        return response() -> json('Data customer telah di ubah!', 200);
    }
    public function destroy($id) {
        $customer = Customer::find($id);
        $customer -> delete();
        return response(null, 204);
    }
}
