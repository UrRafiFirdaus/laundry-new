@php
    $landing = $landing ?? \App\Models\LandingSetting::allKeyed();
    $warna = preg_match('/^#[0-9a-fA-F]{6}$/', $landing['warna_utama'] ?? '') ? $landing['warna_utama'] : '#0ea5e9';
    $namaUsaha = optional($setting)->nama_perusahaan ?? config('app.name');
    $logo = optional($setting)->path_logo;
@endphp
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
        @hasSection('title')
            @yield('title') |
        @endif{{ $namaUsaha }}
    </title>
    <meta name="description"
        content="{{ \Illuminate\Support\Str::limit(strip_tags($landing['hero_subjudul'] ?? ''), 150) }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if ($logo)
        <link rel="shortcut icon" href="{{ url($logo) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}?v={{ @filemtime(public_path('css/landing.css')) }}">
    <style>
        :root {
            --primary: {{ $warna }};
        }
    </style>

    @stack('css')
</head>

<body class="lp">
    @include('landing.header')

    @yield('content')

    @include('landing.footer')

    @php $waLink = \App\Models\LandingSetting::waLink(optional($setting)->telepon); @endphp
    @if ($waLink)
        <a href="{{ $waLink }}" class="wa-float" target="_blank" rel="noopener" aria-label="Chat WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
    @endif

    <script src="{{ asset('js/landing.js') }}?v={{ @filemtime(public_path('js/landing.js')) }}"></script>
    @stack('scripts')
</body>

</html>
