<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from themewagon.github.io/corona-free-dark-bootstrap-admin-template/pages/forms/basic_elements.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 18 Jan 2023 15:14:41 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>VBR - Seller Login</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css')}}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/css/style.css')}}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ URL::asset('admin/assets/images/short-logo.png')}}">
    <style>
      .auth.login-bg {
        background-image: url("{{ asset('images/home/back-3.jpg') }}");
        /* background-size: cover; */
        background-repeat: no-repeat;
        background-size: 100% 100%;
      }
      .mx-auto{
        opacity: 0.95;
      }
      .p_input{
        color: green !important;
      }
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
                  <form class="forms-sample" action="{{url('login')}}" method="POST">
                  @csrf
                  <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control p_input" required>
                  </div>
                  <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="password" class="form-control p_input" required>
                  </div>
                  <div class="form-group d-flex align-items-center justify-content-between">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input"> Remember me </label>
                    </div>
                    <!-- <a href="#" class="forgot-pass">Forgot password</a> -->
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Login </button>
                  </div>
                 
                  <span id="Massage" style="color: red;" min-height="10px" max-height="10px"> &nbsp; @if(Session::has('Failed')){{Session::get('Failed')}}@endif</span>
                  
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
    <script>
    jQuery(document).ready(function() {
        setTimeout(() => {
            jQuery('#Massage').html('&nbsp;');
        },5000);
    })
    </script>
    <!-- End custom js for this page -->
  </body>

<!-- Mirrored from themewagon.github.io/corona-free-dark-bootstrap-admin-template/pages/forms/basic_elements.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 18 Jan 2023 15:14:43 GMT -->
</html>