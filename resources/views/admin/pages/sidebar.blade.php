<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('site/assets/img/slogo.png') }}" alt="Sitara"
            class="brand-image">
        <span class="brand-text font-weight-light"><img src="{{asset('site/assets/img/sslogo.png')}}" alt="" width="100"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- SidebarSearch Form -->
        <div class="form-inline mt-3 pb-3 mb-3 ">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.home') }}"
                        class="nav-link {{ $activePage == 'adminhome' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.getManageCompany') }}"
                        class="nav-link {{ $activePage == 'admincompanymanage' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Company
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.getManageClinic') }}"
                        class="nav-link {{ $activePage == 'adminclinicmanage' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clinic-medical"></i>
                        <p>
                            Clinic
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.getManageCompanyAccount') }}"
                        class="nav-link {{ $activePage == 'admincomapnyaccount' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clinic-medical"></i>
                        <p>
                            Company Account
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.getManageClinicAccount') }}"
                        class="nav-link {{ $activePage == 'adminclinicaccount' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clinic-medical"></i>
                        <p>
                            Clinic Account
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link {{ $activePage == 'registrationrequest' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Registration Request
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.getRegistrationRequestList')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Request</p>
                            </a>
                        </li>
                       
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>
<!-- /.control-sidebar -->
