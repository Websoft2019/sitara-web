@extends('layouts.admin', ['activePage' => 'adminclinicaccount'])

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Clinic Account</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item active"><a href="#">Dashboard</a></li> -->
                        <li class="breadcrumb-item active">Dashboard</li>
                        <li class="breadcrumb-item active">Clinic</li>
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
                                        <th width="30%">Clinic Details</th>
                                        <th>Appointment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clinics as $item)
                                        <?php
                                        $apps = getAppointmentForAdminOfClinic($item->id, $monthyear);
                                        
                                        $appId = $apps->pluck('id')->toArray();
                                        
                                        $appointments = \App\Models\Appointment::whereIn('id', $appId)->get();
                                        
                                        $totalamount = \App\Models\Account::whereIn('appointment_id', $appId)->sum('amount');
                                        ?>
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                @if ($item->logo)
                                                    <img src="{{ asset('site/uploads/clinic/' . $item->logo) }}"
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
                                                {{-- <a href="{{ route('admin.getClinicAccountDetails', $item->slug) }}"
                                                    class="btn btn-xs btn-outline-success">View Details</a> --}}
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-xs btn-outline-success"
                                                    data-toggle="modal" data-target="#exampleModal-{{ $item->id }}">
                                                    View Details
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal-{{ $item->id }}"
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
                                                            <div class="modal-body"><h3>Clinic Details</h3>
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
                                                                <div class="container"
                                                                    style="background: #ededed; color: #000; border-radius: 10px; padding: 6px;">
                                                                    <div style="float: right; color: tomato;">
                                                                        {{ $monthyear->format('Y-M') }}</div>
                                                                    <h4>Overall Account Details</h4>
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
                                                                                <td>RM.
                                                                                    {{ \App\Models\Payment::whereIn('appointment_id', $appId)->sum('company_claim_amount') }}
                                                                                </td>
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
                                                                                    <td>RM.
                                                                                        {{ \App\Models\Payment::whereIn('appointment_id', $appointId)->sum('total_amount') }}
                                                                                    </td>
                                                                                    <td>RM.
                                                                                        {{ \App\Models\Payment::whereIn('appointment_id', $appointId)->sum('company_claim_amount') }}
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
                                                </div>
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
@endsection
