<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — RMS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">
    
    <!-- Icons & CSS -->
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
    </style>

    @stack('styles')
</head>

<body>
<script>
(() => {
    const getStoredTheme = () => localStorage.getItem('theme');
    const getPreferredTheme = () => {
        const storedTheme = getStoredTheme();
        if (storedTheme) return storedTheme;
        return window.matchMedia('(prefers-color-scheme: dark)').matches
               ? 'dark' : 'light';
    };
    document.documentElement.setAttribute(
        'data-bs-theme', getPreferredTheme());
})();

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
           href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('vendor/dasher/assets/images/brand/logo/logo-icon.svg') }}"
                 alt="" width="28">
            <span class="fw-bold fs-5 site-logo-text">RMS Admin</span>
        </a>
    </div>

    <!-- NEW SIDEBAR STRUCTURE START -->
    <ul class="navbar-nav flex-column">

        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active':'' }}"
               href="{{ route('admin.dashboard') }}">
                <span class="nav-icon"><i class="ti ti-layout-dashboard"></i></span>
                <span class="text">Dashboard</span>
            </a>
        </li>

        <!-- Management heading -->
        <li class="nav-item">
            <div class="nav-heading">Management</div>
            <hr class="mx-5 nav-line mb-1">
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active':'' }}"
               href="{{ route('admin.orders.index') }}">
                <span class="nav-icon"><i class="ti ti-shopping-cart"></i></span>
                <span class="text">Orders</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.reservations*') ? 'active':'' }}"
               href="{{ route('admin.reservations.index') }}">
                <span class="nav-icon"><i class="ti ti-calendar"></i></span>
                <span class="text">Reservations</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.tables*') ? 'active':'' }}"
               href="{{ route('admin.tables.index') }}">
                <span class="nav-icon"><i class="ti ti-armchair"></i></span>
                <span class="text">Tables</span>
            </a>
        </li>

        <!-- Menu heading -->
        <li class="nav-item">
            <div class="nav-heading">Menu</div>
            <hr class="mx-5 nav-line mb-1">
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.categories*') ? 'active':'' }}"
               href="{{ route('admin.categories.index') }}">
                <span class="nav-icon"><i class="ti ti-list"></i></span>
                <span class="text">Categories</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.menu*') ? 'active':'' }}"
               href="{{ route('admin.menu.index') }}">
                <span class="nav-icon"><i class="ti ti-tools-kitchen-2"></i></span>
                <span class="text">Menu Items</span>
            </a>
        </li>

        <!-- Reports heading -->
        <li class="nav-item">
            <div class="nav-heading">Reports</div>
            <hr class="mx-5 nav-line mb-1">
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.reports') ? 'active':'' }}"
               href="{{ route('admin.reports') }}">
                <span class="nav-icon"><i class="ti ti-chart-bar"></i></span>
                <span class="text">Analytics</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.reports.daily*') ? 'active':'' }}"
               href="{{ route('admin.reports.daily') }}">
                <span class="nav-icon"><i class="ti ti-calendar-stats"></i></span>
                <span class="text">Daily Report</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.coupons*') ? 'active':'' }}"
               href="{{ route('admin.coupons.index') }}">
                <span class="nav-icon"><i class="ti ti-ticket"></i></span>
                <span class="text">Coupons</span>
            </a>
        </li>

        <!-- System heading -->
        <li class="nav-item">
            <div class="nav-heading">System</div>
            <hr class="mx-5 nav-line mb-1">
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active':'' }}"
               href="{{ route('admin.users.index') }}">
                <span class="nav-icon"><i class="ti ti-users"></i></span>
                <span class="text">Users</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.reviews*') ? 'active':'' }}"
               href="{{ route('admin.reviews.index') }}">
                <span class="nav-icon"><i class="ti ti-star"></i></span>
                <span class="text">Reviews</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.settings*') ? 'active':'' }}"
               href="{{ route('admin.settings') }}">
                <span class="nav-icon"><i class="ti ti-adjustments"></i></span>
                <span class="text">Settings</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('staff.dashboard') }}">
                <span class="nav-icon"><i class="ti ti-chef-hat"></i></span>
                <span class="text">Staff Panel</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}" target="_blank">
                <span class="nav-icon"><i class="ti ti-world"></i></span>
                <span class="text">View Website</span>
            </a>
        </li>
    </ul>
    <!-- NEW SIDEBAR STRUCTURE END -->

</div>
<!-- ══ END SIDEBAR ════════════════════════════════════ -->

<!-- ══ CONTENT ════════════════════════════════════════ -->
<div id="content" class="position-relative h-100">

    <!-- Topbar -->
    <div class="navbar-glass navbar navbar-expand-lg px-0 px-lg-4">
        <div class="container-fluid px-lg-0">
            <div class="d-flex align-items-center gap-3">

                <div class="d-block d-lg-none">
                    <a class="text-inherit" data-bs-toggle="offcanvas"
                       href="#adminMobileMenu" role="button">
                        <i class="ti ti-menu-2 fs-4"></i>
                    </a>
                </div>

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
                    @yield('page-title', 'Dashboard')
                </h6>
            </div>

            <ul class="list-unstyled d-flex align-items-center mb-0 gap-3">

                <!-- Dark Mode Toggle -->
                <li>
                    <button class="btn btn-sm btn-outline-secondary"
                            id="themeToggle" title="Toggle Theme">
                        <i class="ti ti-sun" id="themeIcon"></i>
                    </button>
                </li>

                <!-- Notification Bell -->
                <li class="dropdown">
                    <a href="#" class="position-relative"
                       data-bs-toggle="dropdown">
                        <i class="ti ti-bell fs-5"></i>
                        @php
                            $pendingCount = \App\Models\Order::where('status','pending')->count();
                            $pendingRes   = \App\Models\Reservation::where('status','pending')->count();
                            $total        = $pendingCount + $pendingRes;
                        @endphp
                        @if($total > 0)
                        <span class="position-absolute top-0 start-100
                                     translate-middle badge rounded-pill bg-danger"
                              style="font-size:10px;">
                            {{ $total }}
                        </span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow border-0"
                         style="min-width:300px;">
                        <h6 class="dropdown-header fw-bold">Notifications</h6>

                        @if($pendingCount > 0)
                        <a class="dropdown-item py-2"
                           href="{{ route('admin.orders.index',
                                          ['status' => 'pending']) }}">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-warning-subtle rounded p-2">
                                    <i class="ti ti-shopping-cart text-warning"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold small">
                                        {{ $pendingCount }} Pending Orders
                                    </div>
                                    <div class="text-muted" style="font-size:11px;">
                                        Waiting to be processed
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endif

                        @if($pendingRes > 0)
                        <a class="dropdown-item py-2"
                           href="{{ route('admin.reservations.index') }}">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-info-subtle rounded p-2">
                                    <i class="ti ti-calendar text-info"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold small">
                                        {{ $pendingRes }} New Reservations
                                    </div>
                                    <div class="text-muted" style="font-size:11px;">
                                        Waiting for confirmation
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endif

                        @if($total === 0)
                        <div class="dropdown-item text-center text-muted py-3">
                            <i class="ti ti-check-circle text-success d-block
                                       fs-4 mb-1"></i>
                            All caught up!
                        </div>
                        @endif

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-center small text-primary"
                           href="{{ route('admin.orders.index') }}">
                            View All Orders
                        </a>
                    </div>
                </li>

                <!-- User dropdown -->
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
                            <div class="text-muted" style="font-size:11px;">
                                Administrator
                            </div>
                        </div>
                        <i class="ti ti-chevron-down text-muted small"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li>
                            <span class="dropdown-item-text small text-muted">
                                {{ auth()->user()->email }}
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item"
                               href="{{ route('admin.users.edit',
                                             auth()->user()) }}">
                                <i class="ti ti-user me-2"></i>My Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger"
                                        type="submit">
                                    <i class="ti ti-logout me-2"></i>Logout
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
            <i class="ti ti-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3">
            <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')

    </div>

</div>
<!-- ══ END CONTENT ════════════════════════════════════ -->

<!-- Mobile Offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="adminMobileMenu">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold">RMS Admin</h5>
        <button type="button" class="btn-close"
                data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <ul class="navbar-nav flex-column p-3 gap-1">
            
            <!-- Dashboard -->
            <li><a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="ti ti-layout-dashboard me-2"></i>Dashboard</a></li>

            <!-- Management -->
            <li><h6 class="px-3 mt-2 mb-1 text-muted text-uppercase fw-bold fs-7" style="font-size: 0.75rem;">Management</h6></li>
            <li><a class="nav-link" href="{{ route('admin.orders.index') }}">
                <i class="ti ti-shopping-cart me-2"></i>Orders</a></li>
            <li><a class="nav-link" href="{{ route('admin.reservations.index') }}">
                <i class="ti ti-calendar me-2"></i>Reservations</a></li>
            <li><a class="nav-link" href="{{ route('admin.tables.index') }}">
                <i class="ti ti-armchair me-2"></i>Tables</a></li>

            <!-- Menu -->
            <li><h6 class="px-3 mt-2 mb-1 text-muted text-uppercase fw-bold fs-7" style="font-size: 0.75rem;">Menu</h6></li>
            <li><a class="nav-link" href="{{ route('admin.categories.index') }}">
                <i class="ti ti-list me-2"></i>Categories</a></li>
            <li><a class="nav-link" href="{{ route('admin.menu.index') }}">
                <i class="ti ti-tools-kitchen-2 me-2"></i>Menu Items</a></li>
            
            <!-- Reports -->
            <li><h6 class="px-3 mt-2 mb-1 text-muted text-uppercase fw-bold fs-7" style="font-size: 0.75rem;">Reports</h6></li>
            <li><a class="nav-link" href="{{ route('admin.reports') }}">
                <i class="ti ti-chart-bar me-2"></i>Analytics</a></li>
            <li><a class="nav-link" href="{{ route('admin.reports.daily') }}">
                <i class="ti ti-calendar-stats me-2"></i>Daily Report</a></li>
            <li><a class="nav-link" href="{{ route('admin.coupons.index') }}">
                <i class="ti ti-ticket me-2"></i>Coupons</a></li>

            <!-- System -->
            <li><h6 class="px-3 mt-2 mb-1 text-muted text-uppercase fw-bold fs-7" style="font-size: 0.75rem;">System</h6></li>
            <li><a class="nav-link" href="{{ route('admin.users.index') }}">
                <i class="ti ti-users me-2"></i>Users</a></li>
            <li><a class="nav-link" href="{{ route('admin.reviews.index') }}">
                <i class="ti ti-star me-2"></i>Reviews</a></li>
            <li><a class="nav-link" href="{{ route('admin.settings') }}">
                <i class="ti ti-adjustments me-2"></i>Settings</a></li>

            <li><hr class="my-2"></li>
            <li><a class="nav-link" href="{{ route('staff.dashboard') }}">
                <i class="ti ti-chef-hat me-2"></i>Staff Panel</a></li>
        </ul>
    </div>
</div>

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
        if (sidebar) sidebar.style.height = window.innerHeight + 'px';
    }
    setSidebarHeight();
    window.addEventListener('resize', setSidebarHeight);

    // Dark mode toggle
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon   = document.getElementById('themeIcon');

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-bs-theme', theme);
        localStorage.setItem('theme', theme);
        themeIcon.className = theme === 'dark'
                              ? 'ti ti-moon' : 'ti ti-sun';
    }

    const savedTheme = localStorage.getItem('theme') || 'light';
    applyTheme(savedTheme);

    themeToggle?.addEventListener('click', () => {
        const current = localStorage.getItem('theme') || 'light';
        applyTheme(current === 'light' ? 'dark' : 'light');
    });

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