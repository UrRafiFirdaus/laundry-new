@extends('layouts.master')

@section('title')
    Tampilan Website
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Tampilan Website</li>
@endsection

@push('css')
    <style>
        .lp-tabs {
            margin-bottom: 0;
            border-bottom: 0;
        }

        .lp-tabs>li>a {
            cursor: pointer;
        }

        .lp-pane {
            display: none;
            padding-top: 20px;
        }

        .lp-pane.active {
            display: block;
        }

        .lp-section-title {
            font-size: 15px;
            font-weight: 700;
            margin: 5px 0 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
            color: #444;
        }

        .lp-hint {
            color: #999;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }

        .lp-preview {
            max-width: 100%;
            max-height: 160px;
            border-radius: 6px;
            border: 1px solid #ddd;
            margin-top: 8px;
            display: block;
        }

        .lp-card {
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
            margin-bottom: 20px;
        }

        .lp-card .thumb {
            height: 140px;
            background: #f4f6f8 center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #bbb;
            font-size: 32px;
        }

        .lp-card .body {
            padding: 12px 14px;
        }

        .lp-card .body h4 {
            margin: 0 0 4px;
            font-size: 16px;
            font-weight: 700;
        }

        .lp-card .body p {
            color: #777;
            margin: 0 0 8px;
            min-height: 36px;
            font-size: 13px;
        }

        .lp-card.nonaktif {
            opacity: .55;
        }

        .lp-topbar {
            margin: 0 0 15px;
        }
    </style>
@endpush

@section('content')
    @php
        $tab = request('tab', 'hero');
        $L = $landing;
        $v = fn($k) => old($k, $L[$k] ?? '');
    @endphp

    <div class="row">
        <div class="col-lg-12">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check"></i> {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Gagal menyimpan:</strong>
                    <ul style="margin:5px 0 0 15px; padding:0;">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="lp-topbar">
                <a href="{{ route('landing.index') }}" target="_blank" class="btn btn-default btn-sm btn-flat">
                    <i class="fa fa-external-link"></i> Lihat Website
                </a>
                <span class="text-muted" style="margin-left:8px;">Kosongkan sebuah kolom lalu simpan untuk mengembalikan ke
                    teks bawaan.</span>
            </div>

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs lp-tabs" id="lpTabs">
                    <li data-pane="hero"><a><i class="fa fa-image"></i> Banner / Hero</a></li>
                    <li data-pane="proses"><a><i class="fa fa-list-ol"></i> Statistik & Proses</a></li>
                    <li data-pane="layanan"><a><i class="fa fa-cubes"></i> Layanan Kami</a></li>
                    <li data-pane="tentang"><a><i class="fa fa-info-circle"></i> Tentang Kami</a></li>
                    <li data-pane="kontak"><a><i class="fa fa-phone"></i> Kontak & Sosial</a></li>
                    <li data-pane="login"><a><i class="fa fa-sign-in"></i> Halaman Login</a></li>
                </ul>

                <form action="{{ route('landing_setting.update') }}" method="post" enctype="multipart/form-data"
                    id="formLanding">
                    @csrf
                    <input type="hidden" name="tab" id="tabInput" value="{{ $tab }}">

                    <div class="box-body" style="padding: 0 20px 10px;">

                        {{-- ================= HERO ================= --}}
                        <div class="lp-pane" id="pane-hero">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="lp-section-title">Teks Banner</div>
                                    <div class="form-group">
                                        <label>Label kecil di atas judul</label>
                                        <input type="text" name="hero_badge" class="form-control" maxlength="80"
                                            value="{{ $v('hero_badge') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Judul Utama</label>
                                        <input type="text" name="hero_judul" class="form-control" maxlength="120"
                                            value="{{ $v('hero_judul') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Sub Judul</label>
                                        <textarea name="hero_subjudul" class="form-control" rows="3" maxlength="300">{{ $v('hero_subjudul') }}</textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>Tombol 1 - Teks</label>
                                            <input type="text" name="hero_tombol_teks" class="form-control"
                                                maxlength="40" value="{{ $v('hero_tombol_teks') }}">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Tombol 1 - Link</label>
                                            <input type="text" name="hero_tombol_link" class="form-control"
                                                maxlength="255" value="{{ $v('hero_tombol_link') }}">
                                            <span class="lp-hint">Contoh: /status, #layanan, atau https://...</span>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Tombol 2 - Teks</label>
                                            <input type="text" name="hero_tombol2_teks" class="form-control"
                                                maxlength="40" value="{{ $v('hero_tombol2_teks') }}">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Tombol 2 - Link</label>
                                            <input type="text" name="hero_tombol2_link" class="form-control"
                                                maxlength="255" value="{{ $v('hero_tombol2_link') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="lp-section-title">Gambar & Warna</div>
                                    <div class="form-group">
                                        <label>Foto Banner</label>
                                        <input type="file" name="hero_gambar" class="form-control" accept="image/*"
                                            data-preview="#prev-hero">
                                        <span class="lp-hint">JPG / PNG / WEBP, maks 4 MB. Disarankan lebar min.
                                            1600px.</span>
                                        <img id="prev-hero" class="lp-preview"
                                            @if (!empty($L['hero_gambar'])) src="{{ url($L['hero_gambar']) }}" @else style="display:none" @endif
                                            alt="">
                                        @if (!empty($L['hero_gambar']))
                                            <label style="font-weight:400; margin-top:6px;"><input type="checkbox"
                                                    name="reset_hero_gambar" value="1"> Hapus foto (pakai latar
                                                gradasi)</label>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Gelap overlay foto: <span
                                                id="ovVal">{{ $v('hero_overlay') }}</span>%</label>
                                        <input type="range" name="hero_overlay" min="0" max="90"
                                            step="5" value="{{ $v('hero_overlay') }}" style="width:100%"
                                            oninput="document.getElementById('ovVal').textContent=this.value">
                                        <span class="lp-hint">Makin tinggi, teks makin mudah dibaca di atas foto.</span>
                                    </div>
                                    <div class="form-group">
                                        <label>Warna Utama Website</label>
                                        <input type="color" name="warna_utama" value="{{ $v('warna_utama') }}"
                                            style="width:70px; height:36px; padding:2px;" class="form-control">
                                        <span class="lp-hint">Dipakai untuk tombol, ikon, dan aksen di seluruh landing
                                            page.</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ================= STATISTIK & PROSES ================= --}}
                        <div class="lp-pane" id="pane-proses">
                            <div class="lp-section-title">Statistik Singkat (di bawah banner)</div>
                            <div class="row">
                                @foreach ([1, 2, 3] as $i)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Statistik {{ $i }} - Angka</label>
                                            <input type="text" name="stat{{ $i }}_angka"
                                                class="form-control" maxlength="20" value="{{ $v("stat{$i}_angka") }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Statistik {{ $i }} - Keterangan</label>
                                            <input type="text" name="stat{{ $i }}_label"
                                                class="form-control" maxlength="40" value="{{ $v("stat{$i}_label") }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="lp-section-title" style="margin-top:10px;">Bagian "Proses Kami"</div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Judul Bagian</label>
                                    <input type="text" name="proses_judul" class="form-control" maxlength="100"
                                        value="{{ $v('proses_judul') }}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Sub Judul</label>
                                    <input type="text" name="proses_subjudul" class="form-control" maxlength="120"
                                        value="{{ $v('proses_subjudul') }}">
                                </div>
                            </div>
                            <div class="row">
                                @foreach ([1, 2, 3] as $i)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Langkah {{ $i }} - Judul</label>
                                            <input type="text" name="langkah{{ $i }}_judul"
                                                class="form-control" maxlength="80"
                                                value="{{ $v("langkah{$i}_judul") }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Langkah {{ $i }} - Isi</label>
                                            <textarea name="langkah{{ $i }}_isi" class="form-control" rows="4" maxlength="300">{{ $v("langkah{$i}_isi") }}</textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- ================= LAYANAN ================= --}}
                        <div class="lp-pane" id="pane-layanan">
                            <div class="lp-section-title">Judul Bagian Layanan</div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Judul</label>
                                    <input type="text" name="layanan_judul" class="form-control" maxlength="100"
                                        value="{{ $v('layanan_judul') }}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Sub Judul</label>
                                    <input type="text" name="layanan_subjudul" class="form-control" maxlength="160"
                                        value="{{ $v('layanan_subjudul') }}">
                                </div>
                            </div>
                            <p class="text-muted" style="margin-top:-5px;">Judul bagian disimpan lewat tombol <b>Simpan
                                    Perubahan</b>. Kartu layanan (tambah, ubah, hapus) langsung tersimpan saat Anda menekan
                                tombol Simpan di jendela layanan.</p>

                            <div class="lp-section-title" style="margin-top:20px;">
                                Kartu Layanan
                                <button type="button" class="btn btn-success btn-xs btn-flat pull-right"
                                    onclick="layananForm()">
                                    <i class="fa fa-plus-circle"></i> Tambah Layanan
                                </button>
                            </div>

                            <div class="row">
                                @forelse ($layanan as $l)
                                    <div class="col-md-3 col-sm-6">
                                        <div class="lp-card {{ $l->aktif ? '' : 'nonaktif' }}">
                                            <div class="thumb"
                                                @if ($l->foto) style="background-image:url('{{ url($l->foto) }}')" @endif>
                                                @unless ($l->foto)
                                                    <i class="fa fa-image"></i>
                                                @endunless
                                            </div>
                                            <div class="body">
                                                <h4>{{ $l->judul }}</h4>
                                                <p>{{ \Illuminate\Support\Str::limit($l->deskripsi, 70) }}</p>
                                                <small class="text-muted">Urutan {{ $l->urutan }} &middot;
                                                    {{ $l->aktif ? 'Tampil' : 'Disembunyikan' }}</small>
                                                <div style="margin-top:8px;">
                                                    <button type="button" class="btn btn-info btn-xs btn-flat"
                                                        data-layanan="{{ json_encode(['id' => $l->id, 'judul' => $l->judul, 'deskripsi' => $l->deskripsi, 'harga_label' => $l->harga_label, 'urutan' => $l->urutan, 'aktif' => $l->aktif, 'foto' => $l->foto ? url($l->foto) : null, 'url' => route('landing_setting.layanan.update', $l->id)]) }}"
                                                        onclick="layananForm(JSON.parse(this.dataset.layanan))"><i
                                                            class="fa fa-pencil"></i> Ubah</button>
                                                    <button type="button" class="btn btn-danger btn-xs btn-flat"
                                                        data-url="{{ route('landing_setting.layanan.destroy', $l->id) }}"
                                                        data-judul="{{ $l->judul }}"
                                                        onclick="layananHapus(this.dataset.url, this.dataset.judul)"><i
                                                            class="fa fa-trash"></i> Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-md-12">
                                        <p class="text-muted">Belum ada layanan. Klik "Tambah Layanan".</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- ================= TENTANG ================= --}}
                        <div class="lp-pane" id="pane-tentang">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="lp-section-title">Isi Halaman Tentang Kami</div>
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" name="tentang_judul" class="form-control" maxlength="100"
                                            value="{{ $v('tentang_judul') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea name="tentang_isi" class="form-control" rows="7" maxlength="3000">{{ $v('tentang_isi') }}</textarea>
                                        <span class="lp-hint">Pisahkan paragraf dengan baris kosong.</span>
                                    </div>
                                    <div class="form-group">
                                        <label>Poin Keunggulan (satu per baris)</label>
                                        <textarea name="tentang_poin" class="form-control" rows="5" maxlength="1000">{{ $v('tentang_poin') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Visi</label>
                                        <textarea name="visi" class="form-control" rows="2" maxlength="500">{{ $v('visi') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Misi (satu per baris)</label>
                                        <textarea name="misi" class="form-control" rows="4" maxlength="1000">{{ $v('misi') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="lp-section-title">Foto</div>
                                    <div class="form-group">
                                        <label>Foto Tentang Kami</label>
                                        <input type="file" name="tentang_gambar" class="form-control"
                                            accept="image/*" data-preview="#prev-tentang">
                                        <span class="lp-hint">JPG / PNG / WEBP, maks 4 MB.</span>
                                        <img id="prev-tentang" class="lp-preview"
                                            @if (!empty($L['tentang_gambar'])) src="{{ url($L['tentang_gambar']) }}" @else style="display:none" @endif
                                            alt="">
                                        @if (!empty($L['tentang_gambar']))
                                            <label style="font-weight:400; margin-top:6px;"><input type="checkbox"
                                                    name="reset_tentang_gambar" value="1"> Hapus foto</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ================= KONTAK ================= --}}
                        <div class="lp-pane" id="pane-kontak">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="lp-section-title">Ajakan Kontak (CTA)</div>
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" name="cta_judul" class="form-control" maxlength="100"
                                            value="{{ $v('cta_judul') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Isi</label>
                                        <input type="text" name="cta_isi" class="form-control" maxlength="200"
                                            value="{{ $v('cta_isi') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Teks Tombol</label>
                                        <input type="text" name="cta_tombol_teks" class="form-control" maxlength="40"
                                            value="{{ $v('cta_tombol_teks') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Nomor WhatsApp</label>
                                        <input type="text" name="whatsapp" class="form-control" maxlength="20"
                                            placeholder="Kosongkan = pakai nomor telepon di menu Settings"
                                            value="{{ $v('whatsapp') }}">
                                        <span class="lp-hint">Format bebas, contoh 0812xxxx atau 62812xxxx.</span>
                                    </div>
                                    <div class="form-group">
                                        <label>Jam Operasional</label>
                                        <input type="text" name="jam_operasional" class="form-control"
                                            maxlength="100" value="{{ $v('jam_operasional') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="lp-section-title">Media Sosial & Peta</div>
                                    <div class="form-group">
                                        <label>Instagram (URL)</label>
                                        <input type="text" name="instagram" class="form-control" maxlength="255"
                                            placeholder="https://instagram.com/..." value="{{ $v('instagram') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Facebook (URL)</label>
                                        <input type="text" name="facebook" class="form-control" maxlength="255"
                                            placeholder="https://facebook.com/..." value="{{ $v('facebook') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>TikTok (URL)</label>
                                        <input type="text" name="tiktok" class="form-control" maxlength="255"
                                            placeholder="https://tiktok.com/@..." value="{{ $v('tiktok') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Link Embed Google Maps</label>
                                        <input type="text" name="maps_embed" class="form-control" maxlength="1000"
                                            placeholder="https://www.google.com/maps/embed?pb=..."
                                            value="{{ $v('maps_embed') }}">
                                        <span class="lp-hint">Google Maps &rarr; Bagikan &rarr; Sematkan peta &rarr; salin
                                            isi <code>src="..."</code> saja.</span>
                                    </div>
                                    <p class="text-muted">Nama usaha, telepon, email, alamat, dan logo diatur di menu <a
                                            href="{{ route('setting.index') }}">Settings</a>.</p>
                                </div>
                            </div>
                        </div>

                        {{-- ================= LOGIN ================= --}}
                        <div class="lp-pane" id="pane-login">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="lp-section-title">Teks Halaman Login</div>
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" name="login_judul" class="form-control" maxlength="100"
                                            value="{{ $v('login_judul') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Sub Judul</label>
                                        <textarea name="login_subjudul" class="form-control" rows="3" maxlength="250">{{ $v('login_subjudul') }}</textarea>
                                    </div>
                                    <p class="text-muted">Logo dan nama usaha mengikuti menu Settings, warna mengikuti
                                        "Warna Utama" di tab Banner / Hero.</p>
                                </div>
                                <div class="col-md-5">
                                    <div class="lp-section-title">Foto Samping</div>
                                    <div class="form-group">
                                        <label>Foto Latar Halaman Login</label>
                                        <input type="file" name="login_gambar" class="form-control" accept="image/*"
                                            data-preview="#prev-login">
                                        <span class="lp-hint">JPG / PNG / WEBP, maks 4 MB. Foto berorientasi tegak/persegi
                                            paling pas.</span>
                                        <img id="prev-login" class="lp-preview"
                                            @if (!empty($L['login_gambar'])) src="{{ url($L['login_gambar']) }}" @else style="display:none" @endif
                                            alt="">
                                        @if (!empty($L['login_gambar']))
                                            <label style="font-weight:400; margin-top:6px;"><input type="checkbox"
                                                    name="reset_login_gambar" value="1"> Hapus foto (pakai latar
                                                gradasi)</label>
                                        @endif
                                    </div>
                                    <a href="{{ route('login') }}" target="_blank"
                                        class="btn btn-default btn-sm btn-flat"><i class="fa fa-external-link"></i> Lihat
                                        Halaman Login</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="box-footer text-right" id="lpFooter">
                        <button type="submit" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ============ MODAL TAMBAH / UBAH LAYANAN (di luar form utama) ============ --}}
    <div class="modal fade" id="modalLayanan" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form method="post" action="" enctype="multipart/form-data" id="formLayanan" class="modal-content">
                @csrf
                <input type="hidden" name="_method" value="POST" id="layananMethod">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="layananTitle">Tambah Layanan</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Layanan <span class="text-danger">*</span></label>
                        <input type="text" name="judul" id="l_judul" class="form-control" maxlength="100"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" id="l_deskripsi" class="form-control" rows="3" maxlength="500"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-sm-8 form-group">
                            <label>Label Harga (opsional)</label>
                            <input type="text" name="harga_label" id="l_harga" class="form-control"
                                maxlength="100" placeholder="Mulai Rp 6.000 / Kg">
                        </div>
                        <div class="col-sm-4 form-group">
                            <label>Urutan</label>
                            <input type="number" name="urutan" id="l_urutan" class="form-control" min="0"
                                max="9999">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Foto Layanan</label>
                        <input type="file" name="foto" class="form-control" accept="image/*"
                            data-preview="#prev-layanan">
                        <img id="prev-layanan" class="lp-preview" style="display:none" alt="">
                        <label id="l_hapusfoto_wrap" style="font-weight:400; margin-top:6px; display:none;">
                            <input type="checkbox" name="hapus_foto" value="1"> Hapus foto saat ini
                        </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="aktif" id="l_aktif" value="1" checked> Tampilkan di
                            landing page</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <form method="post" id="formHapusLayanan" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script>
        (function() {
            var panes = ['hero', 'proses', 'layanan', 'tentang', 'kontak', 'login'];

            function showPane(name) {
                if (panes.indexOf(name) === -1) name = 'hero';
                panes.forEach(function(p) {
                    document.getElementById('pane-' + p).classList.toggle('active', p === name);
                    document.querySelector('#lpTabs li[data-pane="' + p + '"]').classList.toggle('active', p ===
                        name);
                });
                document.getElementById('tabInput').value = name;
                history.replaceState(null, '', '?tab=' + name);
            }

            document.querySelectorAll('#lpTabs li').forEach(function(li) {
                li.addEventListener('click', function() {
                    showPane(li.dataset.pane);
                });
            });
            showPane(@json($tab));

            // preview gambar sebelum upload
            document.querySelectorAll('input[type=file][data-preview]').forEach(function(inp) {
                inp.addEventListener('change', function() {
                    var img = document.querySelector(inp.dataset.preview);
                    if (inp.files && inp.files[0]) {
                        img.src = URL.createObjectURL(inp.files[0]);
                        img.style.display = 'block';
                    }
                });
            });
        })();

        var layananStoreUrl = @json(route('landing_setting.layanan.store'));

        function layananForm(d) {
            var f = document.getElementById('formLayanan');
            f.reset();
            var prev = document.getElementById('prev-layanan');
            prev.style.display = 'none';
            prev.removeAttribute('src');
            document.getElementById('l_hapusfoto_wrap').style.display = 'none';

            if (d) {
                f.action = d.url;
                document.getElementById('layananMethod').value = 'PUT';
                document.getElementById('layananTitle').textContent = 'Ubah Layanan';
                document.getElementById('l_judul').value = d.judul || '';
                document.getElementById('l_deskripsi').value = d.deskripsi || '';
                document.getElementById('l_harga').value = d.harga_label || '';
                document.getElementById('l_urutan').value = d.urutan;
                document.getElementById('l_aktif').checked = !!d.aktif;
                if (d.foto) {
                    prev.src = d.foto;
                    prev.style.display = 'block';
                    document.getElementById('l_hapusfoto_wrap').style.display = 'block';
                }
            } else {
                f.action = layananStoreUrl;
                document.getElementById('layananMethod').value = 'POST';
                document.getElementById('layananTitle').textContent = 'Tambah Layanan';
                document.getElementById('l_aktif').checked = true;
            }
            $('#modalLayanan').modal('show');
        }

        function layananHapus(url, judul) {
            if (!confirm('Hapus layanan "' + judul + '"?')) return;
            var f = document.getElementById('formHapusLayanan');
            f.action = url;
            f.submit();
        }
    </script>
@endpush
