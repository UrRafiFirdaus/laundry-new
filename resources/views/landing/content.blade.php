@includeIf('landing.header')

@extends('landing.master')



@section('content')
    <main>
        <!--? slider Area Start-->
        <section class="slider-area hero-overly" style="background-image:url('{{ url($setting->path_logo) }}')">
            <div class="slider-active">
                <!-- Single Slider -->
                <div class="single-slider slider-height d-flex align-items-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-7 col-lg-9 col-md-10 col-sm-9">
                                <div class="hero__caption">
                                    <h1 data-animation="fadeInLeft" data-delay="0.2s">Quality laundry service in your
                                        city</h1>
                                    <p data-animation="fadeInLeft" data-delay="0.4s">We take care about cleenness of
                                        your cloth</p>
                                    <a href="{{ route('landing.status') }}" class="genric-btn info circle"
                                        data-animation="fadeInLeft" data-delay="0.7s">Cek Status Laundry</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- slider Area End-->
        <!--? Services Area Start -->
        <section class="services-area pt-top border-bottom pb-20 mb-60">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="section-tittle text-center mb-55">
                            <span class="element">Cepat, Mudah, Praktis, & Terpercaya</span>
                            <h2>Bagaimana Proses Kami?</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-cat text-center">
                            <div class="cat-icon">
                                <img src="{{ asset('/laundry-master/assets/img/icon/services-icon1.svg') }}" alt="">
                            </div>
                            <div class="cat-cap">
                                <h5><a href="services.html">Kami Terima Laundry Anda</a></h5>
                                <p>Bawa Laundry Anda ke Hamidah Laundry. Kami akan mencatat dengan teliti agar setiap
                                    laundry mendapatkan penanganan yang tepat.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-cat text-center">
                            <div class="cat-icon">
                                <img src="{{ asset('/laundry-master/assets/img/icon/services-icon2.svg') }}" alt="">
                            </div>
                            <div class="cat-cap">
                                <h5><a href="services.html">Kami Proses Laundry Anda</a></h5>
                                <p>Laundry Anda diproses dengan cermat melalui tahapan pencucian dan perawatan sesuai
                                    layanan yang dipilih untuk menjaga kebersihan dan kenyamanannya.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-cat text-center">
                            <div class="cat-icon">
                                <img src="{{ asset('/laundry-master/assets/img/icon/services-icon3.svg') }}" alt="">
                            </div>
                            <div class="cat-cap">
                                <h5><a href="services.html">Laundry siap Diambil</a></h5>
                                <p>Setelah proses selesai, laundry Anda siap diambil dalam kondisi bersih dan rapi sesuai
                                    layanan yang dipesan. Cek status laundry Anda dengan mudah melalui website kami.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Services End -->
        <!--? Offer-services Start  -->
        <section class="offer-services pb-bottom2">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="section-tittle text-center mb-55">
                            <!-- <span class="element">Services</span> -->
                            <h2>Layanan Kami</h2>
                        </div>
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-lg-6 col-md-6">
                        <div class="single-offers">
                            <img src="{{ asset('/laundry-master/assets/img/gallery/offers1.png') }}" alt=""
                                class=" w-100">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="single-offers">
                            <img src="{{ asset('/laundry-master/assets/img/gallery/offers2.png') }}" alt=""
                                class=" w-100">
                            <div class="offers-caption text-center">
                                <div class="cat-icon">
                                    <img src="{{ asset('/laundry-master/assets/img/icon/offers-icon1.png') }}"
                                        alt="">
                                </div>
                                <div class="cat-cap">
                                    <h5><a href="services.html">Cuci Bersih</a></h5>
                                    <p>Pakaian bersih, segar, dan harum setiap hari! Kami membantu membersihkan laundry Anda
                                        dengan proses pencucian yang tepat agar kembali nyaman digunakan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="single-offers">
                            <img src="{{ asset('/laundry-master/assets/img/gallery/offers2.png') }}" alt=""
                                class=" w-100">
                            <div class="offers-caption text-center">
                                <div class="cat-icon">
                                    <img src="{{ asset('/laundry-master/assets/img/icon/offers-icon1.png') }}"
                                        alt="">
                                </div>
                                <div class="cat-cap">
                                    <h5><a href="services.html">Cuci Bersih dan Setrika</a></h5>
                                    <p>Solusi praktis untuk laundry bersih sekaligus rapi. Serahkan urusan mencuci dan
                                        menyetrika kepada Hamidah Laundry, agar Anda punya lebih banyak waktu untuk hal-hal
                                        penting lainnya.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="single-offers">
                            <img src="{{ asset('/laundry-master/assets/img/gallery/offers4.png') }}" alt=""
                                class=" w-100">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Offer-services End  -->
        <!--? Want To work -->
        <section class="container">
            <section class="wantToWork-area"
                data-background="{{ asset('/laundry-master/assets/img/gallery/section_bg01.png') }}">
                <div class="wants-wrapper w-padding2">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-xl-8 col-lg-9 col-md-7">
                            <div class="wantToWork-caption wantToWork-caption2">
                                <h2>Butuh Bantuan?</h2>
                                <p>Kami siap melayani sepenuh hati.</p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-5">
                            <a href="#" class="btn wantToWork-btn"><img
                                    src="{{ asset('/laundry-master/assets/img/icon/call2.png') }}" alt="">
                                Hubungi</a>
                        </div>
                    </div>
                </div>
            </section>
        </section>


        <!-- Want To work End
        <!-- Testimonials_start -->
        <!-- <section class="testimonials-area testimonials-overly  position-relative">
            <div class="container">
                <div class="border-bottom section-padding40 ">
                    <div class="row">
                        <div class="col-xl-12 ">
                            <!-- testmonial-image -->
        <!-- <div class="testmonial-nav text-center">
                                <div class="testmonial-thumb">
                                    <img src="{{ asset('/laundry-master/assets/img/gallery/testimonila1.png') }}" alt="">
                                </div>
                                <div class="testmonial-thumb">
                                    <img src="{{ asset('/laundry-master/assets/img/gallery/testimonila2.png') }}" alt="">
                                </div> -->
        <!--<div class="testmonial-thumb">
                                    <img src="{{ asset('/laundry-asset/assets/img/gallery/testimonila3.png') }}" alt="">
                                </div>-->
        <!-- <div class="testmonial-thumb">
                                    <img src="{{ asset('/laundry-master/assets/img/gallery/testimonila2.png') }}" alt="">
                                </div>
                            </div>
                            <div class="testmonial-item-active text-center"> -->
        <!-- testimonial-single-items -->
        <!-- <div class="testmonial-item ">
                                    <p class="pera">The automated process starts as soon as your clothes go into the<br>
                                        machine. The outcome is gleaming clothes!</p>
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <p> - Rupaya</p>
                                </div> -->
        <!-- testimonial-single-items -->
        <!-- <div class="testmonial-item ">
                                    <p class="pera">The automated process starts as soon as your clothes go into the<br>
                                        machine. The outcome is gleaming clothes!</p>
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <p> - Rupaya</p>
                                </div> -->
        <!-- testimonial-single-items -->
        <!-- <div class="testmonial-item ">
                                    <p class="pera">The automated process starts as soon as your clothes go into the<br>
                                        machine. The outcome is gleaming clothes!</p>
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <p> - Rupaya</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>  -->


        <!-- Testimonials_end -->
        <!--? Company achievement Start -->
        <!--<section class="services-area section-padding40 fix">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="section-tittle text-center mb-55">
                            <span class="element">Fun Fact</span>
                            <h2>Company achievement</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-cat text-center">
                            <div class="cat-cap">
                                <span>4000</span>
                                <p>The automated process starts as soon as your clothes go into the machine.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-cat text-center">
                            <div class="cat-cap">
                                <span>300+</span>
                                <p>The automated process starts as soon as your clothes go into the machine.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-cat text-center">
                            <div class="cat-cap">
                                <span>95%</span>
                                <p>The automated process starts as soon as your clothes go into the machine.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="bottom-bt">
                                <img src="{{ asset('/laundry-master/assets/img/gallery/company-bg.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->


        <!-- Company achievement End -->
        <!--? About Area  -->
        <section class="about-area2 pb-bottom mt-30">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <!-- about-img -->
                        <div class="about-img ">
                            <img src="{{ asset('/laundry-master/assets/img/gallery/about1.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="about-caption mb-50">
                            <!-- Section Tittle -->
                            <div class="section-tittle mb-25">
                                <h2>Tentang Kami</h2>
                            </div>
                            <p class="mb-20">
                                Hamidah Laundry hadir sebagai solusi praktis untuk menjaga laundry Anda tetap bersih, harum,
                                dan nyaman digunakan. Kami berkomitmen memberikan pelayanan terbaik dengan mengutamakan
                                kebersihan dan kualitas hasil cucian
                            </p>
                            <p class="mb-30">Dengan pelayanan yang ramah dan proses pengerjaan yang teliti, kami membantu
                                Anda menghemat waktu dan tenaga agar dapat lebih fokus pada aktivitas sehari-hari. Kepuasan
                                Anda adalah prioritas kami.</p>

                            <a href="about.html" class="btn">Lebih Lanjut</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Area End -->


        <!--?  Map Area start  -->
        <div class="Map-area">
            <img src="{{ asset('/laundry-master/assets/img/gallery/Map.png') }}" alt="" class="w-100">
        </div>
        <!-- Map Area End -->
    </main>


    <!--<div class="slider-active">
        
                <div class="single-slider slider-height d-flex align-items-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-7 col-lg-9 col-md-10 col-sm-9">
                                <div class="hero__caption">
                                    <h1 data-animation="fadeInLeft" data-delay="0.2s">Quality laundry service in your
                                        city</h1>
                                    <p data-animation="fadeInLeft" data-delay="0.4s">We take care about cleenness of
                                        your cloth</p>
                                    <a href="{{ route('landing.status') }}" class="genric-btn info circle" data-animation="fadeInLeft"
                                        data-delay="0.7s">Cek Status Laundry</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
@endsection
