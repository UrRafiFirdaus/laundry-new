@includeIf('landing.header')

@extends('landing.master')

@section('content')
<div class="container" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Lacak Status Laundry</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('status.cek') }}" method="GET" class="form-origin">
                        <div class="form-group">
                            <input type="text" name="kode_paket" id="kode_paket" class="single-input"
                                placeholder="Masukkan Kode Tranasksi" required value="{{ request('kode_paket') }}">
                        </div>
                        <div class="col-xs-4">
                            <button type="submit" class="genric-btn info circle">
                                <i class="fa fa-search"></i> Lacak Status
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            @if(isset($paket))
            <div class="card shadow mt-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Hasil Pelacakan</h4>
                </div>

                <div class="card-body">

                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Kode Laundry</th>
                            <td>{{ $paket->kode_paket }}</td>
                        </tr>

                        <tr>
                            <th>Nama Customer</th>
                            <td>{{ $paket->customer->nama_customer }}</td>
                        </tr>

                        <tr>
                            <th>Berat Total</th>
                            <td>{{ $paket-> berat_total }} Kg</td>
                        </tr>

                        <tr>
                            <th>Kategori Laundry</th>
                            <td>
                                @foreach($paket -> detail as $item)
                                {{ $item ->kategori->nama_kategori }}
                                @endforeach
                            </td>
                        </tr>

                        <tr>
                            <th>Total Harga</th>
                            <td>Rp. {{ format_uang($paket-> total_harga) }}</td>
                        </tr>

                        <tr>
                            <th>Status Pembayaran</th>
                            <td>{{ $paket-> status_pembayaran }}</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                @if($paket->status_paket == 'menunggu antrian')
                                <span class="badge badge-warning">
                                    Menunggu Antrian
                                </span>

                                @elseif($paket->status_paket == 'diproses')
                                <span class="badge badge-info">
                                    Diproses
                                </span>

                                @elseif($paket->status_paket == 'siap diambil')
                                <span class="badge badge-primary">
                                    Siap Diambil
                                </span>

                                @elseif($paket->status_paket == 'sedang diantar')
                                <span class="badge badge-secondary">
                                    Sedang Diantar
                                </span>

                                @elseif($paket->status_paket == 'diterima')
                                <span class="badge badge-success">
                                    Diterima
                                </span>

                                @else
                                <span class="badge badge-dark">
                                    {{ $paket->status_paket }}
                                </span>
                                @endif
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger mt-4">
                {{ session('error') }}
            </div>
            @endif

        </div>
    </div>
</div

@endsection

