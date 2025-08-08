@extends('site.template')
@section('content')
    <div class="breadcrumb-bar-two">
        <div class="container">
            <div class="row align-items-center inner-banner">
                <div class="col-md-12 col-12 text-center">
                    <h2 class="breadcrumb-title">Doctor</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('getHome') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Doctor</li>
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
                    @include('clinic.navbar', ['activePage' => 'clinicdoctors'])
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

                    <div class="row">
                        <div class="col-md-12">
                            <h3>Doctor Lists</h3>
                            <hr>
                            <div class="appointment-tab">
                                <div class="row">
                                    <div class="col-md-12" style="text-align:right">
                                        <a href="#" class="btn btn-sm bg-danger-light" data-bs-toggle="modal"
                                            data-bs-target="#add_appointment_modal">Add Doctor</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-table mb-0">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Doctor Name</th>
                                                    <th>Specialties</th>
                                                    <th>No. of Appointments</th>
                                                    <th>Status</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($doctors->count())
                                                    @foreach ($doctors as $item)
                                                        @php $totalappoitnment = App\Models\Appointment::where('clinic_user_id', $item->id)->count(); @endphp
                                                        <tr>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="" class="avatar avatar-sm me-2">
                                                                        @if ($item->image == null)
                                                                            <img class="avatar-img rounded-circle"
                                                                                src="{{ asset('site/uploads/avatar.svg') }}"
                                                                                alt="User Image">
                                                                        @else
                                                                            <img class="avatar-img rounded-circle"
                                                                                src="{{ asset('site/uploads/clinic/user/' . $item->image) }}"
                                                                                alt="User Image">
                                                                        @endif
                                                                    </a>
                                                                    <a href="">{{ $item->name }}</a>
                                                                </h2>
                                                            </td>
                                                            <td>{{ $item->specialities }}</td>
                                                            <td>
                                                                <a href="">{{$totalappoitnment}}</a>
                                                            </td>
                                                            <td>{{ $item->status }}</td>

                                                            <td class="text-end">
                                                                <div class="appointment-action">
                                                                    {{-- <a href="javascript:void(0);"
                                                                        class="btn btn-sm bg-info-light">
                                                                        <i class="far fa-eye"></i> View
                                                                    </a> --}}
                                                                    <a data-bs-toggle="modal"
                                                                        data-bs-target="#editDoctorDetails-{{ $item->id }}"
                                                                        class="btn btn-sm bg-success-light">
                                                                        <i class="far fa-edit"></i> Edit
                                                                    </a>
                                                                    <a href="{{ route('clinic.getDeleteClinicDoctor', $item->id) }}"
                                                                        class="btn btn-sm bg-danger-light">
                                                                        <i class="fas fa-times"></i> Remove
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4" style="color: red">No any doctor added yet!!!
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('model')
    <div class="modal fade custom-modal" id="add_appointment_modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add Doctor</h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('clinic.postAddDoctor') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="name">Full Name (*)</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') }}" required>
                                    @if ($errors->has('name'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('name') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Specialities (*)</label>
                                    <input type="text" class="form-control" id="specialities" name="specialities"
                                        value="{{ old('specialities') }}" required>
                                    @if ($errors->has('specialities'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('specialities') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control" id="image" name="image"
                                        value="{{ old('image') }}">
                                    @if ($errors->has('image'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('image') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status (*)</label>
                                    <select id="status" class="form-control" name="status" required>
                                        <option value="active" selected>Active</option>
                                        <option value="hidden">Hidden</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('status') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email (*)</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('email') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Password (*)</label>
                                    <input type="text" class="form-control" id="password" name="password"
                                        value="{{ old('password') }}" required>

                                    @if ($errors->has('password'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('password') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea type="text" class="form-control" id="description" rows="8" name="description" value="">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('description') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-success" value="Add">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @foreach ($doctors as $doctor)
        <div class="modal fade custom-modal" id="editDoctorDetails-{{ $doctor->id }}" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">{{ $doctor->name }}</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('clinic.postEditDoctor', $doctor->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="name">Full Name (*)</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $doctor->name }}" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small style="font-weight: bold">{{ $errors->first('name') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="specialities">Specialities (*)</label>
                                        <input type="text" class="form-control" id="specialities" name="specialities"
                                            value="{{ $doctor->specialities }}" required>
                                        @if ($errors->has('specialities'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small
                                                    style="font-weight: bold">{{ $errors->first('specialities') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" id="image" name="image"
                                            value="{{ $doctor->image }}">
                                        @if ($doctor->image)
                                            <img class="avatar-img rounded-circle"
                                                src="{{ asset('site/uploads/clinic/user/' . $doctor->image) }}"
                                                alt="User Image" style="height: 100px;">
                                        @endif
                                        @if ($errors->has('image'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small style="font-weight: bold">{{ $errors->first('image') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status (*)</label>
                                        <select id="status" class="form-control" name="status" required>
                                            <option value="active" <?php if ($doctor->status == 'active') {
                                                echo 'selected';
                                            } ?>>Active</option>
                                            <option value="hidden" <?php if ($doctor->status == 'hidden') {
                                                echo 'selected';
                                            } ?>>Hidden</option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small style="font-weight: bold">{{ $errors->first('status') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email (*)</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $doctor->email }}" required>

                                        @if ($errors->has('email'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small style="font-weight: bold">{{ $errors->first('email') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password (*)</label>
                                        <input type="text" class="form-control" id="password" name="password"
                                            value="">

                                        <small><b>Nothing write to not changing the password.</b></small>
                                        @if ($errors->has('password'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small style="font-weight: bold">{{ $errors->first('password') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea type="text" class="form-control" id="description" rows="8" name="description" value="">{{ $doctor->description }}</textarea>
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
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal"
                                    aria-label="Close">Close</button>
                                <input type="submit" class="btn btn-success" value="Save Changes">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@stop

@section('js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let submitBtn = document.getElementById('submitBtn');

            $('#submitBtn').click(function() {
                let referCode = $('#referCode').val();
                $.ajax({
                    type: 'GET',
                    url: "{{ route('clinic.getCompanyFromReferCode') }}",
                    data: {
                        refer_code: referCode,
                    },
                    success: function(data) {
                        if (data.success === true) {
                            $('#showRow').css('display', 'block');
                            $('#companyName').text(data.name);
                            if (data.logo) {
                                $('#companyImage').attr('src',
                                    '{{ asset('site/uploads/company') }}/' + data.logo);
                            } else {
                                $('#companyImage').attr('src',
                                    "{{ asset('site/assets/img/logo.png') }}");
                            }
                            $('#companyAddress').text(data.address);
                            $('#companyNumber').text(data.number);
                            $('#companyEmail').text(data.email);
                            $('#companyEmployeeCount').text(data.employee_count);
                            $('#companyContactPerson').text(data.contact_person);
                            $('#companyContactPersonNumber').text(data.contact_person_number);
                        } else {
                            $('#showRow').css('display', 'none');
                            errorMessage(
                                "Compnay with this refer_code not available!");
                        }
                    },
                });
            });

        });

        /*------------------------------------------
        --------------------------------------------
        Toastr Success Code
        --------------------------------------------
        --------------------------------------------*/
        function displayMessage(message) {
            toastr.success(message, 'Congratulations!');
        }

        function errorMessage(message) {
            toastr.error(message, 'Sorry!');
        }
    </script>

@endsection
@section('js')
    <script src="{{ asset('site/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('site/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
    <script src="{{ asset('site/assets/js/circle-progress.min.js') }}"></script>
@stop
