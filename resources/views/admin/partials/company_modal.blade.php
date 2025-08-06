<?php                                    
    $apps = getAppointmentForAdminOfCompany($company->id, $monthyear);
    $appId = $apps->pluck('id')->toArray();
    
    $appointments = \App\Models\Appointment::whereIn('id', $appId)->get();
    
    // $totalamount = \App\Models\Account::whereIn('appointment_id', $appId)->sum('amount');
    $totalamount = \App\Models\Payment::whereIn('appointment_id', $appId)->sum('total_amount');
?>
<div class="modal-body">
    <h3>Company Details</h3>
    <table class="table table-sm table-responsive-sm">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Contact Number</th>
                <th scope="col">Key Person</th>
                <th scope="col">Key Person Contact</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $company->name }}</td>
                <td>{{ $company->email }}</td>
                <td>{{ $company->number }}</td>
                <td>{{ $company->contact_person }}</td>
                <td>{{ $company->contact_person_number }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <div class="container" style="background: #ededed; color: #000; border-radius: 10px; padding: 15px;">
        
        <div style="float: right; color: tomato;">
            {{ $monthyear }}
        </div>
        <h4>Overall Clinic Account Details </h4>

        <table class="table table-sm table-responsive-sm">
            <thead>
                <tr>
                    <th scope="col">Clinic</th>
                    <th scope="col">Appointment Count</th>
                    <th scope="col">Total Account</th>
                    <th scope="col">Sitara Claim</th>
                    <th></th>
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
                        <td>RM{{ \App\Models\Payment::whereIn('appointment_id', $appointId)->sum('total_amount') }}
                        </td>
                        <td>RM{{ \App\Models\Payment::whereIn('appointment_id', $appointId)->sum('company_claim_amount') }}
                        </td>
                        <td><a href="{{route('admin.getpayableBillofMonthPDF', [ $company->id, $getClinic->id, $monthyear ])}}" target="_blank">PDF</a></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th>{{ $appointments->count() }}</th>
                    <th>RM{{ $totalamount }}</th>
                    <th>RM{{ \App\Models\Payment::whereIn('appointment_id', $appId)->sum('company_claim_amount') }}</th>
                    <th><a href="{{route('admin.getALLpayableBillofMonthPDF', [ $company->id, $getClinic->id, $monthyear ])}}" target="_blank">PDF</a></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>