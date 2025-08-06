
<div class="profile-sidebar">
    <div class="widget-profile pro-widget-content">
        @if(Auth()->guard('web')->check())
        <div class="profile-info-widget">
            <a href="#" class="booking-doc-img">

                @if(Auth()->user()->image == Null)
                <img src="{{ asset('site/uploads/avatar.svg') }}" alt="employee icon">
                @else
                <img src="{{ asset('site/uploads/company/employee/'.Auth()->user()->image) }}" alt="{{ Auth()->user()->first_name }}">
                @endif
            </a>
            <div class="profile-det-info">
                <h3>{{ Auth()->user()->first_name }} {{ Auth()->user()->last_name }}, {{Auth()->user()->gender}}</h3>
                <div class="patient-details">
                    <h5><i class="fas fa-birthday-cake"></i> {{ Auth()->user()->date_of_birth->format('d M, Y') }},
                        {{ Carbon\Carbon::parse(Auth()->user()->date_of_birth)->age }} years</h5>
                    <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> {{ Auth()->user()->address }}</h5>
                </div>
            </div>
        </div>
        @elseif(Auth()->guard('clinic')->check())
        <div class="profile-info-widget">
            <a href="#" class="booking-doc-img">
                @if(Auth()->user()->image == Null)
                <img src="{{ asset('site/uploads/avatar.svg') }}" alt="employee icon">
                @else
                <img src="{{ asset('site/uploads/company/employee/'.Auth()->user()->image) }}" alt="{{ Auth()->user()->name }}">
                @endif
            </a>
            <div class="profile-det-info">
                <h3> {{ Auth()->user()->name }}</h3>
                <div class="patient-details">
                    <h5><i class="fas fa-birthday-cake"></i> {{ Auth()->user()->date_of_birth->format('d M, Y') }},
                        {{ Carbon\Carbon::parse(Auth()->user()->date_of_birth)->age }} years</h5>
                    <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> {{ Auth()->user()->address }}</h5>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="dashboard-widget">
        <nav class="dashboard-menu">
            <ul>
                <li class="{{ $activePage == 'employeedashboard' ? 'active' : '' }}">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-columns"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ $activePage == 'employeeapointments' ? 'active' : '' }}">
                    <a href="{{ route('user.getClinicList') }}">
                        <i class="fas fa-bookmark"></i>
                        <span>Appointment</span>
                    </a>
                </li>
                <li class="{{ $activePage == 'employeereservations' ? 'active' : '' }}">
                    <a href="{{ route('user.getAppointmented') }}">
                        <i class="fas fa-users"></i>
                        <span>Your Reservations</span>
                    </a>
                </li>
                <li class="{{ $activePage == 'employeereports' ? 'active' : '' }}">
                    <a href="">
                        <i class="fas fa-clipboard"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li class="{{ $activePage == 'user.getDependent' ? 'active' : '' }}">
                    <a href="{{ route('user.getDependent') }}">
                        <i class="fas fa-clipboard"></i>
                        <span>My Dependents</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
