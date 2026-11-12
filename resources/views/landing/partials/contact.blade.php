<div class="contact-grid">
    <div class="contact-list">
        @if (optional($setting)->alamat)
            <div class="c-item reveal">
                <div class="ci"><i class="fa-solid fa-location-dot"></i></div>
                <div><b>Alamat</b><span>{{ $setting->alamat }}</span></div>
            </div>
        @endif
        @if (optional($setting)->telepon)
            <div class="c-item reveal" style="--d:.08s">
                <div class="ci"><i class="fa-solid fa-phone"></i></div>
                <div><b>Telepon</b><span>{{ $setting->telepon }}</span></div>
            </div>
        @endif
        @if (optional($setting)->email)
            <div class="c-item reveal" style="--d:.16s">
                <div class="ci"><i class="fa-solid fa-envelope"></i></div>
                <div><b>Email</b><span>{{ $setting->email }}</span></div>
            </div>
        @endif
        @if (!empty($landing['jam_operasional']))
            <div class="c-item reveal" style="--d:.24s">
                <div class="ci"><i class="fa-solid fa-clock"></i></div>
                <div><b>Jam Operasional</b><span>{{ $landing['jam_operasional'] }}</span></div>
            </div>
        @endif
    </div>
    <div class="map-box reveal" style="--d:.1s">
        @if (!empty($landing['maps_embed']))
            <iframe src="{{ $landing['maps_embed'] }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen title="Lokasi"></iframe>
        @else
            <div class="ph"><i
                    class="fa-solid fa-map-location-dot"></i><span>{{ optional($setting)->alamat }}</span></div>
        @endif
    </div>
</div>
