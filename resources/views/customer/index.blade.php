@extends('layouts.master')

@section('title')
    Customer
@endsection

@section('breadcrumb')
@parent
<li class="active">Customer</li>
@endsection

@push('scripts')
<script>window.customerDataUrl = "{{ route('customer.data') }}";</script>
<script src="{{asset('js/customer/index.js')}}"></script>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm('{{ route('customer.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i>Tambah</button>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kode Customer</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@includeIf('customer.form')
@endsection
