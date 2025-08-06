<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap');

        body {
            font-family: 'Rubik', sans-serif;
        }

        .table-bordered td,
        .table-bordered th {
            vertical-align: middle;
        }

        td,
        th {
            vertical-align: middle;
        }

        label {
            font-weight: bold;
        }

        #toast-container>.toast-success {
            background-color: #198754;
            font-weight: bold;
        }
        #toast-container>.toast-danger {
            background-color: #dc3545;
            font-weight: bold;
        }
    </style>
    <style> </style>

    @yield('css')

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('company.login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{ route('company.getEmployeeManage') }}">{{ __('Employee') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('company.getManageClinics') }}">{{ __('Clinics') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('company.logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('company.logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
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
