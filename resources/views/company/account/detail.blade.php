@extends('company.template', ['activePage' => 'companyaccount'])

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-7 col-auto">
                        <h3 class="page-title">{{ $employee->first_name }} {{ $employee->middle_name }}
                            {{ $employee->last_name }} - #{{ $employee->employee_id }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('company.home') }}">Dasboard</a></li>
                            <li class="breadcrumb-item active">Appointments</li>
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
                                            <th>Clinic Information</th>
                                            <th>Claiming Amount/Limit Per visit</th>
                                            <th>Total Charges</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        
                                        $apps = getAppointmentofSelectedMonthofClinic($employee->id, $company->id, $monthyear);
                                        
                                        $appId = $apps->pluck('id')->toArray();
                                        
                                        $appointments = \App\Models\Appointment::whereIn('id', $appId)->get();
                                        
                                        ?>
                                        @foreach ($appointments as $appointment)
                                            <tr>
                                                <td>{{ $appointment->id }}</td>
                                                <td>
                                                    @if ($appointment->getClinicFromAppointment->logo)
                                                        <img src="{{ asset('site/uploads/clinic/' . $appointment->getClinicFromAppointment->logo) }}"
                                                            alt="{{ $appointment->getClinicFromAppointment->name }}"
                                                            class="img-fluid" width="100">
                                                    @else
                                                        <img src="{{ asset('site/assets/img/logo.png') }}"
                                                            alt="{{ $appointment->getClinicFromAppointment->name }}"
                                                            class="img-fluid" width="100">
                                                    @endif
                                                </td>
                                                <td>
                                                    <b>Name: </b> {{ $appointment->getClinicFromAppointment->name }} <br>
                                                    <b>Email: </b>{{ $appointment->getClinicFromAppointment->email }} <br>
                                                    <b>Contact Number:
                                                    </b>{{ $appointment->getClinicFromAppointment->number }} <br>
                                                    <b>Contact Person:
                                                    </b>{{ $appointment->getClinicFromAppointment->contact_person }} <br>
                                                    <b>Person Number:
                                                    </b>{{ $appointment->getClinicFromAppointment->contact_person_number }}
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
                                                    <a href="">MYR {{ $employee->per_visit_claim }}</a>
                                                </td>
                                                <td>
                                                    <a href="">MYR {{ $totalamount }}</a>
                                                </td>
                                                <td class="text-start">
                                                    <div class="actions">
                                                        <a class="btn btn-sm bg-success-light"
                                                            href="{{ route('company.viewAppointmentAllDetails', [
                                                                'employee_id' => $appointment->getEmployeeFromAppointment->employee_id,
                                                                'id' => $appointment->id,
                                                            ]) }}">
                                                            <i class="fe fe-pencil"></i> View More Details
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
