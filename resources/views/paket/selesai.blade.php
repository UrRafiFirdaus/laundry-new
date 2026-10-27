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

                    @if (isset($paket) && $paket)
                        @if ($paket->status_pembayaran === 'sudah dibayar')
                            <div class="alert alert-info">
                                <i class="fa fa-money"></i>
                                Paket <strong>{{ $paket->kode_paket }}</strong> —
                                pembayaran
                                <strong>{{ \App\Services\MidtransService::label($paket->tipe_pembayaran) }}</strong>
                                sudah diterima.
                            </div>
                        @elseif (\App\Services\MidtransService::perluMidtrans($paket->tipe_pembayaran))
                            <div class="alert alert-warning">
                                <i class="fa fa-clock-o"></i>
                                Paket <strong>{{ $paket->kode_paket }}</strong> menunggu pembayaran
                                <strong>Non Tunai</strong>
                                sebesar <strong>Rp. {{ format_uang($paket->total_harga) }}</strong>.
                                <br>
                                Customer membayar lewat menu <em>Cek Status Laundry</em> di beranda
                                dengan memasukkan kode paket, lalu menekan tombol <strong>Bayar</strong>.
                                <br><br>
                                <a href="{{ route('status.cek', ['kode_paket' => $paket->kode_paket]) }}" target="_blank"
                                    class="btn btn-success btn-flat">
                                    <i class="fa fa-credit-card"></i> Buka Halaman Pembayaran
                                </a>
                            </div>
                        @endif
                    @endif
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
