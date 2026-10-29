@extends('admin.template.base')

@section('title', 'Edit User')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Edit User</h3>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>User Type</label>
                                <select name="usertype" class="form-control">
                                    <option value="1" {{ $user->usertype == 1 ? 'selected' : '' }}>Admin</option>
                                    <option value="3"{{ $user->usertype == 3 ? 'selected' : '' }}>User</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $user->status == 0 ? 'selected' : '' }}> Inactive</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Update User
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
```

</div>

@endsection
