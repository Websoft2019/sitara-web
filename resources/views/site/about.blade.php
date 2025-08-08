@extends('site.template')
@section('content')
    <div class="breadcrumb-bar-two">
        <div class="container">
            <div class="row align-items-center inner-banner">
                <div class="col-md-12 col-12 text-center">
                    <h2 class="breadcrumb-title">About Us</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('getHome') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">About Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <section class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12">
                    <div class="about-img-info">
                        <div class="row">
                            
                           
                                <div class="about-inner-img">
                                    <div class="about-img">
                                        <img src="{{ asset('site/assets/img/about-us.png') }}" class="img-fluid"
                                            alt="">
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="section-inner-header about-inner-header">
                        <h6>Discover Sitara</h6>
                        <h2>THE CATALYST IN HEALTHCARE MANAGEMENT EVOLUTION</h2>
                    </div>
                    <div class="about-content">
                        <div class="about-content-details">
                            <p>
                                Sitara Healthcare Apps revolutionize medical connectivity offering an all-in-one platform shaping the future of healthcare management.
                                In a rapidly evolving landscape where IT advances drive healthcare transformation, Sitara stands as the beacon for enhanced capcity and adaptability.
                                Bridging the gap between policymakers and healthcare administrators, Sitara spearheads dialogue and innovation in healthcare management.
                                With a comprehensive system facilitating seamless connectivity, Sitara propels the evolution of healthcare management without compromising quality, setting a new standard in the industry.
                            </p>
                        </div>
                        {{-- <div class="about-contact">
                            <div class="about-contact-icon">
                                <span><img src="{{ asset('site/assets/img/icons/phone-icon.svg') }}" alt=""></span>
                            </div>
                            <div class="about-contact-text">
                                <p>Need Emergency?</p>
                                <h4>016 5591819</h4>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="why-choose-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-inner-header text-center">
                        <h2>Why Choose Us</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="card why-choose-card w-100">
                        <div class="card-body">
                            <div class="why-choose-icon">
                                <span><img src="{{ asset('site/assets/img/icons/choose-01.svg') }}" alt=""></span>
                            </div>
                            <div class="why-choose-content">
                                <h4>Convenience</h4>
                                <p>Online appointments provide the convenience of scheduling and managing appointments from
                                    anywhere at any time. You can access the appointment system using a computer,
                                    smartphone, or tablet, eliminating the need for physical travel and saving time and
                                    effort.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="card why-choose-card w-100">
                        <div class="card-body">
                            <div class="why-choose-icon">
                                <span><img src="{{ asset('site/assets/img/icons/choose-02.svg') }}" alt=""></span>
                            </div>
                            <div class="why-choose-content">
                                <h4>Accessibility</h4> 
                                <p>Online appointments make healthcare services more accessible to individuals with limited
                                    mobility, transportation challenges, or living in remote areas. It allows people to
                                    receive professional help without the need to physically visit a healthcare facility.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="card why-choose-card w-100">
                        <div class="card-body">
                            <div class="why-choose-icon">
                                <span><img src="{{ asset('site/assets/img/icons/choose-03.svg') }}" alt=""></span>
                            </div>
                            <div class="why-choose-content">
                                <h4>Time-saving</h4>
                                <p>
                                    Online appointments reduce waiting times and allow you to optimize your schedule. With
                                    virtual appointments, you can join the session promptly at the scheduled time,
                                    minimizing time wasted in waiting rooms.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-flex">
                    <div class="card why-choose-card w-100">
                        <div class="card-body">
                            <div class="why-choose-icon">
                                <span><img src="{{ asset('site/assets/img/icons/choose-04.svg') }}" alt=""></span>
                            </div>
                            <div class="why-choose-content">
                                <h4>Continuity of care</h4>
                                <p>
                                    Online appointments enable seamless continuity of care, particularly for individuals
                                    with chronic conditions. It allows healthcare providers to monitor patients remotely,
                                    offer follow-up consultations, and provide ongoing support without the need for frequent
                                    in-person visits.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    {{-- <section class="way-section">
        <div class="container">
            <div class="way-bg">
                <div class="way-shapes-img">
                    <div class="way-shapes-left">
                        <img src="{{ asset('site/assets/img/shape-06.png') }}" alt="">
                    </div>
                    <div class="way-shapes-right">
                        <img src="{{ asset('site/assets/img/shape-07.png') }}" alt="">
                    </div>
                </div>
                <div class="row align-items-end">
                    <div class="col-lg-7 col-md-12">
                        <div class="section-inner-header way-inner-header mb-0">
                            <h2>Be on Your Way to Feeling Better with the Doccure</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                labore et dolore magna aliqua.</p>
                            <a href="contact-us.html" class="btn btn-primary">Contact With Us</a>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12">
                        <div class="way-img">
                            <img src="{{ asset('site/assets/img/way-img.png') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="testimonial-section" style="background-color: skyblue">
        <div class="testimonial-shape-img">
            <div class="testimonial-shape-left">
                <img src="{{ asset('site/assets/img/shape-04.png') }}" alt="">
            </div>
            <div class="testimonial-shape-right">
                <img src="{{ asset('site/assets/img/shape-05.png') }}" alt="">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('site/assets/img/objectives.png') }}" class="img-fluid" alt="">
                </div>
                <div class="col-md-8">
                    <br /> <br /> <br />
                    <div class="section-inner-header testimonial-header">
                        <h2>OBJECTIVES</h2>
                    </div>
                    <p>
                        <ul style="margin-left: 30px">
                            <li style="border-bottom: 1px solid #ccc; line-height: 34px; color:#000"> Optimize healthcare accessibility by providing a seamless and user-friendly platform.</li>
                            <li style="border-bottom: 1px solid #ccc; line-height: 34px; color:#000">Leverage innovative technology to centralize medical services and information for streamlined healthcare management.</li>
                            <li style="border-bottom: 1px solid #ccc; line-height: 34px; color:#000">Facilitate collaboration amoung healthcare stakeholders to expand the network of quality healthcare providers.</li>
                            <li style="border-bottom: 1px solid #ccc; line-height: 34px; color:#000">Empower user with comprehensive health resources, ensuring informed decision-making and proactive health management.</li>
                        </ul>
                    </p>
                </div>
                </div>
            </div>
        </div>
    </section>
    <section class="testimonial-section" style="background-color: #6ecef2">
        <div class="testimonial-shape-img">
            <div class="testimonial-shape-left">
                <img src="{{ asset('site/assets/img/shape-04.png') }}" alt="">
            </div>
            <div class="testimonial-shape-right">
                <img src="{{ asset('site/assets/img/shape-05.png') }}" alt="">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="testimonial-content">
                        <div class="section-inner-header testimonial-header">
                            <h2>VISION</h2>
                        </div>
                        <p>
                            Striving to create a globally connected and empowered community by delivering accessible, personalized healthcare solutions through innovative technology.
                        </p>
                    </div>
                    <div class="testimonial-content">
                        <div class="section-inner-header testimonial-header">
                            <br />
                             <br />
                             <br />
                             <br />
                            <h2>MISSION</h2>
                        </div>
                        <p>
                            Sitara Healthcare Apps is dedicated to revolutionizing healthcare management by providing an all-encompassing platform that seamlessly integrates medical services,
                            empowers individuals with informed choices, and facilitates collaboration among healthcare stakeholders. We strive to elevate healthcare acessibility, efficiency,
                            and quality while prioritising user-centric experiences.
                        </p>
                    </div>

                </div>
                <div class="col-md-4">
                    <img src="{{ asset('site/assets/img/mission.png') }}" class="img-fluid" alt="">
                </div>
                </div>
            </div>
        </div>
    </section>
    <section class="faq-section faq-section-inner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-inner-header text-center">
                        <h6>Get Your Answer</h6>
                        <h2>Frequently Asked Questions (FAQ)</h2>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12">
                    <div class="faq-img">
                        <img src="{{ asset('site/assets/img/faq-img.png') }}" class="img-fluid" alt="img">
                        <div class="faq-patients-count">
                            <div class="faq-smile-img">
                                <img src="{{ asset('site/assets/img/icons/smiling-icon.svg') }}" alt="icon">
                            </div>  
                            <div class="faq-patients-content">
                                <h4><span class="count-digit">95</span>k+</h4>
                                <p>Happy Patients</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="faq-info">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <a class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                        aria-expanded="true" aria-controls="collapseOne">
                                        How do I access Sitara Healthcare Apps?
                                    </a>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="accordion-content">
                                            <p>To access Sitara Healthcare Apps, please visit sitara.my and register either through CLINIC login or COMPANY login, depending on your affiliation or need.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        What kind of healthcare services does Sitara offer?
                                    </a>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="accordion-content">
                                            <p>Sitara provides a range of services, including appointment scheduling, health tracking, access to medical records, telemedicine, and more.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        Is my personal health information secure on Sitara?
                                    </a>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="accordion-content">
                                            <p>Yes, your privacy is our priority. Sitara uses robust security measures to ensure the confidentiality and security of your health data.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                        Can I schedule appointments with healthcare providers through Sitara?
                                    </a>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="accordion-content">
                                            <p>Absolutely! Sitara allows you to conveniently book appointments with healthcare professionals just through your apps.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFive" aria-expanded="false"
                                        aria-controls="collapseFive">
                                        Does Sitara support health tracking and monitoring?
                                    </a>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="accordion-content">
                                            <p>Yes Sitara offers tools for tracking your health metrics and monitoring your progress towards wellness goals.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSix">
                                    <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSix" aria-expanded="false"
                                        aria-controls="collapseSix">
                                        Are there any fees associated with using Sitara?
                                    </a>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="accordion-content">
                                            <p>
                                                Sitara offers both free and premium services. Some features may have associated costs, but many core functions are available for free.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingServen">
                                    <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSeven" aria-expanded="false"
                                        aria-controls="collapseSeven">
                                        Can I access my medical records through the apps?
                                    </a>
                                </h2>
                                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="accordion-content">
                                            <p>
                                                Yes, Sitara enables you to access and manage your medical records securely within the app.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingEight">
                                    <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseEight" aria-expanded="false"
                                        aria-controls="collapseEight">
                                        Does Sitara Offer telemedicine or virtual consulations?
                                    </a>
                                </h2>
                                <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="accordion-content">
                                            <p>
                                                Yes, Sitara facilitates virtual consultations with healthcare providers for your convenience.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingNine">
                                    <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseNine" aria-expanded="false"
                                        aria-controls="collapseNine">
                                        is Sitara available on multiple devices/platforms? 
                                    </a>
                                </h2>
                                <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="accordion-content">
                                            <p>
                                                Yes, Sitara is available on various devices and plateforms, ensuring accessibility where you are.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTen">
                                    <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTen" aria-expanded="false"
                                        aria-controls="collapseTen">
                                        Is Sitara available worldwide?
                                    </a>
                                </h2>
                                <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="accordion-content">
                                            <p>
                                                Sitara's availability might vary based on regions or countries. Currently, Sitara might be available in select countries or regions, with plans for expansion in the future.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
