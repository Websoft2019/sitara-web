@extends('layouts.admin', ['activePage' => 'admincomapnyaccount'])

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Company Account</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item active"><a href="#">Dashboard</a></li> -->
                        <li class="breadcrumb-item active">Dashboard</li>
                        <li class="breadcrumb-item active">Company</li>
                        <li class="breadcrumb-item active">Accounts</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row" style="display:flex; align-items: center;">
                                <div class="col-md-8">

                                </div>
                                <div class="col-md-4">
                                    <form action="" method="GET">
                                        {{-- @csrf --}}
                                        <div class="row">
                                            <div class="col-md-10">
                                                <input type="month" id="datepicker" name="month" class="form-control"
                                                    placeholder="Select Months" value="{{ $monthyear->format('Y-m') }}"
                                                    autocomplete="off" />
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
                            <table id="admincompanytable" class="table table-stripped table-bordered"
                                style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Logo</th>
                                        <th width="30%">Company Details</th>
                                        <th>Appointment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($companies as $item)
                                        <?php
                                        
                                        $apps = getAppointmentForAdminOfCompany($item->id, $monthyear);
                                        $appId = $apps->pluck('id')->toArray();
                                        
                                        $appointments = \App\Models\Appointment::whereIn('id', $appId)->get();
                                        
                                        // $totalamount = \App\Models\Account::whereIn('appointment_id', $appId)->sum('amount');
                                        $totalamount = \App\Models\Payment::whereIn('appointment_id', $appId)->sum('total_amount');
                                        ?>
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                @if ($item->logo)
                                                    <img src="{{ asset('site/uploads/company/' . $item->logo) }}"
                                                        alt="{{ $item->name }}" class="img-fluid" width="100">
                                                @else
                                                    <img src="{{ asset('site/assets/img/logo.png') }}"
                                                        alt="{{ $item->name }}" class="img-fluid" width="100">
                                                @endif
                                            </td>
                                            <td>
                                                <b>Name: </b> {{ $item->name }} <br>
                                                <b>Email: </b>{{ $item->email }} <br>
                                                <b>Contact Number: </b>{{ $item->number }} <br>
                                                <b>Contact Person: </b>{{ $item->contact_person }} <br>
                                                <b>Person Number: </b>{{ $item->contact_person_number }}
                                            </td>
                                            <td>
                                                <b>Appointment Count: </b>{{ $appointments->count() }} <br>
                                                <b>Total Amount: </b>{{ $totalamount }}
                                            </td>
                                            <td>
                                            
                                                <!-- Button trigger modal -->
                                                <!-- <button type="button" class="btn btn-xs btn-outline-success"
                                                    data-toggle="modal" data-target="#exampleModal-{{ $item->id }}">
                                                    View Details
                                                </button> -->
                                                <button type="button" class="btn btn-xs btn-outline-success open-modal-btn"
                                                    data-id="{{ $item->id }}"
                                                    data-date="{{ $monthyear->format('Y-m') }}">
                                                    View Details
                                                </button>

                                                <!-- Modal -->
                                                <!-- <div class="modal fade" id="exampleModal-{{ $item->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalLabel-{{ $item->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-xl" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="exampleModalLabel-{{ $item->id }}">Account
                                                                    Details
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h3>Company Details</h3>
                                                                <table class="table table-sm table-responsive-sm">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">Name</th>
                                                                            <th scope="col">Email</th>
                                                                            <th scope="col">Contact Number</th>
                                                                            <th scope="col">Contact Person</th>
                                                                            <th scope="col">Person Name</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>{{ $item->name }}</td>
                                                                            <td>{{ $item->email }}</td>
                                                                            <td>{{ $item->number }}</td>
                                                                            <td>{{ $item->contact_person }}</td>
                                                                            <td>{{ $item->contact_person_number }}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <br>
                                                                <div class="container" style="background: #ededed; color: #000; border-radius: 10px; padding: 6px;">
                                                                    
                                                                    <div style="float: right; color: tomato;">
                                                                        Filter <input type="month" name="filtermonth">
                                                                    </div>
                                                                    <h4>Overall Account Details {{ $monthyear->format('Y-M') }}</h4>
                                                                    <table class="table table-sm table-responsive-sm">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">Appointment Count</th>
                                                                                <th scope="col">Total Account</th>
                                                                                <th scope="col">Sitara Claim</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>{{ $appointments->count() }}</td>
                                                                                <td>RM. {{ $totalamount }}</td>
                                                                                <td>RM. {{ \App\Models\Payment::whereIn('appointment_id', $appId)->sum('company_claim_amount') }}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <br>
                                                                    <h4>Clinic Details</h4>
                                                                    <table class="table table-sm table-responsive-sm">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">Clinic</th>
                                                                                <th scope="col">Appointment Count</th>
                                                                                <th scope="col">Total Account</th>
                                                                                <th scope="col">Sitara Claim</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            @php

                                                                                $clinicId = \App\Models\Appointment::whereIn(
                                                                                    'id',
                                                                                    $appId,
                                                                                )
                                                                                    ->pluck('clinic_id')
                                                                                    ->toArray();
                                                                                $getClinics = \App\Models\Clinic::whereIn(
                                                                                    'id',
                                                                                    array_unique($clinicId),
                                                                                )->get();

                                                                            @endphp

                                                                            @foreach ($getClinics as $getClinic)
                                                                                <tr>
                                                                                    <td>{{ $getClinic->name }}</td>
                                                                                    <td>{{ \App\Models\Appointment::whereIn('id', $appId)->where('clinic_id', $getClinic->id)->count() }}
                                                                                    </td>
                                                                                    @php
                                                                                        $appointId = \App\Models\Appointment::whereIn(
                                                                                            'id',
                                                                                            $appId,
                                                                                        )
                                                                                            ->where(
                                                                                                'clinic_id',
                                                                                                $getClinic->id,
                                                                                            )
                                                                                            ->pluck('id')
                                                                                            ->toArray();
                                                                                    @endphp
                                                                                    <td>RM. {{ \App\Models\Payment::whereIn('appointment_id', $appointId)->sum('total_amount') }}
                                                                                    </td>
                                                                                    <td>RM. {{ \App\Models\Payment::whereIn('appointment_id', $appointId)->sum('company_claim_amount') }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {!! $companies->links() !!} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main content ends here -->
     <!-- Single Modal Outside Loop -->
<div class="modal fade" id="companyModal"
    tabindex="-1" role="dialog"
    aria-labelledby="companyModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Account Details</h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="companyModalBody">
                <!-- Content will be loaded via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        $(function() {
            $("#admincompanytable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.open-modal-btn').on('click', function () {
                const companyId = $(this).data('id');
                const monthYear = $(this).data('date');

                $('#companyModal').modal('show');
                $('#companyModalBody').html('<p>Loading...</p>');

                $.ajax({
                    url: '/admin/company-account-details',
                    method: 'POST',
                    data: {
                        company_id: companyId,
                        month_year: monthYear,
                        _token: '{{ csrf_token() }}' // Laravel CSRF protection
                    },
                    success: function (response) {
                        $('#companyModalBody').html(response);
                    },
                    error: function () {
                        $('#companyModalBody').html('<p>Error loading data.</p>');
                    }
                });
            });
        });
    </script>

@endsection
