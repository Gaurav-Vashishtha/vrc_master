<!-- BEGIN: Header-->
<div class="container-fluid page-body-wrapper">
	<nav class="navbar p-0 fixed-top d-flex flex-row">
		<div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
			<a class="sidebar-brand brand-logo-mini" href="/dashboard"><img src="{{asset('images/brand/logo.png')}}" alt="Company Logo"></a>
		</div>
		<div class="navbar-menu-wrapper d-flex align-items-stretch">
			<button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
				<span class="mdi mdi-menu"></span>
			</button>
			<ul class="navbar-nav w-100">
				<li class="nav-item w-100">
					<!-- <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
				<input type="text" class="form-control" placeholder="Search products">
			</form> -->
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
			</li>-->
				<!-- <li class="nav-item dropdown border-left">
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
			</li> -->
			<li class="nav-item dropdown border-left border-right">
				<a href="{{ route('user.notifications.index') }}" class="nav-link count-indicator" id="notification-link">
					<i class="mdi mdi-bell"></i>					
					@php $notificationCount = count(getUserNotificationByID(session('users.id'))); @endphp
					@if($notificationCount > 0)
						<span class="count-number bg-danger" id="notification-count" aria-live="polite"></span>
					@else
						<span class="count-number bg-danger" id="notification-count" aria-live="polite" style="display: none;"></span>
					@endif
				</a>
			</li>

			@if(Session::has('users'))
			<li class="nav-item dropdown">
				<a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
					<div class="navbar-profile">
						@if(!empty(Session::get('users.profile_photo')))
						<img class="img-xs rounded-circle" src="{{ asset('images/employees/' . Session::get('users.profile_photo')) }}" alt="Profile Pic">
						@else
						<img class="img-xs rounded-circle" src="{{ asset('images/employees/user.jpg') }}" alt="Profile Pic">
						@endif
						<div class="profile-name">
							<p class="mb-0 d-none d-sm-block navbar-profile-name">{{ Session::get('users.first_name')}} {{ Session::get('users.last_name')}}</p>
							<p class="mb-0 d-none d-sm-block navbar-profile-name" style="font-weight: 100; color: blue;">@if(Session::get('users.usertype')=='1')Admin @else Employee @endif</p>
						</div>
						<i class="mdi mdi-menu-down d-none d-sm-block"></i>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
					<div class="dropdown-divider"></div>
					<a class="dropdown-item preview-item"
						href="{{ route('user.logout') }}"
						onclick="return confirm('Are you sure you want to logout?')">

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


<script>
    var notificationDiv = document.getElementById('notification-count');
    var notificationCount = notificationDiv.textContent || 0;
    var notificationAudio = new Audio("{{ asset('admin/positive-notification.mp3') }}");
    let audioUnlocked = false;

    // Unlock browser audio after first click
    document.addEventListener('click', function () {
        notificationAudio.play()
            .then(() => {
                notificationAudio.pause();
                notificationAudio.currentTime = 0;
                audioUnlocked = true;
                console.log('Audio unlocked');
            })
            .catch(err => console.log(err));
    }, { once: true });


    setInterval(function () {
        $.ajax({
            url: "{{ route('user.notification.count') }}",
            method: 'GET',
            success: function (data) {
                if (data.count > 0 && data.status == true) {
                    notificationDiv.textContent = data.count;
                    notificationDiv.style.display = 'block';
                    if (notificationCount != data.count) {
                        notificationCount = data.count;
                        if (audioUnlocked) {
                            notificationAudio.currentTime = 0;
                            notificationAudio.play().catch(err => console.log('Audio play blocked:', err));
                        }
                    }
                } else {
                    notificationDiv.style.display = 'none';
                }
            }
        });
    }, 10000);
</script>