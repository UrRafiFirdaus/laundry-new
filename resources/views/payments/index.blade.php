@includeIf('landing.header')

@extends('landing.master')

@php
    $lunas = $paket->status_pembayaran === 'sudah dibayar';
    $isQris = $pembayaran && $pembayaran->payment_type === 'qris';
    $isMandiri = $pembayaran && $pembayaran->payment_type === 'echannel';
@endphp

@section('content')
    <div class="container" style="margin-top: 50px; margin-bottom: 50px;">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Pembayaran Laundry</h4>
                    </div>

                    <div class="card-body">

                        <table class="table table-bordered">
                            <tr>
                                <th width="35%">Kode Laundry</th>
                                <td>{{ $paket->kode_paket }}</td>
                            </tr>
                            <tr>
                                <th>Nama Customer</th>
                                <td>{{ optional($paket->customer)->nama_customer ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Metode Pembayaran</th>
                                <td>{{ \App\Services\MidtransService::label($paket->tipe_pembayaran) }}</td>
                            </tr>
                            <tr>
                                <th>Total Bayar</th>
                                <td><strong>Rp. {{ format_uang($paket->total_harga) }}</strong></td>
                            </tr>
                        </table>

                        {{-- ============ SUDAH DIBAYAR ============ --}}
                        @if ($lunas)
                            <div class="alert alert-success text-center mb-0">
                                <h4 class="mb-1"><i class="fa fa-check-circle"></i> Pembayaran Berhasil</h4>
                                @if ($pembayaran && $pembayaran->paid_at)
                                    <small>Dibayar pada {{ $pembayaran->paid_at->format('d/m/Y H:i') }}</small>
                                @endif
                            </div>

                            {{-- ============ GAGAL MEMBUAT TAGIHAN ============ --}}
                        @elseif ($error)
                            <div class="alert alert-danger">{{ $error }}</div>
                            <a href="{{ route('pembayaran.tampil', $paket->kode_paket) }}"
                                class="genric-btn primary circle">
                                <i class="fa fa-refresh"></i> Coba Lagi
                            </a>

                            {{-- ============ MENUNGGU PEMBAYARAN ============ --}}
                        @elseif ($pembayaran)
                            <div id="area-bayar">

                                @if ($isQris)
                                    <div class="text-center">
                                        <p>Scan QR di bawah ini menggunakan aplikasi e-wallet atau mobile banking
                                            yang mendukung <strong>QRIS</strong>.</p>

                                        <div id="qris-box"
                                            style="display:inline-block; padding:14px; background:#fff; border:1px solid #ddd; border-radius:6px;">
                                            @if (!$pembayaran->qr_string && $pembayaran->qr_url)
                                                <img src="{{ $pembayaran->qr_url }}" alt="QRIS" width="256"
                                                    height="256">
                                            @endif
                                        </div>

                                        <h3 class="mt-3">Rp. {{ format_uang($pembayaran->gross_amount) }}</h3>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <p class="mb-1">Transfer ke
                                            <strong>{{ \App\Services\MidtransService::label($pembayaran->tipe) }}</strong>
                                        </p>

                                        @if ($isMandiri)
                                            <p class="mb-0 text-muted">Kode Perusahaan (Biller Code)</p>
                                            <h3 style="letter-spacing:2px;">{{ $pembayaran->biller_code }}</h3>
                                            <p class="mb-0 text-muted">Kode Bayar (Bill Key)</p>
                                            <h3 style="letter-spacing:2px;" id="nomor-va">{{ $pembayaran->bill_key }}</h3>
                                        @else
                                            <p class="mb-0 text-muted">Nomor Virtual Account</p>
                                            <h2 style="letter-spacing:3px;" id="nomor-va">{{ $pembayaran->va_number }}
                                            </h2>
                                        @endif

                                        <button type="button" class="genric-btn info-border circle small" id="btn-salin">
                                            <i class="fa fa-copy"></i> Salin Nomor
                                        </button>

                                        <p class="mb-0 mt-4 text-muted">Jumlah yang harus dibayar</p>
                                        <h3>Rp. {{ format_uang($pembayaran->gross_amount) }}</h3>
                                        <small class="text-muted">Transfer sesuai nominal di atas agar pembayaran terdeteksi
                                            otomatis.</small>
                                    </div>
                                @endif

                                @if ($pembayaran->expiry_time)
                                    <p class="text-center text-muted mt-3 mb-0">
                                        Bayar sebelum <strong>{{ $pembayaran->expiry_time->format('d/m/Y H:i') }}</strong>
                                    </p>
                                @endif

                                @if (!config('midtrans.is_production') && $pembayaran->qr_url)
                                    <p class="text-center mt-3 mb-0" style="word-break:break-all;">
                                        <small class="text-muted">[Sandbox] URL QR untuk simulator Midtrans:<br>
                                            <code>{{ $pembayaran->qr_url }}</code></small>
                                    </p>
                                @endif

                                <p class="text-center mt-3 mb-0 text-muted" id="info-menunggu">
                                    <i class="fa fa-spinner fa-spin"></i> Menunggu pembayaran...
                                    halaman ini akan otomatis berubah setelah pembayaran diterima.
                                </p>
                            </div>

                            <div id="area-kedaluwarsa" class="alert alert-warning text-center mb-0" style="display:none;">
                                <p>Tagihan ini sudah kedaluwarsa.</p>
                                <a href="{{ route('pembayaran.tampil', $paket->kode_paket) }}"
                                    class="genric-btn primary circle">
                                    <i class="fa fa-refresh"></i> Buat Pembayaran Baru
                                </a>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('status.cek', ['kode_paket' => $paket->kode_paket]) }}">
                        &laquo; Kembali ke status laundry
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection

@if (!$lunas && !$error && $pembayaran)
    @push('scripts')
        @if ($isQris && $pembayaran->qr_string)
            <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        @endif
        <script>
            (function() {
                @if ($isQris && $pembayaran->qr_string)
                    new QRCode(document.getElementById('qris-box'), {
                        text: @json($pembayaran->qr_string),
                        width: 256,
                        height: 256,
                        correctLevel: QRCode.CorrectLevel.M
                    });
                @endif

                var btnSalin = document.getElementById('btn-salin');
                if (btnSalin) {
                    btnSalin.addEventListener('click', function() {
                        var teks = document.getElementById('nomor-va').innerText.trim();
                        if (navigator.clipboard) {
                            navigator.clipboard.writeText(teks);
                        } else {
                            var t = document.createElement('textarea');
                            t.value = teks;
                            document.body.appendChild(t);
                            t.select();
                            document.execCommand('copy');
                            document.body.removeChild(t);
                        }
                        btnSalin.innerHTML = '<i class="fa fa-check"></i> Tersalin';
                    });
                }

                // Cek status pembayaran tiap 5 detik
                var statusUrl = @json(route('pembayaran.status', $paket->kode_paket));
                var timer = setInterval(function() {
                    fetch(statusUrl, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        })
                        .then(function(r) {
                            return r.json();
                        })
                        .then(function(d) {
                            if (d.paid) {
                                clearInterval(timer);
                                location.reload();
                            } else if (d.expired) {
                                clearInterval(timer);
                                document.getElementById('area-bayar').style.display = 'none';
                                document.getElementById('area-kedaluwarsa').style.display = 'block';
                            }
                        })
                        .catch(function() {
                            /* abaikan, coba lagi di putaran berikut */ });
                }, 5000);
            })();
        </script>
    @endpush
@endif
