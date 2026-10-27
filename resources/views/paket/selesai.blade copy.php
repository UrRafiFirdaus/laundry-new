@extends('layouts.master')

@section('title')
    Transaksi Selesai
@endsection


@section('breadcrumb')
    @parent
    <li class="active">Transaksi Selesai</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body">
                <div class="alert alert-success alert-dismissible">
                    <i class="fa fa-check icon"></i>
                    Data Transaksi telah selesai.
                </div>
            </div>
            <div class="box-footer">
                
                <button class="btn btn-warning btn-flat" onclick="#">Cetak Ulang Nota</button>
                
                <button class="btn btn-warning btn-flat" onclick="#">Cetak Struk</button>

                <a href="{{ route('daftarpaket.index') }}" class="btn btn-info btn-flat">Daftar Paket</a>
                
                <a href="{{ route('transaksi.baru') }}" class="btn btn-primary btn-flat">Transaksi Baru</a>
            </div>
        </div>
    </div>
</div>
@endsection