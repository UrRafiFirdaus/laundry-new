@php
    $paragraf = array_filter(array_map('trim', preg_split('/\R{2,}/', trim($landing['tentang_isi'] ?? ''))));
    $poin = array_filter(array_map('trim', preg_split('/\R/', $landing['tentang_poin'] ?? '')));
@endphp
<div class="about-grid">
    <div class="about-media reveal">
        <div class="frame">
            @if (!empty($landing['tentang_gambar']))
                <img src="{{ url($landing['tentang_gambar']) }}" alt="{{ $landing['tentang_judul'] }}" loading="lazy">
            @else
                <div class="ph"><i class="fa-solid fa-shirt"></i></div>
            @endif
        </div>
    </div>
    <div class="about-text reveal" style="--d:.12s">
        <span class="sec-eyebrow">{{ optional($setting)->nama_perusahaan }}</span>
        <h2>{{ $landing['tentang_judul'] }}</h2>
        @foreach ($paragraf as $p)
            <p>{{ $p }}</p>
        @endforeach
        @if ($poin)
            <ul class="check-list">
                @foreach ($poin as $item)
                    <li><i class="fa-solid fa-check"></i> {{ $item }}</li>
                @endforeach
            </ul>
        @endif
        @if (!empty($showMore))
            <a href="{{ route('landing.about') }}" class="btn-lp primary">Selengkapnya <i
                    class="fa-solid fa-arrow-right"></i></a>
        @endif
    </div>
</div>
