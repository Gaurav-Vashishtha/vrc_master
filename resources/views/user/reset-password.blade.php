<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>VRConsulting - Reset Password</title>
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/css/style.css') }}">
    <link rel="shortcut icon"   href="{{ URL::asset('admin/assets/images/short-logo.png') }}">
    <meta name="base-url" content="{{ url('/') }}">
    <style>
        .auth.login-bg {background-image: url("{{ asset('images/home/back-1.jpg') }}");background-repeat: no-repeat;background-size: 100% 100%;}
        .mx-auto {opacity: 0.95;}
        .p_input {color: green !important;}
        .password-wrapper {position: relative;}
        .password-wrapper .form-control {padding-right: 45px;}
        .password-toggle {position: absolute;right: 10px;top: 50%;transform: translateY(-50%);border: 0;background: transparent;color: #777;cursor: pointer;padding: 5px;font-size: 20px;}
        .password-toggle:focus {outline: none;}
        .back-login {text-align: center;margin-top: 20px;}
        .back-login a {color: #007bff;text-decoration: none;}
        .back-login a:hover {text-decoration: underline;}
        .reset-message {min-height: 20px;}
        @media (min-width: 992px) {.page-body-wrapper {margin-left: 0px !important;}}
    </style>
</head>

<body style="background-color: #000000 !important">
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                    <div class="card col-lg-4 mx-auto">
                        <div class="pt-4" style="text-align: center;">
                            <img src="{{ asset('images/brand/logo.png') }}"  alt="Company Logo">
                        </div>

                        <div class="card-body px-5 py-5">
                            <h3 class="card-title text-left mb-3">Reset Password</h3>
                            <p class="text-muted mb-4">Enter your new password below.</p>

                            {{-- Success Message --}}
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            {{-- Error Message --}}
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif


                            <form class="forms-sample" action="{{ route('password.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group">
                                    <label>Email *</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', request('email')) }}" class="form-control p_input @error('email') is-invalid @enderror" required autofocus>
                                    @error('email')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <!-- New Password -->
                                <div class="form-group">
                                    <label>New Password *</label>

                                    <div class="password-wrapper">
                                        <input type="password" name="password" id="password" class="form-control p_input" required>
                                        <button type="button" class="password-toggle" onclick="togglePassword('password', 'passwordIcon')">
                                            <i class="mdi mdi-eye" id="passwordIcon"></i>
                                        </button>
                                    </div>


                                    @error('password')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>


                                <!-- Confirm Password -->
                                <div class="form-group">
                                    <label>Confirm Password *</label>
                                    <div class="password-wrapper">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control p_input" required>
                                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'confirmPasswordIcon')">
                                            <i class="mdi mdi-eye" id="confirmPasswordIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit"class="btn btn-primary btn-block enter-btn">
                                        Reset Password
                                    </button>
                                </div>

                                <!-- Back to Login -->
                                <div class="back-login">
                                    <a href="{{ route('user.login') }}">
                                        <i class="mdi mdi-arrow-left"></i>
                                        Back to Login
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- plugins:js -->
    <script src="{{ URL::asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/js/off-canvas.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/js/misc.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/js/settings.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/js/todolist.js') }}"></script>

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
</body>
</html>