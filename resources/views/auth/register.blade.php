<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register — The Venue Restaurant</title>
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

        /* Left Side — Image */
        .left-panel {
            flex: 1;
            background: url('/vendor/thevenue/images/reservations.jpg')
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
            font-size: 48px;
            font-weight: 400;
            margin-bottom: 20px;
        }
        .left-overlay p {
            color: rgba(255,255,255,0.7);
            font-size: 15px;
            line-height: 1.8;
            max-width: 300px;
        }
        .gold-line {
            width: 60px;
            height: 2px;
            background: #c8a951;
            margin: 0 auto 20px;
        }

        /* Right Side — Form */
        .right-panel {
            width: 100%;
            max-width: 520px;
            background: #111;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 30px;
        }
        .form-box { width: 100%; }
        .form-logo {
            font-family: 'Playfair Display', serif;
            color: #c8a951;
            font-size: 28px;
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
            font-size: 22px;
            font-weight: 600;
            margin: 30px 0 5px;
        }
        .form-subtitle {
            color: #888;
            font-size: 13px;
            margin-bottom: 30px;
        }
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block;
            color: #c8a951;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .form-group .input-wrap {
            position: relative;
        }
        .form-group .input-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #555;
            font-size: 14px;
        }
        .form-group input {
            width: 100%;
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            color: #fff;
            padding: 12px 14px 12px 40px;
            font-family: 'Raleway', sans-serif;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            border-color: #c8a951;
        }
        .form-group input::placeholder { color: #444; }
        .error-msg {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }
        .alert-error {
            background: rgba(220,53,69,0.1);
            border: 1px solid rgba(220,53,69,0.3);
            color: #dc3545;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .btn-submit {
            width: 100%;
            background: #c8a951;
            color: #fff;
            border: none;
            padding: 14px;
            font-family: 'Raleway', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 10px;
        }
        .btn-submit:hover { background: #b8943e; }
        .divider {
            text-align: center;
            margin: 25px 0;
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
        .login-link {
            text-align: center;
            color: #888;
            font-size: 13px;
        }
        .login-link a {
            color: #c8a951;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover { text-decoration: underline; }
        .row-2 { display: flex; gap: 15px; }
        .row-2 .form-group { flex: 1; }
    </style>
</head>
<body>

<!-- Left Panel -->
<div class="left-panel">
    <div class="left-overlay">
        <div class="gold-line"></div>
        <h1>Join Us</h1>
        <p>Create your account and enjoy exclusive benefits,
           track your orders, and make reservations easily.</p>
    </div>
</div>

<!-- Right Panel -->
<div class="right-panel">
    <div class="form-box">

        <!-- Logo -->
        <div class="form-logo">
            The Venue
            <span>Restaurant</span>
        </div>

        <div class="form-title">Create Account</div>
        <div class="form-subtitle">
            Fill in your details to get started
        </div>

        <!-- Errors -->
        @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name + Phone -->
            <div class="row-2">
                <div class="form-group">
                    <label>Full Name *</label>
                    <div class="input-wrap">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name"
                               value="{{ old('name') }}"
                               placeholder="Your name"
                               required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <div class="input-wrap">
                        <i class="fas fa-phone"></i>
                        <input type="text" name="phone"
                               value="{{ old('phone') }}"
                               placeholder="+92 300...">
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label>Email Address *</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="your@email.com"
                           required>
                </div>
            </div>

            <!-- Password + Confirm -->
            <div class="row-2">
                <div class="form-group">
                    <label>Password *</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password"
                               placeholder="Min 6 chars"
                               required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Confirm *</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password"
                               name="password_confirmation"
                               placeholder="Repeat"
                               required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                Create My Account
            </button>
        </form>

        <div class="divider"><span>or</span></div>

        <div class="login-link">
            Already have an account?
            <a href="{{ route('login') }}">Sign In</a>
        </div>

    </div>
</div>

</body>
</html>