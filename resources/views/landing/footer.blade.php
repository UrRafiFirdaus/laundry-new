@php
    $nama = optional($setting)->nama_perusahaan;
    $sosial = [
        'instagram' => 'fa-instagram',
        'facebook' => 'fa-facebook-f',
        'tiktok' => 'fa-tiktok',
    ];
    $waLinkFooter = \App\Models\LandingSetting::waLink(optional($setting)->telepon);
@endphp
<footer class="lp-footer">
    <div class="lp-container">
        <div class="foot-grid">
            <div>
                <a href="{{ url('/') }}" class="lp-brand">
                    @if (optional($setting)->path_logo)
                        <img src="{{ url($setting->path_logo) }}" alt="Logo">
                    @endif
                    <span>{{ $nama }}</span>
                </a>
                <p>{{ \Illuminate\Support\Str::limit(strip_tags($landing['hero_subjudul'] ?? ''), 160) }}</p>
                <div class="foot-social">
                    @foreach ($sosial as $key => $icon)
                        @if (!empty($landing[$key]))
                            <a href="{{ $landing[$key] }}" target="_blank" rel="noopener"
                                aria-label="{{ ucfirst($key) }}"><i class="fab {{ $icon }}"></i></a>
                        @endif
                    @endforeach
                    @if ($waLinkFooter)
                        <a href="{{ $waLinkFooter }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i
                                class="fab fa-whatsapp"></i></a>
                    @endif
                </div>
            </div>
            <div>
                <h4>Menu</h4>
                <ul>
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li><a href="{{ url('/') }}#layanan">Layanan</a></li>
                    <li><a href="{{ route('landing.about') }}">Tentang Kami</a></li>
                    <li><a href="{{ route('landing.status') }}">Cek Status Laundry</a></li>
                </ul>
            </div>
            <div>
                <h4>Hubungi Kami</h4>
                <ul>
                    @if (optional($setting)->telepon)
                        <li><i class="fa-solid fa-phone"></i> {{ $setting->telepon }}</li>
                    @endif
                    @if (optional($setting)->email)
                        <li><i class="fa-solid fa-envelope"></i> {{ $setting->email }}</li>
                    @endif
                    @if (optional($setting)->alamat)
                        <li><i class="fa-solid fa-location-dot"></i> {{ $setting->alamat }}</li>
                    @endif
                    @if (!empty($landing['jam_operasional']))
                        <li><i class="fa-solid fa-clock"></i> {{ $landing['jam_operasional'] }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="foot-bottom">
        <div class="lp-container">Copyright &copy; {{ date('Y') }} <strong>{{ $nama }}</strong>. All
            rights reserved.</div>
    </div>
</footer>
