@extends('site.template')
@section('content')
    <div class="breadcrumb-bar-two">
        <div class="container">
            <div class="row align-items-center inner-banner">
                <div class="col-md-12 col-12 text-center">
                    <h2 class="breadcrumb-title">Why Sitara</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('getHome') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Why Sitara</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="why-choose-section">
        <div class="container">

            <div class="row">
                <div class="col-lg-12 col-md-12 d-flex" style="margin-top: 30px">
                    <div class="card why-choose-card w-100">
                        <div class="card-body">
                            {{-- <div class="why-choose-content">
                               

                                <h4 class="my-3">Overview:</h4>
                                <p>SITARA is a cutting-edge healthcare company at the forefront of innovation, integrating
                                    the latest
                                    technology and artificial intelligence to revolutionize the delivery of healthcare
                                    services. Committed to
                                    improving patient outcomes, SITARA combines advanced medical expertise with data-driven
                                    insights to
                                    provide personalized and efficient care.</p>

                                <h4 class="my-3">Services Offered:</h4>
                                <ol>
                                    <li class="my-2">
                                        <b>AI-Driven Diagnostics:</b> SITARA leverages the power of artificial
                                        intelligence and machine learning
                                        algorithms to enhance diagnostic accuracy. Through automated image analysis, pattern
                                        recognition, and
                                        predictive analytics, their AI systems assist healthcare professionals in detecting
                                        and diagnosing diseases
                                        with greater precision and speed. This leads to early detection, improved treatment
                                        planning, and
                                        ultimately better patient outcomes.
                                    </li>
                                    <li class="my-2">
                                        <b>Telehealth Services:</b> Recognizing the importance of accessible healthcare,
                                        SITARA offers state-of-the-
                                        art telehealth services. Through secure video consultations and remote patient
                                        monitoring, patients can
                                        conveniently connect with healthcare providers from the comfort of their homes and
                                        office. This
                                        improves access to medical expertise, reduces wait times, increase productivity and
                                        allows for
                                        continuous monitoring and management of chronic conditions.
                                    </li>
                                    <li class="my-2">
                                        <b>Digital Health Platforms:</b> SITARA develops intuitive and user-friendly
                                        digital health platforms that
                                        empower patients to actively manage their health. These platforms provide
                                        personalized health
                                        tracking, medication reminders, and access to various health clinic, pharmacy,
                                        dental, physiotherapist,
                                        Audiometric, optometrist and etc. By leveraging mobile apps and wearable devices,
                                        patients can
                                        proactively monitor their well-being, leading to improved self-care and preventive
                                        measures.
                                    </li>
                                    <li class="my-2">
                                        <b>Predictive Analytics for Population Health:</b> SITARA harnesses the power of
                                        big data and predictive
                                        analytics to drive population health initiatives. By analyzing vast amounts of
                                        health information, they
                                        identify patterns, trends, and risk factors in specific populations. This enables
                                        proactive interventions,
                                        targeted health campaigns, and resource allocation to improve the overall health of
                                        communities.
                                    </li>
                                    <li class="my-2">
                                        <b>Smart Healthcare Infrastructure:</b> SITARA collaborates with healthcare
                                        facilities to design and
                                        implement smart healthcare infrastructure. This includes integrating electronic
                                        health records (EHR)
                                        systems, implementing IoT-enabled medical devices, and optimizing workflow
                                        management through AI-
                                        powered algorithms. These technological advancements enhance efficiency, streamline
                                        operations, and
                                        improve patient care experiences.
                                    </li>
                                </ol>

                                <h4 class="my-3">Approach and Values:</h4>
                                <p>SITARA is driven by a commitment to innovation, quality, and patient-centric care. Their
                                    approach
                                    combines the expertise of healthcare professionals with the power of technology to
                                    deliver precise
                                    diagnoses, individualized treatments, and proactive healthcare management. SITARA values
                                    ethics,
                                    transparency, and the responsible use of data to ensure patient privacy and data
                                    security.</p>

                                <h4 class="my-3">Industry Impact:</h4>
                                <p>SITARA is transforming the healthcare landscape by leveraging the potential of the latest
                                    technology and
                                    artificial intelligence. Their AI-driven diagnostics improve accuracy, reduce diagnostic
                                    errors, and
                                    facilitate early interventions. Telehealth services expand access to care, particularly
                                    in underserved
                                    areas. By utilizing predictive analytics, SITARA contributes to population health
                                    initiatives, enabling
                                    proactive healthcare interventions.</p>

                                <p class="mt-5">In conclusion, SITARA is an innovative healthcare company that prioritizes the
                                    integration of the latest
                                    technology and artificial intelligence to advance patient care. With a focus on
                                    AI-driven diagnostics,
                                    telehealth services, digital health platforms, predictive analytics, and smart
                                    healthcare infrastructure,
                                    they are reshaping healthcare delivery and improving patient outcomes. SITARA strives to
                                    make a
                                    significant impact in the industry through their commitment to innovation, quality, and
                                    patient-centric
                                    care.</p>

                            </div> --}}
                            <div class="row">
                                <div class="col-md-4" style="text-align: center">
                                    <h5>Doctor Consultation</h5>
                                    <img src="{{asset('site/assets/img/doctor-consultation.png')}}" alt="">
                                    
                                </div>
                                <div class="col-md-4" style="text-align: center">
                                    <h5>Healthcare Provide Network</h5>
                                    <img src="{{asset('site/assets/img/HealthcareProvideNetwork.png')}}" alt="">
                                </div>
                                <div class="col-md-4" style="text-align: center">
                                    <h5>Healthcare Record Management</h5>
                                    <img src="{{asset('site/assets/img/HealthcareRecordManagement.png')}}" alt="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" style="text-align: center">
                                    <h5>In House Healthcare Service</h5>
                                    <img src="{{asset('site/assets/img/InHouseHealthcareService.png')}}" alt="">
                                </div>
                                <div class="col-md-4" style="text-align: center;">
                                    <br /> <br /> <br /> <br />
                                    <h1>SITARA SERVICES</h1>
                                </div>
                                <div class="col-md-4" style="text-align: center">
                                    <h5>Emergency Assistance</h5>
                                    <img src="{{asset('site/assets/img/EmergencyAssistance.png')}}" alt="">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 75px;">
                                <div class="col-md-3" style="text-align: center">
                                    <h5>Medical Check Up</h5>
                                    <img src="{{asset('site/assets/img/MedicalCheckUp.png')}}" alt="">
                                </div>
                                <div class="col-md-3" style="text-align: center">
                                    <h5>Telemedicine Service</h5>
                                    <img src="{{asset('site/assets/img/TelemedicineService.png')}}" alt="">
                                </div>
                                <div class="col-md-3" style="text-align: center">
                                    <h5>Appointment Scheduling</h5>
                                    <img src="{{asset('site/assets/img/AppointmentScheduling.png')}}" alt="">
                                </div>
                                <div class="col-md-3" style="text-align: center">
                                    <h5>Health Monitoring and Tracking</h5>
                                    <img src="{{asset('site/assets/img/HealthMonitoringandTracking.png')}}" alt="">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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


@stop
