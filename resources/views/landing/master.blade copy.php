<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name') }} </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/laundry-master/assets/img/favicon.ico')}}">

    <!-- CSRF-TOKEN -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('/laundry-master/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/laundry-master/assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/laundry-master/assets/css/slicknav.css')}}">
    <link rel="stylesheet" href="{{ asset('/laundry-master/assets/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{ asset('/laundry-master/assets/css/progressbar_barfiller.css')}}">
    <link rel="stylesheet" href="{{ asset('/laundry-master/assets/css/gijgo.css')}}">
    <link rel="stylesheet" href="{{ asset('/laundry-master/assets/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/laundry-master/assets/css/animated-headline.css')}}">
    <link rel="stylesheet" href="{{ asset('/laundry-master/assets/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{ asset('/laundry-master/assets/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/laundry-master/assets/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{ asset('/laundry-master/assets/css/slick.css')}}">
    <link rel="stylesheet" href="{{ asset('/laundry-master/assets/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{ asset('/laundry-master/assets/css/style.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    

     @stack('css')
</head>

<body>
    <!-- ? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{ url($setting->path_logo) }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->

    <!-- HEADER -->
    

    <!-- MAIN CONTENT -->
    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <!--<section class="content-header">
                <h1>
                    @yield('title')
                </h1>
                <ol class="breadcrumb">
                    @section('breadcrumb')
                    <li><a href="{ url('/')}"><i class="fa fa-dashboard"></i> Home</a></li>
                    @show
                </ol>
            </section>-->
            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>

    <!-- FOOTER --> 
    @includeIf('landing.footer')


    <!-- Scroll Up -->
    <div id="back-top">
        <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
    </div>

    <!-- JS here -->

    <script src="{{ asset('./laundry-master/assets/js/vendor/modernizr-3.5.0.min.js')}}"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="{{ asset('./laundry-master/assets/js/vendor/jquery-1.12.4.min.js')}}"></script>
    <script src="{{ asset('./laundry-master/assets/js/popper.min.js')}}"></script>
    <script src="{{ asset('./laundry-master/assets/js/bootstrap.min.js')}}"></script>
    <!-- Jquery Mobile Menu -->
    <script src="{{ asset('./laundry-master/assets/js/jquery.slicknav.min.js')}}"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="{{ asset('./laundry-master/assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('./laundry-master/assets/js/slick.min.js')}}"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="{{ asset('./laundry-master/assets/js/wow.min.js')}}"></script>
    <script src="{{ asset('./laundry-master/assets/js/animated.headline.js')}}"></script>
    <script src="{{ asset('./laundry-master/assets/js/jquery.magnific-popup.js')}}"></script>

    <!-- Date Picker -->
    <script src="{{ asset('./laundry-master/assets/js/gijgo.min.js')}}"></script>
    <!-- Nice-select, sticky -->
    <script src="{{ asset('./laundry-master/assets/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{ asset('./laundry-master/assets/js/jquery.sticky.js')}}"></script>
    <!-- Progress -->
    <script src="{{ asset('./laundry-master/assets/js/jquery.barfiller.js')}}"></script>

    <!-- counter , waypoint,Hover Direction -->
    <script src="{{ asset('./laundry-master/assets/js/jquery.counterup.min.js')}}"></script>
    <script src="{{ asset('./laundry-master/assets/js/waypoints.min.js')}}"></script>
    <script src="{{ asset('./laundry-master/assets/js/jquery.countdown.min.js')}}"></script>
    <script src="{{ asset('./laundry-master/assets/js/hover-direction-snake.min.js')}}"></script>

    <!-- contact js -->
    <script src="{{ asset('./laundry-master/assets/js/contact.js')}}"></script>
    <script src="{{ asset('./laundry-master/assets/js/jquery.form.js')}}"></script>
    <script src="{{ asset('./laundry-master/assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('./laundry-master/assets/js/mail-script.js')}}"></script>
    <script src="{{ asset('./laundry-master/assets/js/jquery.ajaxchimp.min.js')}}"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="{{ asset('./laundry-master/assets/js/plugins.js')}}"></script>
    <script src="{{ asset('./laundry-master/assets/js/main.js')}}"></script>

    @stack('scripts')
</body>

</html>