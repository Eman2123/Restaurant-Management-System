@extends('layouts.customer')
@section('title', 'My Profile')

@section('content')
<div style="padding-top:100px; background:#0d0d0d; min-height:100vh;">
    <div class="container py-5">

        <!-- Header -->
        <div class="text-center mb-5">
            <p style="color:#c8a951; letter-spacing:4px; font-size:11px;
                      text-transform:uppercase; margin-bottom:15px;
                      display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-cog" style="margin-right:10px; font-size:13px;"></i>
                Account Settings
            </p>
            <h2 style="font-family:'Playfair Display',serif;
                       color:#fff; font-size:42px; font-weight:400;">
                My Profile
            </h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-7">

                @if(session('success'))
                <div style="background:rgba(25,135,84,0.15);
                            border-left:4px solid #198754;
                            color:#198754; padding:16px 18px;
                            margin-bottom:25px; border-radius:4px;
                            display:flex; align-items:center;">
                    <i class="fas fa-check-circle" style="margin-right:12px; font-size:18px;"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div style="background:rgba(220,53,69,0.15);
                            border-left:4px solid #dc3545;
                            color:#dc3545; padding:16px 18px;
                            margin-bottom:25px; border-radius:4px;">
                    <div style="display:flex; align-items:center; margin-bottom:8px;">
                        <i class="fas fa-exclamation-circle" style="margin-right:10px; font-size:18px;"></i>
                        <strong>Please fix the following:</strong>
                    </div>
                    @foreach($errors->all() as $e)
                    <div style="margin-left:28px; font-size:13px; margin-top:6px;">
                        • {{ $e }}
                    </div>
                    @endforeach
                </div>
                @endif

                <form method="POST"
                      action="{{ route('customer.profile.update') }}">
                    @csrf

                    <!-- Personal Info -->
                    <div style="background:#1a1a1a;
                                border:1px solid #2a2a2a;
                                padding:30px; margin-bottom:25px;
                                border-radius:8px;">
                        <h5 style="color:#c8a951; font-size:11px;
                                    letter-spacing:3px;
                                    text-transform:uppercase;
                                    margin-bottom:25px; font-weight:600;
                                    display:flex; align-items:center;">
                            <i class="fas fa-user-circle" style="margin-right:10px; font-size:14px;"></i>
                            Personal Information
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label style="color:#888; font-size:11px;
                                              letter-spacing:2px;
                                              text-transform:uppercase;
                                              display:block;
                                              margin-bottom:8px; font-weight:600;">
                                    <i class="fas fa-user" style="margin-right:6px; color:#c8a951;"></i>
                                    Full Name *
                                </label>
                                <input type="text" name="name"
                                       value="{{ old('name', $user->name) }}"
                                       style="width:100%; background:#111;
                                              border:1px solid #333;
                                              color:#fff; padding:12px;
                                              font-size:14px; outline:none;
                                              border-radius:4px;
                                              transition:border-color 0.2s ease;"
                                       required
                                       onfocus="this.style.borderColor='#c8a951'; this.style.boxShadow='0 0 0 2px rgba(200,169,81,0.1)';"
                                       onblur="this.style.borderColor='#333'; this.style.boxShadow='none';">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label style="color:#888; font-size:11px;
                                              letter-spacing:2px;
                                              text-transform:uppercase;
                                              display:block;
                                              margin-bottom:8px; font-weight:600;">
                                    <i class="fas fa-phone" style="margin-right:6px; color:#c8a951;"></i>
                                    Phone Number
                                </label>
                                <input type="text" name="phone"
                                       value="{{ old('phone', $user->phone) }}"
                                       placeholder="+92 300 1234567"
                                       style="width:100%; background:#111;
                                              border:1px solid #333;
                                              color:#fff; padding:12px;
                                              font-size:14px; outline:none;
                                              border-radius:4px;
                                              transition:border-color 0.2s ease;"
                                       onfocus="this.style.borderColor='#c8a951'; this.style.boxShadow='0 0 0 2px rgba(200,169,81,0.1)';"
                                       onblur="this.style.borderColor='#333'; this.style.boxShadow='none';">
                            </div>
                            <div class="col-12 mb-2">
                                <label style="color:#888; font-size:11px;
                                              letter-spacing:2px;
                                              text-transform:uppercase;
                                              display:block;
                                              margin-bottom:8px; font-weight:600;">
                                    <i class="fas fa-envelope" style="margin-right:6px; color:#c8a951;"></i>
                                    Email Address *
                                </label>
                                <input type="email" name="email"
                                       value="{{ old('email', $user->email) }}"
                                       style="width:100%; background:#111;
                                              border:1px solid #333;
                                              color:#fff; padding:12px;
                                              font-size:14px; outline:none;
                                              border-radius:4px;
                                              transition:border-color 0.2s ease;"
                                       required
                                       onfocus="this.style.borderColor='#c8a951'; this.style.boxShadow='0 0 0 2px rgba(200,169,81,0.1)';"
                                       onblur="this.style.borderColor='#333'; this.style.boxShadow='none';">
                            </div>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div style="background:#1a1a1a;
                                border:1px solid #2a2a2a;
                                padding:30px; margin-bottom:25px;
                                border-radius:8px;">
                        <h5 style="color:#c8a951; font-size:11px;
                                    letter-spacing:3px;
                                    text-transform:uppercase;
                                    margin-bottom:8px; font-weight:600;
                                    display:flex; align-items:center;">
                            <i class="fas fa-lock" style="margin-right:10px; font-size:14px;"></i>
                            Change Password
                        </h5>
                        <p style="color:#666; font-size:12px;
                                   margin-bottom:25px; display:flex;
                                   align-items:center;">
                            <i class="fas fa-info-circle" style="margin-right:8px; color:#c8a951; font-size:11px;"></i>
                            Leave blank to keep current password
                        </p>

                        <div class="row">
                            <div class="col-12 mb-4">
                                <label style="color:#888; font-size:11px;
                                              letter-spacing:2px;
                                              text-transform:uppercase;
                                              display:block;
                                              margin-bottom:8px; font-weight:600;">
                                    <i class="fas fa-key" style="margin-right:6px; color:#c8a951;"></i>
                                    Current Password
                                </label>
                                <input type="password"
                                       name="current_password"
                                       placeholder="Enter current password"
                                       style="width:100%; background:#111;
                                              border:1px solid #333;
                                              color:#fff; padding:12px;
                                              font-size:14px; outline:none;
                                              border-radius:4px;
                                              transition:border-color 0.2s ease;"
                                       onfocus="this.style.borderColor='#c8a951'; this.style.boxShadow='0 0 0 2px rgba(200,169,81,0.1)';"
                                       onblur="this.style.borderColor='#333'; this.style.boxShadow='none';">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label style="color:#888; font-size:11px;
                                              letter-spacing:2px;
                                              text-transform:uppercase;
                                              display:block;
                                              margin-bottom:8px; font-weight:600;">
                                    <i class="fas fa-shield-alt" style="margin-right:6px; color:#c8a951;"></i>
                                    New Password
                                </label>
                                <input type="password" name="password"
                                       placeholder="Min 6 characters"
                                       style="width:100%; background:#111;
                                              border:1px solid #333;
                                              color:#fff; padding:12px;
                                              font-size:14px; outline:none;
                                              border-radius:4px;
                                              transition:border-color 0.2s ease;"
                                       onfocus="this.style.borderColor='#c8a951'; this.style.boxShadow='0 0 0 2px rgba(200,169,81,0.1)';"
                                       onblur="this.style.borderColor='#333'; this.style.boxShadow='none';">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label style="color:#888; font-size:11px;
                                              letter-spacing:2px;
                                              text-transform:uppercase;
                                              display:block;
                                              margin-bottom:8px; font-weight:600;">
                                    <i class="fas fa-check-square" style="margin-right:6px; color:#c8a951;"></i>
                                    Confirm Password
                                </label>
                                <input type="password"
                                       name="password_confirmation"
                                       placeholder="Repeat new password"
                                       style="width:100%; background:#111;
                                              border:1px solid #333;
                                              color:#fff; padding:12px;
                                              font-size:14px; outline:none;
                                              border-radius:4px;
                                              transition:border-color 0.2s ease;"
                                       onfocus="this.style.borderColor='#c8a951'; this.style.boxShadow='0 0 0 2px rgba(200,169,81,0.1)';"
                                       onblur="this.style.borderColor='#333'; this.style.boxShadow='none';">
                            </div>
                        </div>
                    </div>

                    <!-- Account Info -->
                    <div style="background:linear-gradient(135deg, #1a1a1a 0%, #242424 100%);
                                border:1px solid #2a2a2a;
                                padding:25px 30px;
                                margin-bottom:30px; border-radius:8px;">
                        <h5 style="color:#c8a951; font-size:11px;
                                    letter-spacing:3px;
                                    text-transform:uppercase;
                                    margin-bottom:20px; font-weight:600;
                                    display:flex; align-items:center;">
                            <i class="fas fa-info-circle" style="margin-right:10px; font-size:14px;"></i>
                            Account Information
                        </h5>
                        <div class="row" style="color:#888; font-size:13px;">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div style="background:#111; padding:15px;
                                            border-radius:4px; border:1px solid #333;
                                            text-align:center;">
                                    <div style="color:#777; font-size:11px;
                                                text-transform:uppercase;
                                                letter-spacing:2px; margin-bottom:8px;
                                                display:flex; align-items:center;
                                                justify-content:center;">
                                        <i class="fas fa-id-badge" style="margin-right:6px;"></i>
                                        Account Type
                                    </div>
                                    <div style="color:#c8a951; font-weight:600; font-size:14px;">
                                        {{ ucfirst($user->role) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div style="background:#111; padding:15px;
                                            border-radius:4px; border:1px solid #333;
                                            text-align:center;">
                                    <div style="color:#777; font-size:11px;
                                                text-transform:uppercase;
                                                letter-spacing:2px; margin-bottom:8px;
                                                display:flex; align-items:center;
                                                justify-content:center;">
                                        <i class="fas fa-calendar-check" style="margin-right:6px;"></i>
                                        Member Since
                                    </div>
                                    <div style="color:#ddd; font-weight:500; font-size:14px;">
                                        {{ $user->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div style="background:#111; padding:15px;
                                            border-radius:4px; border:1px solid #333;
                                            text-align:center;">
                                    <div style="color:#777; font-size:11px;
                                                text-transform:uppercase;
                                                letter-spacing:2px; margin-bottom:8px;
                                                display:flex; align-items:center;
                                                justify-content:center;">
                                        <i class="fas fa-receipt" style="margin-right:6px;"></i>
                                        Total Orders
                                    </div>
                                    <div style="color:#198754; font-weight:700; font-size:20px;">
                                        {{ $user->orders()->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                            style="width:100%; background:#c8a951;
                                   color:#000; border:none; padding:16px;
                                   font-size:12px; font-weight:700;
                                   letter-spacing:3px;
                                   text-transform:uppercase;
                                   cursor:pointer; border-radius:4px;
                                   transition:all 0.3s ease;
                                   display:flex; align-items:center;
                                   justify-content:center;"
                            onmouseover="this.style.background='#d4b86a'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(200,169,81,0.3)';"
                            onmouseout="this.style.background='#c8a951'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <i class="fas fa-save" style="margin-right:10px;"></i>
                        Save Changes
                    </button>

                </form>

            </div>
        </div>
    </div>
</div>

<!-- Ensure Font Awesome is loaded -->
@if(!View::hasSection('styles'))
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endif

@endsection