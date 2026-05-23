<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Staff') — RMS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.css">
    <link rel="stylesheet"
          href="{{ asset('vendor/dasher/assets/css/theme.css') }}">

    <style>
        .badge-pending   { background:#ffc107 !important; color:#000 !important; }
        .badge-cooking   { background:#fd7e14 !important; color:#fff !important; }
        .badge-ready     { background:#198754 !important; color:#fff !important; }
        .badge-served    { background:#6c757d !important; color:#fff !important; }
        .badge-cancelled { background:#dc3545 !important; color:#fff !important; }
        .order-card-pending { border-left: 4px solid #ffc107 !important; }
        .order-card-cooking { border-left: 4px solid #fd7e14 !important; }
        .order-card-ready   { border-left: 4px solid #198754 !important; }
    </style>

    @stack('styles')
</head>

<body>
<script>
    if (localStorage.getItem('sidebarExpanded') === 'false') {
        document.documentElement.classList.add('collapsed');
        document.documentElement.classList.remove('expanded');
    } else {
        document.documentElement.classList.remove('collapsed');
        document.documentElement.classList.add('expanded');
    }
</script>

<!-- ══ SIDEBAR ════════════════════════════════════════ -->
<div id="miniSidebar">
    <div class="brand-logo">
        <a class="d-flex align-items-center gap-2"
           href="{{ route('staff.dashboard') }}">
            <img src="{{ asset('vendor/dasher/assets/images/brand/logo/logo-icon.svg') }}"
                 alt="" width="28">
            <span class="fw-bold fs-5 site-logo-text">Chef Panel</span>
        </a>
    </div>

    <ul class="navbar-nav flex-column">

        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('staff.dashboard')
                                   ? 'active' : '' }}"
               href="{{ route('staff.dashboard') }}">
                <span class="nav-icon">
                    <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="text">Dashboard</span>
            </a>
        </li>

        <!-- Kitchen Heading -->
        <li class="nav-item">
            <div class="nav-heading">Kitchen</div>
            <hr class="mx-5 nav-line mb-1">
        </li>

        <!-- Live Orders -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('staff.orders*')
                                   ? 'active' : '' }}"
               href="{{ route('staff.orders.index') }}">
                <span class="nav-icon">
                    <i class="ti ti-shopping-cart"></i>
                </span>
                <span class="text">Live Orders</span>
            </a>
        </li>

        <!-- Kitchen Display (Added) -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('staff.kitchen*') ? 'active' : '' }}"
               href="{{ route('staff.kitchen') }}">
                <span class="nav-icon">
                    <i class="ti ti-device-desktop"></i>
                </span>
                <span class="text">Kitchen Display</span>
            </a>
        </li>

        <!-- Navigation Heading -->
        <li class="nav-item">
            <div class="nav-heading">Navigation</div>
            <hr class="mx-5 nav-line mb-1">
        </li>

        <!-- Admin Panel (only for admin role) -->
        @if(auth()->user()->role === 'admin')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <span class="nav-icon">
                    <i class="ti ti-settings"></i>
                </span>
                <span class="text">Admin Panel</span>
            </a>
        </li>
        @endif

        <!-- View Website -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}" target="_blank">
                <span class="nav-icon">
                    <i class="ti ti-world"></i>
                </span>
                <span class="text">View Website</span>
            </a>
        </li>

    </ul>
</div>
<!-- ══ END SIDEBAR ════════════════════════════════════ -->

<!-- ══ CONTENT ════════════════════════════════════════ -->
<div id="content" class="position-relative h-100">

    <!-- Topbar -->
    <div class="navbar-glass navbar navbar-expand-lg px-0 px-lg-4">
        <div class="container-fluid px-lg-0">
            <div class="d-flex align-items-center gap-3">

                <!-- Mobile toggle -->
                <div class="d-block d-lg-none">
                    <a class="text-inherit"
                       data-bs-toggle="offcanvas"
                       href="#staffMobileMenu" role="button">
                        <i class="ti ti-menu-2 fs-4"></i>
                    </a>
                </div>

                <!-- Desktop sidebar toggle -->
                <div class="d-none d-lg-block">
                    <a class="sidebar-toggle d-flex p-2"
                       href="javascript:void(0)">
                        <span class="collapse-mini">
                            <i class="ti ti-arrow-bar-left fs-5
                                      text-secondary"></i>
                        </span>
                        <span class="collapse-expanded">
                            <i class="ti ti-arrow-bar-right fs-5
                                      text-secondary"></i>
                        </span>
                    </a>
                </div>

                <h6 class="mb-0 d-none d-lg-block fw-semibold">
                    @yield('page-title', 'Kitchen Dashboard')
                </h6>

                <!-- Live Badge -->
                <span class="badge bg-danger">
                    <i class="ti ti-circle-filled me-1"
                       style="font-size:8px;"></i>
                    LIVE
                </span>
            </div>

            <!-- Right Items -->
            <ul class="list-unstyled d-flex align-items-center
                        mb-0 gap-3">

                <!-- Auto Refresh Badge -->
                <li>
                    <span class="badge bg-success-subtle text-success">
                        <i class="ti ti-refresh me-1"></i>
                        Auto Refresh: ON
                    </span>
                </li>

                <!-- Pending Orders Count -->
                @php
                    $pendingCount = \App\Models\Order::where('status','pending')->count();
                @endphp
                @if($pendingCount > 0)
                <li>
                    <a href="{{ route('staff.orders.index') }}"
                       class="badge bg-warning text-dark text-decoration-none">
                        {{ $pendingCount }} Pending
                    </a>
                </li>
                @endif

                <!-- User Dropdown -->
                <li class="dropdown">
                    <a href="#"
                       class="d-flex align-items-center gap-2
                              text-decoration-none"
                       data-bs-toggle="dropdown">
                        <img src="{{ asset('vendor/dasher/assets/images/avatar/avatar.jpg') }}"
                             class="rounded-circle"
                             width="36" height="36" alt="">
                        <div class="d-none d-lg-block lh-1">
                            <div class="fw-semibold small">
                                {{ auth()->user()->name }}
                            </div>
                            <div class="text-muted"
                                 style="font-size:11px;">
                                {{ ucfirst(auth()->user()->role) }}
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end
                               shadow border-0">
                        <li>
                            <span class="dropdown-item-text small
                                         text-muted">
                                {{ auth()->user()->email }}
                            </span>
                        </li>
                        
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST"
                                  action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger"
                                        type="submit">
                                    <i class="ti ti-logout me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
    <!-- End Topbar -->

    <!-- Page Content -->
    <div class="custom-container">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3">
            <i class="ti ti-circle-check me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3">
            <i class="ti ti-alert-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')

    </div>
    <!-- End Page Content -->

</div>
<!-- ══ END CONTENT ════════════════════════════════════ -->

<!-- Mobile Offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1"
     id="staffMobileMenu">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold">Chef Panel</h5>
        <button type="button" class="btn-close"
                data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <ul class="navbar-nav flex-column p-3 gap-1">
            <li>
                <a class="nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}"
                   href="{{ route('staff.dashboard') }}">
                    <i class="ti ti-layout-dashboard me-2"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a class="nav-link {{ request()->routeIs('staff.orders*') ? 'active' : '' }}"
                   href="{{ route('staff.orders.index') }}">
                    <i class="ti ti-shopping-cart me-2"></i>
                    Live Orders
                </a>
            </li>
            <li>
                <a class="nav-link {{ request()->routeIs('staff.kitchen*') ? 'active' : '' }}"
                   href="{{ route('staff.kitchen') }}">
                    <i class="ti ti-device-desktop me-2"></i>
                    Kitchen Display
                </a>
            </li>
            @if(auth()->user()->role === 'admin')
            <li>
                <a class="nav-link"
                   href="{{ route('admin.dashboard') }}">
                    <i class="ti ti-settings me-2"></i>
                    Admin Panel
                </a>
            </li>
            @endif
            <li>
                <a class="nav-link"
                   href="{{ route('home') }}" target="_blank">
                    <i class="ti ti-world me-2"></i>
                    View Website
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // Sidebar toggle
    document.querySelectorAll('.sidebar-toggle').forEach((btn) => {
        btn.addEventListener('click', () => {
            if (localStorage.getItem('sidebarExpanded') === 'false') {
                document.documentElement.classList.remove('collapsed');
                document.documentElement.classList.add('expanded');
                localStorage.setItem('sidebarExpanded', 'true');
            } else {
                document.documentElement.classList.add('collapsed');
                document.documentElement.classList.remove('expanded');
                localStorage.setItem('sidebarExpanded', 'false');
            }
        });
    });

    // Sidebar height
    function setSidebarHeight() {
        const sidebar = document.getElementById('miniSidebar');
        if (sidebar) {
            sidebar.style.height = window.innerHeight + 'px';
        }
    }
    setSidebarHeight();
    window.addEventListener('resize', setSidebarHeight);

    // Auto refresh every 30 seconds
    setTimeout(function() {
        location.reload();
    }, 30000);

    // Auto hide alerts
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        });
    }, 4000);

});
</script>

@stack('scripts')
</body>
</html>