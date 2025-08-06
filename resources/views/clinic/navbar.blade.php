@php
    $clinicinfo = App\Models\Clinic::find(
        Auth()
            ->guard('clinic')
            ->user()->clinic_id,
    );
@endphp
<div class="profile-sidebar">
    <div class="widget-profile pro-widget-content">
        <div class="profile-info-widget">
            <a href="#" class="booking-doc-img">
                @if ($clinicinfo->logo != null)
                    <img src="{{ asset('site/uploads/clinic/' . $clinicinfo->logo) }}" alt="{{ $clinicinfo->name }}">
                @else
                    <img src="{{ asset('site/assets/img/clinic.avif') }}" alt="{{ $clinicinfo->name }}">
                @endif
            </a>
            <div class="profile-det-info">
                <h3>{{ $clinicinfo->name }}</h3>
                <div class="patient-details">
                    <h5 class="mb-0">{{ $clinicinfo->address }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-widget">
        <nav class="dashboard-menu">
            <ul>
                <li class="{{ $activePage == 'clinichome' ? 'active' : '' }}">
                    <a href="{{ route('clinic.home') }}">
                        <i class="fas fa-columns"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ $activePage == 'clinicappointments' ? 'active' : '' }}">
                    <a href="{{ route('clinic.getAppointments') }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Appointments</span>
                    </a>
                </li>
                <li class="{{ $activePage == 'clinicpatients' ? 'active' : '' }}">
                    <a href="{{ route('clinic.getPatients') }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Patients</span>
                    </a>
                </li>
                <li class="{{ $activePage == 'cliniccompanies' ? 'active' : '' }}">
                    <a href="{{ route('clinic.getManageCompany') }}">
                        <i class="fas fa-user-injured"></i>
                        <span>Affiliated Companies</span>
                    </a>
                </li>
                <li class="{{ $activePage == 'clinicschedule' ? 'active' : '' }}">
                    <a href="{{ route('clinic.getManageSchedule') }}">
                        <i class="fas fa-hourglass-start"></i>
                        <span>Schedule Timings</span>
                    </a>
                </li>
                <li class="{{ $activePage == 'clinicdoctors' ? 'active' : '' }}">
                    <a href="{{ route('clinic.getManageDoctors') }}">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Our Doctors</span>
                    </a>
                </li>
                <li class="{{ $activePage == 'clinicaccounts' ? 'active' : '' }}">
                    <a href="{{ route('clinic.getManageAccounts') }}">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Account</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
