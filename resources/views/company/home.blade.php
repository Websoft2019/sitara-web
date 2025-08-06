@extends('company.template', ['activePage' => 'companyhome'])
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h3 class="page-title">Welcome Admin!</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
                $employee_count = \App\Models\User::where('company_id', Auth::user()->id)->where('deleted_at', null)->count();
                $affilated_clinics_count = \App\Models\CompanyClinic::where('company_id', Auth::user()->id)->where('deleted_at', null)->count();
            ?>
            <div class="row">
                <div class="col-xl-6 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-primary border-primary">
                                    <i class="fe fe-users"></i>
                                </span>
                                <div class="dash-count">
                                    <h3>{{ $employee_count }}</h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6 class="text-muted"><a href="{{ route('company.getEmployeeManage') }}">Employees</a></h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-primary w-50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon text-success">
                                    <i class="fe fe-credit-card"></i>
                                </span>
                                <div class="dash-count">
                                    <h3>{{ $affilated_clinics_count }}</h3>
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6 class="text-muted"><a href="{{ route('company.getManageClinics') }}">Affiliated Clinics</a></h6>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success w-50"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="card card-chart">
                        <div class="card-header">
                            <h4 class="card-title">Revenue</h4>
                        </div>
                        <div class="card-body">
                            <div id="morrisArea"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="card card-chart">
                        <div class="card-header">
                            <h4 class="card-title">Status</h4>
                        </div>
                        <div class="card-body">
                            <div id="morrisLine"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h4 class="card-title">Doctors List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Doctor Name</th>
                                            <th>Speciality</th>
                                            <th>Earned</th>
                                            <th>Reviews</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="{{ asset('company/assets/img/doctors/doctor-thumb-01.jpg') }}"
                                                            alt="User Image"></a>
                                                    <a href="">Dr. Ruby Perrin</a>
                                                </h2>
                                            </td>
                                            <td>Dental</td>
                                            <td>$3200.00</td>
                                            <td>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star-o text-secondary"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="{{ asset('company/assets/img/doctors/doctor-thumb-02.jpg') }}"
                                                            alt="User Image"></a>
                                                    <a href="">Dr. Darren Elder</a>
                                                </h2>
                                            </td>
                                            <td>Dental</td>
                                            <td>$3100.00</td>
                                            <td>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star-o text-secondary"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="{{ asset('company/assets/img/doctors/doctor-thumb-03.jpg') }}"
                                                            alt="User Image"></a>
                                                    <a href="">Dr. Deborah Angel</a>
                                                </h2>
                                            </td>
                                            <td>Cardiology</td>
                                            <td>$4000.00</td>
                                            <td>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star-o text-secondary"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="{{ asset('company/assets/img/doctors/doctor-thumb-04.jpg') }}"
                                                            alt="User Image"></a>
                                                    <a href="">Dr. Sofia Brient</a>
                                                </h2>
                                            </td>
                                            <td>Urology</td>
                                            <td>$3200.00</td>
                                            <td>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star-o text-secondary"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="{{ asset('company/assets/img/doctors/doctor-thumb-05.jpg') }}"
                                                            alt="User Image"></a>
                                                    <a href="">Dr. Marvin Campbell</a>
                                                </h2>
                                            </td>
                                            <td>Orthopaedics</td>
                                            <td>$3500.00</td>
                                            <td>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star text-warning"></i>
                                                <i class="fe fe-star-o text-secondary"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex">
                    <div class="card  card-table flex-fill">
                        <div class="card-header">
                            <h4 class="card-title">Patients List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Patient Name</th>
                                            <th>Phone</th>
                                            <th>Last Visit</th>
                                            <th>Paid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="{{ asset('company/assets/img/patients/patient1.jpg') }}"
                                                            alt="User Image"></a>
                                                    <a href="">Charlene Reed </a>
                                                </h2>
                                            </td>
                                            <td>8286329170</td>
                                            <td>20 Oct 2019</td>
                                            <td class="text-end">$100.00</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="{{ asset('company/assets/img/patients/patient2.jpg') }}"
                                                            alt="User Image"></a>
                                                    <a href="">Travis Trimble </a>
                                                </h2>
                                            </td>
                                            <td>2077299974</td>
                                            <td>22 Oct 2019</td>
                                            <td class="text-end">$200.00</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="{{ asset('company/assets/img/patients/patient3.jpg') }}"
                                                            alt="User Image"></a>
                                                    <a href="profile.html">Carl Kelly</a>
                                                </h2>
                                            </td>
                                            <td>2607247769</td>
                                            <td>21 Oct 2019</td>
                                            <td class="text-end">$250.00</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="assets/img/patients/patient4.jpg" alt="User Image"></a>
                                                    <a href="profile.html"> Michelle Fairfax</a>
                                                </h2>
                                            </td>
                                            <td>5043686874</td>
                                            <td>21 Sep 2019</td>
                                            <td class="text-end">$150.00</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="assets/img/patients/patient5.jpg" alt="User Image"></a>
                                                    <a href="profile.html">Gina Moore</a>
                                                </h2>
                                            </td>
                                            <td>9548207887</td>
                                            <td>18 Sep 2019</td>
                                            <td class="text-end">$350.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-table">
                        <div class="card-header">
                            <h4 class="card-title">Appointment List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Doctor Name</th>
                                            <th>Speciality</th>
                                            <th>Patient Name</th>
                                            <th>Apointment Time</th>
                                            <th>Status</th>
                                            <th class="text-end">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="assets/img/doctors/doctor-thumb-01.jpg"
                                                            alt="User Image"></a>
                                                    <a href="profile.html">Dr. Ruby Perrin</a>
                                                </h2>
                                            </td>
                                            <td>Dental</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="assets/img/patients/patient1.jpg" alt="User Image"></a>
                                                    <a href="profile.html">Charlene Reed </a>
                                                </h2>
                                            </td>
                                            <td>9 Nov 2019 <span class="text-primary d-block">11.00 AM - 11.15 AM</span>
                                            </td>
                                            <td>
                                                <div class="status-toggle">
                                                    <input type="checkbox" id="status_1" class="check" checked>
                                                    <label for="status_1" class="checktoggle">checkbox</label>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                $200.00
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="assets/img/doctors/doctor-thumb-02.jpg"
                                                            alt="User Image"></a>
                                                    <a href="profile.html">Dr. Darren Elder</a>
                                                </h2>
                                            </td>
                                            <td>Dental</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="assets/img/patients/patient2.jpg" alt="User Image"></a>
                                                    <a href="profile.html">Travis Trimble </a>
                                                </h2>
                                            </td>
                                            <td>5 Nov 2019 <span class="text-primary d-block">11.00 AM - 11.35 AM</span>
                                            </td>
                                            <td>
                                                <div class="status-toggle">
                                                    <input type="checkbox" id="status_2" class="check" checked>
                                                    <label for="status_2" class="checktoggle">checkbox</label>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                $300.00
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="assets/img/doctors/doctor-thumb-03.jpg"
                                                            alt="User Image"></a>
                                                    <a href="profile.html">Dr. Deborah Angel</a>
                                                </h2>
                                            </td>
                                            <td>Cardiology</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="assets/img/patients/patient3.jpg" alt="User Image"></a>
                                                    <a href="profile.html">Carl Kelly</a>
                                                </h2>
                                            </td>
                                            <td>11 Nov 2019 <span class="text-primary d-block">12.00 PM - 12.15 PM</span>
                                            </td>
                                            <td>
                                                <div class="status-toggle">
                                                    <input type="checkbox" id="status_3" class="check" checked>
                                                    <label for="status_3" class="checktoggle">checkbox</label>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                $150.00
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="assets/img/doctors/doctor-thumb-04.jpg"
                                                            alt="User Image"></a>
                                                    <a href="profile.html">Dr. Sofia Brient</a>
                                                </h2>
                                            </td>
                                            <td>Urology</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="assets/img/patients/patient4.jpg" alt="User Image"></a>
                                                    <a href="profile.html"> Michelle Fairfax</a>
                                                </h2>
                                            </td>
                                            <td>7 Nov 2019<span class="text-primary d-block">1.00 PM - 1.20 PM</span></td>
                                            <td>
                                                <div class="status-toggle">
                                                    <input type="checkbox" id="status_4" class="check" checked>
                                                    <label for="status_4" class="checktoggle">checkbox</label>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                $150.00
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="assets/img/doctors/doctor-thumb-05.jpg"
                                                            alt="User Image"></a>
                                                    <a href="profile.html">Dr. Marvin Campbell</a>
                                                </h2>
                                            </td>
                                            <td>Orthopaedics</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html" class="avatar avatar-sm me-2"><img
                                                            class="avatar-img rounded-circle"
                                                            src="assets/img/patients/patient5.jpg" alt="User Image"></a>
                                                    <a href="profile.html">Gina Moore</a>
                                                </h2>
                                            </td>
                                            <td>15 Nov 2019 <span class="text-primary d-block">1.00 PM - 1.15 PM</span>
                                            </td>
                                            <td>
                                                <div class="status-toggle">
                                                    <input type="checkbox" id="status_5" class="check" checked>
                                                    <label for="status_5" class="checktoggle">checkbox</label>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                $200.00
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@stop
