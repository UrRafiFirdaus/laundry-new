@extends('layouts.master')

@section('title')
    Daftar Paket
@endsection

@section('breadcrumb')
@parent
<li class="active">Daftar Paket</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="btn-group">
                    <button onclick="cetakBarcode('{{ route('paketbaru.cetakbarcode') }}')"
                        class="btn btn-info btn-xs btn-flat"><i class="fa fa-barcode"></i> Cetak Barcode
                    </button>
                </div>
            </div>
            <div class="box-body table-responsive">

                <form method="POST" class="form-paket">
                    @csrf
                </form>

                <table class="table table-stiped table-bordered table-paketbaru">
                    <thead>
                        <th width="5%">
                            <input type="checkbox" name="select_all" id="select_all">
                        </th>
                        <th width="5%">No</th>
                        <th>Kode Paket</th>
                        <th>Nama</th>
                        <th>Tipe Laundry</th>
                        <th>Berat</th>
                        <th>Total Harga</th>
                        <th>Status Pembayaran</th>
                        <th>Status Paket</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>

            </div>
        </div>
    </div>
</div>
@includeIf('paket.detail')
@includeIf('paket.form')
@endsection

@push('scripts')
<script>
    window.paketbaruDataUrl = '{{route('paketbaru.data')}}';
    window.basePaketUrl = '{{url('/paketbaru')}}';
    window.csrfToken = '{{csrf_token()}}';
</script>
<script src="{{asset('js/paket/index.js')}}"></script>
@endpush

