@php
    $landing = $landing ?? \App\Models\LandingSetting::allKeyed();
    $warna = preg_match('/^#[0-9a-fA-F]{6}$/', $landing['warna_utama'] ?? '') ? $landing['warna_utama'] : '#0ea5e9';
    $namaUsaha = optional($setting)->nama_perusahaan ?? config('app.name');
    $logo = optional($setting)->path_logo;
    $foto = $landing['login_gambar'] ?? null;
@endphp
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Login | {{ $namaUsaha }}</title>
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
</head>

<body class="lp">
    <div class="login-page-lp">

        {{-- Panel kiri: foto/gradasi + teks (diatur admin) --}}
        <aside class="login-side {{ $foto ? '' : 'no-photo' }}"
            @if ($foto) style="background-image:url('{{ url($foto) }}')" @endif>
            <div class="bubbles"><span></span><span></span><span></span><span></span><span></span><span></span></div>
            <a href="{{ url('/') }}" class="lp-brand">
                @if ($logo)
                    <img src="{{ url($logo) }}" alt="Logo">
                @endif
                <span>{{ $namaUsaha }}</span>
            </a>
            <div>
                <h2>{{ $landing['login_judul'] }}</h2>
                <p>{{ $landing['login_subjudul'] }}</p>
            </div>
            <small style="opacity:.75">&copy; {{ date('Y') }} {{ $namaUsaha }}</small>
        </aside>

        {{-- Panel kanan: form --}}
        <main class="login-main">
            <div class="login-box">
                @if ($logo)
                    <img src="{{ url($logo) }}" alt="Logo" class="logo-mini">
                @endif
                <h1>Masuk</h1>
                <p class="sub">Gunakan username atau email akun Anda.</p>

                @if (session('status'))
                    <div class="status-ok">{{ session('status') }}</div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="f-group">
                        <label for="login">Username atau Email</label>
                        <div class="f-input">
                            <i class="fa-solid fa-user lead"></i>
                            <input type="text" name="login" id="login" class="@error('login') err @enderror"
                                placeholder="Username atau Email" value="{{ old('login') }}" autocomplete="username"
                                autocapitalize="none" autofocus required>
                        </div>
                        @error('login')
                            <span class="f-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="f-group">
                        <label for="password">Password</label>
                        <div class="f-input">
                            <i class="fa-solid fa-lock lead"></i>
                            <input type="password" name="password" id="password"
                                class="@error('password') err @enderror" placeholder="Password"
                                autocomplete="current-password" required>
                            <button type="button" class="toggle-pw" id="togglePassword"
                                aria-label="Tampilkan password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="f-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="login-row">
                        <label><input type="checkbox" name="remember"> Ingat saya</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Lupa password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-lp primary"><i class="fa-solid fa-right-to-bracket"></i>
                        Login</button>
                </form>

                <a href="{{ url('/') }}" class="back-home"><i class="fa-solid fa-arrow-left"></i> Kembali ke
                    beranda</a>
            </div>
        </main>
    </div>

    <script>
        (function() {
            var btn = document.getElementById('togglePassword');
            var pw = document.getElementById('password');
            btn.addEventListener('click', function() {
                var show = pw.type === 'password';
                pw.type = show ? 'text' : 'password';
                btn.querySelector('i').className = show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
            });
        })();
    </script>
</body>

</html>
