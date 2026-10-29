@extends('admin.template.base')

@section('title', 'Add User')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add User</h3>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control" value="{{old('first_name')}}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="{{old('last_name')}}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{old('email')}}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{old('phone')}}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}" required>
                                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                    <i class="mdi mdi-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>User Type</label>
                            <select name="usertype" class="form-control">
                                <option value="1" {{ old('usertype') == '1' ? 'selected' : '' }}>Admin</option>
                                <option value="3" {{ old('usertype') == '3' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1"{{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0"{{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-success">
                        Save User
                    </button>

                    <a href="{{ route('admin.users.index') }}"
                        class="btn btn-secondary">
                        Back
                    </a>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (password.type === 'password') {
            password.type = 'text';
            eyeIcon.classList.remove('mdi-eye');
            eyeIcon.classList.add('mdi-eye-off');
        } else {
            password.type = 'password';
            eyeIcon.classList.remove('mdi-eye-off');
            eyeIcon.classList.add('mdi-eye');
        }
    });
</script>
@endsection