@php $home = url('/'); @endphp
<header class="lp-nav">
    <div class="lp-container">
        <a href="{{ $home }}" class="lp-brand">
            @if (optional($setting)->path_logo)
                <img src="{{ url($setting->path_logo) }}" alt="Logo">
            @endif
            <span>{{ optional($setting)->nama_perusahaan }}</span>
        </a>

        <button class="lp-burger" type="button" aria-label="Menu" aria-expanded="false"><i
                class="fa-solid fa-bars"></i></button>

        <ul class="lp-menu">
            <li><a href="{{ $home }}"
                    class="{{ request()->routeIs('landing.index') ? 'active' : '' }}">Beranda</a></li>
            <li><a href="{{ $home }}#layanan">Layanan</a></li>
            <li><a href="{{ route('landing.about') }}"
                    class="{{ request()->routeIs('landing.about') ? 'active' : '' }}">Tentang Kami</a></li>
            <li><a href="{{ route('landing.status') }}"
                    class="{{ request()->routeIs('landing.status', 'status.cek') ? 'active' : '' }}">Cek Status</a></li>
            <li><a href="{{ $home }}#kontak">Kontak</a></li>
            <li class="login"><a href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
            </li>
        </ul>
    </div>
</header>
