@extends('site.template')
@section('content')
    <section class="banner-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="banner-content aos" data-aos="fade-up">
                        <h1>Easily Manage <span>Your Employees’</span> Medical Benefit</h1>
                        <img src="{{ asset('site/assets/img/icons/header-icon.svg') }}" class="header-icon" alt="header-icon">
                        <p>Establishing a seamless connection between the company its employees and clinics.</p>
                        <a href="" class="btn">Join Now</a>
                        <div class="banner-arrow-img">
                            <img src="{{ asset('site/assets/img/down-arrow-img.png') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                    <div class="search-box-one aos" data-aos="fade-up">
                        <form action="">
                            <div class="search-input search-line">
                                <i class="feather-search bficon"></i>
                                <div class="form-group mb-0">
                                    <input type="text" class="form-control" placeholder="Company Name">
                                </div>
                            </div>
                            <div class="search-input search-map-line">
                                <i class="feather-map-pin"></i>
                                <div class="form-group mb-0">
                                    <input type="text" class="form-control" placeholder="Location">
                                    <a class="current-loc-icon current_location" href="javascript:void(0);">

                                    </a>
                                </div>
                            </div>
                            <div class="search-input search-calendar-line">
                                <i class="feather-mail"></i>
                                <div class="form-group mb-0">
                                    <input type="text" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-search-btn">
                                <button class="btn" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="banner-img aos" data-aos="fade-up">
                        <img src="{{ asset('site/assets/img/banner-img.png') }}" class="img-fluid" alt="">
                        <div class="banner-img1">
                            <img src="{{ asset('site/assets/img/banner-img1.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="banner-img2">
                            <img src="{{ asset('site/assets/img/banner-img2.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="banner-img3">
                            <img src="{{ asset('site/assets/img/banner-img3.png') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12">
                    <div class="about-img-info">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="about-inner-img">
                                    <div class="about-img">
                                        <img src="{{ asset('site/assets/img/about-img1.jpg') }}" class="img-fluid"
                                            alt="">
                                    </div>
                                    <div class="about-img">
                                        <img src="{{ asset('site/assets/img/about-img2.jpg') }}" class="img-fluid"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="about-inner-img">
                                    <div class="about-box">
                                        <h4>Over 80+ Company Enroll</h4>
                                    </div>
                                    <div class="about-img">
                                        <img src="{{ asset('site/assets/img/about-img3.jpg') }}" class="img-fluid"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="section-inner-header about-inner-header">
                        <h6>About Sitara</h6>
                        <h2>We have the best platform in managing employees medical benefit</h2>
                    </div>
                    <div class="about-content">
                        <div class="about-content-details">
                            <p>
                                Step into Sitara Healthcare Apps, where innovation transforms care! We're reshaping the healthcare landscape by integrating advanced technology to redefine service delivery. Committed to enhancing patient outcomes,
                                our blend of medical expertise and data-driven insights ensures personalized, efficient care. Come, be part of our journey as we revolutionize healthcare for a better tomorrow.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="work-section">
        <div class="container">
            <div class="row">
               
                <div class="col-lg-12 col-md-12 work-details">
                    <div class="section-header-one aos" data-aos="fade-up">
                        <h5>How it Works</h5>
                        <h2 class="section-title">FACILITATION OF SITARA</h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 aos" data-aos="fade-up">
                            <div class="work-info">
                                {{-- <div class="work-icon">
                                    <span><img src="{{ asset('site/assets/img/icons/work-01.svg') }}"
                                            alt=""></span>
                                </div> --}}
                                <div class="work-content">
                                    <h5>EMR</h5>
                                    <img src="{{asset('site/assets/img/EMR-software-development.png')}}" alt="" style="border-radius: 10px; margin-bottom: 10px">
                                    <p>Electronic Medical Records and other relevant platforms to ensure interoperability.
                                        Enable seamless integration with existing healthcare systems.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 aos" data-aos="fade-up">
                            <div class="work-info">
                                {{-- <div class="work-icon">
                                    <span><img src="{{ asset('site/assets/img/icons/work-02.svg') }}"
                                            alt=""></span>
                                </div> --}}
                                <div class="work-content">
                                    <h5>PNM</h5>
                                    <img src="{{asset('site/assets/img/PNM.png')}}" alt="" style="border-radius: 10px; margin-bottom: 10px">
                                    <p>Provider Network Management Managing and expanding the network of healthcare providers within an insrance plan.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 aos" data-aos="fade-up">
                            <div class="work-info">
                                {{-- <div class="work-icon">
                                    <span><img src="{{ asset('site/assets/img/icons/work-03.svg') }}"
                                            alt=""></span>
                                </div> --}}
                                <div class="work-content">
                                    <h5>THS</h5>
                                    <img src="{{asset('site/assets/img/THS.png')}}" alt="" style="border-radius: 10px; margin-bottom: 10px">
                                    <p>Telehealth Services Providing medical services and consultations remotely via digital platforms.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="testimonial-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="testimonial-slider slick">
                        <div class="testimonial-grid">
                            <div class="testimonial-info">
                                <div class="testimonial-img">
                                    <img src="{{ asset('site/assets/img/clients/client-01.jpg') }}" class="img-fluid"
                                        alt="">
                                </div>
                                <div class="testimonial-content">
                                    <div class="section-header section-inner-header testimonial-header">
                                        <h5>Testimonials</h5>
                                        <h2>What Our Client Says</h2>
                                    </div>
                                    <div class="testimonial-details">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                            nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                                            fugiat nulla pariatur.</p>
                                        <h6><span>John Doe</span> New York</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-grid">
                            <div class="testimonial-info">
                                <div class="testimonial-img">
                                    <img src="{{ asset('site/assets/img/clients/client-02.jpg') }}" class="img-fluid"
                                        alt="">
                                </div>
                                <div class="testimonial-content">
                                    <div class="section-header section-inner-header testimonial-header">
                                        <h5>Testimonials</h5>
                                        <h2>What Our Client Says</h2>
                                    </div>
                                    <div class="testimonial-details">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                            nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                                            fugiat nulla pariatur.</p>
                                        <h6><span>Amanda Warren</span> Florida</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-grid">
                            <div class="testimonial-info">
                                <div class="testimonial-img">
                                    <img src="{{ asset('site/assets/img/clients/client-03.jpg') }}" class="img-fluid"
                                        alt="">
                                </div>
                                <div class="testimonial-content">
                                    <div class="section-header section-inner-header testimonial-header">
                                        <h5>Testimonials</h5>
                                        <h2>What Our Client Says</h2>
                                    </div>
                                    <div class="testimonial-details">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                            nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                                            fugiat nulla pariatur.</p>
                                        <h6><span>Betty Carlson</span> Georgia</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-grid">
                            <div class="testimonial-info">
                                <div class="testimonial-img">
                                    <img src="{{ asset('site/assets/img/clients/client-04.jpg') }}" class="img-fluid"
                                        alt="">
                                </div>
                                <div class="testimonial-content">
                                    <div class="section-header section-inner-header testimonial-header">
                                        <h5>Testimonials</h5>
                                        <h2>What Our Client Says</h2>
                                    </div>
                                    <div class="testimonial-details">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                            nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                                            fugiat nulla pariatur.</p>
                                        <h6><span>Veronica</span> California</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-grid">
                            <div class="testimonial-info">
                                <div class="testimonial-img">
                                    <img src="{{ asset('site/assets/img/clients/client-05.jpg') }}" class="img-fluid"
                                        alt="">
                                </div>
                                <div class="testimonial-content">
                                    <div class="section-header section-inner-header testimonial-header">
                                        <h5>Testimonials</h5>
                                        <h2>What Our Client Says</h2>
                                    </div>
                                    <div class="testimonial-details">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                            nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                                            fugiat nulla pariatur.</p>
                                        <h6><span>Richard</span> Michigan</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="app-section">
        <div class="container">
            <div class="app-bg">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="app-content">
                            <div class="app-header aos" data-aos="fade-up">
                                {{-- <h5>Link to Company Clinic &amp; Employee.</h5> --}}
                                <h2>Install SITARA App today!</h2>
                            </div>
                            <div class="app-scan aos" data-aos="fade-up">
                                <h5>Experience the future of Healthcare</h5>
                                <p>Scan the QR code to get the app now</p>
                                <img src="{{ asset('site/assets/img/scan-img.png') }}" alt="">
                            </div>
                            <div class="google-imgs aos" data-aos="fade-up">
                                <a href="javascript:void(0);"><img src="{{ asset('site/assets/img/google-play.png') }}"
                                        alt="img"></a>
                                <a href="javascript:void(0);"><img src="{{ asset('site/assets/img/app-store.png') }}"
                                        alt="img"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 aos" data-aos="fade-up">
                        <div class="mobile-img">
                            <img src="{{ asset('site/assets/img/mobile-img.png') }}" class="img-fluid" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
