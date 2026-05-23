<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — The Venue Restaurant</title>
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
            margin-bottom: 35px;
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
        .remember-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 13px;
        }
        .remember-row label {
            color: #888;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        .remember-row input[type=checkbox] {
            accent-color: #c8a951;
        }
        .forgot-link {
            color: #c8a951;
            text-decoration: none;
            font-size: 12px;
        }
        .forgot-link:hover { text-decoration: underline; }
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
        }
        .btn-submit:hover { background: #b8943e; }
        .alert-error {
            background: rgba(220,53,69,0.1);
            border: 1px solid rgba(220,53,69,0.3);
            color: #dc3545;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
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
        .register-link {
            text-align: center;
            color: #888;
            font-size: 13px;
        }
        .register-link a {
            color: #c8a951;
            text-decoration: none;
            font-weight: 600;
        }
        .demo-accounts {
            margin-top: 25px;
            padding: 15px;
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            font-size: 12px;
            color: #888;
        }
        .demo-accounts strong { color: #c8a951; display: block; margin-bottom: 8px; }
        .demo-item { margin-bottom: 4px; }
    </style>
</head>
<body>

<!-- Left Panel -->
<div class="left-panel">
    <div class="left-overlay">
        <div class="gold-line"></div>
        <h1>Welcome<br><span class="gold-text">Back</span></h1>
        <p>Sign in to your account and enjoy seamless dining,
           reservations, and exclusive member benefits.</p>
    </div>
</div>

<!-- Right Panel -->
<div class="right-panel">
    <div class="form-box">

        <div class="form-logo">
            The Venue
            <span>Restaurant</span>
        </div>

        <div class="form-title">Sign In</div>
        <div class="form-subtitle">
            Welcome back! Please enter your details.
        </div>

        @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        @if(session('status'))
        <div style="background:rgba(25,135,84,0.1);
                    border:1px solid rgba(25,135,84,0.3);
                    color:#198754; padding:12px 16px;
                    margin-bottom:20px; font-size:13px;">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email Address</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="your@email.com"
                           autofocus required>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password"
                           placeholder="Your password"
                           required>
                </div>
            </div>

            <div class="remember-row">
                <label>
                    <input type="checkbox" name="remember">
                    Remember me
                </label>
                @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="forgot-link">
                    Forgot password?
                </a>
                @endif
            </div>

            <button type="submit" class="btn-submit">
                Sign In to Account
            </button>
        </form>

        <div class="divider"><span>or</span></div>

        <div class="register-link">
            Don't have an account?
            <a href="{{ route('register') }}">Create one free</a>
        </div>

        <!-- Demo Accounts -->
        <div class="demo-accounts">
            <strong>Demo Accounts</strong>
            <div class="demo-item">
                Admin: admin@rms.com / password
            </div>
            <div class="demo-item">
                Staff: staff@rms.com / password
            </div>
        </div>

    </div>
</div>

</body>
</html>