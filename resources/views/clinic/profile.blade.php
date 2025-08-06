@extends('site.template')
@section('content')
    <div class="breadcrumb-bar-two">
        <div class="container">
            <div class="row align-items-center inner-banner">
                <div class="col-md-12 col-12 text-center">
                    <h2 class="breadcrumb-title">Profile</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('getHome') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                    @include('clinic.navbar', ['activePage' => 'clinichome'])
                </div>
                <div class="col-md-7 col-lg-8 col-xl-9">
                    @if (session('status'))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            </div>
                        </div>
                    @endif


                    <div class="container">
                        <h3>Update Profile</h3>
                        <div class="card">
                            <div class="card-body">

                                <form method="POST" action="{{ route('clinic.postUpdateProfile') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Full Name (*)</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ $user->name }}" disabled required>
                                                @if ($errors->has('name'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('name') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image">Image</label>
                                                <input type="file" class="form-control" id="image" name="image"
                                                    value="{{ old('image') }}">
                                                @if ($errors->has('image'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('image') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div> --}}
                                        {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Role (*)</label>
                                        <input type="text" class="form-control" id="role" name="role"
                                            value="{{ $user->role }}" disabled>
                                        @if ($errors->has('role'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small style="font-weight: bold">{{ $errors->first('role') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                </div> --}}

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email (*)</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $user->email }}" disabled>

                                                @if ($errors->has('email'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('email') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Specialities (*)</label>
                                                <textarea class="form-control" id="specialities" name="specialities" required>{{ $user->specialities }}</textarea>
                                                @if ($errors->has('specialities'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('specialities') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea type="text" class="form-control" id="description" rows="8" name="description">{{ $user->description }}</textarea>
                                                @if ($errors->has('description'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('description') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h4>Change Password</h4>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password </label>
                                            <input type="password" class="form-control" id="password" name="password">

                                            @if ($errors->has('password'))
                                                <span class="text-danger" style="font-style: italic;">
                                                    <small
                                                        style="font-weight: bold">{{ $errors->first('password') }}</small>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm New Password</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation">

                                            @if ($errors->has('password_confirmation'))
                                                <span class="text-danger" style="font-style: italic;">
                                                    <small
                                                        style="font-weight: bold">{{ $errors->first('password_confirmation') }}</small>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div>
                                        <input type="submit" class="btn btn-primary" value="Update">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Clinic Profile -->
                    <div class="container">
                        <h3>Clinic Profile</h3>
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route("clinic.postUpdateClinicProfile") }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name <span class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ $user->getClinicFromClinicUser->name }}" placeholder="Name" required>
                                                @if ($errors->has('name'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('name') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="logo">Logo </label>
                                                <input type="file" class="form-control" id="logo"
                                                    name="logo">
                                                @if ($errors->has('logo'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('name') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Registration Number </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $user->getClinicFromClinicUser->registration_number }}"
                                                    disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="contactno">Contact Number <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control" id="contactno"
                                                    name="contactno" value="{{ $user->getClinicFromClinicUser->number }}"
                                                    placeholder="Contact Number" required>
                                                @if ($errors->has('contactno'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('contactno') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="contactperson">Contact Person </label>
                                                <input type="text" class="form-control" id="contactperson"
                                                    name="contactperson"
                                                    value="{{ $user->getClinicFromClinicUser->contact_person }}"
                                                    placeholder="Contact Person">
                                                @if ($errors->has('contactperson'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('contactperson') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="contactpersonnumber">Contact Person Number </label>
                                                <input type="text" class="form-control" id="contactpersonnumber"
                                                    name="contactpersonnumber"
                                                    value="{{ $user->getClinicFromClinicUser->number }}"
                                                    placeholder="Contact Person Number">
                                                @if ($errors->has('contactpersonnumber'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('contactpersonnumber') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="address">Address </label>
                                                <input type="text" class="form-control" id="address" name="address"
                                                    value="{{ $user->getClinicFromClinicUser->address }}"
                                                    placeholder="Address">
                                                @if ($errors->has('address'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('address') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="city">City </label>
                                                <input type="text" class="form-control" id="city" name="city"
                                                    value="{{ $user->getClinicFromClinicUser->city }}"
                                                    placeholder="City">
                                                @if ($errors->has('city'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('city') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="state">State </label>
                                                <input type="text" class="form-control" id="state" name="state"
                                                    value="{{ $user->getClinicFromClinicUser->state }}"
                                                    placeholder="State">
                                                @if ($errors->has('state'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('state') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="postalcode">Postal Code </label>
                                                <input type="text" class="form-control" id="postalcode"
                                                    name="postalcode"
                                                    value="{{ $user->getClinicFromClinicUser->postalcode }}"
                                                    placeholder="Postal Code">
                                                @if ($errors->has('postalcode'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('postalcode') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="longitude">Longitude </label>
                                                <input type="text" class="form-control" id="longitude"
                                                    name="longitude"
                                                    value="{{ $user->getClinicFromClinicUser->longitude }}"
                                                    placeholder="Longitude">
                                                @if ($errors->has('longitude'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('longitude') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="latitude">Latitude </label>
                                                <input type="text" class="form-control" id="latitude"
                                                    name="latitude"
                                                    value="{{ $user->getClinicFromClinicUser->latitude }}"
                                                    placeholder="Latitude">
                                                @if ($errors->has('latitude'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('latitude') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea type="text" class="form-control" id="description" rows="8" name="description">{{ $user->getClinicFromClinicUser->description }}</textarea>
                                                @if ($errors->has('description'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('description') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div>
                                            <input type="submit" class="btn btn-primary" value="Update">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Clinic Profile -->

                </div>
            </div>
        </div>
    </div>

@stop



@section('js')
    <script src="{{ asset('site/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('site/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
    <script src="{{ asset('site/assets/js/circle-progress.min.js') }}"></script>

@stop
