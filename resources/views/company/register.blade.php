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
                        The best offer <br />
                        <span style="color: hsl(218, 81%, 75%)">for your business</span>
                    </h1>
                    <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                        Temporibus, expedita iusto veniam atque, magni tempora mollitia
                        dolorum consequatur nulla, neque debitis eos reprehenderit quasi
                        ab ipsum nisi dolorem modi. Quos?
                    </p>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0 position-relative" style="margin-top: 80px">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                    <div class="card bg-glass">
                        <div class="card-body px-4 py-5 px-md-5">
                            <h4>Company Register</h4>
                            @if (session()->has('status'))
                                <div class="alert alert-success text-center">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('company.postRegisterRequest') }}">
                                @csrf()
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example3">Company Name</label>
                                    <input type="text" id="form3Example3"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required/>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example3">Address</label>
                                    <input type="text" id="form3Example3"
                                        class="form-control @error('address') is-invalid @enderror" name="address"
                                        value="{{ old('address') }}" required />
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-outline mb-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label" for="form3Example3">City</label>
                                            <input type="text" id="form3Example3"
                                                class="form-control @error('city') is-invalid @enderror" name="city"
                                                value="{{ old('city') }}" required />
                                            @error('city')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    
                                        <div class="col-md-4">
                                                    <label class="form-label" for="form3Example3">State</label>
                                            <input type="text" id="form3Example3"
                                                class="form-control @error('state') is-invalid @enderror" name="state"
                                                value="{{ old('state') }}" required />
                                            @error('state')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                                <label class="form-label" for="form3Example3">Postal Code</label>
                                            <input type="text" id="form3Example3"
                                            class="form-control @error('postalcode') is-invalid @enderror" name="postalcode"
                                            value="{{ old('postalcode') }}" required />
                                            @error('postalcode')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                
                                </div>
                                <div class="form-outline mb-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label" for="form3Example3">Company Registration Number</label>
                                            <input type="text" id="form3Example3"
                                                class="form-control @error('registration_number') is-invalid @enderror" name="registration_number"
                                                value="{{ old('registration_number') }}" required />
                                            @error('registration_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="form3Example3">Business Contact Number</label>
                                            <input type="text" id="form3Example3"
                                                class="form-control @error('phone') is-invalid @enderror" name="phone"
                                                value="{{ old('phone') }}" required />
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    
                                        <div class="col-md-4">
                                                    <label class="form-label" for="form3Example3">Contact Person</label>
                                            <input type="text" id="form3Example3"
                                                class="form-control @error('contactperson') is-invalid @enderror" name="contactperson"
                                                value="{{ old('contactperson') }}" required />
                                            @error('contactperson')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        
                                    </div>
                                
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example3">Email</label>
                                    <input type="email" id="form3Example3"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required/>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                               

                               

                                <!-- Submit button -->
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Signup') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </form>
                            <hr>
                            <a href="{{route('company.login')}}">Already have an account ? login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
