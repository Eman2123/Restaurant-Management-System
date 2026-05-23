@extends('layouts.customer')
@section('title', 'Book a Table')

@section('content')
<div style="padding-top:80px; background:#0d0d0d; min-height:100vh;">

    <!-- Header -->
    <div style="background:linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)),
                url('{{ asset('vendor/thevenue/images/reservations.jpg') }}')
                center/cover; padding:80px 0; text-align:center;">
        <p style="color:#c8a951; letter-spacing:4px; font-size:11px;
                  text-transform:uppercase; margin-bottom:15px;">
            Plan Your Visit
        </p>
        <h1 style="color:#fff; font-family:'Playfair Display',serif;
                   font-size:52px; font-weight:400;">
            Book a Table
        </h1>
    </div>

    <div class="container py-5">

        @guest
        <!-- Not logged in — show login prompt -->
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div style="background:#1a1a1a; border:1px solid #2a2a2a;
                            padding:60px 40px;">
                    <div style="font-size:60px; margin-bottom:20px;">🍽</div>
                    <h3 style="color:#fff; font-family:'Playfair Display',serif;
                                font-size:28px; margin-bottom:15px;">
                        Login Required
                    </h3>
                    <p style="color:#888; font-size:15px; line-height:1.8;
                               margin-bottom:30px;">
                        Please login or create an account to make a
                        reservation. It only takes a minute!
                    </p>
                    <div style="display:flex; gap:15px;
                                justify-content:center; flex-wrap:wrap;">
                        <a href="{{ route('login') }}"
                           style="display:inline-block; background:#c8a951;
                                  color:#fff; padding:14px 40px;
                                  text-decoration:none; font-size:11px;
                                  font-weight:700; letter-spacing:3px;
                                  text-transform:uppercase;">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                           style="display:inline-block;
                                  border:1px solid #c8a951;
                                  color:#c8a951; padding:14px 40px;
                                  text-decoration:none; font-size:11px;
                                  font-weight:700; letter-spacing:3px;
                                  text-transform:uppercase;">
                            Register Free
                        </a>
                    </div>
                    <div style="margin-top:25px; padding-top:25px;
                                border-top:1px solid #2a2a2a;">
                        <p style="color:#555; font-size:13px; margin:0;">
                            Benefits of registering:
                        </p>
                        <div style="display:flex; flex-wrap:wrap; gap:10px;
                                    justify-content:center; margin-top:12px;">
                            @foreach(['Track reservations','Order online',
                                      'View history','Get discounts'] as $b)
                            <span style="background:#111;
                                         border:1px solid #2a2a2a;
                                         color:#888; padding:6px 14px;
                                         font-size:12px;">
                                ✓ {{ $b }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @else
        <!-- Logged in — show reservation form -->
        <div class="row justify-content-center">
            <div class="col-lg-8">

                @if(session('success'))
                <div style="background:rgba(25,135,84,0.1);
                            border:1px solid rgba(25,135,84,0.3);
                            color:#198754; padding:15px; margin-bottom:20px;
                            text-align:center;">
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div style="background:rgba(220,53,69,0.1);
                            border:1px solid rgba(220,53,69,0.3);
                            color:#dc3545; padding:15px; margin-bottom:20px;">
                    @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <!-- User Welcome -->
                <div style="background:#1a1a1a; border:1px solid #2a2a2a;
                            padding:20px 25px; margin-bottom:25px;
                            display:flex; align-items:center; gap:15px;">
                    <div style="width:45px; height:45px; border-radius:50%;
                                background:#c8a951; color:#000;
                                display:flex; align-items:center;
                                justify-content:center; font-weight:700;
                                font-size:18px; flex-shrink:0;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="color:#fff; font-weight:600;">
                            Booking as: {{ auth()->user()->name }}
                        </div>
                        <div style="color:#888; font-size:13px;">
                            {{ auth()->user()->email }}
                        </div>
                    </div>
                    <a href="{{ route('customer.reservations') }}"
                       style="margin-left:auto; color:#c8a951;
                              font-size:12px; text-decoration:none;
                              letter-spacing:1px;">
                        My Reservations →
                    </a>
                </div>

                <form method="POST"
                      action="{{ route('reservation.store') }}"
                      style="background:#1a1a1a; border:1px solid #2a2a2a;
                             padding:40px;">
                    @csrf

                    <!-- Auto fill from user profile -->
                    <h5 style="color:#c8a951; font-size:11px;
                                letter-spacing:3px; text-transform:uppercase;
                                margin-bottom:25px;">
                        Guest Information
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label style="color:#888; font-size:11px;
                                          letter-spacing:2px;
                                          text-transform:uppercase;
                                          display:block; margin-bottom:8px;">
                                Full Name *
                            </label>
                            <input type="text" name="guest_name"
                                   value="{{ old('guest_name',
                                               auth()->user()->name) }}"
                                   style="width:100%; background:#111;
                                          border:1px solid #333; color:#fff;
                                          padding:12px; font-size:14px;
                                          outline:none;"
                                   required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label style="color:#888; font-size:11px;
                                          letter-spacing:2px;
                                          text-transform:uppercase;
                                          display:block; margin-bottom:8px;">
                                Phone *
                            </label>
                            <input type="text" name="guest_phone"
                                   value="{{ old('guest_phone',
                                               auth()->user()->phone) }}"
                                   placeholder="+92 300 1234567"
                                   style="width:100%; background:#111;
                                          border:1px solid #333; color:#fff;
                                          padding:12px; font-size:14px;
                                          outline:none;"
                                   required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label style="color:#888; font-size:11px;
                                          letter-spacing:2px;
                                          text-transform:uppercase;
                                          display:block; margin-bottom:8px;">
                                Email
                            </label>
                            <input type="email" name="guest_email"
                                   value="{{ old('guest_email',
                                               auth()->user()->email) }}"
                                   style="width:100%; background:#111;
                                          border:1px solid #333; color:#fff;
                                          padding:12px; font-size:14px;
                                          outline:none;">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label style="color:#888; font-size:11px;
                                          letter-spacing:2px;
                                          text-transform:uppercase;
                                          display:block; margin-bottom:8px;">
                                Number of Guests *
                            </label>
                            <input type="number" name="guests_count"
                                   min="1" max="20"
                                   value="{{ old('guests_count', 2) }}"
                                   style="width:100%; background:#111;
                                          border:1px solid #333; color:#fff;
                                          padding:12px; font-size:14px;
                                          outline:none;"
                                   required>
                        </div>

                        <div class="col-12 mb-4">
                            <hr style="border-color:#2a2a2a; margin:5px 0 20px;">
                            <h5 style="color:#c8a951; font-size:11px;
                                        letter-spacing:3px;
                                        text-transform:uppercase;
                                        margin-bottom:20px;">
                                Booking Details
                            </h5>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label style="color:#888; font-size:11px;
                                          letter-spacing:2px;
                                          text-transform:uppercase;
                                          display:block; margin-bottom:8px;">
                                Date *
                            </label>
                            <input type="date" name="reservation_date"
                                   value="{{ old('reservation_date') }}"
                                   min="{{ date('Y-m-d',
                                              strtotime('+1 day')) }}"
                                   style="width:100%; background:#111;
                                          border:1px solid #333; color:#fff;
                                          padding:12px; font-size:14px;
                                          outline:none;"
                                   required>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label style="color:#888; font-size:11px;
                                          letter-spacing:2px;
                                          text-transform:uppercase;
                                          display:block; margin-bottom:8px;">
                                Time *
                            </label>
                            <select name="reservation_time"
                                    style="width:100%; background:#111;
                                           border:1px solid #333; color:#fff;
                                           padding:12px; font-size:14px;"
                                    required>
                                <option value="">-- Select Time --</option>
                                @foreach(['12:00','12:30','13:00','13:30',
                                          '14:00','14:30','15:00','15:30',
                                          '16:00','16:30','17:00','17:30',
                                          '18:00','18:30','19:00','19:30',
                                          '20:00','20:30','21:00','21:30',
                                          '22:00','22:30'] as $time)
                                <option value="{{ $time }}"
                                    {{ old('reservation_time') === $time
                                        ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::createFromFormat(
                                        'H:i', $time)->format('h:i A') }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label style="color:#888; font-size:11px;
                                          letter-spacing:2px;
                                          text-transform:uppercase;
                                          display:block; margin-bottom:8px;">
                                Select Table *
                            </label>
                            <select name="table_id"
                                    style="width:100%; background:#111;
                                           border:1px solid #333; color:#fff;
                                           padding:12px; font-size:14px;"
                                    required>
                                <option value="">-- Choose Table --</option>
                                @foreach($tables as $table)
                                <option value="{{ $table->id }}"
                                    {{ old('table_id') == $table->id
                                        ? 'selected' : '' }}>
                                    Table #{{ $table->table_number }}
                                    — {{ $table->capacity }} persons
                                </option>
                                @endforeach
                            </select>
                            @if($tables->isEmpty())
                            <small style="color:#dc3545; font-size:12px;">
                                No tables available right now.
                            </small>
                            @endif
                        </div>

                        <div class="col-12 mb-4">
                            <label style="color:#888; font-size:11px;
                                          letter-spacing:2px;
                                          text-transform:uppercase;
                                          display:block; margin-bottom:8px;">
                                Special Requests
                            </label>
                            <textarea name="notes" rows="3"
                                      placeholder="Birthday? Anniversary? Allergies?"
                                      style="width:100%; background:#111;
                                             border:1px solid #333; color:#fff;
                                             padding:12px; font-size:14px;
                                             resize:none; outline:none;
                                             font-family:'Raleway',sans-serif;">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Policy Note -->
                    <div style="background:#111; border:1px solid #2a2a2a;
                                padding:15px; margin-bottom:25px;
                                font-size:13px; color:#666;">
                        <strong style="color:#888;">Please note:</strong>
                        Reservations must be made at least 1 day in advance.
                        We will confirm your booking via email/phone.
                        Please arrive within 15 minutes of your reservation time.
                    </div>

                    <button type="submit"
                            style="width:100%; background:#c8a951;
                                   color:#fff; border:none; padding:16px;
                                   font-size:12px; font-weight:700;
                                   letter-spacing:3px; text-transform:uppercase;
                                   cursor:pointer;">
                        Confirm Reservation
                    </button>

                </form>
            </div>
        </div>
        @endguest

    </div>
</div>
@endsection