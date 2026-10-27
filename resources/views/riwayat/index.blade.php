@extends('layouts.master')

@section('title')
    Riwayat Transaksi
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Riwayat Transaksi</li>
@endsection

@push('scripts')
<!--<script>window.customerDataUrl = "{{ route('customer.data') }}";</script>-->
<script>window.riwayatDataUrl = '{{route('riwayat.data')}}';</script>
<script src="{{asset('js/riwayat/index.js')}}"></script>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <!--<div class="box-header with-border">
                <button onclick="addForm('')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i>Tambah Paket Baru</button>
            </div>-->
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered table-riwayat">
                    <thead>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Kode Paket</th>
                        <th>Nama</th>
                        <th>Tipe Laundry</th>
                        <th>Berat</th>
                        <th>Total Harga</th>
                        <th>Status Pembayaran</th>
                        <th>Status Paket </th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


