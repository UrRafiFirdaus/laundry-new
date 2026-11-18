{{--
    Layout dasar halaman error (mandiri).
    Sengaja TIDAK memakai landing.master supaya tetap tampil walaupun
    error terjadi karena database/konfigurasi bermasalah (mis. 500/503).
--}}
@php
    // Ambil data perusahaan secara aman: tidak boleh memicu error baru.
    $setting = $setting ?? null;
    if (!$setting) {
        try {
            if (class_exists(\App\Models\Setting::class)) {
                $setting = \App\Models\Setting::first();
            }
        } catch (\Throwable $e) {
            $setting = null;
        }
    }

    $warna = '#0ea5e9';
    try {
        if (class_exists(\App\Models\LandingSetting::class)) {
            $tmp = \App\Models\LandingSetting::allKeyed()['warna_utama'] ?? '';
            if (preg_match('/^#[0-9a-fA-F]{6}$/', $tmp)) {
                $warna = $tmp;
            }
        }
    } catch (\Throwable $e) {
    }

    $namaUsaha = optional($setting)->nama_perusahaan ?: config('app.name', 'Aplikasi');
    $logo = optional($setting)->path_logo;

    $kode = trim($__env->yieldContent('code'));
    $judul = trim($__env->yieldContent('title'));
    $pesan = trim($__env->yieldContent('message'));
    $ikon = trim($__env->yieldContent('icon')) ?: 'fa-triangle-exclamation';
    $isServer = is_numeric($kode) && (int) $kode >= 500;

    try {
        $sudahLogin = auth()->check();
    } catch (\Throwable $e) {
        $sudahLogin = false;
    }
    try {
        $urlBeranda = url('/');
        $urlDashboard = \Illuminate\Support\Facades\Route::has('dashboard') ? route('dashboard') : $urlBeranda;
    } catch (\Throwable $e) {
        $urlBeranda = $urlDashboard = '/';
    }

    $refId = strtoupper(substr(md5(now()->timestamp . request()->fullUrl()), 0, 8));
@endphp
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>{{ $kode }} - {{ $judul }} | {{ $namaUsaha }}</title>
    @if ($logo)
        <link rel="shortcut icon" href="{{ url($logo) }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --primary: {{ $warna }};
            --primary-dark: color-mix(in srgb, var(--primary) 78%, #000);
            --primary-soft: color-mix(in srgb, var(--primary) 10%, #fff);
            --ink: #0f172a;
            --muted: #64748b;
            --line: #e2e8f0;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            font-family: "Plus Jakarta Sans", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(900px 420px at 85% -10%, color-mix(in srgb, var(--primary) 16%, transparent), transparent 60%),
                radial-gradient(700px 380px at -10% 110%, color-mix(in srgb, var(--primary) 12%, transparent), transparent 60%),
                #f8fafc;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        .err-top {
            padding: 18px 22px;
        }

        .err-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            color: var(--ink);
            text-decoration: none;
        }

        .err-brand img {
            height: 36px;
            width: auto;
        }

        .err-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px 20px 40px;
        }

        .err-card {
            width: 100%;
            max-width: 560px;
            text-align: center;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 24px;
            padding: 44px 32px 34px;
            box-shadow: 0 25px 50px -24px rgba(15, 23, 42, .28);
            animation: rise .5s ease both;
        }

        .err-icon {
            width: 76px;
            height: 76px;
            margin: 0 auto 14px;
            border-radius: 22px;
            display: grid;
            place-items: center;
            font-size: 32px;
            color: var(--primary);
            background: var(--primary-soft);
            animation: float 3.2s ease-in-out infinite;
        }

        .err-code {
            font-size: clamp(64px, 16vw, 104px);
            font-weight: 800;
            line-height: 1;
            letter-spacing: -.04em;
            margin: 0;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .err-title {
            font-size: 22px;
            font-weight: 800;
            margin: 10px 0 8px;
            letter-spacing: -.02em;
        }

        .err-msg {
            color: var(--muted);
            line-height: 1.7;
            margin: 0 auto 26px;
            max-width: 440px;
            font-size: 15px;
        }

        .err-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .err-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 20px;
            border-radius: 12px;
            font: inherit;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
            border: 1.5px solid transparent;
            transition: transform .15s ease, box-shadow .15s ease, background .15s ease;
        }

        .err-btn:hover {
            transform: translateY(-2px);
        }

        .err-btn.primary {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 10px 20px -10px var(--primary);
        }

        .err-btn.primary:hover {
            background: var(--primary-dark);
        }

        .err-btn.ghost {
            background: #fff;
            color: var(--ink);
            border-color: var(--line);
        }

        .err-btn.ghost:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .err-meta {
            margin-top: 26px;
            padding-top: 16px;
            border-top: 1px dashed var(--line);
            font-size: 12px;
            color: var(--muted);
        }

        .err-meta code {
            background: #f1f5f9;
            padding: 2px 7px;
            border-radius: 6px;
            font-size: 12px;
        }

        .err-debug {
            margin-top: 18px;
            text-align: left;
            background: #0f172a;
            color: #e2e8f0;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 12px;
            line-height: 1.6;
            overflow-x: auto;
            word-break: break-word;
        }

        .err-foot {
            text-align: center;
            padding: 0 16px 22px;
            font-size: 12px;
            color: var(--muted);
        }

        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .err-card,
            .err-icon {
                animation: none;
            }
        }

        @media (max-width: 480px) {
            .err-card {
                padding: 34px 20px 26px;
                border-radius: 20px;
            }

            .err-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
    @yield('head')
</head>

<body>
    <div class="err-top">
        <a href="{{ $urlBeranda }}" class="err-brand">
            @if ($logo)
                <img src="{{ url($logo) }}" alt="Logo">
            @endif
            <span>{{ $namaUsaha }}</span>
        </a>
    </div>

    <main class="err-main">
        <section class="err-card" role="alert">
            <div class="err-icon"><i class="fa-solid {{ $ikon }}"></i></div>
            <h1 class="err-code">{{ $kode }}</h1>
            <h2 class="err-title">{{ $judul }}</h2>
            <p class="err-msg">{{ $pesan }}</p>

            <div class="err-actions">
                @hasSection('actions')
                    @yield('actions')
                @else
                    <a href="javascript:history.length > 1 ? history.back() : (location.href='{{ $urlBeranda }}')"
                        class="err-btn ghost"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                    <a href="{{ $sudahLogin ? $urlDashboard : $urlBeranda }}" class="err-btn primary">
                        <i class="fa-solid {{ $sudahLogin ? 'fa-gauge' : 'fa-house' }}"></i>
                        {{ $sudahLogin ? 'Ke Dashboard' : 'Ke Beranda' }}
                    </a>
                @endif
            </div>

            @if ($isServer || in_array($kode, ['429', '419']))
                <div class="err-meta">
                    Jika masalah berlanjut, hubungi admin dan sertakan kode
                    <code>{{ $refId }}</code>
                </div>
            @endif

            @if (config('app.debug') && isset($exception) && $exception instanceof \Throwable && $exception->getMessage())
                <div class="err-debug"><strong>Debug:</strong> {{ $exception->getMessage() }}</div>
            @endif
        </section>
    </main>

    <div class="err-foot">&copy; {{ date('Y') }} {{ $namaUsaha }}</div>
    @yield('scripts')
</body>

</html>
