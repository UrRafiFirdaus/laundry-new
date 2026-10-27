<!--
=========================================================
* BLK Design System- v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/blk-design-system
* Copyright 2019 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('blk-design/assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('blk-design/assets/img/favicon.png') }}">
    <title>
        {{ config('app.name') }} | Login
    </title>
    
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" >
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- Nucleo Icons -->
     <link rel="stylesheet" href="{{ asset('blk-design/assets/css/nucleo-icons.css') }}">
    <!-- CSS Files -->
     <link rel="stylesheet" href="{{ asset('blk-design/assets/css/blk-design-system.css?v=1.0.0') }}">
    <!-- CSS Just for demo purpose, don't include it in your project -->
     <link rel="stylesheet" href="{{ asset('blk-design/assets/demo/demo.css') }}">
</head>

<body class="register-page">



    <!-- Navbar -->
    <!-- class="navbar navbar-expand-lg fixed-top navbar-transparent " color-on-scroll="100">
        <div class="container">
            <div class="navbar-translate">
                <a class="navbar-brand" href="https://demos.creative-tim.com/blk-design-system/index.html" rel="tooltip"
                    title="Designed and Coded by Creative Tim" data-placement="bottom" target="_blank">
                    <span>BLK•</span> Design System
                </a>
                <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navigation" aria-controls="navigation-index" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a>
                                BLK•
                            </a>
                        </div>
                        <div class="col-6 collapse-close text-right">
                            <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#navigation" aria-controls="navigation-index" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <i class="tim-icons icon-simple-remove"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <ul class="navbar-nav">
                    <li class="nav-item p-0">
                        <a class="nav-link" rel="tooltip" title="Follow us on Twitter" data-placement="bottom"
                            href="https://twitter.com/CreativeTim" target="_blank">
                            <i class="fab fa-twitter"></i>
                            <p class="d-lg-none d-xl-none">Twitter</p>
                        </a>
                    </li>
                    <li class="nav-item p-0">
                        <a class="nav-link" rel="tooltip" title="Like us on Facebook" data-placement="bottom"
                            href="https://www.facebook.com/CreativeTim" target="_blank">
                            <i class="fab fa-facebook-square"></i>
                            <p class="d-lg-none d-xl-none">Facebook</p>
                        </a>
                    </li>
                    <li class="nav-item p-0">
                        <a class="nav-link" rel="tooltip" title="Follow us on Instagram" data-placement="bottom"
                            href="https://www.instagram.com/CreativeTimOfficial" target="_blank">
                            <i class="fab fa-instagram"></i>
                            <p class="d-lg-none d-xl-none">Instagram</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.html">Back to Kit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://github.com/creativetimofficial/blk-design-system/issues">Have
                            an issue?</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>-->
    <!-- End Navbar -->
    @yield('login')

    <!--   Core JS Files   -->
    <script src="{{ asset('blk-design/assets/js/core/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('blk-design/assets/js/core/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('blk-design/assets/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('blk-design/assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="{{ asset('blk-design/assets/js/plugins/bootstrap-switch.js') }}"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="{{ asset('blk-design/assets/js/plugins/nouislider.min.js') }}" type="text/javascript"></script>
    <!-- Chart JS -->
    <script src="{{ asset('blk-design/assets/js/plugins/chartjs.min.js') }}"></script>
    <!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
    <script src="{{ asset('blk-design/assets/js/plugins/moment.min.js') }}"></script>
    <script src="{{ asset('blk-design/assets/js/plugins/bootstrap-datetimepicker.js') }}" type="text/javascript">
    </script>
    <!-- Black Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{ asset('blk-design/assets/demo/demo.js') }}"></script>
    <!-- Control Center for Black UI Kit: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('blk-design/assets/js/blk-design-system.min.js?v=1.0.0') }}" type="text/javascript"></script>
</body>

</html>