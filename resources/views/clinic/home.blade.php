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
                    @include('clinic.navbar', ['activePage' => 'clinichome'])
                </div>
                <div class="col-md-7 col-lg-8 col-xl-9">
                    @if (session('status'))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card dash-card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-4">
                                            <div class="dash-widget dct-border-rht">
                                                <div class="circle-bar circle-bar1">
                                                    <div class="circle-graph1" data-percent="75">
                                                        <img src="{{ asset('site/assets/img/icon-01.png') }}"
                                                            class="img-fluid" alt="patient">
                                                    </div>
                                                </div>
                                                <div class="dash-widget-info">
                                                    <h6>Total Appointments</h6>
                                                    <h3>{{ $totalAppointments }}</h3>
                                                    <p class="text-muted">Till Today</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-4">
                                            <div class="dash-widget dct-border-rht">
                                                <div class="circle-bar circle-bar2">
                                                    <div class="circle-graph2" data-percent="65">
                                                        <img src="{{ asset('site/assets/img/icon-02.png') }}"
                                                            class="img-fluid" alt="Patient">
                                                    </div>
                                                </div>
                                                <div class="dash-widget-info">
                                                    <h6>Today Appointments</h6>
                                                    <h3>{{ $todayAppointments }}</h3>
                                                    <p class="text-muted">{{ date('d, M Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-4">
                                            <div class="dash-widget">
                                                <div class="circle-bar circle-bar3">
                                                    <div class="circle-graph3" data-percent="50">
                                                        <img src="{{ asset('site/assets/img/icon-03.png') }}"
                                                            class="img-fluid" alt="Patient">
                                                    </div>
                                                </div>
                                                <div class="dash-widget-info">
                                                    <h6>Today Served Appoinments</h6>
                                                    <h3>{{ $todayServedAppointments }}</h3>
                                                    <p class="text-muted">{{ date('d, M Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="appointment-tab">
                                <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
                                    <li class="nav-item">
                                        <a class="nav-link active " href="#today-appointments" data-bs-toggle="tab">Today
                                            Pending Appointment</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#upcoming-appointments" data-bs-toggle="tab">Upcoming
                                            Pending Appointment</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="today-appointments">
                                        <div class="card card-table mb-0">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Patient Name</th>
                                                                <th>Appointment Date</th>
                                                                <th>Company</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($appointments->count())
                                                                @foreach ($appointments as $appointment)
                                                                    @php
                                                                        $timeinfo = App\Models\ScheduleTime::find($appointment->schedule_time_id);
                                                                        $dateinfo = App\Models\ScheduleDate::find($timeinfo->schedule_date_id);
                                                                    @endphp
                                                                    @if ($dateinfo->date->format('Y-m-d') == date('Y-m-d'))
                                                                        @php
                                                                            $patientinfo = App\Models\User::find($appointment->user_id);
                                                                            $companyinfo = App\Models\Company::find($patientinfo->company_id);
                                                                        @endphp

                                                                        <tr>
                                                                            <td>
                                                                                <h2 class="table-avatar">
                                                                                    <a href=""
                                                                                        class="avatar avatar-sm me-2">
                                                                                        @if ($patientinfo->image != null)
                                                                                            <img src="{{ asset('site/uploads/company/employee/' . $patientinfo->image) }}"
                                                                                                class="avatar-img rounded-circle"
                                                                                                alt="{{ $patientinfo->name }}">
                                                                                        @else
                                                                                            <img class="avatar-img rounded-circle"
                                                                                                src="{{ asset('site/assets/img/nophoto.jpeg') }}"
                                                                                                alt="User Image">
                                                                                        @endif
                                                                                        <a href="">{{ $patientinfo->first_name }}
                                                                                            {{ $patientinfo->middle_name }}
                                                                                            {{ $patientinfo->last_name }}
                                                                                            <span>#{{ $patientinfo->employee_id }}</span>
                                                                                            <span>IC
                                                                                                #{{ $patientinfo->ic_number }}</span></a>
                                                                                </h2>
                                                                            </td>
                                                                            <td>{{ $dateinfo->date->format('l d M, Y') }}
                                                                                <span
                                                                                    class="d-block text-info">{{ $timeinfo->time }}</span>
                                                                            </td>
                                                                            <td>
                                                                                <a href="">{{ $companyinfo->name }}
                                                                                    <span
                                                                                        style="display: block"><small>{{ $companyinfo->address }}</small></span></a>
                                                                            </td>

                                                                            <td class="text-end">
                                                                                <div class="table-action">
                                                                                    <a href="#"
                                                                                        id="{{ $appointment->id }}"
                                                                                        class="btn btn-sm bg-info-light appointmentdetail">
                                                                                        <i class="far fa-eye"></i> View
                                                                                    </a>
                                                                                    <a href="#"
                                                                                        class="btn btn-sm bg-success-light assigndoctor"
                                                                                        id="{{ $appointment->id }}">
                                                                                        <i class="fas fa-check"></i> Assign
                                                                                        to doctor
                                                                                    </a>
                                                                                    <a href="javascript:void(0);"
                                                                                        class="btn btn-sm bg-danger-light">
                                                                                        <i class="fas fa-times"></i> Cancel
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="4"> No any appointments yet!!!</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="upcoming-appointments">
                                        <div class="card card-table mb-0">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Patient Name</th>
                                                                <th>Appt Date</th>
                                                                <th>Company</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($appointments->count())
                                                                @foreach ($appointments as $appointment)
                                                                    @php
                                                                        $timeinfo = App\Models\ScheduleTime::find($appointment->schedule_time_id);
                                                                        $dateinfo = App\Models\ScheduleDate::find($timeinfo->schedule_date_id);
                                                                    @endphp
                                                                    @if ($dateinfo->date->format('Y-m-d') > date('Y-m-d'))
                                                                        @php
                                                                            $patientinfo = App\Models\User::find($appointment->user_id);
                                                                            $companyinfo = App\Models\Company::find($patientinfo->company_id);
                                                                        @endphp
                                                                        <tr>
                                                                            <td>
                                                                                <h2 class="table-avatar">
                                                                                    <a href=""
                                                                                        class="avatar avatar-sm me-2">
                                                                                        @if ($patientinfo->image != null)
                                                                                            <img src="{{ asset('site/uploads/company/employee/' . $patientinfo->image) }}"
                                                                                                class="avatar-img rounded-circle"
                                                                                                alt="{{ $patientinfo->name }}">
                                                                                        @else
                                                                                            <img class="avatar-img rounded-circle"
                                                                                                src="{{ asset('site/assets/img/nophoto.jpeg') }}"
                                                                                                alt="User Image">
                                                                                        @endif
                                                                                        <a href="">{{ $patientinfo->first_name }}
                                                                                            {{ $patientinfo->middle_name }}
                                                                                            {{ $patientinfo->last_name }}
                                                                                            <span>#{{ $patientinfo->employee_id }}</span>
                                                                                            <span>IC
                                                                                                #{{ $patientinfo->ic_number }}</span></a>
                                                                                </h2>
                                                                            </td>
                                                                            <td>{{ $dateinfo->date->format('l d M, Y') }}
                                                                                <span
                                                                                    class="d-block text-info">{{ $timeinfo->time }}</span>
                                                                            </td>
                                                                            <td>
                                                                                <a href="">{{ $companyinfo->name }}
                                                                                    <span
                                                                                        style="display: block"><small>{{ $companyinfo->address }}</small></span></a>
                                                                            </td>

                                                                            <td class="text-end">
                                                                                <div class="table-action">
                                                                                    <a hre="#"
                                                                                        id="{{ $appointment->id }}"
                                                                                        class="btn btn-sm bg-info-light appointmentdetail">
                                                                                        <i class="far fa-eye"></i> View
                                                                                    </a>
                                                                                    <a href="#"
                                                                                        id="{{ $appointment->id }}"
                                                                                        class="btn btn-sm bg-success-light assigndoctor">
                                                                                        <i class="fas fa-check"></i> Assign
                                                                                        to doctor
                                                                                    </a>
                                                                                    <a href="javascript:void(0);"
                                                                                        class="btn btn-sm bg-danger-light">
                                                                                        <i class="fas fa-times"></i> Cancel
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="4"> No any appointments yet!!!</td>
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
    </div>

@stop
@section('model')
    <div class="modal fade" id="assign_doctor_model" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Doctor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('clinic.postAssignDoctor') }}" method="POST">
                        @csrf()
                        <div class="row form-row">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label>Doctor Name</label>
                                    <select name="doctor" id="" class="form-control">
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">{{ $doctor->name }}
                                                ({{ $doctor->specialities }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="appointment-model" name="appointmentid" value="">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Assign</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="appointment_detail_modal" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Appointment Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card widget-profile pat-widget-profile">
                                <div class="card-body">
                                    <div class="pro-widget-content">
                                        <div class="profile-info-widget">
                                            <a href="" class="booking-doc-img">
                                                <img src="" alt="User Image" id="model-patientImage">
                                            </a>
                                            <div class="profile-det-info">
                                                <h3><a href=""><span id="model-fullname"></span></a></h3>
                                                <div class="patient-details">
                                                    <h5><b>Employee No. :</b> <span id="model-employeeID"></span> | <b>IC
                                                            No. :</b> <span id="model-ICNumber"></span></h5>
                                                    <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <span
                                                            id="model-patientAddress"></span></h5>
                                                    <h5><b>Race :</b> <span id="model-patientRace"></span> | <b>Gender :
                                                        </b> <span id="model-patientAge"></span></h5>
                                                    <h5><b>Email :</b> <span id="model-patientEmail"></span></h5>
                                                    <h5><b>Contact No :</b> <span id="model-patientContact"></span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="patient-info">
                                        <ul>
                                            <li>Company<span id="model-companyName"> </span></li>
                                            <li>Desgination <span id="model-companyPost"> </span></li>
                                            <li>Company Coverage <span>RM <span id="model-companyCoverage"> </span> </span>
                                            </li>
                                            <li>Pervious Checkup Date <span id="model-perviousCheckUpDate"> </span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 style="color: darkblue">Appointment Detail</h5>
                            <hr>
                            <div class="patient-info">
                                <ul>
                                    <li>Appointment ID<span> # <span id="model-appointmentID"></span></span></li>
                                    <li>Appointment Date/Time <span id="model-appointmentTime"
                                            style="display: block"></span> <span id="model-appointmentDate"> </span></li>
                                    <li>Requested Clinic <span id="model-referClinicName"></span></li>
                                    <li>Cause <span id="model-cause"> </span></li>
                                </ul>
                            </div>
                            <br />


                            <hr>
                            <a href="" class="btn btn-sm bg-success-light"> Medical History</a>
                            <a href="" class="btn btn-sm bg-danger-light">Pervious Medical Reports</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('site/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('site/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
    <script src="{{ asset('site/assets/js/circle-progress.min.js') }}"></script>
    <script>
        $(".assigndoctor").on("click", function() {
            var appointmentid = this.id;
            $("#appointment-model").val(appointmentid);
            $('#assign_doctor_model').modal('show');

        });
    </script>
    <script>
        jQuery(document).ready(function() {
            jQuery('.appointmentdetail').click(function(e) {
                e.preventDefault();
                var appointmentid = this.id;
                jQuery.ajax({
                    url: "{{ url('/clinic/model/appointmentdetail/') }}",
                    method: 'post',
                    data: {
                        appointmentid: appointmentid,
                        "_token": "{{ csrf_token() }}",

                    },
                    success: function(result) {
                        jQuery("#model-cause").html(result.cause11);
                        jQuery("#model-fullname").html(result.patientName);
                        jQuery("#model-employeeID").html(result.employeeID);
                        jQuery("#model-ICNumber").html(result.ICNumber);
                        jQuery("#model-patientAddress").html(result.patientAddress);
                        jQuery("#model-patientRace").html(result.patientRace);
                        jQuery("#model-patientAge").html(result.patientAge);
                        jQuery("#model-patientEmail").html(result.patientEmail);
                        jQuery("#model-patientContact").html(result.patientContact);
                        jQuery("#model-companyName").html(result.companyName);
                        jQuery("#model-companyPost").html(result.companyPost);
                        jQuery("#model-companyCoverage").html(result.companyCoverage);
                        jQuery("#model-perviousCheckUpDate").html(result.perviousCheckUpDate);
                        jQuery("#model-appointmentID").html(result.appointmentID);
                        jQuery("#model-appointmentTime").html(result.appointmentTime);
                        jQuery("#model-appointmentDate").html(result.appointmentDate);
                        jQuery("#model-referClinicName").html(result.referClinicName);
                        jQuery("#model-patientImage").attr('src', result.patientImage);


                        $('#appointment_detail_modal').modal('show');
                    }
                });
            });
        });
    </script>

@stop
