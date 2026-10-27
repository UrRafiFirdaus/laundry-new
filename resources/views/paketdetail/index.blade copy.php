@extends('layouts.master')

@section('title')
    Paket Baru
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Paket Baru</li>
@endsection

@push('scripts')
    <script src="{{ asset('js/paketdetail/index.js') }}"></script>
    <script>
        window.transaksiDataUrl = '{{ route('transaksi.data', ['id' => $paket->id_paket]) }}';
    </script>
    <script>
        window.transaksiStoreUrl = '{{ route('transaksi.store') }}';
    </script>
@endpush

@push('css')
    <style>
        .tampil-bayar {
            font-size: 5em;
            text-align: center;
            height: 100px;
        }

        .tampil-terbilang {
            padding: 10px;
            background: #f0f0f0;
        }

        .table-penjualan tbody tr:last-child {
            display: none;
        }

        @media(max-width: 768px) {
            .tampil-bayar {
                font-size: 3em;
                height: 70px;
                padding-top: 5px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-body">

                    <form action="{{ route('transaksi.simpan') }}" method="POST" class="form-paket">
                        @csrf
                        <div class="form-group row">
                            <label for="nama_customer" class="col-lg-2">Nama Customer</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <input type="hidden" name="id_paket" id="id_paket" value="{{ $paket->id_paket }}">
                                    <input type="hidden" name="id_customer" id="id_customer">
                                    <input type="hidden" name="total_harga" id="total_harga_hidden">
                                    <input type="hidden" name="status_paket" id="status_paket" value="menunggu antrian">
                                    <input type="text" name="nama_customer" id="nama_customer" class="form-control">
                                    <span class="input-group-btn">
                                        <button onclick="tampilCustomer()" class="btn btn-info btn-flat" type="button"><i
                                                class="fa fa-arrow-right"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="nama_customer" class="col-lg-2">Tipe Laundry</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <input type="hidden" name="id_kategori" id="id_kategori">
                                    <input type="hidden" id="harga">
                                    <input type="text" name="nama_kategori" id="nama_kategori" class="form-control"
                                        readonly>
                                    <span class="input-group-btn">
                                        <button onclick="tampilKategori()" class="btn btn-info btn-flat" type="button"><i
                                                class="fa fa-arrow-right"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="berat_total" class="col-lg-2">Berat Laundry</label>
                            <div class="col-lg-5">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="berat_total" id="berat_total"
                                        min="0" step="0.1" required>
                                    <span class="input-group-addon">Kg</span>
                                </div>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="tipe_pengambilan" class="col-lg-2">Tipe Pengambilan</label>
                            <div class="col-lg-5">
                                <select name="tipe_pengambilan" id="tipe_pengambilan" class="form-control" required>
                                    @foreach ($tipePengambilan as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status_pembayaran" class="col-lg-2">Status Pembayaran</label>
                            <div class="col-lg-5">
                                <select name="status_pembayaran" id="status_pembayaran" class="form-control" required>
                                    @foreach ($statusPembayaran as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="tipe_pembayaran" class="col-lg-2">Tipe Pembayaran</label>
                            <div class="col-lg-5">
                                <select name="tipe_pembayaran" id="tipe_pembayaran" class="form-control" required>
                                    <option value="tunai">Tunai</option>
                                    <option value="qris">QRIS</option>
                                    <option value="bni_va">BNI VA</option>
                                </select>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="telepon" class="col-lg-2 control-label">No Telpon</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="telepon" id="telepon">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-lg-2 control-label">Alamat</label>
                            <div class="col-lg-6">
                                <textarea name="alamat" id="alamat" rows="3" class="form-control"></textarea>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="total_harga" class="col-lg-2 control-label">Total Bayar</label>
                            <div class="col-lg-6">
                                <textarea id="total_harga" class="tampil-bayar" readonly></textarea>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i
                                    class="fa fa-floppy-o"></i> Simpan Paket Baru</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    @includeIf('paketdetail.kategori')
    @includeIf('paketdetail.customer')
@endsection
