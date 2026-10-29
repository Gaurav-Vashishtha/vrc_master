<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="base-url" content="{{ url('/') }}">
  <title>@yield('title')</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/css/vendor.bundle.base.css')}}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/jvectormap/jquery-jvectormap.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/owl-carousel-2/owl.carousel.min.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/owl-carousel-2/owl.theme.default.min.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="{{ URL::asset('admin/assets/css/style.css')}}">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="{{ URL::asset('admin/assets/images/short-logo.png')}}">


  @yield('styles')
  <style>
    .notificationerror {
      position: absolute;
      width: 100%;
      top: 160px;
      background: transparent;
      z-index: 99;
      right: 0;
      border: none;
    }

    .d-flex.rightcard {
      justify-content: right;
      margin-top: 9px;
      position: absolute;
      right: 55px;
      border: 2px solid red;
      padding: 10px;
      border-radius: 25px;
    }

    .d-flex.rightcard1 {
      justify-content: right;
      margin-top: 9px;
      position: absolute;
      right: 55px;
      border: 2px solid green;
      padding: 10px;
      border-radius: 25px;
    }

    .notificationerror .card-content p {
      margin: 0px;
    }

    .rightcard .close.white-text,
    .rightcard1 .close.white-text {
      color: red;
      opacity: 1;
      padding-left: 10px;
    }
  </style>
</head>
<!-- END: Head-->

<body>
  <!-- BEGIN: Side Bar-->
  @include('admin.include.sidebar')
  <!-- END: Side Bar-->

  <!-- BEGIN: Header-->
  @include('admin.include.header')
  <!-- END: Header-->

  <!-- BEGIN: Page Main-->


  <!-- Alert Message -->

  @if(Session::has('message'))
  <!--<div class="card-alert card card-alert card {{ Session::get('alert-class', 'alert-info') }} ensober_alert"> 
			<div class="card-content white-text">
				<p><i class="material-icons">check</i> {{ Session::get('message') }}.</p>
			</div>
			<button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>-->
  @endif

  @include('common.notify')
  <!-- /Alert Message -->

  @yield('content')
  <!-- END: Page Main-->


  <!-- BEGIN: Footer-->
  {{-- @include('admin.include.footer') --}}
  <!-- END: Footer-->

  <!-- plugins:js -->
  <script src="{{ URL::asset('admin/assets/vendors/js/vendor.bundle.base.js')}}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="{{ URL::asset('admin/assets/vendors/chart.js/Chart.min.js')}}"></script>
  <script src="{{ URL::asset('admin/assets/vendors/progressbar.js/progressbar.min.js')}}"></script>
  <script src="{{ URL::asset('admin/assets/vendors/jvectormap/jquery-jvectormap.min.js')}}"></script>
  <script src="{{ URL::asset('admin/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
  <script src="{{ URL::asset('admin/assets/vendors/owl-carousel-2/owl.carousel.min.js')}}"></script>
  <script src="{{ URL::asset('admin/assets/vendors/select2/select2.min.js') }}"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{ URL::asset('admin/assets/js/off-canvas.js')}}"></script>
  <script src="{{ URL::asset('admin/assets/js/hoverable-collapse.js')}}"></script>
  <script src="{{ URL::asset('admin/assets/js/misc.js')}}"></script>
  <script src="{{ URL::asset('admin/assets/js/settings.js')}}"></script>
  <script src="{{ URL::asset('admin/assets/js/todolist.js')}}"></script>
  <!-- endinject -->
  <!-- Custom js for this page -->
  <script src="{{ URL::asset('admin/assets/js/dashboard.js')}}"></script>
  <!-- End custom js for this page -->


  <script src="{{ URL::asset('js/datatables-simple-demo.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
  <script src="{{ asset('admin/assets/js/custom.js') }}"></script>
  <script>
    $(document).on('click', '.notificationerror .close', function() {
      $(this).closest('.notificationerror').fadeOut();
    });

    jQuery(document).ready(function() {
      $('.select2').select2({
    
      });
      setTimeout(function() {
        $('.notificationerror').fadeOut();
      }, 8000);
    });
  </script>
  @yield('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const searchInput = document.getElementById('sidebarMenuSearch');
      const searchResult = document.getElementById('sidebarSearchResult');
      const searchList = document.getElementById('sidebarSearchList');
      const sidebar = document.getElementById('sidebar');

      if (!searchInput || !searchResult || !searchList || !sidebar) {
        return;
      }

      const menuData = Array.from(sidebar.querySelectorAll('a.nav-link'))
        .map(function (link) {
          const titleElement = link.querySelector('.menu-title');
          const title = (titleElement ? titleElement.textContent : link.textContent).trim();
          const href = link.getAttribute('href');
          const parentMenu = link.closest('li.menu-items');
          const parentLink = parentMenu
              ? parentMenu.querySelector(':scope > a.nav-link')
              : null;
          const parentTitleElement = parentLink
              ? parentLink.querySelector('.menu-title')
              : null;
          const parentTitle = parentTitleElement
              ? parentTitleElement.textContent.trim()
              : '';
          const icon = link.querySelector('.menu-icon') ||
              (parentLink ? parentLink.querySelector('.menu-icon') : null);

          return {
              title: parentTitle && parentTitle !== title
                  ? parentTitle + ' - ' + title
                  : title,
              url: href,
              icon: icon
          };
        })
        .filter(function (item) {
          return item.title && item.url && item.url !== '#' && item.url.charAt(0) !== '#';
        });

      searchInput.addEventListener('input', function () {
        const searchText = this.value.trim().toLowerCase();
        searchList.innerHTML = '';

        if (searchText === '') {
          searchResult.style.display = 'none';
          return;
        }

        const filteredMenus = menuData.filter(function (item) {
          return item.title.toLowerCase().includes(searchText);
        });

        searchResult.style.display = 'block';

        if (filteredMenus.length === 0) {
          const noResult = document.createElement('li');
          noResult.className = 'no-result';
          noResult.textContent = 'No menu found!';
          searchList.appendChild(noResult);
          return;
        }

        filteredMenus.forEach(function (item) {
          const li = document.createElement('li');
          li.className = 'nav-item';

          const link = document.createElement('a');
          link.className = 'nav-link';
          link.href = item.url;

          const icon = document.createElement('span');
          icon.className = 'menu-icon';
          if (item.icon) {
              icon.appendChild(item.icon.cloneNode(true));
          }

          const title = document.createElement('span');
          title.className = 'menu-title';
          title.textContent = item.title;

          link.appendChild(icon);
          link.appendChild(title);
          li.appendChild(link);
          searchList.appendChild(li);
        });
      });
    });
  </script>
</body>

</html>