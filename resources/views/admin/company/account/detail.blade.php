@extends('layouts.admin', ['activePage' => 'admincomapnyaccount'])

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $company->name }} Accounts</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item active"><a href="#">Dashboard</a></li> -->
                        <li class="breadcrumb-item active">Dashboard</li>
                        <li class="breadcrumb-item active">{{ $company->name }}</li>
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
                                        
                                        $apps = getAppointmentofSelectedMonth($item->id, $company->id, $monthyear);
                                        
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
                                                <a href="" class="btn btn-outline-success btn-xs">View More
                                                    Details</a>
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
