@extends('site.template')
@section('content')
    <div class="breadcrumb-bar-two">
        <div class="container">
            <div class="row align-items-center inner-banner">
                <div class="col-md-12 col-12 text-center">
                    <h2 class="breadcrumb-title">Account</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('getHome') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Account</li>
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
                    @include('clinic.navbar', ['activePage' => 'clinicaccounts'])
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
                            <h3>Account</h3>
                            <hr>
                            {{-- <div class="appointment-tab">
                                <div class="row">
                                    <div class="col-md-12" style="text-align:right">
                                        <a href="#" class="btn btn-sm bg-danger-light" data-bs-toggle="modal"
                                            data-bs-target="#add_appointment_modal">Invoke Ref Code</a>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="card card-table mb-0">
                                <div class="card-header">
                                    <div class="row" style="display:flex; align-items: center;">
                                        <div class="col-md-8">

                                        </div>
                                        <div class="col-md-4">
                                            <form action="" method="GET">
                                                {{-- @csrf --}}
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <input type="month" id="datepicker" name="month"
                                                            class="form-control" placeholder="Select Months"
                                                            value="{{ $monthyear->format('Y-m') }}" autocomplete="off" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="fas fa-search" style=""></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Company Name</th>
                                                    <th>No. of Appointments</th>
                                                    <th>Total Amount</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($clinic->getCompanyClinicFromClinic->count())
                                                    @foreach ($companies as $item)
                                                        <?php

                                                        $apps = getAppointmentofSelectedMonth($clinic->id, $item->id, $monthyear);

                                                        $appId = $apps->pluck('id')->toArray();

                                                        $appointments = \App\Models\Appointment::whereIn('id', $appId)->get();

                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="" class="avatar avatar-sm me-2">
                                                                        <img class="avatar-img rounded-circle"
                                                                            src="{{ asset('site/assets/img/patients/patient.jpg') }}"
                                                                            alt="User Image">
                                                                    </a>
                                                                    <a href="">{{ $item->name }}
                                                                        <span>{{ $item->address }}</span>
                                                                        <span>{{ $item->number }}</span></a>
                                                                </h2>
                                                            </td>
                                                            <td>
                                                                <a href="">{{ $appointments->count() }}</a>
                                                            </td>
                                                            <?php
                                                            $totalamount = 0;
                                                            ?>
                                                            @foreach ($appointments as $appoint)
                                                                @foreach ($appoint->getAccountingFromAppointment as $account)
                                                                    <?php
                                                                    $totalamount = $totalamount + $account->amount;
                                                                    ?>
                                                                @endforeach
                                                            @endforeach
                                                            <td>
                                                                <a href="">{{ $totalamount }}</a>
                                                            </td>
                                                            {{-- <td class="text-end">
                                                            <div class="appointment-action">
                                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                                    <i class="far fa-eye"></i> View
                                                                </a>
                                                                <a href="javascript:void(0);"
                                                                    class="btn btn-sm bg-danger-light">
                                                                    <i class="fas fa-times"></i> Remove
                                                                </a>
                                                            </div>
                                                        </td> --}}
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4" style="color: red">No any company link yet!!!
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
@stop
@section('model')
    <div class="modal fade custom-modal" id="add_appointment_modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add Company</h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('clinic.addCompanyFromReferCode') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label">Ref Code</label>
                                            <input type="text" name="refer_code" id="referCode"
                                                class="form-control bank_name" placeholder="Ref code provide by Company">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"></label>
                                            <button type="button" class="form-control btn btn-primary" id="submitBtn"
                                                value="" style="color: #fff">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="row" id="showRow" style="display: none;">
                            <div class="col-md-12">
                                <div class="card widget-profile pat-widget-profile">
                                    <div class="card-body">
                                        <div class="pro-widget-content">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="profile-info-widget" style="text-align:left !important">
                                                        <h2 class="table-avatar">
                                                            <a href="" class="avatar avatar-sm me-2">
                                                                <img class="avatar-img rounded-circle"
                                                                    src="{{ asset('site/assets/img/patients/patient.jpg') }}"
                                                                    alt="User Image" id="companyImage">
                                                            </a>
                                                            <span style="font-size: 22px" id="companyName">Company
                                                                Name</span>
                                                            <span style="font-size: 14px; display:block;"
                                                                id="companyAddress">
                                                                &nbsp; &nbsp; &nbsp;
                                                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Company
                                                                address</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="submit" class="btn btn-danger" value="Add Company">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="patient-info">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <ul>
                                                        <li>Company Phone :<span id="companyNumber"> 061 538358</span></li>
                                                        <li>Company Email : <span id="companyEmail">
                                                                ishworchalise@gmail.com
                                                            </span></li>
                                                        <li>Total Employee <span id="companyEmployeeCount">456
                                                                <small>/person</small></span></li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6">
                                                    <ul>
                                                        <li>Contact Person (HR) :<span id="companyContactPerson"> Arjun
                                                                Acharya</span></li>
                                                        <li>HR Phone : <span id="companyContactPersonNumber">
                                                                ishworchalise@gmail.com </span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let submitBtn = document.getElementById('submitBtn');

            $('#submitBtn').click(function() {
                let referCode = $('#referCode').val();
                $.ajax({
                    type: 'GET',
                    url: "{{ route('clinic.getCompanyFromReferCode') }}",
                    data: {
                        refer_code: referCode,
                    },
                    success: function(data) {
                        if (data.success === true) {
                            $('#showRow').css('display', 'block');
                            $('#companyName').text(data.name);
                            if (data.logo) {
                                $('#companyImage').attr('src',
                                    '{{ asset('site/uploads/company') }}/' + data.logo);
                            } else {
                                $('#companyImage').attr('src',
                                    "{{ asset('site/assets/img/logo.png') }}");
                            }
                            $('#companyAddress').text(data.address);
                            $('#companyNumber').text(data.number);
                            $('#companyEmail').text(data.email);
                            $('#companyEmployeeCount').text(data.employee_count);
                            $('#companyContactPerson').text(data.contact_person);
                            $('#companyContactPersonNumber').text(data.contact_person_number);
                        } else {
                            $('#showRow').css('display', 'none');
                            errorMessage(
                                "Compnay with this refer_code not available!");
                        }
                    },
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

@endsection
@section('js')
    <script src="{{ asset('site/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('site/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
    <script src="{{ asset('site/assets/js/circle-progress.min.js') }}"></script>
@stop
