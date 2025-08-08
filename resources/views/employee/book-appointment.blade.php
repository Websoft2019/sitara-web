@extends('site.template')
@section('css')
    <style>
        .nav-tabs .nav-link.active {
            background: #00a3e4;

        }


        .timing {
            background-color: #e9e9e9;
            border: 1px solid #e9e9e9;
            border-radius: 3px;
            color: #757575;
            display: block;
            font-size: 14px;
            margin-bottom: 10px;
            margin-right: 5px;
            padding: 5px;
            text-align: center;
            position: relative;
        }
    </style>
@stop
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
                    <h3>Clinics Appointment</h3>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="booking-doc-info">
                                        <a href="" class="booking-doc-img">
                                            @if ($clinic->logo != null)
                                                <img src="{{ asset('site/uploads/clinic/' . $clinic->logo) }}"
                                                    class="img-fluid" alt="{{ $clinic->name }}">
                                            @else
                                                <img src="{{ asset('site/assets/img/nophoto.jpeg') }}" class="img-fluid"
                                                    alt="{{ $clinic->name }}">
                                            @endif
                                        </a>
                                        <div class="booking-info">
                                            <h4><a href="">{{ $clinic->name }}</a></h4>
                                            <div class="rating">
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>

                                            </div>
                                            <p class="text-muted mb-0"><i class="fas fa-map-marker-alt"></i>
                                                {{ $clinic->address }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('user.postAppointment', $clinic->slug) }}" method="POST">
                                @csrf()
                                <div class="row">
                                    <div class="col-12 col-sm-4 col-md-6">
                                        <h4 class="mb-1">Pickup Appointment Date &amp; Time</h4>
                                    </div>
                                    {{-- <div class="col-12 col-sm-8 col-md-6 text-sm-end">
                                        <div class="bookingrange btn btn-white btn-sm mb-3">
                                            <i class="far fa-calendar-alt me-2"></i>
                                            <span></span>
                                            <i class="fas fa-chevron-down ms-2"></i>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="my-3">
                                    <label for="">Select the </label>
                                    <select class="form-control" name="dependent" id="">
                                        <option value="0">self</option>
                                        @foreach ($dependents as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="card booking-schedule schedule-widget">
                                    <div class="schedule-header">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="day-slot">
                                                    <ul class="nav nav-tabs">
                                                        <li class="left-arrow">
                                                            <a href="#">
                                                                <i class="fa fa-chevron-left"></i>
                                                            </a>
                                                        </li>
                                                        @php $current_date = date('d-m-Y'); @endphp
                                                        @foreach ($dates as $date)
                                                            <li>
                                                                <a class="nav-link <?php if ($current_date == $date->date->format('d-m-Y')) {
                                                                    echo 'active';
                                                                } ?>"
                                                                    href="#dateTable-{{ $date->id }}"
                                                                    data-bs-toggle="tab">
                                                                    <span
                                                                        style="font-size: 14px;">{{ $date->date->format('l') }}</span>
                                                                    <span class="slot-date"
                                                                        style="font-size: 14px;">{{ $date->date->format('d M') }}
                                                                        <br>{{ $date->date->format('Y') }}</span>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                        <li class="right-arrow">
                                                            <a href="#">
                                                                <i class="fa fa-chevron-right"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="schedule-cont">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="tab-content">
                                                    @foreach ($dates as $date1)
                                                        <div class="tab-pane <?php if ($current_date == $date1->date->format('d-m-Y')) {
                                                            echo 'active';
                                                        } ?> show"
                                                            id="dateTable-{{ $date1->id }}">
                                                            <div class="time-slot">
                                                                <ul class="clearfix">
                                                                    @php
                                                                        $timeslots = App\Models\ScheduleTime::where('schedule_date_id', $date1->id)
                                                                            ->orderby('time', 'asc')
                                                                            ->get();
                                                                    @endphp
                                                                    @if ($timeslots->count())
                                                                        @foreach ($timeslots as $timeslot)
                                                                            <li class="timing">
                                                                                <input type="radio" name="time"
                                                                                    value="{{ $timeslot->id }}" required />
                                                                                <span>{{ \Carbon\Carbon::createFromFormat('H:i:s', $timeslot->time)->format('h:i A') }}</span>
                                                                            </li>
                                                                        @endforeach
                                                                    @else
                                                                        <p>Not Available</p>
                                                                    @endif

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label> Appointment Cause</label>
                                        <textarea id="" name="cause" class="form-control" required></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label> </label>
                                        <div class="submit-section proceed-btn text-end">
                                            <input type="submit" class="btn btn-primary submit-btn" value="Book">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
