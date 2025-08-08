@extends('site.template')
@section('content')
    <div class="breadcrumb-bar-two">
        <div class="container">
            <div class="row align-items-center inner-banner">
                <div class="col-md-12 col-12 text-center">
                    <h2 class="breadcrumb-title">Search</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Search</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-4 col-xl-3 theiaStickySidebar">
                    @include('employee.sidebar', ['activePage' => 'employeeapointments'])
                </div>
                <div class="col-md-12 col-lg-8 col-xl-9">
                    <h3>Clinics</h3>
                    <hr>
                    @if ($clinics->count())
                        @foreach ($clinics as $clinic)
                            <?php $is_available = clinicAvailableToday($clinic->id); ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="doctor-widget">
                                        <div class="doc-info-left">
                                            <div class="doctor-img">
                                                <a href="">
                                                    @if ($clinic->logo != null)
                                                        <img src="{{ asset('site/uploads/clinic/' . $clinic->logo) }}"
                                                            class="img-fluid" alt="{{ $clinic->name }}">
                                                    @else
                                                        <img src="{{ asset('site/assets/img/nophoto.jpeg') }}"
                                                            class="img-fluid" alt="{{ $clinic->name }}">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="doc-info-cont">
                                                <h4 class="doc-name"><a href="">{{ $clinic->name }}</a></h4>
                                                <div class="rating">
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    {{-- <span class="d-inline-block average-rating">(17)</span> --}}
                                                </div>
                                                <div class="clinic-details">
                                                    <p class="doc-location"><i class="fas fa-map-marker-alt"></i>
                                                        {{ $clinic->address }}</p>
                                                    <ul class="clinic-gallery">
                                                        <li>
                                                            <a href="{{ asset('site/assets/img/features/feature-01.jpg') }}"
                                                                data-fancybox="gallery">
                                                                <img src="{{ asset('site/assets/img/features/feature-01.jpg') }}"
                                                                    alt="Feature">
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ asset('site/assets/img/features/feature-02.jpg') }}"
                                                                data-fancybox="gallery">
                                                                <img src="{{ asset('site/assets/img/features/feature-02.jpg') }}"
                                                                    alt="Feature">
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ asset('site/assets/img/features/feature-03.jpg') }}"
                                                                data-fancybox="gallery">
                                                                <img src="{{ asset('site/assets/img/features/feature-03.jpg') }}"
                                                                    alt="Feature">
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ asset('site/assets/img/features/feature-04.jpg') }}"
                                                                data-fancybox="gallery">
                                                                <img src="{{ asset('site/assets/img/features/feature-04.jpg') }}"
                                                                    alt="Feature">
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="clini-infos">
                                                    <ul>
                                                        <li>
                                                            <i class="feather-clock available-icon"></i>
                                                            @if ($is_available)
                                                                <span class="available-date available-today"
                                                                    style="background: #dcfce5; color: #22c550; font-weight: 500; padding:10px">Available
                                                                    Today</span>
                                                            @else
                                                                <span class="available-date available-today"
                                                                    style="background: #e2040b67; color: #c54322; font-weight: 500; padding:10px">Not
                                                                    Available
                                                                    Today</span>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="doc-info-right">
                                            <div class="clini-infos">
                                                <ul>
                                                    <li><i class="far fa-phone"></i> {{ $clinic->number }}</li>
                                                    <li><i class="far fa-envelope"></i> {{ $clinic->email }}</li>
                                                </ul>
                                            </div>
                                            <div class="clinic-booking">
                                                <a class="view-pro-btn" href="">View Clinic Profile</a>
                                                <a class="apt-btn"
                                                    href="{{ route('user.getBookAppointment', $clinic->slug) }}">Book
                                                    Appointment</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Oops !!!</strong> Currently your company not associated any clients.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
