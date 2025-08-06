@extends('company.template', ['activePage' => 'companyaccount'])

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-7 col-auto">
                        <h3 class="page-title">Account</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('company.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Account</li>
                        </ul>
                    </div>
                    <div class="col-sm-5 col">
                        <form action="" method="GET">
                            {{-- @csrf --}}
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="month" id="datepicker" name="month" class="form-control"
                                        placeholder="Select Months" value="{{ $monthyear->format('Y-m') }}"
                                        autocomplete="off" />
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{-- <i class="fas fa-search" style=""></i> --}}Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="datatable table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Clinic Informations</th>
                                            <th>Total Appointment</th>
                                            <th>Claim Amount</th>
                                            <th>Total Appointment Ammount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $item)
                                            <?php

                                            $apps = getAppointmentofSelectedMonthofClinic($item->id, $company->id, $monthyear);

                                            $appId = $apps->pluck('id')->toArray();

                                            $appointments = \App\Models\Appointment::whereIn('id', $appId)->get();

                                            ?>
                                            <tr>
                                                <td>{{ $item->employee_id }}</td>
                                                <td style="text-align: center;">
                                                    <div class="profile-header"
                                                        style="background-color:transparent; border:none; padding:0">
                                                        <div class="row align-items-center">
                                                            <div class="col-auto profile-image">
                                                                @if ($item->image)
                                                                    <img class="rounded-circle" alt="User Image"
                                                                        src="{{ asset('site/uploads/company/employee/' . $item->image) }}">
                                                                @else
                                                                    <img class="rounded-circle" alt="User Image"
                                                                        src="{{ asset('site/assets/img/logo.png') }}">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col ml-md-2 profile-user-info">
                                                        <h6 class="user-name mb-0">{{ $item->first_name }}
                                                            {{ $item->middle_name }} {{ $item->last_name }}</h6>
                                                        <h6 class="text-muted">{{ $item->post }},
                                                            {{ $item->gender }}</h6>
                                                        <div class="user-Location"><i class="fa fa-phone"></i>
                                                            {{ $item->phone_number }} | IC#{{ $item->ic_number }}
                                                        </div>
                                                        <div class="about-text"></div>
                                                    </div>
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
                                                    <a href="">MYR {{ $item->per_visit_claim }}</a>
                                                </td>
                                                <td>
                                                    <a href="">MYR {{ $totalamount }}</a>
                                                </td>
                                                <td class="text-start">
                                                    <div class="actions">
                                                        <a class="btn btn-sm bg-success-light"
                                                            href="{{ route('company.viewAppointmentDetails', $item->employee_id) }}">
                                                            <i class="fe fe-pencil"></i> View Details
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
