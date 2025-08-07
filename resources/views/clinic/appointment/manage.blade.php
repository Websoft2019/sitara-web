    @extends('site.template')
    @section('content')
        <div class="breadcrumb-bar-two">
            <div class="container">
                <div class="row align-items-center inner-banner">
                    <div class="col-md-12 col-12 text-center">
                        <h2 class="breadcrumb-title">Appointments</h2>
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('getHome') }}">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page">Appointments</li>
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
                        @include('clinic.navbar', ['activePage' => 'clinicappointments'])
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
                                <h3>Appointments</h3>
                                <hr>
                                <div class="appointment-tab">
                                    <div class="row">
                                        <div class="col-sm-6 col-12 avail-time">
                                            <div class="mb-3">
                                                <div class="schedule-calendar-col justify-content-start">
                                                    <form action="{{ route('clinic.getAppointments') }}" method="GET"
                                                        class="d-flex flex-wrap">

                                                        <div class="me-3">
                                                            <input type="date" class="form-control" name="date"
                                                                id="schedule_date" value="{{ $date }}"
                                                                style="min-height: 10px; padding:5px">
                                                        </div>
                                                        <div class="search-time-mobile">
                                                            <input type="submit" value="View"
                                                                class="btn btn-sm bg-info-light h-100">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="text-align:right">
                                            <a href="#" class="btn btn-sm bg-danger-light" data-bs-toggle="modal"
                                                data-bs-target="#add_appointment_modal">Add New Appointment</a>
                                        </div>
                                    </div>

                                </div>
                                <div class="card card-table mb-0">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-center mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Patient Name</th>
                                                        <th>Patient Company</th>
                                                        <th>Appointment Date</th>
                                                        <th>Assign Doctor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($appointments->count())
                                                        @foreach ($appointments as $appointment)
                                                            @php
                                                                $timeinfo = App\Models\ScheduleTime::find(
                                                                    $appointment->schedule_time_id,
                                                                );
                                                                $dateinfo = App\Models\ScheduleDate::find(
                                                                    $timeinfo->schedule_date_id,
                                                                );
                                                            @endphp
                                                            @if ($dateinfo->date->format('Y-m-d') == $date)
                                                                @php
                                                                    $patientinfo = App\Models\User::find(
                                                                        $appointment->user_id,
                                                                    );
                                                                    $companyinfo = App\Models\Company::find(
                                                                        $patientinfo->company_id,
                                                                    );
                                                                @endphp
                                                                <tr>
                                                                    <td>
                                                                        <h2 class="table-avatar">
                                                                            <a href="" class="avatar avatar-sm me-2">
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
                                                                    <td>
                                                                        <a href="">
                                                                            {{ $companyinfo->name }}<br />
                                                                            <span>{{ $companyinfo->address }}</span><br />
                                                                            <span>{{ $companyinfo->number }}</span>
                                                                        </a>
                                                                    </td>
                                                                    <td>{{ $dateinfo->date->format('l d M, Y') }} <span
                                                                            class="d-block text-info">{{ $timeinfo->time }}</span>
                                                                    </td>
                                                                    <td>
                                                                        @if ($appointment->clinic_user_id != null)
                                                                            @php $getassigndoctorinfo = App\Models\ClinicUser::find($appointment->clinic_user_id); @endphp
                                                                            {{ $getassigndoctorinfo->name }}
                                                                            ({{ $getassigndoctorinfo->specialities }})
                                                                        @else
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" style="background-color: #ccc;">
                                                                        <div class="table-action">
                                                                            <a hre="#" id="{{ $appointment->id }}"
                                                                                class="btn btn-sm bg-info-light appointmentdetail">
                                                                                <i class="far fa-eye"></i> View
                                                                            </a>
                                                                            @if ($appointment->clinic_user_id == null)
                                                                                <a href="#"
                                                                                    class="btn btn-sm bg-success-light assigndoctor"
                                                                                    id="{{ $appointment->id }}">
                                                                                    <i class="fas fa-check"></i> Assign to
                                                                                    doctor
                                                                                </a>
                                                                            @else
                                                                                <a href="{{ route('clinic.getCheckUpPanel', $appointment->id) }}"
                                                                                    class="btn btn-sm bg-success-light">
                                                                                    <i class="fas fa-close"></i> Visit
                                                                                </a>
                                                                                {{-- <a href="{{ route('clinic.getCheckUpPanel', $appointment->id) }}"
                                                                                class="btn btn-sm bg-success-light">
                                                                                <i class="fas fa-check"></i> Reports
                                                                            </a>
                                                                            <a href="{{ route('clinic.getCheckUpPanel', $appointment->id) }}"
                                                                                class="btn btn-sm bg-success-light">
                                                                                <i class="fas fa-check"></i> Invoice
                                                                            </a> --}}
                                                                            @endif
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

    @stop
    @section('model')
        <div class="modal fade custom-modal" id="add_appointment_modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Add New Appointment</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="control-label">Employee ID / IC Number</label>
                                                <input type="text" name="patient" id="searchvalue"
                                                    class="form-control bank_name"
                                                    placeholder="Patient Employee Number Or IC Number">

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label"></label>
                                                <input type="submit" class="form-control btn btn-primary"
                                                    name="searchEmployee" id="searchEmployee" value="Search"
                                                    style="color: #fff">
                                            </div>
                                        </div>
                                        <div class="alert alert-danger print-error-msg" style="display:none">
                                            <p> Data Not found </p>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <hr>
                        <div class="row" id="detailsEmployee" style="display: none;">
                            <div class="col-md-6">
                                <div class="card widget-profile pat-widget-profile">
                                    <div class="card-body">
                                        <div class="pro-widget-content">
                                            <div class="profile-info-widget">
                                                <a href="" class="booking-doc-img">
                                                    <img src="" id="model1-patientImage" alt="User Image">
                                                </a>
                                                <div class="profile-det-info">
                                                    <h3><a href="" id="model1-fullname"></a></h3>
                                                    <div class="patient-details">
                                                        <h5><b>Company : </b><span id="model1-companyName"> </span></h5>
                                                        <h5><b>Employee No. : </b> <span id="model1-employeeID"></span> |
                                                            <b>IC
                                                                No. :</b> <span id="model1-ICNumber"></span>
                                                        </h5>
                                                        <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <span
                                                                id="model1-patientAddress"></span></h5>
                                                        <h5><b>Race : </b> <span id="model1-patientRace"></span> |
                                                            <b>Gender :
                                                            </b> <span id="model1-patientAge"></span>
                                                        </h5>
                                                        <h5><b>Conatct Number: </b> <span
                                                                id="model1-patientContact"></span>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="patient-info">
                                            <ul>
                                                <li>Company Coverage <span>RM <span id="model1-companyCoverage"></span>
                                                    </span>
                                                </li>
                                                <!-- <li>Pervious Checkup Date :  <span></span></li> -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form id="accounts_form" method="post">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Patient Name</label>
                                                <select id="patientlist" name="patient" class="form-control" required>
                                                    <option value="">Select Patient</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Appointment Date/time</label>
                                                <input type="date" id="schedule_date" name="schedule_date"
                                                    class="form-control" required>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Appointment Time</label>
                                                <input type="time" id="schedule_time" name="schedule_time"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Assign Doctor</label>
                                                <select name="" id="clinic_user_id" class="form-control" required>
                                                    @foreach ($doctors as $doctor)
                                                        <option value="{{ $doctor->id }}">{{ $doctor->name }}
                                                            ({{ $doctor->specialities }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Cause</label>
                                                <input type="text" id="cause" required class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="checkbox" name="coverage" id="company_claim"> Company Claim?
                                        </div>
                                    </div>
                                </div> --}}
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: right">
                                            <button type="submit" id="acc_btn" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="assign_doctor_model" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Doctor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('clinic.postAssignDoctor') }}" id="assignDr" method="POST">
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
                                        <input type="hidden" id="appointment-model" name="appointmentid"
                                            value="">
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                class="d-flex justify-content-center align-items-center btn btn-primary w-100">
                                <span class="d-none" id="assignDrLoading">@include('layouts/loading')</span>
                                <span>Assign</span>
                            </button>
                        </form>
                        <script>
                            document.getElementById('assignDr').addEventListener('submit', function() {
                                document.getElementById('assignDrLoading').classList.remove('d-none');
                            });
                        </script>
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
                                                        <h5><b>Employee No. :</b> <span id="model-employeeID"></span> |
                                                            <b>IC
                                                                No. :</b> <span id="model-ICNumber"></span>
                                                        </h5>
                                                        <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <span
                                                                id="model-patientAddress"></span></h5>
                                                        <h5><b>Race :</b> <span id="model-patientRace"></span> | <b>Gender
                                                                :
                                                            </b> <span id="model-patientAge"></span></h5>
                                                        <h5><b>Email :</b> <span id="model-patientEmail"></span></h5>
                                                        <h5><b>Contact No :</b> <span id="model-patientContact"></span>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="patient-info">
                                            <ul>
                                                <li>Company<span id="model-companyName"> </span></li>
                                                <li>Desgination <span id="model-companyPost"> </span></li>
                                                <li>Company Coverage <span>RM <span id="model-companyCoverage"> </span>
                                                    </span>
                                                </li>
                                                <li>Previous Checkup Date <span id="model-perviousCheckUpDate"> </span>
                                                </li>
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
                                                style="display: block"></span> <span id="model-appointmentDate"> </span>
                                        </li>
                                        <li>Requested Clinic <span id="model-referClinicName"></span></li>
                                        <li>Complain <span id="model-cause"> </span></li>
                                    </ul>
                                </div>
                                <br />


                                <hr>
                                <a href="" class="btn btn-sm bg-success-light"> Medical History</a>
                                <a href="" class="btn btn-sm bg-danger-light">Previous Medical Reports</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @stop
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
        <script>
            // assign current date and time for appointement
            // document.addEventListener('DOMContentLoaded', (event) => {
            function displayCurrentDateTime() {
                const now = new Date();

                // Set current date in YYYY-MM-DD format
                const dateInput = document.getElementById('schedule_date');
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                dateInput.value = `${year}-${month}-${day}`;

                // Set current time in HH:MM format
                const timeInput = document.getElementById('schedule_time');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                timeInput.value = `${hours}:${minutes}`;
            }
            // });


            $(document).ready(function() {
                $("#searchEmployee").click(function(e) {
                    e.preventDefault();

                    var search = $("#searchvalue").val();
                    $.ajax({
                        type: "POST",
                        url: "/clinic/ajax/employeedetail",
                        data: {
                            search: search,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(result) {
                            $(".print-error-msg").hide();
                            $("#detailsEmployee").css("display", "flex");

                            // Fill profile details
                            $("#model1-fullname").html(result.patientName);
                            $("#model1-employeeID").html(result.employeeID);
                            $("#model1-ICNumber").html(result.ICNumber);
                            $("#model1-patientAddress").html(result.patientAddress);
                            $("#model1-patientRace").html(result.patientRace);
                            $("#model1-patientAge").html(result.patientAge);
                            $("#model1-patientContact").html(result.patientContact);
                            $("#model1-companyName").html(result.companyName);
                            $("#model1-companyPost").html(result.companyPost);
                            $("#model1-companyCoverage").html(result.companyCoverage);
                            $("#model1-patientImage").attr('src', result.patientImage);

                            // Store data
                            let dependents = result.listofdependants || [];
                            let employeeCoverage = result.companyCoverage;

                            // Populate select dropdown
                            let $patientList = $("#patientlist");
                            $patientList.empty();

                            // Add main employee
                            $patientList.append(
                                $('<option>', {
                                    value: "employee",
                                    text: result.patientName + " (Main Employee)"
                                })
                            );

                            // Add dependents
                            $.each(dependents, function(index, dependent) {
                                let label = dependent.name +
                                    (dependent.icnumber ? ' | IC: ' + dependent.icnumber :
                                        '') +
                                    ' | DOB: ' + dependent.dob;
                                $patientList.append(
                                    $('<option>', {
                                        value: dependent.id,
                                        text: label,
                                        'data-benefit': dependent.min_benefit ||
                                            '0.00'
                                    })
                                );
                            });

                            // Change handler to update coverage
                            $patientList.off('change').on('change', function() {
                                let selectedVal = $(this).val();
                                let selectedText = $("#patientlist option:selected").text();

                                if (selectedVal === "employee") {
                                    $("#model1-companyCoverage").text(employeeCoverage);
                                } else {
                                    // Get selected option's benefit
                                    let minBenefit = $("#patientlist option:selected").data(
                                        "benefit") || '0.00';
                                    $("#model1-companyCoverage").text(minBenefit);
                                }
                            });

                            // Trigger initial change to show employee coverage
                            $patientList.val("employee").trigger("change");
                            displayCurrentDateTime();
                        },

                        error: function(xhr, status, error) {
                            $(".print-error-msg").show();
                            $("#detailsEmployee").css("display", "none");
                        }
                    });
                });
            });
        </script>

        <script>
            $(document).ready(function() {

                $("#acc_btn").click(function(e) {
                    let schedule_date = $("#schedule_date").val();
                    let schedule_time = $("#schedule_time").val();
                    let clinic_user_id = $("#clinic_user_id").val();
                    let employee_id = $("#model1-employeeID").html();
                    let patient_id = $("#patientlist").val();
                    let cause = $("#cause").val();
                    // console.log(clinic_user_id);
                    e.preventDefault();
                    // let company_claim
                    $.ajax({
                        type: "POST",
                        url: "{{ route('clinic.postAddAppointmentByClinic') }}",
                        data: {
                            schedule_date: schedule_date,
                            schedule_time: schedule_time,
                            clinic_user_id: clinic_user_id,
                            employee_id: employee_id,
                            patient_id: patient_id,
                            cause: cause,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            if (data.success === true) {
                                displayMessage(data.data);
                                $('#add_appointment_modal').modal('hide');
                            } else {
                                errorMessage(data.data);
                            }

                        }
                    });
                });
            });

            /*------------------------------------------
            --------------------------------------------
            Toastr Success Code
            --------------------------------------------
            --------------------------------------------*/
            function displayMessage(message) {
                toastr.success(message, 'Congratulations!');
            }

            function errorMessage(message) {
                toastr.error(message, 'Sorry!');
            }
        </script>
    @stop
