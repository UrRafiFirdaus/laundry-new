@extends('landing.master')

@section('title', 'Cek Status Laundry')

@section('content')
    <main>
        <section class="page-head" style="padding-bottom: 120px;">
            <div class="bubbles"><span></span><span></span><span></span><span></span><span></span><span></span></div>
            <div class="lp-container">
                <h1>Lacak Status Laundry</h1>
                <p>Masukkan kode transaksi untuk melihat perkembangan cucian Anda.</p>
            </div>
        </section>

        <div class="lp-container">
            <div class="status-wrap">

                @if (session('error'))
                    <div class="alert-lp"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
                @endif

                <div class="panel">
                    <h3><i class="fa-solid fa-magnifying-glass"></i> Cek Kode Transaksi</h3>
                    <form action="{{ route('status.cek') }}" method="GET" class="track-form">
                        <input type="text" name="kode_paket" id="kode_paket" placeholder="Masukkan Kode Transaksi"
                            required value="{{ request('kode_paket') }}">
                        <button type="submit" class="btn-lp primary"><i class="fa-solid fa-search"></i> Lacak
                            Status</button>
                    </form>
                </div>

                @if (isset($paket))
                    <div class="panel">
                        <h3><i class="fa-solid fa-receipt"></i> Hasil Pelacakan</h3>

                        <table class="result-table">
                            <tr>
                                <th>Kode Transaksi</th>
                                <td><strong>{{ $paket->kode_paket }}</strong></td>
                            </tr>
                            <tr>
                                <th>Nama Customer</th>
                                <td>{{ optional($paket->customer)->nama_customer ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Berat Total</th>
                                <td>{{ $paket->berat_total }} Kg</td>
                            </tr>
                            <tr>
                                <th>Kategori Laundry</th>
                                <td>{{ $paket->detail->map(fn($d) => optional($d->kategori)->nama_kategori)->filter()->unique()->implode(', ') ?: '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Total Harga</th>
                                <td>Rp. {{ format_uang($paket->total_harga) }}</td>
                            </tr>
                            <tr>
                                <th>Metode Pembayaran</th>
                                <td>{{ \App\Services\MidtransService::label($paket->tipe_pembayaran) }}</td>
                            </tr>
                            <tr>
                                <th>Status Pembayaran</th>
                                <td>
                                    @if ($paket->status_pembayaran == 'sudah dibayar')
                                        <span class="pill success">Sudah Dibayar</span>
                                    @else
                                        <span class="pill warning">Belum Dibayar</span>

                                        @if (\App\Services\MidtransService::perluMidtrans($paket->tipe_pembayaran))
                                            <div style="margin-top:10px;">
                                                <button type="button" id="btn-bayar" class="btn-lp primary sm">
                                                    <i class="fa-solid fa-credit-card"></i> Bayar
                                                </button>
                                            </div>
                                        @else
                                            <small class="note-muted">Silakan bayar langsung di kasir.</small>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($paket->status_paket == 'menunggu antrian')
                                        <span class="pill warning">Menunggu Antrian</span>
                                    @elseif($paket->status_paket == 'diproses')
                                        <span class="pill info">Diproses</span>
                                    @elseif($paket->status_paket == 'siap diambil')
                                        <span class="pill primary">Siap Diambil</span>
                                    @elseif($paket->status_paket == 'sedang diantar')
                                        <span class="pill secondary">Sedang Diantar</span>
                                    @elseif($paket->status_paket == 'diterima')
                                        <span class="pill success">Diterima</span>
                                    @else
                                        <span class="pill dark">{{ $paket->status_paket }}</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        <div class="status-spacer"></div>
    </main>
@endsection

@if (isset($paket) &&
        $paket->status_pembayaran != 'sudah dibayar' &&
        \App\Services\MidtransService::perluMidtrans($paket->tipe_pembayaran))
    @push('scripts')
        <script
            src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script>
            (function() {
                var btn = document.getElementById('btn-bayar');
                if (!btn) return;

                var snapUrl = @json(route('pembayaran.snap', $paket->kode_paket));
                var statusUrl = @json(route('pembayaran.status', $paket->kode_paket));
                var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                function cekStatus() {
                    return fetch(statusUrl, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        })
                        .then(function(r) {
                            return r.json();
                        })
                        .then(function(d) {
                            if (d.paid) {
                                location.reload();
                            }
                            return d;
                        })
                        .catch(function() {
                            return {};
                        });
                }

                function mulaiPolling() {
                    var n = 0;
                    var t = setInterval(function() {
                        n++;
                        cekStatus();
                        if (n >= 60) {
                            clearInterval(t);
                        }
                    }, 4000);
                }

                btn.addEventListener('click', function() {
                    var label = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = 'Memuat...';

                    fetch(snapUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json'
                            }
                        })
                        .then(function(r) {
                            return r.json().then(function(d) {
                                return {
                                    ok: r.ok,
                                    d: d
                                };
                            });
                        })
                        .then(function(res) {
                            btn.disabled = false;
                            btn.innerHTML = label;

                            if (!res.ok) {
                                alert(res.d.message || 'Pembayaran belum dapat dibuat.');
                                return;
                            }
                            if (res.d.paid) {
                                location.reload();
                                return;
                            }

                            window.snap.pay(res.d.snap_token, {
                                onSuccess: function() {
                                    cekStatus();
                                    mulaiPolling();
                                },
                                onPending: function() {
                                    cekStatus();
                                    mulaiPolling();
                                },
                                onError: function() {
                                    alert('Pembayaran gagal. Silakan coba lagi.');
                                },
                                onClose: function() {
                                    cekStatus();
                                }
                            });
                        })
                        .catch(function() {
                            btn.disabled = false;
                            btn.innerHTML = label;
                            alert('Terjadi gangguan koneksi. Silakan coba lagi.');
                        });
                });
            })();
        </script>
    @endpush
@endif
