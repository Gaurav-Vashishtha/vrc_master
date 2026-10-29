<style>
    .sidebar {
        overflow-y: scroll;
        height: 380px;
    }
</style>

<div class="container-scroller">
    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
            <a class="sidebar-brand brand-logo" href="{{url('admin/dashboard')}}"><img src="{{asset('images/brand/logo.png')}}" alt="Logo"></a>
            <a class="sidebar-brand brand-logo-mini" href="{{url('admin/dashboard')}}"><img src="{{asset('images/brand/mini-logo.png')}}" alt="Logo"></a>
        </div>
        <ul class="nav">
            <li class="nav-item nav-category">
                <!-- <span class="nav-link">Navigation</span> -->
            </li>

            <li class="nav-item menu-items">
                <a class="nav-link" href="{{url('admin/dashboard')}}">
                    <span class="menu-icon">
                        <i class="mdi mdi-speedometer"></i>
                    </span>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>


            {{-- Banner --}}
            {{--<li class="nav-item menu-items">
                <a class="nav-link" data-toggle="collapse" href="#bannerMenu" aria-expanded="false" aria-controls="bannerMenu">
                    <span class="menu-icon">
                        <i class="fa fa-picture-o"></i>
                    </span>
                    <span class="menu-title">Banner</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="bannerMenu">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="{{ url('admin/banner') }}">Banner</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/special-banner') }}">Special Banner</a></li>
        </ul>
</div>
</li>--}}

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('admin/users-list') }}">
        <span class="menu-icon">
            <i class="mdi mdi-account"></i>
        </span>
        <span class="menu-title">Users</span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('admin/user-logs') }}">
        <span class="menu-icon">
            <i class="mdi mdi-history"></i>
        </span>
        <span class="menu-title">Users log</span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('admin/contacts-list') }}">
        <span class="menu-icon">
            <i class="fa fa-phone"></i>
        </span>
        <span class="menu-title">Contacts List</span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('admin/mlm-queries') }}">
        <span class="menu-icon">
            <i class="mdi mdi-chart-line"></i>
        </span>
        <span class="menu-title">MLM Queries</span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ route('admin.chatbox.index') }}">
        <span class="menu-icon">
            <i class="mdi mdi-forum"></i>
        </span>
        <span class="menu-title">ChatBot Sessions</span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('admin/careers-list') }}">
        <span class="menu-icon">
            <i class="mdi mdi-briefcase"></i>
        </span>
        <span class="menu-title">Career</span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('admin/projects-list') }}">
        <span class="menu-icon">
            <i class="mdi mdi-rocket" style="color:red;"></i>
        </span>
        <span class="menu-title">Projects</span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('admin/websites-list') }}">
        <span class="menu-icon">
            <i class="mdi mdi-web"></i>
        </span>
        <span class="menu-title">Websites</span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('admin/servers-list') }}">
        <span class="menu-icon">
            <i class="mdi mdi-server"></i>
        </span>
        <span class="menu-title">Servers</span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ route('admin.attendance') }}">
        <span class="menu-icon">
            <i class="mdi mdi-calendar-check"></i>
        </span>
        <span class="menu-title">Attendance</span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('admin/work-reports-list') }}">
        <span class="menu-icon">
            <i class="mdi mdi-clipboard-text"></i>
        </span>
        <span class="menu-title">Work Reports</span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('admin/news') }}">
        <span class="menu-icon">
            <i class="mdi mdi-newspaper"></i>
        </span>
        <span class="menu-title">News</span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('admin/holiday-list') }}">
        <span class="menu-icon">
            <i class="mdi mdi-beach"></i>
        </span>
        <span class="menu-title">Holiday Leave</span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('admin/leave-list') }}">
        <span class="menu-icon">
            <i class="mdi mdi-beach"></i>
        </span>
        <span class="menu-title">Leave Apply </span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ route('admin.notes.index') }}">
        <span class="menu-icon">
            <i class="mdi mdi-calendar"></i>
        </span>
        <span class="menu-title">Notes</span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ route('admin.reminders') }}">
        <span class="menu-icon">
            <i class="mdi mdi-bell-outline"></i>
        </span>
        <span class="menu-title">Reminders</span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('admin/testimonials') }}">
        <span class="menu-icon">
            <i class="mdi mdi-comment-account"></i>
        </span>
        <span class="menu-title">Testimonials</span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" data-toggle="collapse" href="#ipoContactMenu" aria-expanded="false" aria-controls="ipoContactMenu">
        <span class="menu-icon">
            <i class="fa fa-envelope"></i>
        </span>
        <span class="menu-title">IPO Contact</span>
        <i class="menu-arrow"></i>
    </a>

    <div class="collapse" id="ipoContactMenu">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.ipo.contactus') }}">
                    Contact Us
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.ipo.contactusLanding') }}">
                    Contact Landing
                </a>
            </li>
        </ul>
    </div>
</li>


<li class="nav-item menu-items">
    <a class="nav-link" href="{{ route('admin.notifications.index') }}">
        <span class="menu-icon">
            <i class="mdi mdi-bell"></i>
        </span>
        <span class="menu-title">Notifications</span>
    </a>
</li>


<li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('admin/change-password') }}">
        <span class="menu-icon">
            <i class="mdi mdi-lock-reset"></i>
        </span>
        <span class="menu-title">Change Password</span>
    </a>
</li>

<li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('admin/admin-setting') }}">
        <span class="menu-icon">
            <i class="mdi mdi-beach"></i>
        </span>
        <span class="menu-title">Setting</span>
    </a>
</li>
{{-- Logout --}}
<li class="nav-item menu-items">
    <a class="nav-link" href="{{ url('admin/logout') }}">
        <span class="menu-icon">
            <i class="mdi mdi-logout text-danger"></i>
        </span>
        <span class="menu-title">Logout</span>
    </a>
</li>
</ul>
</nav>
<!-- partial -->