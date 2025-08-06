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
                    <h3>My Dependents</h3>
                    <hr>
                    @if ($dependents->count())
                        @foreach ($dependents as $dependent)
                            <?php $is_available = clinicAvailableToday($dependent->id); ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="doctor-widget">
                                        <div class="doc-info-left">
                                            <div class="doctor-img">
                                                <a href="">
                                                    @if ($dependent->photo)
                                                        <img src="{{ asset('site/uploads/dependent/' . $dependent->photo) }}"
                                                            alt="{{ $dependent->name }}" class="img-fluid" width="100">
                                                    @else
                                                        <img src="{{ asset('site/assets/img/logo.png') }}"
                                                            alt="{{ $dependent->name }}" class="img-fluid" width="100">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="doc-info-cont">
                                                <h4 class="doc-name"><a href="">{{ $dependent->name }}</a></h4>
                                                <div><span class="fw-bold">Relation: </span><span>{{ $dependent->relation }}</span></div>
                                                <div><span class="fw-bold">DOB: </span><span>{{ $dependent->dob }}</span></div>
                                                <div><span class="fw-bold">ICnumber: </span><span>{{ $dependent->icnumber }}</span></div>
                                                <div><span class="fw-bold">Gander: </span><span>{{ $dependent->gender }}</span></div>
                                                <div><span class="fw-bold">Medical Benefit: </span><span>MYR {{ $dependent->min_benefit }}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Oops !!!</strong> You haven't add any dependent.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
