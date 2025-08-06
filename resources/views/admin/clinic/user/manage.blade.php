@extends('layouts.admin', ['activePage' => 'adminclinicmanage'])

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $clinic->name }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item active"><a href="#">Dashboard</a></li> -->
                        <li class="breadcrumb-item active">Dashboard</li>
                        <li class="breadcrumb-item active">{{ $clinic->name }}</li>
                        <li class="breadcrumb-item active">User</li>
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
                                    data-target="#adminclinicuser">
                                    Add User
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="adminclinicusertable" class="table table-stripped table-bordered"
                                style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clinic->getUserFromClinic as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                @if ($item->image)
                                                    <img src="{{ asset('site/uploads/clinic/user/' . $item->image) }}"
                                                        alt="{{ $item->name }}" class="img-fluid" width="100">
                                                @else
                                                    <img src="{{ asset('site/assets/img/logo.png') }}"
                                                        alt="{{ $item->name }}" class="img-fluid" width="100">
                                                @endif
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                @if ($item->role == 'admin')
                                                    <b class="text-success">Admin</b>
                                                @else
                                                    <b class="text-primary">Doctor</b>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->status == 'active')
                                                    <b class="text-success">Active</b>
                                                @else
                                                    <b class="text-danger">Hidden</b>
                                                @endif
                                            </td>

                                            <td>
                                                <a class="btn btn-xs btn-outline-success" data-toggle="modal"
                                                    data-target="#adminclinicuseredit-{{ $item->id }}">Edit</a>
                                                &nbsp;
                                                <a class="btn btn-xs btn-outline-danger"
                                                    href="{{ route('admin.getDeleteClinicUser', $item->id) }}"
                                                    onclick="if(!confirm(`Are you sure to delete {{ $item->name }} user!`)) { event.preventDefault(); }">Delete</a>
                                                &nbsp;
                                                <a class="btn btn-xs btn-outline-warning"
                                                    href="{{ route('admin.getSendPasswordForClinicUser', $item->id) }}"
                                                    onclick="if(!confirm(`Are you sure to send password to {{ $item->name }} user!`)) { event.preventDefault(); }">Send
                                                    Passwrod</a>
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

    <!-- add clinic user model -->
    <div id="adminclinicuser" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="gridModalLabel">Add User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.postAddClinicUser', $clinic->slug) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
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
                                    <label for="role">Role (*)</label>
                                    <select id="role" class="form-control" name="role" required>
                                        <option value="admin" selected>Admin</option>
                                        <option value="doctor">Doctor</option>
                                    </select>
                                    @if ($errors->has('role'))
                                        <span class="text-danger" style="font-style: italic;">
                                            <small style="font-weight: bold">{{ $errors->first('role') }}</small>
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
    <!-- add clinic user model ends -->

    <!-- edit clinic user modal -->
    @foreach ($clinic->getUserFromClinic as $user)
        <div id="adminclinicuseredit-{{ $user->id }}" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="gridModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="gridModalLabel">Edit >> {{ $user->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('admin.postEditClinicUser', $user->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Name (*)</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $user->name }}" required>
                                        @if ($errors->has('name'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small style="font-weight: bold">{{ $errors->first('name') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" id="image" name="image"
                                            value="{{ old('image') }}">

                                        @if ($user->image)
                                            <img src="{{ asset('site/uploads/clinic/user/' . $user->image) }}"
                                                alt="{{ $user->name }}" class="img-fluid" width="100">
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
                                        <label for="email">Email (*)</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $user->email }}" required>

                                        @if ($errors->has('email'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small style="font-weight: bold">{{ $errors->first('email') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Role (*)</label>
                                        <select id="role" class="form-control" name="role" required>
                                            <option value="admin" <?php if ($user->role == 'admin') {
                                                echo 'selected';
                                            } ?>>Admin</option>
                                            <option value="doctor" <?php if ($user->role == 'doctor') {
                                                echo 'selected';
                                            } ?>>Doctor</option>
                                        </select>
                                        @if ($errors->has('role'))
                                            <span class="text-danger" style="font-style: italic;">
                                                <small style="font-weight: bold">{{ $errors->first('role') }}</small>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select id="status" class="form-control" name="status" required>
                                            <option value="active" <?php if ($user->status == 'active') {
                                                echo 'selected';
                                            } ?>>Active</option>
                                            <option value="hidden" <?php if ($user->status == 'hidden') {
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea type="text" class="form-control" id="description" rows="8" name="description" value="">{{ $user->description }}</textarea>
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
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-success" value="Save Changes">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- edit clinic user model ends -->
@endsection
@section('js')
    <script>
        $(function() {
            $("#adminclinicusertable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
