@extends('landing.master')

@section('content')
    @php
        $heroFoto = $landing['hero_gambar'] ?? null;
        $overlay = max(0, min(90, (int) ($landing['hero_overlay'] ?? 55))) / 100;
        $langkah = [
            ['fa-solid fa-hand-holding-heart', $landing['langkah1_judul'], $landing['langkah1_isi']],
            ['fa-solid fa-soap', $landing['langkah2_judul'], $landing['langkah2_isi']],
            ['fa-solid fa-bag-shopping', $landing['langkah3_judul'], $landing['langkah3_isi']],
        ];
        $stats = [
            [$landing['stat1_angka'], $landing['stat1_label']],
            [$landing['stat2_angka'], $landing['stat2_label']],
            [$landing['stat3_angka'], $landing['stat3_label']],
        ];
    @endphp
    <main>
        {{-- ============ HERO ============ --}}
        <section class="lp-hero {{ $heroFoto ? '' : 'no-photo' }}"
            style="@if ($heroFoto) background-image:url('{{ url($heroFoto) }}'); @endif --overlay: {{ $overlay }};">
            <div class="bubbles"><span></span><span></span><span></span><span></span><span></span><span></span></div>
            <div class="lp-container">
                <div class="hero-inner">
                    @if (!empty($landing['hero_badge']))
                        <span class="hero-badge"><i class="fa-solid fa-star"></i> {{ $landing['hero_badge'] }}</span>
                    @endif
                    <h1>{{ $landing['hero_judul'] }}</h1>
                    <p class="lead">{{ $landing['hero_subjudul'] }}</p>
                    <div class="hero-actions">
                        @if (!empty($landing['hero_tombol_teks']))
                            <a href="{{ $landing['hero_tombol_link'] ?: route('landing.status') }}" class="btn-lp primary"><i
                                    class="fa-solid fa-magnifying-glass"></i> {{ $landing['hero_tombol_teks'] }}</a>
                        @endif
                        @if (!empty($landing['hero_tombol2_teks']))
                            <a href="{{ $landing['hero_tombol2_link'] ?: '#layanan' }}"
                                class="btn-lp ghost">{{ $landing['hero_tombol2_teks'] }} <i
                                    class="fa-solid fa-arrow-down"></i></a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="hero-wave">
                <svg viewBox="0 0 1440 80" preserveAspectRatio="none">
                    <path fill="#ffffff" d="M0,48 C240,90 480,0 720,30 C960,60 1200,90 1440,40 L1440,80 L0,80 Z" />
                </svg>
            </div>
        </section>

        {{-- ============ STATISTIK ============ --}}
        <section class="lp-stats">
            <div class="lp-container">
                <div class="stats-grid">
                    @foreach ($stats as $i => $st)
                        <div class="stat-card reveal" style="--d: {{ $i * 0.1 }}s">
                            <div class="num" data-count="{{ $st[0] }}">{{ $st[0] }}</div>
                            <div class="lbl">{{ $st[1] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============ PROSES ============ --}}
        <section class="lp-section" id="proses">
            <div class="lp-container">
                <div class="sec-head reveal">
                    <span class="sec-eyebrow">{{ $landing['proses_subjudul'] }}</span>
                    <h2>{{ $landing['proses_judul'] }}</h2>
                </div>
                <div class="steps">
                    @foreach ($langkah as $i => $lk)
                        <div class="step reveal" style="--d: {{ $i * 0.12 }}s">
                            <div class="ico"><i class="{{ $lk[0] }}"></i><span
                                    class="no">{{ $i + 1 }}</span></div>
                            <h3>{{ $lk[1] }}</h3>
                            <p>{{ $lk[2] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============ LAYANAN ============ --}}
        <section class="lp-section alt" id="layanan">
            <div class="lp-container">
                <div class="sec-head reveal">
                    <span class="sec-eyebrow">Layanan</span>
                    <h2>{{ $landing['layanan_judul'] }}</h2>
                    <p>{{ $landing['layanan_subjudul'] }}</p>
                </div>
                @if ($layanan->count())
                    <div class="svc-grid">
                        @foreach ($layanan as $i => $l)
                            <article class="svc-card reveal" style="--d: {{ ($i % 4) * 0.08 }}s">
                                <div class="svc-img">
                                    @if ($l->foto)
                                        <img src="{{ url($l->foto) }}" alt="{{ $l->judul }}" loading="lazy">
                                    @else
                                        <div class="ph"><i class="fa-solid fa-shirt"></i></div>
                                    @endif
                                    @if ($l->harga_label)
                                        <span class="svc-badge">{{ $l->harga_label }}</span>
                                    @endif
                                </div>
                                <div class="svc-body">
                                    <h3>{{ $l->judul }}</h3>
                                    <p>{{ $l->deskripsi }}</p>
                                    <a href="{{ route('landing.status') }}" class="svc-link">Cek status cucian <i
                                            class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <p class="text-center" style="text-align:center;color:var(--muted)">Layanan akan segera tersedia.</p>
                @endif
            </div>
        </section>

        {{-- ============ TENTANG ============ --}}
        <section class="lp-section" id="tentang">
            <div class="lp-container">
                @include('landing.partials.about_section', ['showMore' => true])
            </div>
        </section>

        {{-- ============ CTA ============ --}}
        <section style="padding-bottom: 96px;">
            <div class="lp-container">
                @include('landing.partials.cta')
            </div>
        </section>

        {{-- ============ KONTAK ============ --}}
        <section class="lp-section alt" id="kontak" style="padding-bottom:0;">
            <div class="lp-container" style="padding-bottom:96px;">
                <div class="sec-head reveal">
                    <span class="sec-eyebrow">Kontak</span>
                    <h2>Temukan Kami</h2>
                </div>
                @include('landing.partials.contact')
            </div>
        </section>
    </main>
@endsection
