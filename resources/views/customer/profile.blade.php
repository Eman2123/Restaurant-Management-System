@extends('layouts.customer')
@section('title', 'My Profile')

@section('content')
<div style="padding-top:100px; background:#0d0d0d; min-height:100vh;">
    <div class="container py-5">

        <div class="text-center mb-5">
            <p style="color:#c8a951; letter-spacing:4px; font-size:11px;
                      text-transform:uppercase; margin-bottom:15px;">
                Account Settings
            </p>
            <h2 style="font-family:'Playfair Display',serif;
                       color:#fff; font-size:42px;">
                My Profile
            </h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-7">

                @if(session('success'))
                <div style="background:rgba(25,135,84,0.1);
                            border:1px solid rgba(25,135,84,0.3);
                            color:#198754; padding:15px;
                            margin-bottom:25px; text-align:center;">
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div style="background:rgba(220,53,69,0.1);
                            border:1px solid rgba(220,53,69,0.3);
                            color:#dc3545; padding:15px;
                            margin-bottom:25px;">
                    @foreach($errors->all() as $e)
                    <div>{{ $e }}</div>
                    @endforeach
                </div>
                @endif

                <form method="POST"
                      action="{{ route('customer.profile.update') }}">
                    @csrf

                    <!-- Personal Info -->
                    <div style="background:#1a1a1a;
                                border:1px solid #2a2a2a;
                                padding:30px; margin-bottom:25px;">
                        <h5 style="color:#c8a951; font-size:11px;
                                    letter-spacing:3px;
                                    text-transform:uppercase;
                                    margin-bottom:25px;">
                            Personal Information
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label style="color:#888; font-size:11px;
                                              letter-spacing:2px;
                                              text-transform:uppercase;
                                              display:block;
                                              margin-bottom:8px;">
                                    Full Name *
                                </label>
                                <input type="text" name="name"
                                       value="{{ old('name', $user->name) }}"
                                       style="width:100%; background:#111;
                                              border:1px solid #333;
                                              color:#fff; padding:12px;
                                              font-size:14px; outline:none;"
                                       required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label style="color:#888; font-size:11px;
                                              letter-spacing:2px;
                                              text-transform:uppercase;
                                              display:block;
                                              margin-bottom:8px;">
                                    Phone Number
                                </label>
                                <input type="text" name="phone"
                                       value="{{ old('phone', $user->phone) }}"
                                       placeholder="+92 300 1234567"
                                       style="width:100%; background:#111;
                                              border:1px solid #333;
                                              color:#fff; padding:12px;
                                              font-size:14px; outline:none;">
                            </div>
                            <div class="col-12 mb-2">
                                <label style="color:#888; font-size:11px;
                                              letter-spacing:2px;
                                              text-transform:uppercase;
                                              display:block;
                                              margin-bottom:8px;">
                                    Email Address *
                                </label>
                                <input type="email" name="email"
                                       value="{{ old('email', $user->email) }}"
                                       style="width:100%; background:#111;
                                              border:1px solid #333;
                                              color:#fff; padding:12px;
                                              font-size:14px; outline:none;"
                                       required>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div style="background:#1a1a1a;
                                border:1px solid #2a2a2a;
                                padding:30px; margin-bottom:25px;">
                        <h5 style="color:#c8a951; font-size:11px;
                                    letter-spacing:3px;
                                    text-transform:uppercase;
                                    margin-bottom:5px;">
                            Change Password
                        </h5>
                        <p style="color:#555; font-size:12px;
                                   margin-bottom:25px;">
                            Leave blank to keep current password
                        </p>

                        <div class="row">
                            <div class="col-12 mb-4">
                                <label style="color:#888; font-size:11px;
                                              letter-spacing:2px;
                                              text-transform:uppercase;
                                              display:block;
                                              margin-bottom:8px;">
                                    Current Password
                                </label>
                                <input type="password"
                                       name="current_password"
                                       placeholder="Enter current password"
                                       style="width:100%; background:#111;
                                              border:1px solid #333;
                                              color:#fff; padding:12px;
                                              font-size:14px; outline:none;">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label style="color:#888; font-size:11px;
                                              letter-spacing:2px;
                                              text-transform:uppercase;
                                              display:block;
                                              margin-bottom:8px;">
                                    New Password
                                </label>
                                <input type="password" name="password"
                                       placeholder="Min 6 characters"
                                       style="width:100%; background:#111;
                                              border:1px solid #333;
                                              color:#fff; padding:12px;
                                              font-size:14px; outline:none;">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label style="color:#888; font-size:11px;
                                              letter-spacing:2px;
                                              text-transform:uppercase;
                                              display:block;
                                              margin-bottom:8px;">
                                    Confirm Password
                                </label>
                                <input type="password"
                                       name="password_confirmation"
                                       placeholder="Repeat new password"
                                       style="width:100%; background:#111;
                                              border:1px solid #333;
                                              color:#fff; padding:12px;
                                              font-size:14px; outline:none;">
                            </div>
                        </div>
                    </div>

                    <!-- Account Info -->
                    <div style="background:#1a1a1a;
                                border:1px solid #2a2a2a;
                                padding:20px 30px;
                                margin-bottom:25px;">
                        <div class="row" style="color:#888; font-size:13px;">
                            <div class="col-md-4">
                                <span style="color:#555; font-size:11px;
                                             text-transform:uppercase;
                                             letter-spacing:2px;">
                                    Account Type
                                </span><br>
                                <span style="color:#c8a951; font-weight:600;">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                            <div class="col-md-4">
                                <span style="color:#555; font-size:11px;
                                             text-transform:uppercase;
                                             letter-spacing:2px;">
                                    Member Since
                                </span><br>
                                <span style="color:#fff;">
                                    {{ $user->created_at->format('d M Y') }}
                                </span>
                            </div>
                            <div class="col-md-4">
                                <span style="color:#555; font-size:11px;
                                             text-transform:uppercase;
                                             letter-spacing:2px;">
                                    Total Orders
                                </span><br>
                                <span style="color:#fff;">
                                    {{ $user->orders()->count() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                            style="width:100%; background:#c8a951;
                                   color:#fff; border:none; padding:16px;
                                   font-size:12px; font-weight:700;
                                   letter-spacing:3px;
                                   text-transform:uppercase;
                                   cursor:pointer;">
                        Save Changes
                    </button>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection