<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — Access Denied</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Raleway:wght@300;400;600;700&display=swap"
          rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Raleway', sans-serif;
            background: #0d0d0d;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 40px 20px;
        }
        .number {
            font-family: 'Playfair Display', serif;
            font-size: 150px;
            color: #dc3545;
            line-height: 1;
            margin-bottom: 20px;
            opacity: 0.3;
        }
        h1 {
            font-family: 'Playfair Display', serif;
            color: #fff;
            font-size: 36px;
            font-weight: 400;
            margin-bottom: 15px;
        }
        p {
            color: #888;
            font-size: 15px;
            margin-bottom: 40px;
            line-height: 1.8;
        }
        .btn {
            display: inline-block;
            background: #c8a951;
            color: #fff;
            padding: 14px 40px;
            text-decoration: none;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin: 5px;
        }
    </style>
</head>
<body>
    <div>
        <div class="number">403</div>
        <h1>Access Denied</h1>
        <p>You don't have permission<br>
           to access this page.</p>
        <a href="/" class="btn">Go Home</a>
    </div>
</body>
</html>