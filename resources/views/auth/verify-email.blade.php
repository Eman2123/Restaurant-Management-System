<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email — The Venue Restaurant</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Raleway:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Raleway', sans-serif;
            background: #0d0d0d;
            min-height: 100vh;
            display: flex;
        }
        .left-panel {
            flex: 1;
            background: url('/vendor/thevenue/images/home.jpg')
                        center/cover no-repeat;
            position: relative;
            display: none;
        }
        @media(min-width:992px){ .left-panel { display:block; } }
        .left-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.6);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 40px;
        }
        .left-overlay h1 {
            font-family: 'Playfair Display', serif;
            color: #fff;
            font-size: 52px;
            font-weight: 400;
            line-height: 1.1;
            margin-bottom: 20px;
        }
        .left-overlay p {
            color: rgba(255,255,255,0.7);
            font-size: 15px;
            line-height: 1.8;
        }
        .gold-text { color: #c8a951; }
        .gold-line {
            width: 60px;
            height: 2px;
            background: #c8a951;
            margin: 0 auto 25px;
        }
        .right-panel {
            width: 100%;
            max-width: 480px;
            background: #111;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 35px;
        }
        .form-box { width: 100%; }
        .form-logo {
            font-family: 'Playfair Display', serif;
            color: #c8a951;
            font-size: 30px;
            margin-bottom: 8px;
        }
        .form-logo span {
            display: block;
            font-family: 'Raleway', sans-serif;
            font-size: 11px;
            letter-spacing: 4px;
            color: #888;
            font-weight: 400;
            text-transform: uppercase;
        }
        .form-title {
            color: #fff;
            font-size: 24px;
            font-weight: 600;
            margin: 35px 0 5px;
        }
        .form-subtitle {
            color: #888;
            font-size: 13px;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        .info-box {
            background: rgba(25,135,84,0.1);
            border-left: 4px solid #198754;
            color: #198754;
            padding: 14px 16px;
            margin-bottom: 25px;
            font-size: 13px;
            border-radius: 4px;
        }
        .form-group { margin-bottom: 22px; }
        .form-group label {
            display: block;
            color: #c8a951;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .input-wrap { position: relative; }
        .input-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #555;
            font-size: 14px;
        }
        .input-wrap input {
            width: 100%;
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            color: #fff;
            padding: 13px 14px 13px 42px;
            font-family: 'Raleway', sans-serif;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }
        .input-wrap input:focus { border-color: #c8a951; }
        .input-wrap input::placeholder { color: #444; }
        .btn-submit {
            width: 100%;
            background: #c8a951;
            color: #fff;
            border: none;
            padding: 15px;
            font-family: 'Raleway', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.3s;
            margin-bottom: 12px;
        }
        .btn-submit:hover { background: #b8943e; }
        .btn-logout {
            width: 100%;
            background: transparent;
            color: #c8a951;
            border: 1px solid #c8a951;
            padding: 15px;
            font-family: 'Raleway', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-logout:hover {
            background: #c8a951;
            color: #fff;
        }
        .divider {
            text-align: center;
            margin: 28px 0;
            position: relative;
        }
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #2a2a2a;
        }
        .divider span {
            background: #111;
            color: #555;
            font-size: 12px;
            padding: 0 15px;
            position: relative;
        }
    </style>
</head>
<body>

<!-- Left Panel -->
<div class="left-panel">
    <div class="left-overlay">
        <div class="gold-line"></div>
        <h1>Verify Your<br><span class="gold-text">Email</span></h1>
        <p>We've sent a verification link to your email. 
           Please click it to activate your account.</p>
    </div>
</div>

<!-- Right Panel -->
<div class="right-panel">
    <div class="form-box">

        <div class="form-logo">
            The Venue
            <span>Restaurant</span>
        </div>

        <div class="form-title">Verify Email Address</div>
        <div class="form-subtitle">
            Thanks for signing up! Verify your email to get started.
        </div>

        @if (session('status') == 'verification-link-sent')
        <div class="info-box">
            <i class="fas fa-check-circle" style="margin-right:8px;"></i>
            A new verification link has been sent to your email address.
        </div>
        @endif

        <div style="background:rgba(13,141,219,0.1); border-left:4px solid #0d8ddb;
                    color:#0d8ddb; padding:14px 16px; margin-bottom:25px;
                    font-size:13px; border-radius:4px;">
            <i class="fas fa-info-circle" style="margin-right:8px;"></i>
            {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking the link we sent you. If you didn\'t receive it, we can send another.') }}
        </div>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-submit">
                <i class="fas fa-envelope" style="margin-right:8px;"></i>
                Resend Verification Email
            </button>
        </form>

        <div class="divider"><span>or</span></div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt" style="margin-right:8px;"></i>
                Log Out
            </button>
        </form>

    </div>
</div>

</body>
</html>