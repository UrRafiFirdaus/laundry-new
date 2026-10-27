@includeIf('landing.header')

@extends('landing.master')

@push('css')
    <style>
        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #777;
        }

        .forgot-link {
            color: #007bff !important;
            font-size: 14px;
            text-decoration: none;
        }

        .forgot-link:hover {
            color: #0056b3 !important;
            text-decoration: underline;
        }
    </style>
@endpush

@section('content')
    <div class="container" style="min-height:70vh; display:flex; align-items:center; justify-content:center;">
        <div class="row w-100 justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="section-top-border shadow p-4 bg-white rounded">
                    <h3 class="mb-4 text-center">Sign In</h3>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="text" name="login" class="single-input @error('login') border-danger @enderror"
                                placeholder="Username atau Email" value="{{ old('login') }}" autocomplete="username"
                                autocapitalize="none" autofocus required>
                            @error('login')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="password-wrapper">
                                <input type="password" name="password" id="password"
                                    class="single-input @error('password') border-danger @enderror" placeholder="Password"
                                    required>
                                <i class="fa fa-eye toggle-password" id="togglePassword"></i>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <label>
                                <input type="checkbox" name="remember">
                                Remember Me
                            </label>

                            @if (Route::has('password.request'))
                                <a class="forgot-link" href="{{ route('password.request') }}"> Forgot Password? </a>
                            @endif
                        </div>

                        <div class="text-center">
                            <button type="submit" class="genric-btn info circle">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        const togglePassword =
            document.getElementById('togglePassword');

        const password =
            document.getElementById('password');

        togglePassword.addEventListener('click', function() {

            const type =
                password.getAttribute('type') === 'password' ?
                'text' :
                'password';

            password.setAttribute('type', type);

            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');

        });
    </script>
@endpush
