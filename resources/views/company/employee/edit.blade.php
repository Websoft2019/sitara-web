@extends('company.template', ['activePage' => 'companyemployee'])

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-7 col-auto">
                        <h3 class="page-title">{{ $employee->first_name }} {{ $employee->middle_name }}
                            {{ $employee->last_name }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('company.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Chnage Employee Details</li>
                        </ul>
                    </div>
                    <div class="col-sm-5 col">
                        <a href="{{ route('company.getEmployeeManage') }}" class="btn btn-dark float-end mt-2">Back to
                            Employee Manage</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="modal-body">
                                <form method="POST"
                                    action="{{ route('company.postEditEmployee', $employee->employee_id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="first_name">First Name (*)</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name"
                                                    value="{{ $employee->first_name }}" required>
                                                @if ($errors->has('first_name'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('first_name') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="middle_name">Middle Name</label>
                                                <input type="text" class="form-control" id="middle_name"
                                                    name="middle_name" value="{{ $employee->middle_name }}">
                                                @if ($errors->has('middle_name'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('middle_name') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="last_name">Last Name (*)</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name"
                                                    value="{{ $employee->last_name }}" required>
                                                @if ($errors->has('last_name'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('last_name') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="employee_id">Employee ID (*)</label>
                                                <input type="text" class="form-control" id="employee_id"
                                                    name="employee_id" value="{{ $employee->employee_id }}" required>
                                                @if ($errors->has('employee_id'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('employee_id') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="image">Image</label>
                                                <input type="file" class="form-control" id="image" name="image"
                                                    value="{{ old('image') }}">

                                                @if ($employee->image)
                                                    <img class="rounded-circle" alt="User Image"
                                                        src="{{ asset('site/uploads/company/employee/' . $employee->image) }}"
                                                        width="100">
                                                @endif
                                                @if ($errors->has('image'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('image') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $employee->email }}">

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
                                                <label for="phone_number">Phone Number (*)</label>
                                                <input type="text" class="form-control" id="phone_number"
                                                    name="phone_number" value="{{ $employee->phone_number }}" required>

                                                @if ($errors->has('phone_number'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('phone_number') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="post">Post (*)</label>
                                                <input type="text" class="form-control" id="post" name="post"
                                                    value="{{ $employee->post }}" required>

                                                @if ($errors->has('post'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('post') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="date_of_birth">Date of Birth (*)</label>
                                                <input type="date" class="form-control" id="date_of_birth"
                                                    name="date_of_birth"
                                                    value="{{ $employee->date_of_birth->format('Y-m-d') }}" required>

                                                @if ($errors->has('date_of_birth'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('date_of_birth') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gender">Gender (*)</label>
                                                <select id="gender" class="form-control" name="gender" required>
                                                    <option value="male" <?php if ($employee->gender == 'male') {
                                                        echo 'selected';
                                                    } ?>>Male</option>
                                                    <option value="female" <?php if ($employee->gender == 'female') {
                                                        echo 'selected';
                                                    } ?>>Female</option>
                                                    <option value="others" <?php if ($employee->gender == 'others') {
                                                        echo 'selected';
                                                    } ?>>Others</option>
                                                </select>
                                                @if ($errors->has('gender'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('gender') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="race">Race(*)</label>
                                                <input type="text" class="form-control" id="race" name="race"
                                                    value="{{ $employee->race }}" required>

                                                @if ($errors->has('race'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('race') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="ic_number">IC Number(*)</label>
                                                <input type="text" class="form-control" id="ic_number"
                                                    name="ic_number" value="{{ $employee->ic_number }}" required>

                                                @if ($errors->has('ic_number'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('ic_number') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">Address (*)</label>
                                                <input type="text" class="form-control" id="address" name="address"
                                                    value="{{ $employee->address }}" required>

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
                                                <label for="per_visit_claim">Per Visit Claim (*)</label>
                                                <input type="number" class="form-control" id="per_visit_claim"
                                                    name="per_visit_claim" value="{{ $employee->per_visit_claim }}"
                                                    required>

                                                @if ($errors->has('per_visit_claim'))
                                                    <span class="text-danger" style="font-style: italic;">
                                                        <small
                                                            style="font-weight: bold">{{ $errors->first('per_visit_claim') }}</small>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="status">Status (*)</label>
                                                <select id="status" class="form-control" name="status" required>
                                                    <option value="active" <?php if ($employee->status == 'active') {
                                                        echo 'selected';
                                                    } ?>>Active</option>
                                                    <option value="hidden" <?php if ($employee->status == 'hidden') {
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
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea type="text" class="form-control" id="description" rows="8" name="description" value="">{{ $employee->description }}</textarea>
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
                                        <input type="submit" class="btn btn-success w-100" value="Save Changes">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
