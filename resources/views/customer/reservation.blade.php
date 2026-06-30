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
                            padding:60px 40px; border-radius:8px;
                            transition:all 0.3s ease;">
                    <div style="font-size:48px; margin-bottom:25px; color:#c8a951;">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3 style="color:#fff; font-family:'Playfair Display',serif;
                                font-size:28px; margin-bottom:15px; font-weight:400;">
                        Login Required
                    </h3>
                    <p style="color:#999; font-size:15px; line-height:1.8;
                               margin-bottom:30px;">
                        Please login or create an account to make a
                        reservation. It only takes a minute!
                    </p>
                    <div style="display:flex; gap:12px;
                                justify-content:center; flex-wrap:wrap;
                                margin-bottom:30px;">
                        <a href="{{ route('login') }}"
                           style="display:inline-block; background:#c8a951;
                                  color:#000; padding:14px 40px;
                                  text-decoration:none; font-size:11px;
                                  font-weight:700; letter-spacing:3px;
                                  text-transform:uppercase; border-radius:4px;
                                  transition:all 0.3s ease; cursor:pointer;"
                           onmouseover="this.style.background='#d4b86a'; this.style.transform='translateY(-2px)';"
                           onmouseout="this.style.background='#c8a951'; this.style.transform='translateY(0)';">
                            <i class="fas fa-sign-in-alt" style="margin-right:8px;"></i>
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                           style="display:inline-block;
                                  border:1px solid #c8a951;
                                  color:#c8a951; padding:14px 40px;
                                  text-decoration:none; font-size:11px;
                                  font-weight:700; letter-spacing:3px;
                                  text-transform:uppercase; border-radius:4px;
                                  transition:all 0.3s ease; cursor:pointer;"
                           onmouseover="this.style.background='rgba(200,169,81,0.1)'; this.style.transform='translateY(-2px)';"
                           onmouseout="this.style.background='transparent'; this.style.transform='translateY(0)';">
                            <i class="fas fa-user-plus" style="margin-right:8px;"></i>
                            Register Free
                        </a>
                    </div>

                    <div style="margin-top:25px; padding-top:25px;
                                border-top:1px solid #2a2a2a;">
                        <p style="color:#666; font-size:13px; margin:0; margin-bottom:15px;
                                  letter-spacing:1px; text-transform:uppercase;">
                            Benefits of registering:
                        </p>
                        <div style="display:grid; grid-template-columns:1fr 1fr;
                                    gap:10px; max-width:350px; margin:0 auto;">
                            <div style="background:#111; border:1px solid #2a2a2a;
                                        color:#999; padding:10px 14px;
                                        font-size:12px; border-radius:4px;
                                        transition:all 0.2s ease;"
                                 onmouseover="this.style.borderColor='#c8a951'; this.style.color='#c8a951';"
                                 onmouseout="this.style.borderColor='#2a2a2a'; this.style.color='#999';">
                                <i class="fas fa-bookmark" style="margin-right:6px; color:#c8a951;"></i>
                                Track Reservations
                            </div>
                            <div style="background:#111; border:1px solid #2a2a2a;
                                        color:#999; padding:10px 14px;
                                        font-size:12px; border-radius:4px;
                                        transition:all 0.2s ease;"
                                 onmouseover="this.style.borderColor='#c8a951'; this.style.color='#c8a951';"
                                 onmouseout="this.style.borderColor='#2a2a2a'; this.style.color='#999';">
                                <i class="fas fa-shopping-cart" style="margin-right:6px; color:#c8a951;"></i>
                                Order Online
                            </div>
                            <div style="background:#111; border:1px solid #2a2a2a;
                                        color:#999; padding:10px 14px;
                                        font-size:12px; border-radius:4px;
                                        transition:all 0.2s ease;"
                                 onmouseover="this.style.borderColor='#c8a951'; this.style.color='#c8a951';"
                                 onmouseout="this.style.borderColor='#2a2a2a'; this.style.color='#999';">
                                <i class="fas fa-history" style="margin-right:6px; color:#c8a951;"></i>
                                View History
                            </div>
                            <div style="background:#111; border:1px solid #2a2a2a;
                                        color:#999; padding:10px 14px;
                                        font-size:12px; border-radius:4px;
                                        transition:all 0.2s ease;"
                                 onmouseover="this.style.borderColor='#c8a951'; this.style.color='#c8a951';"
                                 onmouseout="this.style.borderColor='#2a2a2a'; this.style.color='#999';">
                                <i class="fas fa-gift" style="margin-right:6px; color:#c8a951;"></i>
                                Get Discounts
                            </div>
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
                            border-left:4px solid #198754;
                            color:#198754; padding:16px 18px; margin-bottom:25px;
                            border-radius:4px; display:flex; align-items:center;">
                    <i class="fas fa-check-circle" style="margin-right:12px; font-size:18px;"></i>
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div style="background:rgba(220,53,69,0.1);
                            border-left:4px solid #dc3545;
                            color:#dc3545; padding:16px 18px; margin-bottom:25px;
                            border-radius:4px;">
                    <div style="display:flex; align-items:center; margin-bottom:8px;">
                        <i class="fas fa-exclamation-circle" style="margin-right:10px; font-size:18px;"></i>
                        <strong>Please check the following:</strong>
                    </div>
                    @foreach($errors->all() as $error)
                    <div style="margin-left:28px; font-size:13px; margin-top:6px;">
                        • {{ $error }}
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- User Welcome -->
                <div style="background:linear-gradient(135deg, #1a1a1a 0%, #242424 100%);
                            border:1px solid #2a2a2a;
                            padding:20px 25px; margin-bottom:30px;
                            display:flex; align-items:center; gap:15px;
                            border-radius:8px;">
                    <div style="width:50px; height:50px; border-radius:50%;
                                background:linear-gradient(135deg, #c8a951, #d4b86a);
                                color:#000;
                                display:flex; align-items:center;
                                justify-content:center; font-weight:700;
                                font-size:20px; flex-shrink:0;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="color:#fff; font-weight:600; font-size:14px;">
                            Booking as: {{ auth()->user()->name }}
                        </div>
                        <div style="color:#888; font-size:12px; margin-top:2px;">
                            <i class="fas fa-envelope" style="margin-right:6px;"></i>
                            {{ auth()->user()->email }}
                        </div>
                    </div>
                    <a href="{{ route('customer.reservations') }}"
                       style="margin-left:auto; color:#c8a951;
                              font-size:12px; text-decoration:none;
                              letter-spacing:1px; font-weight:600;
                              transition:all 0.2s ease; padding:8px 12px;
                              border-radius:4px;"
                       onmouseover="this.style.background='rgba(200,169,81,0.1)';"
                       onmouseout="this.style.background='transparent';">
                        <i class="fas fa-calendar-alt" style="margin-right:6px;"></i>
                        My Reservations
                    </a>
                </div>

                <form method="POST"
                      action="{{ route('reservation.store') }}"
                      style="background:#1a1a1a; border:1px solid #2a2a2a;
                             padding:40px; border-radius:8px;">
                    @csrf

                    <!-- Auto fill from user profile -->
                    <h5 style="color:#c8a951; font-size:11px;
                                letter-spacing:3px; text-transform:uppercase;
                                margin-bottom:25px; font-weight:600;
                                display:flex; align-items:center;">
                        <i class="fas fa-user-circle" style="margin-right:10px; font-size:14px;"></i>
                        Guest Information
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label style="color:#888; font-size:11px;
                                          letter-spacing:2px;
                                          text-transform:uppercase;
                                          display:block; margin-bottom:8px;
                                          font-weight:600;">
                                <i class="fas fa-user" style="margin-right:6px; color:#c8a951;"></i>
                                Full Name *
                            </label>
                            <input type="text" name="guest_name"
                                   value="{{ old('guest_name',
                                               auth()->user()->name) }}"
                                   style="width:100%; background:#111;
                                          border:1px solid #333; color:#fff;
                                          padding:12px; font-size:14px;
                                          outline:none; border-radius:4px;
                                          transition:border-color 0.2s ease;"
                                   required
                                   onfocus="this.style.borderColor='#c8a951';"
                                   onblur="this.style.borderColor='#333';">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label style="color:#888; font-size:11px;
                                          letter-spacing:2px;
                                          text-transform:uppercase;
                                          display:block; margin-bottom:8px;
                                          font-weight:600;">
                                <i class="fas fa-phone" style="margin-right:6px; color:#c8a951;"></i>
                                Phone *
                            </label>
                            <input type="text" name="guest_phone"
                                   value="{{ old('guest_phone',
                                               auth()->user()->phone) }}"
                                   placeholder="+92 300 1234567"
                                   style="width:100%; background:#111;
                                          border:1px solid #333; color:#fff;
                                          padding:12px; font-size:14px;
                                          outline:none; border-radius:4px;
                                          transition:border-color 0.2s ease;"
                                   required
                                   onfocus="this.style.borderColor='#c8a951';"
                                   onblur="this.style.borderColor='#333';">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label style="color:#888; font-size:11px;
                                          letter-spacing:2px;
                                          text-transform:uppercase;
                                          display:block; margin-bottom:8px;
                                          font-weight:600;">
                                <i class="fas fa-at" style="margin-right:6px; color:#c8a951;"></i>
                                Email
                            </label>
                            <input type="email" name="guest_email"
                                   value="{{ old('guest_email',
                                               auth()->user()->email) }}"
                                   style="width:100%; background:#111;
                                          border:1px solid #333; color:#fff;
                                          padding:12px; font-size:14px;
                                          outline:none; border-radius:4px;
                                          transition:border-color 0.2s ease;"
                                   onfocus="this.style.borderColor='#c8a951';"
                                   onblur="this.style.borderColor='#333';">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label style="color:#888; font-size:11px;
                                          letter-spacing:2px;
                                          text-transform:uppercase;
                                          display:block; margin-bottom:8px;
                                          font-weight:600;">
                                <i class="fas fa-users" style="margin-right:6px; color:#c8a951;"></i>
                                Number of Guests *
                            </label>
                            <input type="number" name="guests_count"
                                   min="1" max="20"
                                   value="{{ old('guests_count', 2) }}"
                                   style="width:100%; background:#111;
                                          border:1px solid #333; color:#fff;
                                          padding:12px; font-size:14px;
                                          outline:none; border-radius:4px;
                                          transition:border-color 0.2s ease;"
                                   required
                                   onfocus="this.style.borderColor='#c8a951';"
                                   onblur="this.style.borderColor='#333';">
                        </div>

                        <div class="col-12 mb-4">
                            <hr style="border-color:#2a2a2a; margin:10px 0 25px;">
                            <h5 style="color:#c8a951; font-size:11px;
                                        letter-spacing:3px;
                                        text-transform:uppercase;
                                        margin-bottom:20px; font-weight:600;
                                        display:flex; align-items:center;">
                                <i class="fas fa-calendar-check" style="margin-right:10px; font-size:14px;"></i>
                                Booking Details
                            </h5>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label style="color:#888; font-size:11px;
                                          letter-spacing:2px;
                                          text-transform:uppercase;
                                          display:block; margin-bottom:8px;
                                          font-weight:600;">
                                <i class="fas fa-calendar" style="margin-right:6px; color:#c8a951;"></i>
                                Date *
                            </label>
                            <input type="date" name="reservation_date"
                                   value="{{ old('reservation_date') }}"
                                   min="{{ date('Y-m-d',
                                              strtotime('+1 day')) }}"
                                   style="width:100%; background:#111;
                                          border:1px solid #333; color:#fff;
                                          padding:12px; font-size:14px;
                                          outline:none; border-radius:4px;
                                          transition:border-color 0.2s ease;"
                                   required
                                   onfocus="this.style.borderColor='#c8a951';"
                                   onblur="this.style.borderColor='#333';">
                        </div>

                        <div class="col-md-4 mb-4">
                            <label style="color:#888; font-size:11px;
                                          letter-spacing:2px;
                                          text-transform:uppercase;
                                          display:block; margin-bottom:8px;
                                          font-weight:600;">
                                <i class="fas fa-clock" style="margin-right:6px; color:#c8a951;"></i>
                                Time *
                            </label>
                            <select name="reservation_time"
                                    style="width:100%; background:#111;
                                           border:1px solid #333; color:#fff;
                                           padding:12px; font-size:14px;
                                           border-radius:4px; cursor:pointer;
                                           transition:border-color 0.2s ease;"
                                    required
                                    onfocus="this.style.borderColor='#c8a951';"
                                    onblur="this.style.borderColor='#333';">
                                <option value="" style="background:#111; color:#888;">-- Select Time --</option>
                                @foreach(['12:00','12:30','13:00','13:30',
                                          '14:00','14:30','15:00','15:30',
                                          '16:00','16:30','17:00','17:30',
                                          '18:00','18:30','19:00','19:30',
                                          '20:00','20:30','21:00','21:30',
                                          '22:00','22:30'] as $time)
                                <option value="{{ $time }}"
                                    style="background:#111; color:#fff;"
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
                                          display:block; margin-bottom:8px;
                                          font-weight:600;">
                                <i class="fas fa-chair" style="margin-right:6px; color:#c8a951;"></i>
                                Select Table *
                            </label>
                            <select name="table_id"
                                    style="width:100%; background:#111;
                                           border:1px solid #333; color:#fff;
                                           padding:12px; font-size:14px;
                                           border-radius:4px; cursor:pointer;
                                           transition:border-color 0.2s ease;"
                                    required
                                    onfocus="this.style.borderColor='#c8a951';"
                                    onblur="this.style.borderColor='#333';">
                                <option value="" style="background:#111; color:#888;">-- Choose Table --</option>
                                @foreach($tables as $table)
                                <option value="{{ $table->id }}"
                                    style="background:#111; color:#fff;"
                                    {{ old('table_id') == $table->id
                                        ? 'selected' : '' }}>
                                    Table #{{ $table->table_number }}
                                    — {{ $table->capacity }} persons
                                </option>
                                @endforeach
                            </select>
                            @if($tables->isEmpty())
                            <small style="color:#dc3545; font-size:12px; margin-top:6px; display:block;">
                                <i class="fas fa-info-circle" style="margin-right:4px;"></i>
                                No tables available right now.
                            </small>
                            @endif
                        </div>

                        <div class="col-12 mb-4">
                            <label style="color:#888; font-size:11px;
                                          letter-spacing:2px;
                                          text-transform:uppercase;
                                          display:block; margin-bottom:8px;
                                          font-weight:600;">
                                <i class="fas fa-sticky-note" style="margin-right:6px; color:#c8a951;"></i>
                                Special Requests
                            </label>
                            <textarea name="notes" rows="3"
                                      placeholder="Birthday? Anniversary? Allergies? Let us know..."
                                      style="width:100%; background:#111;
                                             border:1px solid #333; color:#fff;
                                             padding:12px; font-size:14px;
                                             resize:none; outline:none;
                                             font-family:'Raleway',sans-serif;
                                             border-radius:4px;
                                             transition:border-color 0.2s ease;"
                                      onfocus="this.style.borderColor='#c8a951';"
                                      onblur="this.style.borderColor='#333';">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Policy Note -->
                    <div style="background:#111; border-left:4px solid #c8a951;
                                padding:16px 18px; margin-bottom:25px;
                                font-size:13px; color:#888; border-radius:4px;">
                        <div style="display:flex; align-items:flex-start;">
                            <i class="fas fa-info-circle" style="color:#c8a951; margin-right:12px; margin-top:2px; flex-shrink:0;"></i>
                            <div>
                                <strong style="color:#fff;">Please note:</strong><br>
                                • Reservations must be made at least 1 day in advance<br>
                                • We will confirm your booking via email/phone<br>
                                • Please arrive within 15 minutes of your reservation time
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                            style="width:100%; background:#c8a951;
                                   color:#000; border:none; padding:16px;
                                   font-size:12px; font-weight:700;
                                   letter-spacing:3px; text-transform:uppercase;
                                   cursor:pointer; border-radius:4px;
                                   transition:all 0.3s ease;
                                   display:flex; align-items:center;
                                   justify-content:center;"
                            onmouseover="this.style.background='#d4b86a'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(200,169,81,0.3)';"
                            onmouseout="this.style.background='#c8a951'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <i class="fas fa-check" style="margin-right:10px;"></i>
                        Confirm Reservation
                    </button>

                </form>
            </div>
        </div>
        @endguest

    </div>
</div>

<!-- Ensure Font Awesome is loaded -->
@if(!View::hasSection('styles'))
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endif

@endsection