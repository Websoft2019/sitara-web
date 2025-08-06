@extends('layouts.admin', ['activePage' => 'adminclinicmanage'])

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Clinic</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item active"><a href="#">Dashboard</a></li> -->
                        <li class="breadcrumb-item active">Dashboard</li>
                        <li class="breadcrumb-item active">Clinic</li>
                        <li class="breadcrumb-item active">Manage</li>
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
                                <button type="button" class="btn btn-primary btn-md" data-toggle="modal"
                                    data-target="#adminclinic">
                                    Add Clinic
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="adminclinictable" class="table table-stripped table-bordered"
                                style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Logo</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clinics as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                @if ($item->logo)
                                                    <img src="{{ asset('site/uploads/clinic/' . $item->logo) }}"
                                                        alt="{{ $item->name }}" class="img-fluid" width="100">
                                                @else
                                                    <img src="{{ asset('site/assets/img/logo.png') }}"
                                                        alt="{{ $item->name }}" class="img-fluid" width="100">
                                                @endif
                                            </td>
                                            <td>
                                                <b>Name: </b>{{ $item->name }} <br>
                                                <b>Address: </b>{{ $item->address }} <br>
                                            </td>
                                            <td>
                                                <b>Email: </b>{{ $item->email }} <br>
                                                <b>Contact Number: </b>{{ $item->number }} <br>
                                                <b>Contact Person: </b>{{ $item->contact_person }} <br>
                                                <b>Person Number: </b>{{ $item->contact_person_number }}
                                            </td>
                                            <td>
                                                {{ $item->address }} <br>
                                                <b>Longitude: </b>{{ $item->longitude }} <br>
                                                <b>Latitude: </b>{{ $item->latitude }}
                                            </td>
                                            <td>
                                                @if ($item->status == 'active')
                                                    <b class="text-success">Active</b>
                                                @else
                                                    <b class="text-danger">Hidden</b>
                                                @endif
                                            </td>

                                            <td>
                                                <a class="btn m-1 btn-xs btn-outline-info open-modal-btn" data-id="{{ $item->id }}">Linked Companies</a>
                                                &nbsp;
                                                <a class="btn btn-xs btn-outline-success"
                                                    href="{{ route('admin.getEditClinic', $item->slug) }}">Edit</a>
                                                &nbsp;
                                                <a class="btn btn-xs btn-outline-danger"
                                                    href="{{ route('admin.getDeleteClinic', $item->slug) }}"
                                                    onclick="if(!confirm(`Are you sure to delete {{ $item->name }} clinic!`)) { event.preventDefault(); }">Drop</a>
                                                &nbsp;
                                                <a href="{{ route('admin.getManageClinicUser', $item->slug) }}"
                                                    class="btn btn-xs btn-outline-dark">Add User</a>
                                                {{-- <a href="{{ route('admin.', $item->id) }}">Delete</a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {!! $clinics->links() !!} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main content ends here -->

    <!-- add category model -->
    <div id="adminclinic" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="gridModalLabel">Add Clinic</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.postAddClinic') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name (*)</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') }}" required>
                                    @if ($errors->has('name'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('name') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input type="file" class="form-control" id="logo" name="logo"
                                        value="{{ old('logo') }}">
                                    @if ($errors->has('logo'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('logo') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address (*)</label>
                                    <input type="numeric" class="form-control" id="address" name="address"
                                        value="{{ old('address') }}" required>

                                    @if ($errors->has('address'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('address') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="longitude">Longitude (*)</label>
                                    <input type="numeric" class="form-control" id="longitude" name="longitude"
                                        value="{{ old('longitude') }}">

                                    @if ($errors->has('longitude'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('longitude') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="latitude">Latitude (*)</label>
                                    <input type="numeric" class="form-control" id="latitude" name="latitude"
                                        value="{{ old('latitude') }}">

                                    @if ($errors->has('latitude'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('latitude') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="registration_number">Registration Number (*)</label>
                                    <input type="text" class="form-control" id="registration_number"
                                        name="registration_number" value="{{ old('registration_number') }}" required>

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
                                        value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('email') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="number">Contact Number (*)</label>
                                    <input type="text" class="form-control" id="number" name="number"
                                        value="{{ old('number') }}" required>

                                    @if ($errors->has('number'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('number') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_person">Contact Person (*)</label>
                                    <input type="text" class="form-control" id="contact_person" name="contact_person"
                                        value="{{ old('contact_person') }}" required>

                                    @if ($errors->has('number'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('number') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_person_number">Contact Person Number (*)</label>
                                    <input type="text" class="form-control" id="contact_person_number"
                                        name="contact_person_number" value="{{ old('contact_person_number') }}" required>

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
    <!-- add category model ends -->
      <div class="modal fade" id="LinkCompanyModal"
    tabindex="-1" role="dialog"
    aria-labelledby="LinkCompanyModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Linked Companies</h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="LinkCompanyModalBody">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        $(function() {
            $("#adminclinictable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        $(document).ready(function() {
            // Check if there are any validation errors
            @if ($errors->any())
                $('#adminclinic').modal('show');
            @endif

            // Optionally, you can use localStorage to persist modal state if needed
            $('#adminclinic').on('shown.bs.modal', function() {
                localStorage.setItem('modalOpen', 'true');
            });

            $('#adminclinic').on('hidden.bs.modal', function() {
                localStorage.setItem('modalOpen', 'false');
            });

            if (localStorage.getItem('modalOpen') === 'true') {
                $('#adminclinic').modal('show');
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.open-modal-btn').on('click', function () {
                const clinicId = $(this).data('id');
                

                $('#LinkCompanyModal').modal('show');
                $('#LinkCompanyModalBody').html('<p>Loading...</p>');

                $.ajax({
                    url: '/admin/get-linked-company-list-ajax',
                    method: 'POST',
                    data: {
                        clinic_id: clinicId,
                        _token: '{{ csrf_token() }}' // Laravel CSRF protection
                    },
                    success: function (response) {
                        $('#LinkCompanyModalBody').html(response);
                    },
                    error: function () {
                        $('#LinkCompanyModalBody').html('<p>Error loading data.</p>');
                    }
                });
            });
        });
    </script>
@endsection
