@extends('layouts.admin', ['activePage' => 'admincompanymanage'])

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dependent</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
                        <li class="breadcrumb-item active">Employee</li>
                        <li class="breadcrumb-item active">Manage</li>
                        <li class="breadcrumb-item active">Dependent</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <div>Add Dependent</div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.postDependent', ['slug' => $slug, 'id' => $id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div id="dynamic-form">
                                    <div class="form-group row" id="form-row-1">
                                        <div class="col-md-3">
                                            <label for="name">Member Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror" placeholder="Member Name"
                                                value="{{ old('name') }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="gender">Gender <span class="text-danger">*</span></label>
                                            <select name="gender"
                                                class="form-control @error('gender') is-invalid @enderror">
                                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male
                                                </option>
                                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                                    Female</option>
                                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>
                                                    Other</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="dob">DOB <span class="text-danger">*</span></label>
                                            <input type="date" name="dob"
                                                class="form-control @error('dob') is-invalid @enderror"
                                                value="{{ old('dob') }}">
                                            @error('dob')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="icnumber">IC Number</label>
                                            <input type="text" name="icnumber"
                                                class="form-control @error('icnumber') is-invalid @enderror" placeholder="IC Number"
                                                value="{{ old('icnumber') }}">
                                            @error('icnumber')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="relation">Relation <span class="text-danger">*</span></label>
                                            <select name="relation"
                                                class="form-control @error('relation') is-invalid @enderror">
                                                <option value="" disabled
                                                    {{ old('relation') == '' ? 'selected' : '' }}>Select a relation
                                                </option>
                                                <option value="grandson"
                                                    {{ old('relation') == 'grandson' ? 'selected' : '' }}>Grandson</option>
                                                <option value="granddaughter"
                                                    {{ old('relation') == 'granddaughter' ? 'selected' : '' }}>
                                                    Granddaughter</option>
                                                <option value="nephew" {{ old('relation') == 'nephew' ? 'selected' : '' }}>
                                                    Nephew</option>
                                                <option value="niece" {{ old('relation') == 'niece' ? 'selected' : '' }}>
                                                    Niece</option>
                                                <option value="cousin" {{ old('relation') == 'cousin' ? 'selected' : '' }}>
                                                    Cousin</option>
                                                <option value="brother"
                                                    {{ old('relation') == 'brother' ? 'selected' : '' }}>Brother</option>
                                                <option value="sister" {{ old('relation') == 'sister' ? 'selected' : '' }}>
                                                    Sister</option>
                                                <option value="uncle" {{ old('relation') == 'uncle' ? 'selected' : '' }}>
                                                    Uncle</option>
                                                <option value="aunt" {{ old('relation') == 'aunt' ? 'selected' : '' }}>
                                                    Aunt</option>
                                                <option value="father" {{ old('relation') == 'father' ? 'selected' : '' }}>
                                                    Father</option>
                                                <option value="mother" {{ old('relation') == 'mother' ? 'selected' : '' }}>
                                                    Mother</option>
                                                <option value="son" {{ old('relation') == 'son' ? 'selected' : '' }}>Son
                                                </option>
                                                <option value="daughter"
                                                    {{ old('relation') == 'daughter' ? 'selected' : '' }}>Daughter</option>
                                                <option value="husband"
                                                    {{ old('relation') == 'husband' ? 'selected' : '' }}>Husband</option>
                                                <option value="wife" {{ old('relation') == 'wife' ? 'selected' : '' }}>
                                                    Wife</option>
                                                <option value="partner"
                                                    {{ old('relation') == 'partner' ? 'selected' : '' }}>Partner</option>
                                                <option value="stepfather"
                                                    {{ old('relation') == 'stepfather' ? 'selected' : '' }}>Stepfather
                                                </option>
                                                <option value="stepmother"
                                                    {{ old('relation') == 'stepmother' ? 'selected' : '' }}>Stepmother
                                                </option>
                                                <option value="stepson"
                                                    {{ old('relation') == 'stepson' ? 'selected' : '' }}>Stepson</option>
                                                <option value="stepdaughter"
                                                    {{ old('relation') == 'stepdaughter' ? 'selected' : '' }}>Stepdaughter
                                                </option>
                                                <option value="godson" {{ old('relation') == 'godson' ? 'selected' : '' }}>
                                                    Godson</option>
                                                <option value="goddaughter"
                                                    {{ old('relation') == 'goddaughter' ? 'selected' : '' }}>Goddaughter
                                                </option>
                                                <option value="in-law" {{ old('relation') == 'in-law' ? 'selected' : '' }}>
                                                    In-law</option>
                                                <option value="foster-child"
                                                    {{ old('relation') == 'foster-child' ? 'selected' : '' }}>Foster Child
                                                </option>
                                                <option value="adopted-child"
                                                    {{ old('relation') == 'adopted-child' ? 'selected' : '' }}>Adopted
                                                    Child</option>
                                                <!-- Add more options as needed -->
                                            </select>
                                            @error('relation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="min_benefit">Minimun Benefit (MYR)</label>
                                            <input type="text" name="min_benefit"
                                                class="form-control @error('min_benefit') is-invalid @enderror"
                                                value="{{ old('min_benefit') }}" placeholder="0.00">
                                            @error('min_benefit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="relation">Photo</label>
                                            <input type="file" name="photo"
                                                class="form-control @error('photo') is-invalid @enderror"
                                                value="{{ old('photo') }}">
                                            @error('photo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="admincompanyemployeetable" class="table table-stripped table-bordered"
                                style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Image</th>
                                        <th>Details</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dependents as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                @if ($item->photo)
                                                    <img src="{{ asset('site/uploads/dependent/' . $item->photo) }}"
                                                        alt="{{ $item->name }}" class="img-fluid" width="100">
                                                @else
                                                    <img src="{{ asset('site/assets/img/logo.png') }}"
                                                        alt="{{ $item->name }}" class="img-fluid" width="100">
                                                @endif
                                            </td>
                                            <td>
                                                <b>Name: </b>{{ $item->name }} <br>
                                                <b>Relation: </b>{{ $item->relation }} <br>
                                                <b>DOB: </b>{{ $item->dob }} <br>
                                                <b>IC Number: </b>{{ $item->icnumber }} <br>
                                                <b>Gender: </b><span
                                                    style="text-transform: capitalize;">{{ $item->gender }}</span> <br>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center algin-items-center">
                                                    <div>
                                                        <form
                                                            action="{{ route('admin.statusChangeDependent', ['slug' => $slug, 'id' => $id, 'dependentid' => $item->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            @if ($item->status == 'active')
                                                                <input class="btn btn-warning m-2 text-white"
                                                                    type="submit" value="{{ $item->status }}">
                                                            @else
                                                                <input class="btn btn-secondary m-2 text-white"
                                                                    type="submit" value="{{ $item->status }}">
                                                            @endif
                                                        </form>
                                                    </div>
                                                    <div>
                                                        <form
                                                            action="{{ route('admin.deleteDependent', ['slug' => $slug, 'id' => $id, 'dependentid' => $item->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input class="btn btn-danger m-2 text-white" type="submit"
                                                                value="Remove">
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {!! $companys->links() !!} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main content ends here -->
@endsection
@section('js')
    <script>
        $(function() {
            $("#admincompanyemployeetable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
