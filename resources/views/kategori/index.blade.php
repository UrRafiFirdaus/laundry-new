@extends('layouts.master')

@section('title')
    Kategori Laundry
@endsection

@section('breadcrumb')
@parent
<li class="active">Kategori Laundry</li>
@endsection

@push('scripts')
<script>window.kategoriDataUrl="{{ route('kategori.data') }}"</script>
<script src="{{asset('js/kategori/index.js')}}"></script>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm('{{ route('kategori.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i>Tambah</button>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kategori Laundry</th>
                        <th>Berat Minimal</th>
                        <th>Harga</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@includeIf('kategori.form')
@endsection


