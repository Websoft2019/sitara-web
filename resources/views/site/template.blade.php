<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Sitara</title>
    <link type="image/x-icon" href="{{ asset('site/assets/img/favicon/favicon.ico') }}" rel="icon">
    <link rel="stylesheet" href="{{ asset('site/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/custom.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">

    <style>
        #toast-container>.toast-success {
            background-color: #198754;
            /* font-weight: bold; */
        }

        #toast-container>.toast-danger {
            background-color: #dc3545;
            /* font-weight: bold; */
        }
    </style>
    @yield('css')


</head>

<body>
    @yield('model')
    <div class="main-wrapper">
        <header class="header header-fixed header-one">
            <div class="container">
                <nav class="navbar navbar-expand-lg header-nav">
                    <div class="navbar-header">
                        <a id="mobile_btn" href="javascript:void(0);">
                            <span class="bar-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </a>
                        <a href="{{ route('getHome') }}" class="navbar-brand logo">
                            <img src="{{ asset('site/assets/img/weblogo.png') }}" class="img-fluid" alt="Logo">
                        </a>
                    </div>
                    <div class="main-menu-wrapper">
                        <div class="menu-header">
                            <a href="index.html" class="menu-logo">
                                <img src="{{ asset('site/assets/img/weblogo.png') }}" class="img-fluid" alt="Logo">
                            </a>
                            <a id="menu_close" class="menu-close" href="javascript:void(0);">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                        <ul class="main-nav">
                            <li><a href="{{ route('getHome') }}">Home</a></li>
                            <li><a href="{{ route('getAbout') }}"> About Us </a></li>
                            <li><a href="{{ route('getWhySitara') }}"> Why SITARA </a></li>
                            {{-- <li><a href="#"> Our Partners </a></li> --}}
                            <li><a href="{{ route('getContact') }}"> Feedback </a></li>



                            <li class="searchbar">
                                <a href="javascript:void(0);"><i class="feather-search"></i></a>
                                <div class="togglesearch" style="display: none;">
                                    <form action="">
                                        <div class="input-group">
                                            <input type="text" class="form-control">
                                            <button type="submit" class="btn">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            @if (!Auth()->check())
                                <li class="login-link"><a href="">Login / Signup</a></li>
                                <li class="register-btn">
                                    <a href="{{ route('company.login') }}" class="btn reg-btn"><i
                                            class="feather-user"></i>Company Login</a>
                                </li>
                                <li class="register-btn">
                                    <a href="{{ route('clinic.login') }}" class="btn reg-btn"><i
                                            class="feather-user"></i>Clinic Login</a>
                                </li>
                                <li class="register-btn">
                                    <a href="{{ route('login') }}" class="btn btn-primary log-btn"><i
                                            class="feather-lock"></i>Employee Login</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    @if (Auth()->check())
                        <ul class="nav header-navbar-rht">
                            <li class="nav-item dropdown noti-nav me-3 pe-0">
                                <a href="#" class="dropdown-toggle nav-link p-0" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-bell"></i> <span class="badge">5</span>
                                </a>
                                <div class="dropdown-menu notifications dropdown-menu-end ">
                                    <div class="topnav-dropdown-header">
                                        <span class="notification-title">Notifications</span>
                                    </div>
                                    <div class="noti-content">
                                        <ul class="notification-list">
                                            <li class="notification-message">
                                                <a href="#">
                                                    <div class="media d-flex">
                                                        <span class="avatar">
                                                            <img class="avatar-img" alt=""
                                                                src="{{ asset('site/assets/img/clients/client-01.jpg') }}">
                                                        </span>
                                                        <div class="media-body">
                                                            <h6>Travis Tremble <span class="notification-time">18.30
                                                                    PM</span></h6>
                                                            <p class="noti-details">Sent a amount of $210 for his
                                                                Appointment <span class="noti-title">Dr.Ruby perin
                                                                </span></p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="notification-message">
                                                <a href="#">
                                                    <div class="media d-flex">
                                                        <span class="avatar">
                                                            <img class="avatar-img" alt=""
                                                                src="{{ asset('site/assets/img/clients/client-02.jpg') }}">
                                                        </span>
                                                        <div class="media-body">
                                                            <h6>Travis Tremble <span class="notification-time">12 Min
                                                                    Ago</span></h6>
                                                            <p class="noti-details"> has booked her appointment to
                                                                <span class="noti-title">Dr. Hendry Watt</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="notification-message">
                                                <a href="#">
                                                    <div class="media d-flex">
                                                        <div class="avatar">
                                                            <img class="avatar-img" alt=""
                                                                src="{{ asset('site/assets/img/clients/client-03.jpg') }}">
                                                        </div>
                                                        <div class="media-body">
                                                            <h6>Travis Tremble <span class="notification-time">6 Min
                                                                    Ago</span></h6>
                                                            <p class="noti-details"> Sent a amount $210 for his
                                                                Appointment <span class="noti-title">Dr.Maria
                                                                    Dyen</span></p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="notification-message">
                                                <a href="#">
                                                    <div class="media d-flex">
                                                        <div class="avatar avatar-sm">
                                                            <img class="avatar-img" alt=""
                                                                src="{{ asset('site/assets/img/clients/client-04.jpg') }}">
                                                        </div>
                                                        <div class="media-body">
                                                            <h6>Travis Tremble <span class="notification-time">8.30
                                                                    AM</span></h6>
                                                            <p class="noti-details"> Send a message to his doctor</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown has-arrow logged-item">
                                <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                                    @if (Auth()->guard('web')->check())
                                        <span class="user-img">
                                            @if (Auth()->user()->image == null)
                                                <img class="rounded-circle"
                                                    src="{{ asset('site/uploads/avatar.svg') }}" width="31">
                                            @else
                                                <img class="rounded-circle"
                                                    src="{{ asset('site/uploads/company/employee/' . Auth()->user()->image) }}"
                                                    width="31" alt="{{ Auth()->user()->first_name }}">
                                            @endif
                                        </span>
                                        <span style="margin-left: 5px;">{{ Auth()->user()->first_name }}
                                            (Employee)</span>
                                    @elseif(Auth()->guard('company')->check())
                                        <span class="user-img">
                                            @if (Auth()->user()->image == null)
                                                <img class="rounded-circle"
                                                    src="{{ asset('site/uploads/avatar.svg') }}" width="31">
                                            @else
                                                <img class="rounded-circle"
                                                    src="{{ asset('site/uploads/company/employee/' . Auth()->user()->image) }}"
                                                    width="31" alt="{{ Auth()->user()->first_name }}">
                                            @endif
                                        </span>
                                        <span style="margin-left: 5px;">{{ Auth()->user()->first_name }}
                                            (Company Panel - {{Auth()->user()->id}})</span>
                                    @elseif(Auth()->guard('admin')->check())
                                        <span class="user-img">
                                            @if (Auth()->user()->image == null)
                                                <img class="rounded-circle"
                                                    src="{{ asset('site/uploads/avatar.svg') }}" width="31">
                                            @else
                                                <img class="rounded-circle"
                                                    src="{{ asset('site/assets/img/logo.png') }}" width="31"
                                                    alt="{{ Auth()->user()->first_name }}">
                                            @endif
                                        </span>
                                        <span style="margin-left: 5px;">{{ Auth()->user()->first_name }}
                                            (Admin)</span>
                                    @elseif (Auth()->guard('clinic')->check())
                                        <span class="user-img">
                                            @if (Auth()->user()->getClinicFromClinicUser->logo == null)
                                                <img class="rounded-circle"
                                                    src="{{ asset('site/uploads/avatar.svg') }}" width="31">
                                            @else
                                                <img class="rounded-circle"
                                                    src="{{ asset('site/uploads/clinic/' . Auth()->user()->getClinicFromClinicUser->logo) }}"
                                                    width="31" alt="{{ Auth()->user()->first_name }}">
                                            @endif
                                        </span>
                                        <span style="margin-left: 5px;">{{ Auth()->user()->name }} (Clinic
                                            Panel)</span>
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">

                                    @if (Auth()->guard('clinic')->check())
                                        <a class="dropdown-item" href="{{ route('clinic.home') }}">Dashboard</a>
                                        <a class="dropdown-item" href="{{route('clinic.getProfile')}}">Profile</a>
                                        <a class="dropdown-item" href="{{ route('clinic.logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('clinic.logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    @elseif(Auth()->guard('company')->check())
                                        <a class="dropdown-item" href="{{ route('company.home') }}">Dashboard</a>
                                        {{-- <a class="dropdown-item" href="">Profile Settings</a> --}}
                                        <a class="dropdown-item" href="">Logout</a>
                                    @elseif(Auth()->guard('admin')->check())
                                        <a class="dropdown-item" href="{{ route('admin.home') }}">Dashboard</a>
                                        {{-- <a class="dropdown-item" href="">Profile Settings</a> --}}
                                        <a class="dropdown-item" href="">Logout</a>
                                    @elseif(Auth()->guard('web')->check())
                                        <a class="dropdown-item" href="{{ route('home') }}">Dashboard</a>
                                        {{-- <a class="dropdown-item" href="">Profile Settings</a> --}}

                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                        document.getElementById('emplogout-form').submit();">Logout</a>
                                        <form id="emplogout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    @endif

                                </div>
                            </li>
                        </ul>
                    @endif
                </nav>
            </div>
        </header>
        @yield('content')


        <footer class="footer">
            <div class="footer-top aos" data-aos="fade-up">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="footer-widget footer-about">
                                <div class="footer-logo">
                                    <img src="{{ asset('site/assets/img/weblogo.png') }}" alt="logo"
                                        width="180">
                                </div>
                                <div class="footer-about-content">
                                    <p>Seamless Healthcare Management via Sitara
                                        Your Health, Our Priority, Your Companion App</p>
                                    <div class="social-icon">
                                        <ul>
                                            <li> <a href="#" target="_blank"><i class="fab fa-facebook-f"></i>
                                                </a></li>
                                            <li> <a href="#" target="_blank"><i class="fab fa-twitter"></i>
                                                </a></li>
                                            <li> <a href="#" target="_blank"><i
                                                        class="fab fa-linkedin-in"></i></a></li>
                                            <li> <a href="#" target="_blank"><i
                                                        class="fab fa-instagram"></i></a></li>
                                            <li> <a href="#" target="_blank"><i class="fab fa-dribbble"></i>
                                                </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="footer-widget footer-menu">
                                <h2 class="footer-title">Quick Links</h2>
                                <ul>
                                    <li><a href="{{ route('getHome') }}">Home</a></li>
                                    <li><a href="{{ route('getAbout') }}">About Us</a></li>
                                    <li><a href="{{ route('getWhySitara') }}">Why SITARA</a></li>
                                    <li><a href="">Our Partners</a></li>
                                    <li><a href="{{ route('getContact') }}">Feedback</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="footer-widget footer-menu">
                                <h2 class="footer-title"></h2>
                                <ul>
                                    <li><a href="{{ route('company.login') }}">Company Registration</a></li>
                                    <li><a href="{{ route('clinic.login') }}">Clinic Registration</a></li>
                                    <li><a href="{{ route('login') }}">Employee Login</a></li>

                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="footer-widget footer-contact">
                                <h2 class="footer-title">Contact Us</h2>
                                <div class="footer-contact-info">
                                    <div class="footer-address">
                                        <span><i class="fas fa-map-marker-alt"></i></span>
                                        <p>A207, Level 2, West Wing, Wisma<br />
                                            Consplant 2, Jalan SS 16/1, 47600 <br />
                                            Subang Jaya,Selangor,Malaysia.

                                        </p>
                                    </div>
                                    {{-- <p> <i class="fas fa-phone-alt"></i>
                                        016-5591819
                                    </p> --}}
                                    <p class="mb-0"> <i class="fas fa-envelope"></i>
                                        <a href="" class="__cf_email__"
                                            style="color: #fff">admin@sitara.my</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container-fluid">
                    <div class="copyright">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="copyright-text">
                                    <p class="mb-0">&copy; <?php echo date('Y'); ?> Sitara. All rights reserved.</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="copyright-menu">
                                    <ul class="policy-menu">
                                        <li><a href="{{ route('getTerms') }}">Terms and Conditions</a></li>
                                        <li><a href="{{ route('getPolicy') }}">Policy</a></li>
                                        <li><a href="{{ route('getRefundPolicy') }}">Refund Policy &amp;
                                                Cancellation</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <div class="mouse-cursor cursor-outer"></div>
        <div class="mouse-cursor cursor-inner"></div>
    </div>
    <div class="progress-wrap active-progress">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919px, 307.919px; stroke-dashoffset: 228.265px;">
            </path>
        </svg>
    </div>
    <script src="{{ asset('site/assets/js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('site/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('site/assets/js/slick.js') }}"></script>
    <script src="{{ asset('site/assets/js/backToTop.js') }}"></script>
    <script src="{{ asset('site/assets/js/aos.js') }}"></script>
    <script src="{{ asset('site/assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('site/assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('site/assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('site/assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('site/assets/js/counter.js') }}"></script>
    <script src="{{ asset('site/assets/js/backToTop.js') }}"></script>
    <script src="{{ asset('site/assets/js/script.js') }}"></script>
    <!-- jQuery -->
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
