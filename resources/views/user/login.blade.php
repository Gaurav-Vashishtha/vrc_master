<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>VRConsulting - User Login</title>
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/css/style.css')}}">
    <link rel="shortcut icon" href="{{ URL::asset('admin/assets/images/short-logo.png')}}">
    <meta name="base-url" content="{{ url('/') }}">
    <style>
      .auth.login-bg {background-image: url("{{ asset('images/home/back-1.jpg') }}");background-repeat: no-repeat;background-size: 100% 100%;}
      .mx-auto{opacity: 0.95;}
      .p_input{color: green !important;}
      @media (min-width: 992px) {.page-body-wrapper {margin-left: 0px !important;}}
      .password-wrapper {position: relative;}
      .password-wrapper .form-control {padding-right: 45px;}
      .password-toggle {position: absolute;right: 10px;top: 50%;transform: translateY(-50%);border: 0;background: transparent;color: #777;cursor: pointer;padding: 5px;font-size: 20px;}
      .password-toggle:focus {outline: none;}
    </style>
  </head>
  <body style="background-color: #000000 !important">
  
  <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="pt-4" style="text-align: center;">
                <img src="{{asset('images/brand/logo.png')}}" alt="Company Logo">
              </div>
              <div class="card-body px-5 py-5">
              <h3 class="card-title text-left mb-3">Login</h3>
                  <form class="forms-sample" action="{{ route('user.login.post') }}" method="POST">
                  @csrf
                  <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control p_input" required>
                  </div>
                  <div class="form-group">
                    <label>Password *</label>
                    <div class="password-wrapper">
                      <input type="password" name="password" id="password" class="form-control p_input placeholder="Enter New Password" required>
                      <button type="button" class="password-toggle" onclick="togglePassword('password', 'passwordIcon')">
                        <i class="mdi mdi-eye" id="passwordIcon"></i>
                      </button>
                    </div>
                  </div>
                  
                  <div class="form-group d-flex align-items-center justify-content-between">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input"> Remember me </label>
                    </div>
                    <a href="#" class="forgot-pass" data-toggle="modal" data-target="#forgotPasswordModal">Forgot password</a>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Login </button>
                  </div>
                 
                  <span id="Massage" style="color: red;" min-height="10px" max-height="10px"> &nbsp; @if(Session::has('Failed')){{Session::get('Failed')}}@endif</span>

                  @if (session('status'))
                    <div class="alert alert-success">
                      <i class="mdi mdi-check-circle"></i>{{ session('status') }}
                    </div>
                  @endif
                  
                  <!-- <div class="d-flex">
                    <button class="btn btn-facebook mr-2 col">
                      <i class="mdi mdi-facebook"></i> Facebook </button>
                    <button class="btn btn-google col">
                      <i class="mdi mdi-google-plus"></i> Google plus </button>
                  </div>
                  <p class="sign-up">Don't have an Account?<a href="#"> Sign Up</a></p> -->
                </form>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form id="forgotPasswordForm">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="forgotPasswordModalLabel">Reset Password</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <label for="resetEmail">Enter your email to reset password</label>
              <input type="email" class="form-control" name="email" id="resetEmail" placeholder="Email Address">
              <small id="forgotError" class="text-danger d-block mt-2" style="display: none;">&nbsp;</small>
              <small id="forgotSuccess" class="text-success d-block mt-2" style="display: none;"></small>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" id="send-reset-btn">Send Reset Link</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ URL::asset('admin/assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ URL::asset('admin/assets/vendors/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('admin/assets/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ URL::asset('admin/assets/js/off-canvas.js')}}"></script>
    <script src="{{ URL::asset('admin/assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{ URL::asset('admin/assets/js/misc.js')}}"></script>
    <script src="{{ URL::asset('admin/assets/js/settings.js')}}"></script>
    <script src="{{ URL::asset('admin/assets/js/todolist.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ URL::asset('admin/assets/js/file-upload.js')}}"></script>
    <script src="{{ URL::asset('admin/assets/js/typeahead.js')}}"></script>
    <script src="{{ URL::asset('admin/assets/js/select2.js')}}"></script>
    <script src="{{ asset('admin/assets/js/custom.js') }}"></script>
    <script>
    jQuery(document).ready(function() {
      setTimeout(() => {
        jQuery('#Massage').html('&nbsp;');
      },5000);
    })
    </script>
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