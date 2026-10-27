@extends('layouts.auth')

@section('login')
<div class="wrapper">
    <div class="page-header">
        <div class="page-header-image"></div>
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-6 offset-lg-0 offset-md-3">
                        <div id="square7" class="square square-7"></div>
                        <div id="square8" class="square square-8"></div>
                        <div class="card card-register">
                            <div class="card-header">
                                <img class="card-img" src="{{ asset('blk-design/assets/img/square1.png') }}"
                                    alt="Card image">
                                <h4 class="card-title">LOGIN</h4>
                            </div>
                            <div class="card-body">


                                <form action="{{ route('login') }}" method="post" class="form-origin">
                                    @csrf
                                    <div class="form-group has-feedback @error('email') @has-error @enderror">
        
                                        <input type="email" name="email" class="form-control" placeholder="Email"
                                            required value="{{old('email')}}" autofocus>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        @error('email')
                                        <span class="help-block">{{$message}}</span>
                                        @else
                                        <span class="help-block-with-errors"></span>
                                        @enderror
                                    </div>
                                    <div class="form-group has-feedback @error('password') @has-error @enderror">
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Password" required>
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                        @error('password')
                                        <span class="help-block">{{$message}}</span>
                                        @else
                                        <span class="help-block-with-errors"></span>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="form-check text-left">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox">
                                                <span class="form-check-sign"></span>
                                                Remember Me
                                            </label>
                                        </div>
                                        <!-- /.col -->
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-info btn-round btn-lg">Sign In</button>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="register-bg"></div>
                <div id="square1" class="square square-1"></div>
                <div id="square2" class="square square-2"></div>
                <div id="square3" class="square square-3"></div>
                <div id="square4" class="square square-4"></div>
                <div id="square5" class="square square-5"></div>
                <div id="square6" class="square square-6"></div>
            </div>
        </div>
    </div>
</div>
@endsection
    <!--<footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h1 class="title">BLK•</h1>
                </div>
                <div class="col-md-3">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="../index.html" class="nav-link">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../examples/landing-page.html" class="nav-link">
                                Landing
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../examples/register-page.html" class="nav-link">
                                Register
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../examples/profile-page.html" class="nav-link">
                                Profile
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="https://creative-tim.com/contact-us" class="nav-link">
                                Contact Us
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="https://creative-tim.com/about-us" class="nav-link">
                                About Us
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="https://creative-tim.com/blog" class="nav-link">
                                Blog
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="https://opensource.org/licenses/MIT" class="nav-link">
                                License
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h3 class="title">Follow us:</h3>
                    <div class="btn-wrapper profile">
                        <a target="_blank" href="https://twitter.com/creativetim"
                            class="btn btn-icon btn-neutral btn-round btn-simple" data-toggle="tooltip"
                            data-original-title="Follow us">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a target="_blank" href="https://www.facebook.com/creativetim"
                            class="btn btn-icon btn-neutral btn-round btn-simple" data-toggle="tooltip"
                            data-original-title="Like us">
                            <i class="fab fa-facebook-square"></i>
                        </a>
                        <a target="_blank" href="https://dribbble.com/creativetim"
                            class="btn btn-icon btn-neutral  btn-round btn-simple" data-toggle="tooltip"
                            data-original-title="Follow us">
                            <i class="fab fa-dribbble"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>-->

<!-- /.login-box -->

<!--<form action="{{ route('login') }}" method="post" class="form-origin">
                                    @csrf
                                    <div class="input-group">
                                        <div
                                            class="input-group-prepend has-feedback @error('email') @has-error @enderror">
                                            <div class="input-group-text">
                                                <i class="tim-icons icon-email-85"></i>
                                            </div>
                                        </div>
                                        <input type="email" name="email" class="form-control" placeholder="Email"
                                            required value="{{old('email')}}">
                                        @error('email')
                                        <span class="help-block">{{$message}}</span>
                                        @else
                                        <span class="help-block-with-errors"></span>
                                        @enderror
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tim-icons icon-lock-circle"></i>
                                            </div>
                                        </div>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Password" required>
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                        @error('password')
                                        <span class="help-block">{{$message}}</span>
                                        @else
                                        <span class="help-block-with-errors"></span>
                                        @enderror
                                    </div>
                                    <div class="form-check text-left">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox">
                                            <span class="form-check-sign"></span>
                                            I agree to the
                                            <a href="javascript:void(0)">terms and conditions</a>.
                                        </label>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-info btn-round btn-lg">Sign In</button>
                                    </div>
                                </form>-->



