@extends('admin.template.base')

@section('title', 'Change Password')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">Change Password</h3>
        </div>

        <div class="card">
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ url('admin/change-password') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label>Current Password</label>
                        <input type="password"
                               name="current_password"
                               class="form-control"
                               required>

                        @error('current_password')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>New Password</label>
                        <input type="password"
                               name="new_password"
                               class="form-control"
                               required>

                        @error('new_password')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Confirm Password</label>
                        <input type="password"
                               name="new_password_confirmation"
                               class="form-control"
                               required>
                    </div>

                    <button type="submit"
                            class="btn btn-primary">
                        Update Password
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection