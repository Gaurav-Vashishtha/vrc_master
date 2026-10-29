@extends('user.template.base')

@section('title', 'Change Password')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">Change Password</h3>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('user.update.password') }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <label>
                                <strong>Current Password</strong>
                            </label>

                            <div class="input-group">
                                <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter Current Password" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('current_password', 'current_password_icon')">
                                        <i id="current_password_icon" class="mdi mdi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>
                                <strong>New Password</strong>
                            </label>

                            <div class="input-group">
                                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter New Password" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('new_password', 'new_password_icon')">
                                        <i id="new_password_icon" class="mdi mdi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="col-md-12 mb-3">
                            <label>
                                <strong>Confirm Password</strong>
                            </label>

                            <div class="input-group">
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" placeholder="Confirm New Password" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('new_password_confirmation', 'new_password_confirmation_icon')">
                                        <i id="new_password_confirmation_icon" class="mdi mdi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>Update Password</button>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId)
    {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('mdi-eye');
            icon.classList.add('mdi-eye-off');
        } else {
            input.type = 'password';
            icon.classList.remove('mdi-eye-off');
            icon.classList.add('mdi-eye');
        }
    }
</script>
@endsection