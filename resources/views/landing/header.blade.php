<!-- HEADER -->
    <header>
        <!-- Header Start -->
        <div class="header-area">
            <div class="main-header header-sticky">
                <!-- Logo -->
                <div class="header-left">
                    <div class="logo">
                        <a href="{{('/')}}"><img src="{{ url(optional($setting)->path_logo ?? 'images/logo-default.png') }}"
                                alt="" width="80"></a>
                    </div>
                    <div class="menu-wrapper  d-flex align-items-center">
                        <!-- Main-menu -->
                        <div class="main-menu d-none d-lg-block">
                            <nav>
                                <ul id="navigation">
                                    <li class="active"><a href="{{('/')}}">Beranda</a></li>
                                    <li><a href="{{route('landing.about')}}">Tentang Kami</a></li>
                                    <li><a href="services.html">Layanan</a></li>
                                    <!-- <li><a href="blog.html">Blog</a>
                                        <ul class="submenu">
                                            <li><a href="blog.html">Blog</a></li>
                                            <li><a href="blog_details.html">Blog Details</a></li>
                                            <li><a href="elements.html">Element</a></li>
                                        </ul>
                                    </li> -->
                                    <li><a href="contact.html">Kontak</a></li>
                                    <li><a href="{{ route('login')}}">Login</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <!--<div class="header-right d-none d-lg-block">
                    <a href="#" class="header-btn1"><img src="{{ asset('/laundry-master/assets/img/icon/call.png')}}"
                            alt=""> (08) 728 256 266</a>
                    <a href="#" class="header-btn2">Make an Appointment</a>
                </div>-->
                <!-- Mobile Menu -->
                <div class="col-12">
                    <div class="mobile_menu d-block d-lg-none"></div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
