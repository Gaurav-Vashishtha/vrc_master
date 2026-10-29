<!-- BEGIN: Header-->
<style>
    .sidebar {
        overflow-y: auto;
        height: auto;
        max-height: calc(100vh - 70px);
    }

    .admin-menu-search {
        flex: 0 1 260px;
        min-width: 180px;
        margin: 0 12px;
    }

    .sidebar-search {
        position: relative;
        width: 100%;
        padding: 0;
    }

    .sidebar-search input {
        width: 156%;
        height: 40px;
        padding: 9px 58px 9px 16px;
        box-sizing: border-box;
        border: 1px solid #d6d6d6;
        border-radius: 22px;
        background: #2A3038;
        color: #fff;
        outline: none;
        font-size: 14px;
        margin: 15px 0;
    }

    .sidebar-search input::placeholder {
        color: #888888;
    }

    .sidebar-search input:focus {
        border-color: #b8b8b8;
    }

    .sidebar-search-icon {
        position: absolute;
        top: 15px;
        right: -145px;
        display: flex;
        width: 46px;
        height: 40px;
        align-items: center;
        justify-content: center;
        border-left: 1px solid #d6d6d6;
        border-radius: 0 22px 22px 0;
        color: #fff;
        font-size: 22px;
        pointer-events: none;
    }

    .sidebar-search-result {
        display: none;
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        z-index: 1050;
        width: 100%;
        max-height: 60vh;
        overflow-y: auto;
        padding: 6px 0;
        border: 1px solid #d6d6d6;
        border-radius: 6px;
        background: #ffffff;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .sidebar-search-result .search-heading {
        color: #777777;
        font-size: 12px;
        padding: 5px 10px;
    }

    .sidebar-search-result .nav-link {
        padding: 10px 12px !important;
        font-size: 13px;
    }

    .sidebar-search-result .no-result {
        color: #ff6b6b;
        padding: 10px;
        font-size: 13px;
    }

    @media (max-width: 575px) {
        .admin-menu-search {
            flex: 1 1 180px;
            min-width: 140px;
            margin: 0 6px;
        }
    }
</style>
<div class="container-fluid page-body-wrapper">
	<nav class="navbar p-0 fixed-top d-flex flex-row">
		<div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
		<a class="sidebar-brand brand-logo-mini" href="{{url('admin/dashboard')}}"><img src="{{asset('images/brand/logo.png')}}" alt="Company Logo"></a>
		</div>
		<div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
		<button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
			<span class="mdi mdi-menu"></span>
		</button>

		<ul class="nav admin-menu-search w-100">
			<li class="nav-item sidebar-search w-100">
				<input type="search" id="sidebarMenuSearch" placeholder="Search menu..." aria-label="Search admin menu" autocomplete="off">
				<span class="sidebar-search-icon mdi mdi-magnify" aria-hidden="true"></span>
				<div class="sidebar-search-result" id="sidebarSearchResult">
					<div class="search-heading">SEARCH RESULTS</div>
					<ul class="nav flex-column" id="sidebarSearchList" aria-live="polite"></ul>
				</div>
			</li>
		</ul>
		<ul class="navbar-nav navbar-nav-right">
			<!-- <li class="nav-item dropdown d-none d-lg-block">
			<a class="nav-link btn btn-success create-new-button" id="createbuttonDropdown" data-toggle="dropdown" aria-expanded="false" href="#">+ Create New Project</a>
			<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="createbuttonDropdown">
				<h6 class="p-3 mb-0">Projects</h6>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item preview-item">
				<div class="preview-thumbnail">
					<div class="preview-icon bg-dark rounded-circle">
					<i class="mdi mdi-file-outline text-primary"></i>
					</div>
				</div>
				<div class="preview-item-content">
					<p class="preview-subject ellipsis mb-1">Software Development</p>
				</div>
				</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item preview-item">
				<div class="preview-thumbnail">
					<div class="preview-icon bg-dark rounded-circle">
					<i class="mdi mdi-web text-info"></i>
					</div>
				</div>
				<div class="preview-item-content">
					<p class="preview-subject ellipsis mb-1">UI Development</p>
				</div>
				</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item preview-item">
				<div class="preview-thumbnail">
					<div class="preview-icon bg-dark rounded-circle">
					<i class="mdi mdi-layers text-danger"></i>
					</div>
				</div>
				<div class="preview-item-content">
					<p class="preview-subject ellipsis mb-1">Software Testing</p>
				</div>
				</a>
				<div class="dropdown-divider"></div>
				<p class="p-3 mb-0 text-center">See all projects</p>
			</div>
			</li>
			<li class="nav-item nav-settings d-none d-lg-block">
			<a class="nav-link" href="#">
				<i class="mdi mdi-view-grid"></i>
			</a>
			</li>
			<li class="nav-item dropdown border-left">
			<a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
				<i class="mdi mdi-email"></i>
				<span class="count bg-success"></span>
			</a>
			<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
				<h6 class="p-3 mb-0">Messages</h6>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item preview-item">
				<div class="preview-thumbnail">
					<img src="../admin/assets/images/faces/face4.jpg" alt="image" class="rounded-circle profile-pic">
				</div>
				<div class="preview-item-content">
					<p class="preview-subject ellipsis mb-1">Mark send you a message</p>
					<p class="text-muted mb-0"> 1 Minutes ago </p>
				</div>
				</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item preview-item">
				<div class="preview-thumbnail">
					<img src="../admin/assets/images/faces/face2.jpg" alt="image" class="rounded-circle profile-pic">
				</div>
				<div class="preview-item-content">
					<p class="preview-subject ellipsis mb-1">Cregh send you a message</p>
					<p class="text-muted mb-0"> 15 Minutes ago </p>
				</div>
				</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item preview-item">
				<div class="preview-thumbnail">
					<img src="../admin/assets/images/faces/face3.jpg" alt="image" class="rounded-circle profile-pic">
				</div>
				<div class="preview-item-content">
					<p class="preview-subject ellipsis mb-1">Profile picture updated</p>
					<p class="text-muted mb-0"> 18 Minutes ago </p>
				</div>
				</a>
				<div class="dropdown-divider"></div>
				<p class="p-3 mb-0 text-center">4 new messages</p>
			</div>
			</li>
			<li class="nav-item dropdown border-left">
			<a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
				<i class="mdi mdi-bell"></i>
				<span class="count bg-danger"></span>
			</a>
			<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
				<h6 class="p-3 mb-0">Notifications</h6>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item preview-item">
				<div class="preview-thumbnail">
					<div class="preview-icon bg-dark rounded-circle">
					<i class="mdi mdi-calendar text-success"></i>
					</div>
				</div>
				<div class="preview-item-content">
					<p class="preview-subject mb-1">Event today</p>
					<p class="text-muted ellipsis mb-0"> Just a reminder that you have an event today </p>
				</div>
				</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item preview-item">
				<div class="preview-thumbnail">
					<div class="preview-icon bg-dark rounded-circle">
					<i class="mdi mdi-settings text-danger"></i>
					</div>
				</div>
				<div class="preview-item-content">
					<p class="preview-subject mb-1">Settings</p>
					<p class="text-muted ellipsis mb-0"> Update dashboard </p>
				</div>
				</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item preview-item">
				<div class="preview-thumbnail">
					<div class="preview-icon bg-dark rounded-circle">
					<i class="mdi mdi-link-variant text-warning"></i>
					</div>
				</div>
				<div class="preview-item-content">
					<p class="preview-subject mb-1">Launch Admin</p>
					<p class="text-muted ellipsis mb-0"> New admin wow! </p>
				</div>
				</a>
				<div class="dropdown-divider"></div>
				<p class="p-3 mb-0 text-center">See all notifications</p>
			</div>
			</li>-->
			@if(Session::has('users'))
			<li class="nav-item dropdown">
			<a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
				<div class="navbar-profile">
				@php
					$user = Session::get('users');
				@endphp

				@if(!empty($user['profile_photo']))
					<img class="img-xs rounded-circle" src="{{ asset('images/employees/' . $user['profile_photo']) }}" alt="Profile Pic">
				@else
					<img class="img-xs rounded-circle" src="{{ asset('images/employees/user.jpg') }}" alt="Profile Pic">
				@endif
				<div class="profile-name">
					<p class="mb-0 d-none d-sm-block navbar-profile-name">{{ Session::get('users.first_name')}} {{ Session::get('users.last_name')}}</p>
					<p class="mb-0 d-none d-sm-block navbar-profile-name" style="font-weight: 100; color: blue;">@if(Session::get('users.usertype')=='1')Admin @else Seller  @endif</p>
				</div>
				<i class="mdi mdi-menu-down d-none d-sm-block"></i>
				</div>
			</a>
			<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
				<div class="dropdown-divider"></div>
				<a class="dropdown-item preview-item" href="{{url('admin/logout')}}" onclick="event.preventDefault();
				document.getElementById('logout-form').submit();">
				<form id="logout-form" action="{{url('admin/logout')}}" method="POST" class="d-none">
					@csrf
				</form>
					<div class="preview-thumbnail">
						<div class="preview-icon bg-dark rounded-circle">
						<i class="mdi mdi-logout text-danger"></i>
						</div>
					</div>
					<div class="preview-item-content">
						<p class="preview-subject mb-1">Log out</p>
					</div>
				</a>
				<div class="dropdown-divider"></div>
			</div>
			</li>
			@endif 
		</ul>
		<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
			<span class="mdi mdi-format-line-spacing"></span>
		</button>
		</div>
	</nav>
	<!-- partial -->
<!-- END: Header-->
	
	