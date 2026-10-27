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
                                    placeholder="Masukkan Kode Transaksi" required value="{{ request('kode_paket') }}">
                            </div>
                            <div class="col-xs-4">
                                <button type="submit" class="genric-btn info circle">
                                    <i class="fa fa-search"></i> Lacak Status
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

                @if (isset($paket))
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
                                    <td>{{ optional($paket->customer)->nama_customer ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Berat Total</th>
                                    <td>{{ $paket->berat_total }} Kg</td>
                                </tr>

                                <tr>
                                    <th>Kategori Laundry</th>
                                    <td>
                                        @foreach ($paket->detail as $item)
                                            {{ $item->kategori->nama_kategori }}
                                        @endforeach
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
                                            <span class="badge badge-success">Sudah Dibayar</span>
                                        @else
                                            <span class="badge badge-warning">Belum Dibayar</span>

                                            @if (\App\Services\MidtransService::perluMidtrans($paket->tipe_pembayaran))
                                                <button type="button" id="btn-bayar"
                                                    class="genric-btn primary circle small ml-2">
                                                    <i class="fa fa-credit-card"></i> Bayar
                                                </button>
                                            @else
                                                <small class="text-muted d-block">Silakan bayar langsung di kasir.</small>
                                            @endif
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($paket->status_paket == 'menunggu antrian')
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

                @if (session('error'))
                    <div class="alert alert-danger mt-4">
                        {{ session('error') }}
                    </div>
                @endif

            </div>
        </div>
    </div>

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

                // Tanya status ke server; muat ulang halaman jika sudah dibayar.
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

                // Setelah bayar, webhook bisa terlambat beberapa detik: cek berkala sampai lunas.
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
