@extends('landing.master')

@section('title', $landing['tentang_judul'] ?? 'Tentang Kami')

@section('content')
    @php
        $misi = array_filter(array_map('trim', preg_split('/\R/', $landing['misi'] ?? '')));
    @endphp
    <main>
        <section class="page-head">
            <div class="bubbles"><span></span><span></span><span></span><span></span><span></span><span></span></div>
            <div class="lp-container">
                <h1>{{ $landing['tentang_judul'] }}</h1>
                <p>{{ optional($setting)->nama_perusahaan }}</p>
            </div>
        </section>

        <section class="lp-section">
            <div class="lp-container">
                @include('landing.partials.about_section')

                @if (!empty($landing['visi']) || $misi)
                    <div class="vm-grid">
                        @if (!empty($landing['visi']))
                            <div class="vm-card reveal">
                                <div class="badge-ico"><i class="fa-solid fa-eye"></i></div>
                                <h3>Visi</h3>
                                <p>{{ $landing['visi'] }}</p>
                            </div>
                        @endif
                        @if ($misi)
                            <div class="vm-card reveal" style="--d:.1s">
                                <div class="badge-ico"><i class="fa-solid fa-bullseye"></i></div>
                                <h3>Misi</h3>
                                <ul>
                                    @foreach ($misi as $m)
                                        <li>{{ $m }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </section>

        <section style="padding-bottom: 96px;">
            <div class="lp-container">
                @include('landing.partials.cta')
            </div>
        </section>
    </main>
@endsection
