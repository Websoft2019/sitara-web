@extends('site.template')
@section('css')
    <style>
        .background-radial-gradient {
            background-color: hsl(218, 41%, 15%);
            background-image: radial-gradient(650px circle at 0% 0%,
                    hsl(218, 41%, 35%) 15%,
                    hsl(218, 41%, 30%) 35%,
                    hsl(218, 41%, 20%) 75%,
                    hsl(218, 41%, 19%) 80%,
                    transparent 100%),
                radial-gradient(1250px circle at 100% 100%,
                    hsl(218, 41%, 45%) 15%,
                    hsl(218, 41%, 30%) 35%,
                    hsl(218, 41%, 20%) 75%,
                    hsl(218, 41%, 19%) 80%,
                    transparent 100%);
        }

        #radius-shape-1 {
            height: 220px;
            width: 220px;
            top: -60px;
            left: -130px;
            background: radial-gradient(#44006b, #ad1fff);
            overflow: hidden;
        }

        #radius-shape-2 {
            border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
            bottom: -60px;
            right: -110px;
            width: 300px;
            height: 300px;
            background: radial-gradient(#44006b, #ad1fff);
            overflow: hidden;
        }

        .bg-glass {
            background-color: hsla(0, 0%, 100%, 0.9) !important;
            backdrop-filter: saturate(200%) blur(25px);
        }
    </style>
@stop
@section('content')
    <section class="background-radial-gradient overflow-hidden">

        <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
            <div class="row gx-lg-5 align-items-center mb-5">
                <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                    <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                        Welcome to <br />
                        <span style="color: hsl(218, 81%, 75%)">SITARA</span>
                    </h1>
                    <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
                       <h5 style="color:#fff">Company Panel</h5>
                       Provide your email address to verfiy your account.
                    </p>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0 position-relative" style="margin-top: 80px">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                    <div class="card bg-glass">
                        <div class="card-body px-4 py-5 px-md-5">
                            <h4>Company Password Reset</h4>
                            @if (session()->has('fail'))
                                <div class="alert alert-danger text-center">
                                    {{ session('fail') }}
                                </div>
                            @endif
                            @if (session()->has('status'))
                                <div class="alert alert-success text-center">
                                    {{ session('status') }}
                                </div>
                            @endif
                            
                            
                                <div class="card-body">
                                    <form method="POST" action="{{ route('company.password.update') }}">
                                        @csrf
                                        
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example3">Email Address</label>
                                            <input type="email" id="form3Example3"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus />
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example3">New Password</label>
                                            <input type="password" id="form3Example3"
                                                class="form-control @error('password') is-invalid @enderror" name="password" required/>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example3">Confirm New Password</label>
                                            <input type="password" id="password-confirm"
                                                class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation"
                                                 required >
                                           
                                        </div>
                                       
                            
                                        
                            
                                        
                            
                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Reset Password') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                           
                            <hr>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

