@extends('site.template')

@section('css')
    <style>
        .cke_inner .cke_top {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb-bar-two">
        <div class="container">
            <div class="row align-items-center inner-banner">
                <div class="col-md-12 col-12 text-center">
                    <h2 class="breadcrumb-title">Add Prescription</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Add Prescription</li>
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
                    @include('clinic.employeeMedicalHistory', ['activePage' => 'clinicpatients'])
                </div>
                <div class="col-md-7 col-lg-8 col-xl-9">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-2">
                                    <h4 class="card-title mb-0">Prescription</h4>
                                </div>
                                <div class="col-md-10" style="text-align: right">
                                    <a href="{{ route('clinic.home') }}" class="btn btn-info">Dashboard</a>
                                    @if ($appointment->getPaymentFromAppointment != null)
                                        <a data-bs-toggle="modal" data-bs-target="#payment" class="btn btn-success">Payment
                                            Completed</a>
                                    @else
                                        <a data-bs-toggle="modal" data-bs-target="#payment" class="btn btn-danger">Payment
                                            Incomplete</a>
                                    @endif
                                    <a href="{{ route('clinic.getAppointments') }}" class="btn btn-primary">Appointment
                                        List</a>
                                    <a data-bs-toggle="modal"
                                        data-bs-target="{{ $paymentStatus == true ? '#payment' : '#add_accounting_model' }}"
                                        class="btn btn-dark">Bill</a>
                                    <a data-bs-toggle="modal" data-bs-target="#add_report_model"
                                        class="btn btn-success">Reports</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="min-height: 800px">
                            <form action="{{ route('clinic.postAddPrescriptionReport', $appointment->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row1">
                                    <textarea id="detail" name="prescription" rows="1000" style="width:100% !important; height:500px !important;">
                                        @if ($appointment->getPrescriptionReportFromAppointment != null)
{!! $appointment->getPrescriptionReportFromAppointment->prescription !!}
@else
<div class="row">
                                                <div class="col-sm-6">
                                                    <div class="biller-info">
                                                    <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                {{-- <img src="{{ asset('site/uploads/clinic/' . $clinicinfo->logo) }}" width="100" alt=""><br/> --}}
                                                                <div>
                                                                    <img width="100px" height="100px" src="{{ asset('site/assets/img/PNM.png') }}" alt="">
                                                                </div>
                                                                <strong>{{ $clinicinfo->name }}</strong><br />
                                                                {{ $clinicinfo->address }}<br />
                                                            Phone no : {{ $clinicinfo->number }}<br />
                                                            Email Address: {{ $clinicinfo->email }}</td>
                                                            <td style="text-align: right">
                                                            <p><strong>{{ Auth()->user()->name }}</strong><br />
                                                            Registration No . <br /> <br />
                                                            Appointment Date : {{ $appointdate }} | {{ $appointtime }}<br />
                                                            Appointment ID : #{{ $appointment->id }} <br />
                                                            Checkup Date/Time : {{ date('d M, Y H:i') }}
                                                        </p>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <table border="1" cellpadding="1" cellspacing="1" style="width:100%">
                                                        <tbody>
                                                        <tr>
                                                            @if ($appointment->isself == 'Y')
                                                                <td>Patient Name : {{ $employeeinfo->first_name }} {{ $employeeinfo->middle_name }} {{ $employeeinfo->last_name }}, {{ \Carbon\Carbon::parse($employeeinfo->date_of_birth)->diffInYears(\Carbon\Carbon::now()) }} years old, {{ $employeeinfo->gender }}<br />
                                                                Employee ID : #{{ $employeeinfo->employee_id }}<br />
                                                                Email : #{{ $employeeinfo->email }}<br />
                                                                Cause : {{ $appointment->cause }}</td>
                                                                <td style="text-align: right">Company Name : {{ $companyinfo->name }}<br />
                                                                Company Address : {{ $companyinfo->address }}</td>
                                                            @else
                                                                <td>
                                                                Employee : {{ $employeeinfo->first_name }} {{ $employeeinfo->middle_name }} {{ $employeeinfo->last_name }}<br />
                                                                Patient Name : {{ $employeedependentinfo->name }}, {{ \Carbon\Carbon::parse($employeedependentinfo->dob)->diffInYears(\Carbon\Carbon::now()) }} years old, {{ $employeedependentinfo->gender }}<br />
                                                                Employee Relation : {{ $employeedependentinfo->relation }}<br />
                                                                Employee ID : #{{ $employeeinfo->employee_id }}<br />
                                                                Cause : {{ $appointment->cause }}</td>
                                                                <td style="text-align: right">Company Name : {{ $companyinfo->name }}<br />
                                                                Company Address : {{ $companyinfo->address }}</td>
                                                            @endif
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <p>
                                                        Diagnose :
                                                    </p>
                                                    <p>
                                                        Remarks :
                                                    </p>
                                                    <table border="1" cellpadding="1" cellspacing="1" style="width:100%">
                                                        <tbody>
                                                        <tr>
                                                            <td>Medicine</td>
                                                            <td>Dosage</td>
                                                            <td>Qty</td>
                                                            <td>Duration</td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <p>
                                                        Procedures/additional test:
                                                    </p>
                                                    </div>
                                                </div>
                                            </div>
@endif
                                    </textarea>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group mb-0">
                                            <label for="medical_leave">Medical Leave (*)</label>
                                            @if ($appointment->getPrescriptionReportFromAppointment != null)
                                                <input type="text" class="form-control" id="medical_leave"
                                                    value="{{ $appointment->getPrescriptionReportFromAppointment->medical_leave }}"
                                                    name="medical_leave" required @disabled($paymentStatus)>
                                            @else
                                                <input type="text" class="form-control" id="medical_leave"
                                                    value="{{ old('medical_leave') }}" name="medical_leave" required
                                                    @disabled($paymentStatus)>
                                            @endif
                                        </div>

                                        @if ($errors->has('medical_leave'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small
                                                    style="font-weight: bold">{{ $errors->first('medical_leave') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="submit-section">
                                            <br />
                                            <div class="my-3 text-danger">
                                                <div><small>(*) Save the Prescription before send.</small></div>
                                                <div><small>(*) Prescription will sent to respective patient after payment
                                                        is complete. </small></div>
                                                <div><small><b>(*) Once you save the prescriptin you won't able to
                                                            edit/modify. </b></small></div>
                                            </div>
                                            <button type="submit" class="btn btn-primary submit-btn"
                                                @disabled($paymentStatus)>Save</button>
                                            <button type="reset" class="btn btn-secondary submit-btn"
                                                @disabled($paymentStatus)>Clear</button>
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

@section('model')
    <div class="modal fade custom-modal" id="add_report_model" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add Report</h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    @if ($appointment->getOthersReportFromAppointment != null)
                        @foreach ($appointment->getOthersReportFromAppointment as $report)
                            <form action="{{ route('clinic.postUpdateReports', $report->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-5">
                                        <div class="form-group mb-0">
                                            <label for="report_name">Reports/Referral (*)</label>
                                            <input type="text" class="form-control" id="report_name"
                                                value="{{ $report->report_name }}" name="report_name" required>
                                        </div>

                                        @if ($errors->has('report_name'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small
                                                    style="font-weight: bold">{{ $errors->first('report_name') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-0">
                                            <label for="file_name">File (*)</label>
                                            <input type="file" class="form-control" id="file_name" name="file_name">
                                        </div>

                                        @if ($errors->has('file_name'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small style="font-weight: bold">{{ $errors->first('file_name') }}</small>
                                            </span>
                                        @endif
                                        <a href="{{ asset('site/uploads/reports/' . $report->file_name) }}"
                                            target="_blank" style="color: blue; text-decoration: underline;">View
                                            Report</a>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-0">
                                            <label></label>
                                            <button class="form-control bg-success btn-remove"
                                                style="color: white; font-weight: 200;">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endforeach
                    @endif
                    <hr style="height: 5px; background: rgb(9, 9, 9); font-weight: bold;">
                    <form method="POST" action="{{ route('clinic.postAddReports', $appointment->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div id="container">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="report_name">Reports/Referral (*)</label>
                                        <input type="text" class="form-control" id="report_name" name="report_name[]"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="file_name">File (*)</label>
                                        <input type="file" class="form-control" id="file_name" name="file_name[]"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label></label>
                                        <button class="form-control bg-danger btn-remove"
                                            style="color: white; font-weight: 200;">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="form-control bg-primary btn-add" style="color: white; font-weight: 200;">Add
                                More</button>
                        </div>

                        <div class="row">
                            <input type="submit" class="btn btn-success form-control" value="Add">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade custom-modal" id="add_accounting_model" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add Bill</h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    @if ($appointment->getAccountingFromAppointment != null)
                        @foreach ($appointment->getAccountingFromAppointment as $account)
                            <form action="{{ route('clinic.postUpdateAccounting', $account->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-5">
                                        <div class="form-group mb-0">
                                            <label for="title">Bill (*)</label>
                                            <select class="form-control" id="title" name="title" required>
                                                <option value="">Choose Bill</option>
                                                <option value="Consultation" <?php if ($account->title == 'Consultation') {
                                                    echo 'selected';
                                                } ?>>Consultation</option>
                                                <option value="Medicines" <?php if ($account->title == 'Medicines') {
                                                    echo 'selected';
                                                } ?>>Medicines</option>
                                                <option value="Injections" <?php if ($account->title == 'Injections') {
                                                    echo 'selected';
                                                } ?>>Injections</option>
                                                <option value="Investigation" <?php if ($account->title == 'Investigation') {
                                                    echo 'selected';
                                                } ?>>Investigation</option>
                                                <option value="Procedure" <?php if ($account->title == 'Procedure') {
                                                    echo 'selected';
                                                } ?>>Procedure</option>
                                                <option value="Others" <?php if ($account->title == 'Others') {
                                                    echo 'selected';
                                                } ?>>Others</option>
                                            </select>
                                        </div>

                                        @if ($errors->has('title'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small style="font-weight: bold">{{ $errors->first('title') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group mb-0">
                                            <label for="amount">Amount (*)</label>
                                            <input type="number" class="form-control" id="amount" name="amount"
                                                value="{{ $account->amount }}">
                                        </div>

                                        @if ($errors->has('amount'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small style="font-weight: bold">{{ $errors->first('amount') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-0">
                                            <label></label>
                                            <button class="form-control bg-success btn-remove"
                                                style="color: white; font-weight: 200;">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endforeach
                    @endif
                    <hr style="height: 5px; background: rgb(9, 9, 9); font-weight: bold;">
                    <form method="POST" action="{{ route('clinic.postAddAccounting', $appointment->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div id="container-account">
                            <div class="row mb-3">
                                <div class="col-md-5">
                                    <div class="form-group mb-0">
                                        <label for="title">Bill (*)</label>
                                        <select class="form-control" id="title" name="title[]" required>
                                            <option value="Consultation">Consultation</option>
                                            <option value="Medicines">Medicines</option>
                                            <option value="Injections">Injections</option>
                                            <option value="Investigation">Investigation</option>
                                            <option value="Procedure">Procedure</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>

                                    @if ($errors->has('title'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('title') }}</small>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group mb-0">
                                        <label for="amount">Amount (*)</label>
                                        <input type="number" class="form-control" id="amount"
                                            value="{{ old('amount') }}" name="amount[]">
                                    </div>

                                    @if ($errors->has('amount'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('amount') }}</small>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-0">
                                        <label></label>
                                        <button class="form-control bg-danger btn-remove"
                                            style="color: white; font-weight: 200;">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button class="form-control bg-primary btn-add-account"
                                style="color: white; font-weight: 200;">Add
                                More</button>
                        </div>

                        <div class="row">
                            <input type="submit" class="btn btn-success form-control" value="Add">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade custom-modal" id="payment" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Payment</h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
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
                                        <td>MYR {{ $account->amount }}</td>
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
                                        {{-- {{ $totalamount - $appointment->getEmployeeFromAppointment->per_visit_claim > 0 ? $totalamount - $appointment->getEmployeeFromAppointment->per_visit_claim : 0 }} --}}
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
                                    </th>
                                </tr>
                                <tr style="text-align: right;">
                                    <th colspan="3">
                                        @if ($appointment->getPaymentFromAppointment != null)
                                            <a href="#" class="btn btn-success">Payment Completed</a>
                                        @else
                                            <a id="confirmPayment"
                                                href="{{ route('clinic.getPaymentComplete', $appointment->id) }}"
                                                class="d-flex justify-content-center align-items-center btn btn-danger">
                                                <span class="d-none"
                                                    id="confirmPaymentLoading">@include('layouts/loading')</span>
                                                <span>Confirm Payment</span>
                                            </a>
                                            <script>
                                                document.getElementById("confirmPayment").addEventListener("click", function() {
                                                    document.getElementById("confirmPaymentLoading").classList.remove("d-none");
                                                })
                                            </script>
                                        @endif
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                        {{-- <form action="{{ route('clinic.postUpdateAccounting', $account->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-5">
                                        <div class="form-group mb-0">
                                            <label for="title">Title (*)</label>
                                            <input type="text" class="form-control" id="title"
                                                value="{{ $account->title }}" name="title" required>
                                        </div>

                                        @if ($errors->has('title'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small style="font-weight: bold">{{ $errors->first('title') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group mb-0">
                                            <label for="amount">Amount (*)</label>
                                            <input type="number" class="form-control" id="amount" name="amount"
                                                value="{{ $account->amount }}">
                                        </div>

                                        @if ($errors->has('amount'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small style="font-weight: bold">{{ $errors->first('amount') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-0">
                                            <label></label>
                                            <button class="form-control bg-success btn-remove"
                                                style="color: white; font-weight: 200;">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form> --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
{{-- @section('js')
    <script>
        document.getElementById('add-btn').addEventListener('click', function() {
            var formContainer = document.getElementById('form-container');
            var clone = formContainer.lastElementChild.cloneNode(true);
            formContainer.appendChild(clone);
        });
    </script>
@endsection --}}
@section('js')
    {{-- <script src="https://cdn.ckeditor.com/4.20.2/full-all/ckeditor.js"></script> --}}
    <script src="{{ asset("site/vendor/ckeditor/ckeditor/ckeditor.js") }}"></script>

    <script>
        CKEDITOR.replace('detail', {
            filebrowserUploadUrl: "",
            filebrowserUploadMethod: 'form',


        });

        CKEDITOR.replace('detail2', {
            filebrowserUploadUrl: "",
            filebrowserUploadMethod: 'form',

        });
    </script>

    <script>
        // Add event listener to the "Add More" button
        document.querySelector('.btn-add').addEventListener('click', addRow);
        document.querySelector('.btn-add-account').addEventListener('click', addRowAccount);

        function addRowAccount() {
            // Get the container element for the rows
            const container = document.getElementById('container-account');

            // Create a new row element
            const newRow = document.createElement('div');
            newRow.classList.add('row');

            // Set up the HTML content for the new row
            newRow.innerHTML = `
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="title">Title (*)</label>
                               
                                <select class="form-control" id="title"
                                                 name="title[]" required>
                                                <option value="Consultation">Consultation</option>
                                                <option value="Medicines">Medicines</option>
                                                <option value="Injections">Injections</option>
                                                <option value="Investigation">Investigation</option>
                                                <option value="Procedure">Procedure</option>
                                                <option value="Others">Others</option>
                                            </select>
                                
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="amount">Amount (*)</label>
                                <input type="number" class="form-control" id="amount" name="amount[]" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label></label>
                                <button class="form-control bg-danger btn-remove" style="color: white; font-weight: 200;">Remove</button>
                            </div>
                        </div>
                    `;

            // Add the new row to the container
            container.appendChild(newRow);

            // Add event listener to the "Remove" button in the new row
            const btnRemove = newRow.querySelector('.btn-remove');
            btnRemove.addEventListener('click', removeRow);
        }

        function addRow() {
            // Get the container element for the rows
            const container = document.getElementById('container');

            // Create a new row element
            const newRow = document.createElement('div');
            newRow.classList.add('row');

            // Set up the HTML content for the new row
            newRow.innerHTML = `
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="report_name">Report Name (*)</label>
                                <input type="text" class="form-control" id="report_name" name="report_name[]" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="file_name">Report File (*)</label>
                                <input type="file" class="form-control" id="file_name" name="file_name[]" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label></label>
                                <button class="form-control bg-danger btn-remove" style="color: white; font-weight: 200;">Remove</button>
                            </div>
                        </div>
                    `;

            // Add the new row to the container
            container.appendChild(newRow);

            // Add event listener to the "Remove" button in the new row
            const btnRemove = newRow.querySelector('.btn-remove');
            btnRemove.addEventListener('click', removeRow);
        }

        function removeRow(event) {
            // Get the parent row of the clicked "Remove" button
            const row = event.target.closest('.row');

            // Remove the row from the container
            row.remove();
        }
    </script>

@stop
