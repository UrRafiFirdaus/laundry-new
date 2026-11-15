@extends('layouts.master')

@section('title')
    Transaksi Baru
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Paket Baru</li>
@endsection

@push('scripts')
    <script>
        window.transaksiDataUrl = '{{ route('transaksi.data', ['id' => $paket->id_paket]) }}';
        window.transaksiStoreUrl = '{{ route('transaksi.store') }}';
    </script>
    <script src="{{ asset('js/paketdetail/index.js') }}?v={{ filemtime(public_path('js/paketdetail/index.js')) }}"></script>
@endpush

@push('css')
    <style>
        :root {
            --trx-primary: #2563eb;
            --trx-primary-dark: #1e3a8a;
            --trx-accent: #06b6d4;
            --trx-ok: #16a34a;
            --trx-warn: #f59e0b;
            --trx-border: #e5e7eb;
            --trx-muted: #6b7280;
        }

        /* ---------- Kartu section ---------- */
        .trx-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, .08), 0 4px 14px rgba(15, 23, 42, .04);
            margin-bottom: 18px;
            overflow: hidden;
        }

        .trx-card-head {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            border-bottom: 1px solid var(--trx-border);
            background: linear-gradient(90deg, #f8fafc, #fff);
        }

        .trx-step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--trx-primary);
            color: #fff;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: none;
        }

        .trx-card-head h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
        }

        .trx-card-head small {
            display: block;
            color: var(--trx-muted);
            font-weight: 400;
        }

        .trx-card-body {
            padding: 20px;
        }

        .trx-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--trx-muted);
            margin-bottom: 6px;
            display: block;
        }

        .trx-card .form-control {
            height: 42px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            box-shadow: none;
            transition: border-color .15s, box-shadow .15s;
        }

        .trx-card textarea.form-control {
            height: auto;
        }

        .trx-card .form-control:focus {
            border-color: var(--trx-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .15);
        }

        .trx-card .form-control[readonly] {
            background: #f8fafc;
        }

        .trx-field {
            margin-bottom: 16px;
        }

        .trx-field i.fi {
            color: var(--trx-muted);
            margin-right: 4px;
        }

        /* ---------- Toggle pelanggan lama / baru ---------- */
        .trx-question {
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .trx-seg {
            display: flex;
            gap: 10px;
            margin-bottom: 18px;
        }

        .trx-seg button {
            flex: 1;
            border: 2px solid var(--trx-border);
            background: #fff;
            border-radius: 10px;
            padding: 12px 10px;
            font-weight: 600;
            color: #374151;
            cursor: pointer;
            transition: all .18s;
            outline: none;
        }

        .trx-seg button i {
            display: block;
            font-size: 20px;
            margin-bottom: 4px;
            color: var(--trx-muted);
        }

        .trx-seg button:hover {
            border-color: #93c5fd;
        }

        .trx-seg button.active {
            border-color: var(--trx-primary);
            background: #eff6ff;
            color: var(--trx-primary-dark);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }

        .trx-seg button.active i {
            color: var(--trx-primary);
        }

        /* ---------- Customer terpilih ---------- */
        .trx-picked {
            display: none;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 10px;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            margin-bottom: 16px;
            animation: trxPop .25s ease;
        }

        .trx-picked .av {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--trx-ok);
            color: #fff;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: none;
        }

        .trx-picked .meta {
            flex: 1;
            min-width: 0;
        }

        .trx-picked .meta b {
            display: block;
        }

        .trx-picked .meta span {
            font-size: 12px;
            color: #047857;
        }

        .trx-hint-new {
            display: none;
            padding: 10px 14px;
            border-radius: 10px;
            background: #fffbeb;
            border: 1px solid #fde68a;
            color: #92400e;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .btn-cari-customer {
            width: 100%;
            height: 46px;
            border-radius: 10px;
            border: 2px dashed #93c5fd;
            background: #eff6ff;
            color: var(--trx-primary);
            font-weight: 600;
            margin-bottom: 16px;
            transition: all .15s;
        }

        .btn-cari-customer:hover {
            background: #dbeafe;
            border-style: solid;
        }

        /* ---------- Picker kategori ---------- */
        .trx-kategori {
            display: flex;
            align-items: center;
            gap: 14px;
            width: 100%;
            text-align: left;
            padding: 14px 16px;
            border: 2px dashed #93c5fd;
            border-radius: 10px;
            background: #eff6ff;
            cursor: pointer;
            transition: all .15s;
        }

        .trx-kategori:hover {
            background: #dbeafe;
        }

        .trx-kategori.terpilih {
            border-style: solid;
            border-color: var(--trx-primary);
            background: #fff;
        }

        .trx-kategori .ic {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: var(--trx-primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex: none;
        }

        .trx-kategori .tx {
            flex: 1;
            min-width: 0;
        }

        .trx-kategori .tx b {
            display: block;
            color: #0f172a;
        }

        .trx-kategori .tx span {
            color: var(--trx-muted);
            font-size: 13px;
        }

        /* ---------- Stepper berat ---------- */
        .trx-stepper {
            display: flex;
            align-items: stretch;
            gap: 8px;
        }

        .trx-stepper .btn-step {
            width: 46px;
            border: 1px solid #d1d5db;
            background: #fff;
            border-radius: 8px;
            font-size: 18px;
            color: var(--trx-primary);
            cursor: pointer;
            transition: all .12s;
        }

        .trx-stepper .btn-step:hover {
            background: #eff6ff;
            border-color: var(--trx-primary);
        }

        .trx-stepper .btn-step:active {
            transform: scale(.94);
        }

        .trx-stepper .input-group {
            flex: 1;
        }

        .trx-stepper input {
            text-align: center;
            font-size: 20px;
            font-weight: 700;
        }

        .trx-quick {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 10px;
        }

        .trx-quick button {
            border: 1px solid var(--trx-border);
            background: #f8fafc;
            border-radius: 999px;
            padding: 3px 12px;
            font-size: 12px;
            color: #374151;
            cursor: pointer;
        }

        .trx-quick button:hover {
            background: #e0e7ff;
            border-color: #a5b4fc;
        }

        /* ---------- Tile radio ---------- */
        .trx-tiles {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .trx-tile {
            flex: 1;
            min-width: 130px;
            margin: 0;
            cursor: pointer;
        }

        .trx-tile input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .trx-tile .box {
            border: 2px solid var(--trx-border);
            border-radius: 10px;
            padding: 12px;
            text-align: center;
            font-weight: 600;
            color: #374151;
            background: #fff;
            transition: all .15s;
        }

        .trx-tile .box i {
            display: block;
            font-size: 22px;
            margin-bottom: 4px;
            color: var(--trx-muted);
        }

        .trx-tile:hover .box {
            border-color: #93c5fd;
        }

        .trx-tile input:checked+.box {
            border-color: var(--trx-primary);
            background: #eff6ff;
            color: var(--trx-primary-dark);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }

        .trx-tile input:checked+.box i {
            color: var(--trx-primary);
        }

        .trx-info-bayar {
            margin-top: 10px;
            font-size: 13px;
            color: #92400e;
            background: #fffbeb;
            border-radius: 8px;
            padding: 8px 12px;
            display: none;
        }

        /* ---------- Ringkasan / total bayar ---------- */
        .trx-summary {
            position: sticky;
            top: 70px;
            border-radius: 16px;
            overflow: hidden;
            color: #fff;
            background: linear-gradient(145deg, var(--trx-primary-dark), var(--trx-primary) 60%, var(--trx-accent));
            box-shadow: 0 10px 30px rgba(30, 58, 138, .35);
            margin-bottom: 18px;
        }

        .trx-summary .top {
            padding: 22px 22px 8px;
            text-align: center;
        }

        .trx-summary .top small {
            text-transform: uppercase;
            letter-spacing: .12em;
            opacity: .8;
            font-size: 11px;
        }

        .trx-total {
            font-size: 40px;
            font-weight: 800;
            line-height: 1.15;
            word-break: break-all;
            transition: transform .2s;
        }

        .trx-total.bump {
            transform: scale(1.06);
        }

        .trx-total .cur {
            font-size: 20px;
            font-weight: 600;
            opacity: .85;
            margin-right: 4px;
        }

        .trx-rumus {
            font-size: 13px;
            opacity: .85;
            min-height: 20px;
        }

        .trx-summary .rows {
            margin: 14px 18px 0;
            padding: 12px 14px;
            background: rgba(255, 255, 255, .12);
            border-radius: 12px;
            font-size: 13px;
        }

        .trx-summary .rows .r {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 4px 0;
        }

        .trx-summary .rows .r span:first-child {
            opacity: .8;
        }

        .trx-summary .rows .r span:last-child {
            font-weight: 600;
            text-align: right;
        }

        .trx-chip {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .trx-chip.ok {
            background: #dcfce7;
            color: #166534;
        }

        .trx-chip.warn {
            background: #fef3c7;
            color: #92400e;
        }

        .trx-summary .foot {
            padding: 18px;
        }

        .btn-simpan-trx {
            width: 100%;
            height: 50px;
            border: 0;
            border-radius: 12px;
            background: #fff;
            color: var(--trx-primary-dark);
            font-size: 16px;
            font-weight: 800;
            transition: all .15s;
            cursor: pointer;
        }

        .btn-simpan-trx:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, .25);
        }

        .btn-simpan-trx[disabled] {
            opacity: .7;
            cursor: wait;
            transform: none;
        }

        /* Bar bawah untuk mobile */
        .trx-mobilebar {
            display: none;
        }

        /* ---------- Modal customer ---------- */
        .cust-search {
            position: relative;
        }

        .cust-search>i.fa-search {
            position: absolute;
            left: 14px;
            top: 14px;
            color: var(--trx-muted);
        }

        .cust-search input {
            height: 44px;
            padding-left: 40px;
            padding-right: 36px;
            border-radius: 10px;
            font-size: 15px;
        }

        .cust-search-clear {
            position: absolute;
            right: 8px;
            top: 6px;
            border: 0;
            background: none;
            font-size: 18px;
            color: #9ca3af;
        }

        .cust-count {
            font-size: 12px;
            color: var(--trx-muted);
            margin: 8px 2px;
        }

        .cust-table-wrap {
            max-height: 52vh;
            overflow-y: auto;
        }

        .cust-row {
            cursor: pointer;
        }

        .cust-modal .table>thead>tr>th {
            position: sticky;
            top: 0;
            background: #f8fafc;
            z-index: 1;
        }

        mark.hl {
            background: #fde68a;
            padding: 0 1px;
            border-radius: 2px;
        }

        @keyframes trxPop {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        @media (max-width: 991px) {
            .trx-summary {
                position: static;
            }

            .trx-summary .foot {
                display: none;
            }

            .trx-mobilebar {
                display: flex;
                position: fixed;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 1000;
                align-items: center;
                gap: 12px;
                padding: 10px 14px;
                background: #fff;
                box-shadow: 0 -4px 16px rgba(0, 0, 0, .15);
            }

            .trx-mobilebar .t {
                flex: 1;
            }

            .trx-mobilebar .t small {
                display: block;
                color: var(--trx-muted);
                font-size: 11px;
            }

            .trx-mobilebar .t b {
                font-size: 20px;
                color: var(--trx-primary-dark);
            }

            .trx-mobilebar .btn-simpan-trx {
                width: auto;
                padding: 0 22px;
                height: 44px;
                background: var(--trx-primary);
                color: #fff;
            }

            .content-wrapper {
                padding-bottom: 70px;
            }

            .trx-total {
                font-size: 34px;
            }
        }
    </style>
@endpush

@section('content')
    <form action="{{ route('transaksi.simpan') }}" method="POST" class="form-paket" id="form-paket" novalidate>
        @csrf
        <input type="hidden" name="id_paket" id="id_paket" value="{{ $paket->id_paket }}">
        <input type="hidden" name="id_customer" id="id_customer">
        <input type="hidden" name="total_harga" id="total_harga_hidden">
        <input type="hidden" name="status_paket" id="status_paket" value="menunggu antrian">
        <input type="hidden" name="id_kategori" id="id_kategori" value="{{ old('id_kategori') }}">
        <input type="hidden" id="harga">
        {{-- Diisi otomatis berdasarkan tipe pembayaran. Server tetap menentukan nilai akhirnya. --}}
        <input type="hidden" name="status_pembayaran" id="status_pembayaran" value="sudah dibayar">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="list-unstyled" style="margin:0;">
                    @foreach ($errors->all() as $error)
                        <li><i class="fa fa-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            {{-- ================= KOLOM KIRI: FORM ================= --}}
            <div class="col-md-8">

                {{-- 1. PELANGGAN --}}
                <div class="trx-card">
                    <div class="trx-card-head">
                        <div class="trx-step">1</div>
                        <h3>Data Pelanggan</h3>
                    </div>
                    <div class="trx-card-body">
                        <div class="trx-question">Customer sudah pernah laundry di sini?</div>
                        <div class="trx-seg">
                            <button type="button" id="mode-lama" class="active"><i class="fa fa-history"></i> Sudah
                                pernah<br><small class="text-muted">Pilih dari daftar</small></button>
                            <button type="button" id="mode-baru"><i class="fa fa-user-plus"></i> Belum pernah<br><small
                                    class="text-muted">Input customer baru</small></button>
                        </div>

                        {{-- Mode lama --}}
                        <div id="panel-lama">
                            <button type="button" class="btn-cari-customer" onclick="tampilCustomer()">
                                <i class="fa fa-search"></i> Cari &amp; pilih customer
                            </button>
                            <div class="trx-picked" id="picked-box">
                                <div class="av" id="picked-av">A</div>
                                <div class="meta">
                                    <b id="picked-nama">-</b>
                                    <span id="picked-kode">-</span>
                                </div>
                                <button type="button" class="btn btn-default btn-xs btn-flat"
                                    onclick="tampilCustomer()">Ganti</button>
                            </div>
                        </div>

                        {{-- Mode baru --}}
                        <div class="trx-hint-new" id="hint-baru">
                            <i class="fa fa-info-circle"></i> Data di bawah akan disimpan sebagai <b>customer baru</b> saat
                            transaksi disimpan.
                        </div>

                        <div class="trx-field">
                            <label class="trx-label" for="nama_customer"><i class="fa fa-user fi"></i> Nama Customer</label>
                            <input type="text" name="nama_customer" id="nama_customer" class="form-control"
                                placeholder="Nama pelanggan" value="{{ old('nama_customer') }}" autocomplete="off">
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="trx-field">
                                    <label class="trx-label" for="telepon"><i class="fa fa-phone fi"></i> No
                                        Telepon</label>
                                    <input type="text" class="form-control" name="telepon" id="telepon"
                                        placeholder="08xxxxxxxxxx" value="{{ old('telepon') }}">
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="trx-field">
                                    <label class="trx-label" for="alamat"><i class="fa fa-map-marker fi"></i>
                                        Alamat</label>
                                    <textarea name="alamat" id="alamat" rows="2" class="form-control" placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. DETAIL LAUNDRY --}}
                <div class="trx-card">
                    <div class="trx-card-head">
                        <div class="trx-step">2</div>
                        <h3>Detail Laundry</h3>
                    </div>
                    <div class="trx-card-body">
                        <div class="trx-field">
                            <label class="trx-label">Layanan Laundry</label>
                            <button type="button" class="trx-kategori" id="btn-kategori" onclick="tampilKategori()">
                                <div class="ic"><i class="fa fa-tags"></i></div>
                                <div class="tx">
                                    <b id="kategori-judul">Pilih Layanan Laundry</b>
                                    <span id="kategori-sub">Klik untuk memilih kategori &amp; harga per Kg</span>
                                </div>
                                <i class="fa fa-chevron-right text-muted"></i>
                            </button>
                            <input type="hidden" name="nama_kategori" id="nama_kategori">
                        </div>

                        <div class="trx-field" style="margin-bottom:0;">
                            <label class="trx-label" for="berat_total">Berat Laundry</label>
                            <div class="trx-stepper">
                                <button type="button" class="btn-step" data-step="-0.5"><i
                                        class="fa fa-minus"></i></button>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="berat_total" id="berat_total"
                                        min="0" step="0.1" placeholder="0" value="{{ old('berat_total') }}"
                                        required>
                                    <span class="input-group-addon">Kg</span>
                                </div>
                                <button type="button" class="btn-step" data-step="0.1"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                            <div class="trx-quick">
                                <span class="text-muted" style="font-size:12px;padding-top:3px;">Cepat:</span>
                                @foreach ([1, 2, 3, 5, 10] as $q)
                                    <button type="button" data-set="{{ $q }}">{{ $q }}
                                        Kg</button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. PENGAMBILAN & PEMBAYARAN --}}
                <div class="trx-card">
                    <div class="trx-card-head">
                        <div class="trx-step">3</div>
                        <h3>Pengambilan &amp; Pembayaran</h3>
                    </div>
                    <div class="trx-card-body">
                        <div class="trx-field">
                            <label class="trx-label">Tipe Pengambilan</label>
                            <div class="trx-tiles">
                                @foreach ($tipePengambilan as $i => $item)
                                    <label class="trx-tile">
                                        <input type="radio" name="tipe_pengambilan" value="{{ $item }}"
                                            {{ old('tipe_pengambilan', $tipePengambilan[0]) === $item ? 'checked' : '' }}>
                                        <div class="box">
                                            <i
                                                class="fa {{ $item === 'diantar' ? 'fa-motorcycle' : 'fa-shopping-bag' }}"></i>
                                            {{ ucfirst($item) }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="trx-field" style="margin-bottom:0;">
                            <label class="trx-label">Tipe Pembayaran</label>
                            <div class="trx-tiles">
                                @foreach ($metodePembayaran as $kode => $metode)
                                    <label class="trx-tile">
                                        <input type="radio" name="tipe_pembayaran" value="{{ $kode }}"
                                            {{ old('tipe_pembayaran', array_key_first($metodePembayaran)) === $kode ? 'checked' : '' }}>
                                        <div class="box">
                                            <i class="fa {{ $kode === 'tunai' ? 'fa-money' : 'fa-credit-card' }}"></i>
                                            {{ $metode['label'] }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            <div class="trx-info-bayar" id="info_tipe_pembayaran"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= KOLOM KANAN: RINGKASAN ================= --}}
            <div class="col-md-4">
                <div class="trx-summary">
                    <div class="top">
                        <small>Total Bayar</small>
                        <div class="trx-total" id="tampil-total"><span class="cur">Rp</span>0</div>
                        <div class="trx-rumus" id="tampil-rumus">Pilih tipe laundry &amp; isi berat</div>
                    </div>

                    <div class="rows">
                        <div class="r"><span>Pelanggan</span><span id="sum-customer">-</span></div>
                        <div class="r"><span>Tipe laundry</span><span id="sum-kategori">-</span></div>
                        <div class="r"><span>Harga / Kg</span><span id="sum-harga">-</span></div>
                        <div class="r"><span>Berat</span><span id="sum-berat">-</span></div>
                        <div class="r"><span>Pengambilan</span><span id="sum-ambil">-</span></div>
                        <div class="r"><span>Status bayar</span><span><span class="trx-chip ok"
                                    id="status_pembayaran_tampil">Sudah dibayar</span></span></div>
                    </div>

                    <div class="foot">
                        <button type="submit" class="btn-simpan-trx btn-simpan">
                            <i class="fa fa-floppy-o"></i> Simpan Paket Baru
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bar bawah (khusus layar kecil) --}}
        <div class="trx-mobilebar">
            <div class="t"><small>Total Bayar</small><b id="mobile-total">Rp 0</b></div>
            <button type="submit" class="btn-simpan-trx btn-simpan"><i class="fa fa-floppy-o"></i> Simpan</button>
        </div>
    </form>

    @includeIf('paketdetail.kategori')
    @includeIf('paketdetail.customer')
@endsection
