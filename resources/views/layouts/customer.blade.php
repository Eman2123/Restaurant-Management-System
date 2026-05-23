<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'The Venue Restaurant')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700|Raleway:300,400,500,600,700" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css"/>

    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>

    <!-- TheVenue Main CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/thevenue/styles/style.css') }}"/>

    <style>
        .navbar-custom {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 9999;
            padding: 20px 0;
            transition: all 0.3s ease;
            background: transparent;
        }
        .navbar-custom.scrolled {
            background: rgba(0,0,0,0.95) !important;
            padding: 10px 0;
        }
        .navbar-custom .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            color: #fff !important;
            letter-spacing: 2px;
        }
        .navbar-custom .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-family: 'Raleway', sans-serif;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 8px 15px !important;
            transition: color 0.3s;
        }
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: #c8a951 !important;
        }
        .btn-order-now {
            color: #c8a951 !important;
            font-weight: 700 !important;
            font-size: 12px !important;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 8px 15px !important;
            transition: all 0.3s;
        }
        .btn-order-now:hover {
            color: #fff !important;
            background: #c8a951;
            border-radius: 4px;
        }
        .btn-reservation {
            border: 1px solid #fff;
            color: #fff !important;
            font-size: 11px;
            letter-spacing: 1px;
            padding: 10px 20px !important;
            transition: all 0.3s;
        }
        .btn-reservation:hover {
            background: #c8a951;
            border-color: #c8a951;
        }
        .dropdown-menu-dark {
            background: #111;
            border: 1px solid #333;
            border-radius: 0;
        }
        .dropdown-menu-dark .dropdown-item {
            color: #ccc;
            font-size: 13px;
            padding: 8px 20px;
        }
        .dropdown-menu-dark .dropdown-item:hover {
            background: #c8a951;
            color: #000;
        }
        .dropdown-menu-dark .dropdown-divider {
            border-color: #333;
        }
        .dropdown-toggle::after {
            margin-left: 6px;
        }
        body { overflow-x: hidden; }
    </style>

    @stack('styles')
</head>
<body>

<!-- ══ Navigation ══════════════════════════════════════════ -->
<nav class="navbar navbar-expand-lg navbar-custom" id="mainNav">
    <div class="container">

        <a class="navbar-brand" href="{{ route('home') }}">
            The Venue<br>
            <small style="font-size:12px; letter-spacing:4px;
                          font-family:'Raleway',sans-serif;
                          font-weight:300;">RESTAURANT</small>
        </a>

        <button class="navbar-toggler" type="button"
                data-toggle="collapse" data-target="#navbarNav"
                style="border-color:rgba(255,255,255,0.3);">
            <span style="color:#fff;"><i class="fas fa-bars"></i></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('menu*') ? 'active' : '' }}"
                       href="{{ route('menu') }}">MENU</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reservation*') ? 'active' : '' }}"
                       href="{{ route('reservation.create') }}">RESERVATIONS</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto align-items-center">
                @auth
                    <!-- Order Now Button -->
                    <li class="nav-item">
                        <a class="nav-link btn-order-now {{ request()->routeIs('customer.order*') ? 'active' : '' }}"
                           href="{{ route('customer.order.create') }}">
                            ORDER NOW
                        </a>
                    </li>

                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#"
                           data-toggle="dropdown">
                            <i class="fas fa-user-circle mr-1"></i>
                            {{ auth()->user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-dark dropdown-menu-right">
                            <a class="dropdown-item"
                               href="{{ route('customer.profile') }}">
                                <i class="fas fa-user-circle mr-2"></i>My Profile
                            </a>
                            <a class="dropdown-item"
                               href="{{ route('customer.order.create') }}">
                                <i class="fas fa-utensils mr-2"></i>Place Order
                            </a>
                            <a class="dropdown-item"
                               href="{{ route('customer.orders') }}">
                                <i class="fas fa-shopping-bag mr-2"></i>My Orders
                            </a>
                            <a class="dropdown-item"
                               href="{{ route('customer.reservations') }}">
                                <i class="fas fa-calendar mr-2"></i>My Reservations
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item"
                               href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-cog mr-2"></i>Admin Panel
                            </a>
                            @endif
                            @if(in_array(auth()->user()->role, ['admin','staff']))
                            <a class="dropdown-item"
                               href="{{ route('staff.dashboard') }}">
                                <i class="fas fa-tools mr-2"></i>Staff Panel
                            </a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger"
                                        type="submit">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">LOGIN</a>
                    </li>
                    <li class="nav-item ml-2">
                        <a class="nav-link btn-reservation"
                           href="{{ route('register') }}">
                            REGISTER
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Flash Messages -->
@if(session('success'))
<div style="position:fixed;top:80px;left:0;right:0;z-index:99999;">
    <div class="alert alert-success alert-dismissible fade show
                text-center mb-0 rounded-0">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        <button type="button" class="close"
                data-dismiss="alert">&times;</button>
    </div>
</div>
@endif

<!-- Page Content -->
@yield('content')

<!-- ══ Footer ══════════════════════════════════════════════ -->
@php
    $rName   = \App\Models\Setting::get('restaurant_name', 'The Restaurant');
    $rPhone  = \App\Models\Setting::get('restaurant_phone', '+92 300 1234567');
    $rEmail  = \App\Models\Setting::get('restaurant_email', 'info@restaurant.com');
    $rAddr   = \App\Models\Setting::get('restaurant_address', '123 Main Street');
    $rHours  = \App\Models\Setting::get('restaurant_hours', 'Daily: 12pm - 11pm');
    $fbUrl   = \App\Models\Setting::get('facebook_url', '#');
    $igUrl   = \App\Models\Setting::get('instagram_url', '#');
    $twUrl   = \App\Models\Setting::get('twitter_url', '#');
@endphp

<footer style="background:#0a0a0a; color:#666; padding:70px 0 30px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-5">
                <h4 style="font-family:'Playfair Display',serif;
                            color:#fff; font-size:28px; margin-bottom:20px;">
                    {{ $rName }}
                </h4>
                <p style="font-size:14px; line-height:2; color:#888;">
                    Experience fine dining at its best with fresh
                    ingredients and exquisite flavors in an elegant setting.
                </p>
                <div class="mt-4">
                    <a href="{{ $fbUrl }}" target="_blank" style="color:#c8a951; font-size:20px;
                                       margin-right:15px;">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="{{ $igUrl }}" target="_blank" style="color:#c8a951; font-size:20px;
                                       margin-right:15px;">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{ $twUrl }}" target="_blank" style="color:#c8a951; font-size:20px;">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 mb-5">
                <h6 style="color:#c8a951; letter-spacing:3px;
                            font-size:11px; margin-bottom:25px;">
                    QUICK LINKS
                </h6>
                <ul class="list-unstyled" style="font-size:14px;">
                    <li style="margin-bottom:12px;">
                        <a href="{{ route('home') }}"
                           style="color:#888; text-decoration:none;
                                  transition:color 0.3s;"
                           onmouseover="this.style.color='#c8a951'"
                           onmouseout="this.style.color='#888'">
                            Home
                        </a>
                    </li>
                    <li style="margin-bottom:12px;">
                        <a href="{{ route('menu') }}"
                           style="color:#888; text-decoration:none;"
                           onmouseover="this.style.color='#c8a951'"
                           onmouseout="this.style.color='#888'">
                            Our Menu
                        </a>
                    </li>
                    <li style="margin-bottom:12px;">
                        <a href="{{ route('reservation.create') }}"
                           style="color:#888; text-decoration:none;"
                           onmouseover="this.style.color='#c8a951'"
                           onmouseout="this.style.color='#888'">
                            Reservations
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 mb-5">
                <h6 style="color:#c8a951; letter-spacing:3px;
                            font-size:11px; margin-bottom:25px;">
                    FIND US
                </h6>
                <ul class="list-unstyled"
                    style="font-size:14px; color:#888; line-height:2.2;">
                    <li>
                        <i class="fas fa-map-marker-alt mr-2"
                           style="color:#c8a951;"></i>
                        {{ $rAddr }}
                    </li>
                    <li>
                        <i class="fas fa-phone mr-2"
                           style="color:#c8a951;"></i>
                        {{ $rPhone }}
                    </li>
                    <li>
                        <i class="fas fa-envelope mr-2"
                           style="color:#c8a951;"></i>
                        {{ $rEmail }}
                    </li>
                    <li>
                        <i class="fas fa-clock mr-2"
                           style="color:#c8a951;"></i>
                        {{ $rHours }}
                    </li>
                </ul>
            </div>
        </div>

        <hr style="border-color:#1a1a1a; margin:20px 0;">
        <p class="text-center mb-0"
           style="font-size:12px; color:#444; letter-spacing:1px;">
            &copy; {{ date('Y') }} {{ $rName }}. All Rights Reserved.
        </p>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
 $(window).scroll(function(){
    if($(this).scrollTop() > 50){
        $('#mainNav').addClass('scrolled')
                     .css('background','rgba(0,0,0,0.95)');
    } else {
        $('#mainNav').removeClass('scrolled')
                     .css('background','transparent');
    }
});

setTimeout(function(){
    $('.alert').fadeOut('slow');
}, 4000);
</script>
 
@stack('scripts')
</body>
</html>