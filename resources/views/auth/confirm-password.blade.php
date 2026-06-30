<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirm Password — The Venue Restaurant</title>
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
            background: rgba(13,141,219,0.1);
            border-left: 4px solid #0d8ddb;
            color: #0d8ddb;
            padding: 14px 16px;
            margin-bottom: 25px;
            font-size: 13px;
            border-radius: 4px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .info-box i {
            flex-shrink: 0;
            margin-top: 2px;
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
        .alert-error {
            background: rgba(220,53,69,0.1);
            border: 1px solid rgba(220,53,69,0.3);
            color: #dc3545;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
            border-radius: 4px;
        }
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
    </style>
</head>
<body>

<!-- Left Panel -->
<div class="left-panel">
    <div class="left-overlay">
        <div class="gold-line"></div>
        <h1>Confirm Your<br><span class="gold-text">Password</span></h1>
        <p>This is a secure area of the application. 
           Please verify your password to continue.</p>
    </div>
</div>

<!-- Right Panel -->
<div class="right-panel">
    <div class="form-box">

        <div class="form-logo">
            The Venue
            <span>Restaurant</span>
        </div>

        <div class="form-title">Confirm Password</div>
        <div class="form-subtitle">
            Please enter your password to continue.
        </div>

        <div class="info-box">
            <i class="fas fa-lock"></i>
            <span>{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</span>
        </div>

        @if ($errors->any())
        <div class="alert-error">
            @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="form-group">
                <label>Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password"
                           placeholder="Enter your password"
                           required autocomplete="current-password">
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-check" style="margin-right:8px;"></i>
                Confirm Password
            </button>
        </form>

    </div>
</div>

</body>
</html>