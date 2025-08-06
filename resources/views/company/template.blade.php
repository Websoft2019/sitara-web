<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Sitara :: Admin Panel</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('company/assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('company/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('company/assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('company/assets/css/feathericon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('company/assets/plugins/morris/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('company/assets/css/custom.css') }}">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">

    <style>
        label {
            font-weight: bold;
        }
    </style>

    @yield('css')
</head>

<body>
    <div class="main-wrapper">
        <div class="header">
            <div class="header-left">
                <a href="{{ route('company.home') }}" class="logo">
                   
                    <img src="{{ asset('site/assets/img/weblogo.png') }}" alt="Logo">
                </a>
                <a href="{{ route('company.home') }}" class="logo logo-small">
                    <img src="{{ asset('site/assets/img/logo.png') }}" alt="Logo" width="30" height="30">
                </a>
            </div>
            <a href="javascript:void(0);" id="toggle_btn">
                <i class="fe fe-text-align-left"></i>
            </a>
            <div class="top-nav-search">
                <form>
                    <input type="text" class="form-control" placeholder="Search here">
                    <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <a class="mobile_btn" id="mobile_btn">
                <i class="fa fa-bars"></i>
            </a>
            <ul class="nav user-menu">
                {{-- <li class="nav-item dropdown noti-dropdown">
                    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <i class="fe fe-bell"></i> <span class="badge rounded-pill">3</span>
                    </a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Notifications</span>
                            <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="#">
                                        <div class="media d-flex">
                                            <span class="avatar avatar-sm flex-shrink-0">
                                                <img class="avatar-img rounded-circle" alt="User Image"
                                                    src="{{ asset('company/assets/img/doctors/doctor-thumb-01.jpg') }}">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Dr. Ruby Perrin</span>
                                                    Schedule <span class="noti-title">her appointment</span></p>
                                                <p class="noti-time"><span class="notification-time">4 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="#">
                                        <div class="media d-flex">
                                            <span class="avatar avatar-sm flex-shrink-0">
                                                <img class="avatar-img rounded-circle" alt="User Image"
                                                    src="{{ asset('company/assets/img/patients/patient1.jpg') }}">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Charlene Reed</span>
                                                    has booked her appointment to <span class="noti-title">Dr. Ruby
                                                        Perrin</span></p>
                                                <p class="noti-time"><span class="notification-time">6 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="#">
                                        <div class="media d-flex">
                                            <span class="avatar avatar-sm flex-shrink-0">
                                                <img class="avatar-img rounded-circle" alt="User Image"
                                                    src="{{ asset('company/assets/img/patients/patient2.jpg') }}">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Travis Trimble</span>
                                                    sent a amount of $210 for his <span
                                                        class="noti-title">appointment</span></p>
                                                <p class="noti-time"><span class="notification-time">8 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="#">
                                        <div class="media d-flex">
                                            <span class="avatar avatar-sm flex-shrink-0">
                                                <img class="avatar-img rounded-circle" alt="User Image"
                                                    src="{{ asset('company/assets/img/patients/patient3.jpg') }}">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Carl Kelly</span>
                                                    send a message <span class="noti-title"> to his doctor</span></p>
                                                <p class="noti-time"><span class="notification-time">12 mins
                                                        ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="#">View all Notifications</a>
                        </div>
                    </div>
                </li> --}}
                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <span class="user-img">
                            @if (Auth::user()->logo)
                                <img class="rounded-circle"
                                    src="{{ asset('site/uploads/company/' . Auth::user()->logo) }}" width="31"
                                    alt="">
                            @else
                                <img class="rounded-circle"
                                    src="{{ asset('site/assets/img/logo.png') }}" width="31"
                                    alt="">
                            @endif
                            {{ Auth::user()->name }} (Company Panel)
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="user-header">
                            <div class="avatar avatar-sm">
                                @if (Auth::user()->logo)
                                    <img src="{{ asset('site/uploads/company/' . Auth::user()->logo) }}"
                                        alt="User Image" class="avatar-img rounded-circle" width="31">
                                @else
                                    <img class="rounded-circle"
                                        src="{{ asset('site/assets/img/logo.png') }}"
                                        alt="User Image" class="avatar-img rounded-circle">
                                @endif
                                
                            </div>
                            <div class="user-text">
                                <h6>{{ Auth::user()->name }} - {{Auth::user()->id}}</h6>
                                <p class="text-muted mb-0">Company Panel</p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="{{ route('company.home') }}">Dashboard</a>
                        <a class="dropdown-item" href="{{route('company.getProfile')}}">Profile</a>
                        <a class="dropdown-item" href="{{ route('company.logout') }}"
                            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('company.logout') }}" method="POST"
                            class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title">
                            <span>Main</span>
                        </li>
                        <li class="{{ $activePage == 'companyhome' ? 'active' : '' }}">
                            <a href="{{ route('company.home') }}"><i class="fe fe-home"></i>
                                <span>Dashboard</span></a>
                        </li>
                        <li class="{{ $activePage == 'companyclinics' ? 'active' : '' }}">
                            <a href="{{ route('company.getManageClinics') }}"><i class="fe fe-layout"></i>
                                <span>Affiliated Clinics</span></a>
                        </li>
                        <li class="{{ $activePage == 'companyemployee' ? 'active' : '' }}">
                            <a href="{{ route('company.getEmployeeManage') }}"><i class="fe fe-users"></i>
                                <span>Employees</span></a>
                        </li>
                        <li class="{{ $activePage == 'companyaccount' ? 'active' : '' }}">
                            <a href="{{ route('company.getManageAccount') }}"><i class="fe fe-users"></i>
                                <span>Bill</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @yield('content')
    </div>
    <script src="{{ asset('company/assets/js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('company/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('company/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('company/assets/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('company/assets/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('company/assets/js/chart.morris.js') }}"></script>
    <script src="{{ asset('company/assets/js/script.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('admin/plugins/toastr/toastr.min.js') }}"></script>

    <script>
        $(function() {
            @if (session()->has('success'))
                toastr.success('{{ session('success') }}')
            @endif
            @if (session()->has('error'))
                toastr.error('{{ session('error') }}')
            @endif
        });
    </script>

    @yield('js')
</body>

</html>
