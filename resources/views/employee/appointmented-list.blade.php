@extends('site.template')

@section('content')
    <div class="breadcrumb-bar-two">
        <div class="container">
            <div class="row align-items-center inner-banner">
                <div class="col-md-12 col-12 text-center">
                    <h2 class="breadcrumb-title">Dashboard</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('getHome') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                    @include('employee.sidebar', ['activePage' => 'employeereservations'])
                </div>
                <div class="col-md-7 col-lg-8 col-xl-9">

                    <div class="card">
                        <div class="card-body pt-0">
                            <nav class="user-tabs mb-4">
                                <ul class="nav nav-tabs nav-tabs-bottom">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#pat_appointments"
                                            data-bs-toggle="tab">Appointments</a>
                                    </li>
                                </ul>
                            </nav>
                            <div class="tab-content pt-0">
                                <div id="pat_appointments" class="tab-pane fade show active">
                                    <div class="card card-table mb-0">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-center mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Appt Date</th>
                                                            <th>Clinic</th>
                                                            <th>Status</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($appointments->count())
                                                            @foreach ($appointments as $appointment)
                                                                @php
                                                                    $clinicinfo = App\Models\Clinic::find($appointment->clinic_id);
                                                                    $timeinfo = App\Models\ScheduleTime::find($appointment->schedule_time_id);
                                                                    $dateinfo = App\Models\ScheduleDate::find($timeinfo->schedule_date_id);
                                                                @endphp

                                                                <tr>
                                                                    <td>{{ $dateinfo->date->format('l d M, Y') }} <span
                                                                            class="d-block text-info">{{ $timeinfo->time }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <h2 class="table-avatar">
                                                                            <a href="" class="avatar avatar-sm me-2">
                                                                                @if ($clinicinfo->logo != null)
                                                                                    <img src="{{ asset('site/uploads/clinic/' . $clinicinfo->logo) }}"
                                                                                        class="avatar-img rounded-circle"
                                                                                        alt="{{ $clinicinfo->name }}">
                                                                                @else
                                                                                    <img class="avatar-img rounded-circle"
                                                                                        src="site/assets/img/nophoto.jpeg"
                                                                                        alt="User Image">
                                                                                @endif
                                                                            </a>
                                                                            <a
                                                                                href="">{{ $clinicinfo->name }}<span>{{ $clinicinfo->addess }}</span></a>
                                                                        </h2>
                                                                    </td>

                                                                    <td><span
                                                                            class="badge rounded-pill bg-success-light">{{ $appointment->status }}</span>
                                                                    </td>
                                                                    <td class="text-end">
                                                                        <div class="table-action">
                                                                            {{-- <a href="javascript:void(0);"
                                                                                class="btn btn-sm bg-primary-light">
                                                                                <i class="fas fa-print"></i> Print
                                                                            </a> --}}
                                                                            <a href="{{ route('user.getViewAppointment', $appointment->id) }}"
                                                                                class="btn btn-sm bg-info-light">
                                                                                <i class="far fa-eye"></i> View
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="4">
                                                                    <p>No any appointment found!!!</p>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
