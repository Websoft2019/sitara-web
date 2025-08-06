@extends('site.template')
@section('css')
    <style>
        .box {
            background-color: white;
            box-shadow: 5px 5px 17px #ccc;
            border-radius: 5px;
            min-height: 285px;
            flex-wrap: wrap;
        }

        .box .box-header,
        .box .box-body {
            padding: 10px;
        }

        .box .box-header {
            background: #00cdf2;
            font-weight: bold;
            text-align: center;
            font-size: 20px;
            color: #fff;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .box .box-body-image {
            border-radius: 50%;
            height: 150px;
            width: 150px;
            line-height: 150px;
            padding: 2px;
            background: #ccc;
            overflow: hidden;
        }

        .box .box-body-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb-bar-two">
        <div class="container">
            <div class="row align-items-center inner-banner">
                <div class="col-md-12 col-12 text-center">
                    <h2 class="breadcrumb-title">Appointment Details</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Appointment Details #{{ $appointment->id }}</li>
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
                    <h3>Appointment Details #{{ $appointment->id }}</h3>
                    <hr>
                    <div class="row">
                        {{-- <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-5 mb-4">
                            <div class="box">
                                <div class="box-header">
                                    Employee Details
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-4 col-xxl-3">
                                            <div class="box-body-image">
                                                @if ($employee->image)
                                                    <img src="{{ asset('site/uploads/company/employee/' . $employee->image) }}"
                                                        alt="{{ $appointment->employee_id }}" class="img-fluid ">
                                                @else
                                                    <img src="{{ asset('site/assets/img/logo.png') }}"
                                                        alt="{{ $appointment->employee_id }}" class="img-fluid ">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <b>Name: </b> {{ $employee->first_name }} {{ $employee->middle_name }}
                                            {{ $employee->last_name }} <br>
                                            <b>Employee Id: </b>{{ $employee->employee_id }} <br>
                                            <b>Address: </b> {{ $employee->address }} <br>
                                            <b>Email:
                                            </b>{{ $employee->email != null ? $employee->email : 'Email not found' }}
                                            <br>
                                            <b>Contact Number: </b>{{ $employee->phone_number }} <br>
                                            <b>Per Visit Claim: </b>{{ $employee->per_visit_claim }} <br>
                                            <b>Date: </b>
                                            {{ $appointment->reschedule_time_id == null ? $appointment->scheduleTimeFromAppointment->getScheduleDateFromScheduleTime->date->format('l d M, Y') : $appointment->reScheduleTimeFromAppointment->getScheduleDateFromScheduleTime->date->format('l d M, Y') }}
                                            <span
                                                class="text-info">{{ $appointment->reschedule_time_id != null ? $appointment->reScheduleTimeFromAppointment->time->format('H:i A') : $appointment->scheduleTimeFromAppointment->time }}</span>
                                            <br>
                                            <b>Requested Date: </b>{{ $appointment->created_at->format('l d M, Y h:i A') }}
                                            <br>
                                            <b>Completed Date: </b>{{ $appointment->updated_at->format('l d M, Y h:i A') }}
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-md-7 mb-4">
                            <div class="box">
                                <div class="box-header">
                                    Clinic Details
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="box-body-image">
                                                @if ($appointment->getClinicFromAppointment->logo)
                                                    <img src="{{ asset('site/uploads/clinic/' . $appointment->getClinicFromAppointment->logo) }}"
                                                        alt="{{ $appointment->getClinicFromAppointment->name }}">
                                                @else
                                                    <img src="{{ asset('site/assets/img/logo.png') }}"
                                                        alt="{{ $appointment->getClinicFromAppointment->name }}">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <b>Name: </b> {{ $appointment->getClinicFromAppointment->name }} <br>
                                            <b>Address: </b> {{ $appointment->getClinicFromAppointment->address }} <br>
                                            <b>Longitude: </b> {{ $appointment->getClinicFromAppointment->longitude }} <br>
                                            <b>Latitude: </b> {{ $appointment->getClinicFromAppointment->latitude }} <br>
                                            <b>Email: </b>{{ $appointment->getClinicFromAppointment->email }} <br>
                                            <b>Contact Number:
                                            </b>{{ $appointment->getClinicFromAppointment->number }} <br>
                                            <b>Contact Person:
                                            </b>{{ $appointment->getClinicFromAppointment->contact_person }} <br>
                                            <b>Person Number:
                                            </b>{{ $appointment->getClinicFromAppointment->contact_person_number }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 mb-4">
                            <div class="box">
                                <div class="box-header">
                                    Reports
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <table class="table table-bordered table-stripped">
                                            <thead>
                                                <tr>
                                                    <th>S.N</th>
                                                    <th>Report Name</th>
                                                    <th>Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $a = 0; ?>
                                                @if ($appointment->getPrescriptionReportFromAppointment != null)
                                                    <?php $a = 1; ?>
                                                    <tr>
                                                        <td>{{ $a }}</td>
                                                        <td style="text-transform: capitalize;">
                                                            {{ $appointment->getPrescriptionReportFromAppointment->report_name }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ asset('site/uploads/reports/' . $appointment->getPrescriptionReportFromAppointment->file_name) }}"
                                                                target="_blank"
                                                                style="color: blue; text-decoration: underline;">View
                                                                Report</a>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($appointment->getOthersReportFromAppointment != null)
                                                    @foreach ($appointment->getOthersReportFromAppointment as $report)
                                                        <tr>
                                                            <td>{{ $loop->iteration + $a }}</td>
                                                            <td>{{ $report->report_name }}</td>
                                                            <td>
                                                                <a href="{{ asset('site/uploads/reports/' . $report->file_name) }}"
                                                                    target="_blank"
                                                                    style="color: blue; text-decoration: underline;">View
                                                                    Report</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="box">
                                <div class="box-header">
                                    Accounting
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if ($appointment->getAccountingFromAppointment != null)
                                                <table class="table table-bordered table-stripped">
                                                    <thead>
                                                        <tr>
                                                            <th>S.N</th>
                                                            <th>Title</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $totalamount = 0; ?>
                                                        @foreach ($appointment->getAccountingFromAppointment as $account)
                                                            <?php $totalamount = $totalamount + $account->amount; ?>
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $account->title }}</td>
                                                                <td>{{ $account->amount }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr style="text-align: right;">
                                                            <th colspan="3">Total Amount: MYR {{ $totalamount }}</th>
                                                        </tr>
                                                        <tr style="text-align: right;">
                                                            <th colspan="3">Company Claim: MYR
                                                                @if ($appointment->isself == 'N' && $appointment->dependent_id != null)
                                                                    @php
                                                                        $benifitCharge = \App\Models\Dependent::findOrFail($appointment->dependent_id);
                                                                        echo $benifitCharge->min_benefit;
                                                                    @endphp
                                                                @else
                                                                    {{ $minBenifit = $appointment->getEmployeeFromAppointment->per_visit_claim < $totalamount
                                                                    ? $appointment->getEmployeeFromAppointment->per_visit_claim
                                                                    : $totalamount }}
                                                                @endif
                                                        </th>
                                                        </tr>
                                                        <tr style="text-align: right;">
                                                            <th colspan="3">Amount to Pay: MYR
                                                                @if ($appointment->isself == 'N' && $appointment->dependent_id != null)
                                                                    @php
                                                                        if ($totalamount > $benifitCharge->min_benefit) {
                                                                            echo $totalamount - $benifitCharge->min_benefit;
                                                                        } else {
                                                                            echo 0;
                                                                        }
                                                                    @endphp
                                                                @else
                                                                    {{ $totalamount - $appointment->getEmployeeFromAppointment->per_visit_claim > 0 ? $totalamount - $appointment->getEmployeeFromAppointment->per_visit_claim : 0 }}
                                                                @endif
                                                                <br> <br>
                                                                @if ($appointment->getPaymentFromAppointment != null)
                                                                    <span
                                                                        class="btn btn-sm btn-outline-success text-bold">Payment
                                                                        Completed</span>
                                                                @else
                                                                    <span
                                                                        class="btn btn-sm btn-outline-danger text-bold">Payment
                                                                        Incomplete</span>
                                                                @endif
                                                            </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            @endif
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
