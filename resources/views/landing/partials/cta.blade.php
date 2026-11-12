@php $waCta = \App\Models\LandingSetting::waLink(optional($setting)->telepon); @endphp
<div class="lp-cta reveal">
    <div>
        <h2>{{ $landing['cta_judul'] }}</h2>
        <p>{{ $landing['cta_isi'] }}</p>
    </div>
    @if ($waCta)
        <a href="{{ $waCta }}" target="_blank" rel="noopener" class="btn-lp white"><i class="fab fa-whatsapp"></i>
            {{ $landing['cta_tombol_teks'] }}</a>
    @elseif (optional($setting)->telepon)
        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $setting->telepon) }}" class="btn-lp white"><i
                class="fa-solid fa-phone"></i> {{ $landing['cta_tombol_teks'] }}</a>
    @endif
</div>
