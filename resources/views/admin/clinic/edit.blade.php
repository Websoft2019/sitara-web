@extends('layouts.admin', ['activePage' => 'adminclinicmanage'])

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit {{ $clinic->name }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item active"><a href="#">Dashboard</a></li> -->
                        <li class="breadcrumb-item active">Dashboard</li>
                        <li class="breadcrumb-item active">{{ $clinic->name }}</li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="bd-example bd-example-padded-bottom">
                                <a href="{{ route('admin.getManageClinic') }}" class="btn btn-dark btn-md">
                                    Back to Manage Clinic
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="modal-body">
                                <form method="POST" action="{{ route('admin.postEditClinic', $clinic->slug) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name (*)</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ $clinic->name }}" required>
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
                                                <label for="logo">Logo</label>
                                                <input type="file" class="form-control" id="logo" name="logo"
                                                    value="{{ $clinic->logo }}">
                                                @if ($clinic->logo)
                                                    <img src="{{ asset('site/uploads/clinic/' . $clinic->logo) }}"
                                                        alt="{{ $clinic->name }}" class="img-fluid" width="100">
                                                @endif
                                                @if ($errors->has('logo'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('logo') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">Address (*)</label>
                                                <input type="numeric" class="form-control" id="address" name="address"
                                                    value="{{ $clinic->address }}" required>

                                                @if ($errors->has('address'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('address') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="longitude">Longitude</label>
                                                <input type="numeric" class="form-control" id="longitude" name="longitude"
                                                    value="{{ $clinic->longitude }}">

                                                @if ($errors->has('longitude'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('longitude') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="latitude">Latitude</label>
                                                <input type="numeric" class="form-control" id="latitude" name="latitude"
                                                    value="{{ $clinic->latitude }}">

                                                @if ($errors->has('latitude'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('latitude') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="registration_number">Registration Number (*)</label>
                                                <input type="text" class="form-control" id="registration_number"
                                                    name="registration_number" value="{{ $clinic->registration_number }}"
                                                    required>

                                                @if ($errors->has('registration_number'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('registration_number') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Email (*)</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $clinic->email }}" required>

                                                @if ($errors->has('email'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('email') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="status">Status (*)</label>
                                                <select id="status" class="form-control" name="status" required>
                                                    <option value="active" <?php if ($clinic->status == 'active') {
                                                        echo 'selected';
                                                    } ?>>Active</option>
                                                    <option value="hidden" <?php if ($clinic->status == 'hidden') {
                                                        echo 'selected';
                                                    } ?>>Hidden</option>
                                                </select>
                                                @if ($errors->has('status'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('status') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="number">Contact Number (*)</label>
                                                <input type="text" class="form-control" id="number" name="number"
                                                    value="{{ $clinic->number }}" required>

                                                @if ($errors->has('number'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('number') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="contact_person">Contact Person (*)</label>
                                                <input type="text" class="form-control" id="contact_person"
                                                    name="contact_person" value="{{ $clinic->contact_person }}" required>

                                                @if ($errors->has('number'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('number') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="contact_person_number">Contact Person Number (*)</label>
                                                <input type="text" class="form-control" id="contact_person_number"
                                                    name="contact_person_number"
                                                    value="{{ $clinic->contact_person_number }}" required>

                                                @if ($errors->has('contact_person_number'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('contact_person_number') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea type="text" class="form-control" id="description" rows="8" name="description" value="">{{ $clinic->description }}</textarea>
                                                @if ($errors->has('description'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('description') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-success w-100 p-2" value="Save Changes">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main content ends here -->
@endsection
