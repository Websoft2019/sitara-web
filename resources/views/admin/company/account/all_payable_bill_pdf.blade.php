<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>All Monthly Payable Bill</title>

    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #555;
        }
        .invoice-box {
            width: 100%;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        table th, table td {
            padding: 8px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        .heading th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-left {
            text-align: left;
        }
        .no-border {
            border: none !important;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table class="no-border">
            <tr>
                <td class="no-border">
                    <img src="{{ public_path('site/assets/img/weblogo.png') }}" style="width: 180px;" />
                </td>
                <td class="text-right no-border">
                    <strong>Monthly Invoice</strong><br>
                    Invoice #: {{ $company->id }}-{{ \Carbon\Carbon::parse($date)->format('Ym') }}<br>
                    Created: {{ \Carbon\Carbon::now()->format('M d, Y') }}<br>
                    For: {{ \Carbon\Carbon::parse($date)->format('F Y') }}
                </td>
            </tr>
        </table>

        <table class="no-border" style="margin-top: 20px;">
            <tr>
                <td class="no-border">
                    <strong>SITARA M SDN. BHD.</strong><br>
                    A207, Level 2, West Wing, Wisma Consplant 2,<br>
                    Jalan SS 16/1, 47600 Subang Jaya, Selangor, Malaysia.
                </td>
                <td class="text-right no-border">
                    <strong>{{ $company->name }}</strong><br>
                    {{ $company->address }}<br>
                    {{ $company->email }}
                </td>
            </tr>
        </table>

        <h3 style="margin-top: 30px;">Payable Appointments</h3>

        <table>
            <thead class="heading">
                <tr>
                    <th>AID / Date</th>
                    <th>Patient</th>
                    <th>Clinic / Doctor</th>
                    <th>Total Bill (RM)</th>
                    <th>Coverage (RM)</th>
                    <th>Payable (RM)</th>
                </tr>
            </thead>
            <tbody>
                @php $totalPayable = 0; @endphp
                @foreach ($appointments as $appointment)
                    @php
                        $timeinfo = App\Models\ScheduleTime::find($appointment->schedule_time_id);
                        $dateinfo = App\Models\ScheduleDate::find($timeinfo->schedule_date_id);
                        $dependent = $appointment->isself == 'Y' ? null : App\Models\Dependent::find($appointment->dependent_id);
                        $doctor = App\Models\ClinicUser::find($appointment->clinic_user_id);
                        $totalbill = \App\Models\Account::where('appointment_id', $appointment->id)->sum('amount');
                        $payable = min($totalbill, $appointment->claim_amount);
                        $totalPayable += $payable;
                    @endphp
                    <tr>
                        <td>
                            <strong>#{{ $appointment->id }}</strong><br>
                            {{ $dateinfo->date->format('D d M, Y') }}<br>
                            {{ $timeinfo->time }}
                        </td>
                        <td>
                            @if($appointment->isself == 'Y')
                                {{ $appointment->user->first_name }} {{ $appointment->user->mid_name }} {{ $appointment->user->last_name }}<br />
                                <small>eID #{{ $appointment->user->employee_id }} | IC #{{ $appointment->user->ic_number }}</small>
                            @else
                                {{ $dependent->name }} ({{ $dependent->relation }})<br>
                                <small>{{ $appointment->user->first_name }} {{ $appointment->user->last_name }}</small><br>
                                <small>eID #{{ $appointment->user->employee_id }} | IC #{{ $appointment->user->ic_number }}</small>
                            @endif
                        </td>
                        <td>
                            {{ $appointment->clinic->name }}<br>
                            <small>{{ $doctor->name }}
                                @if(!empty($doctor->specialities))
                                    ({{ $doctor->specialities }})
                                @endif
                            </small>
                        </td>
                        <td class="text-right">{{ number_format($totalbill, 2) }}</td>
                        <td class="text-right">{{ number_format($appointment->claim_amount, 2) }}</td>
                        <td class="text-right">{{ number_format($payable, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4 style="text-align:right; margin-top: 20px;">
            Total Payable Amount: RM {{ number_format($totalPayable, 2) }}
        </h4>
    </div>
</body>
</html>
