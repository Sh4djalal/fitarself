<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitarSelf Verification Code</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #0f0f1a;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .card {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border-radius: 24px;
            padding: 40px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .logo {
            font-size: 48px;
            margin-bottom: 20px;
        }
        h1 {
            color: #ffffff;
            font-size: 24px;
            margin-bottom: 16px;
        }
        p {
            color: #a0a0b0;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .otp-code {
            background: #2a2a3e;
            border-radius: 16px;
            padding: 20px;
            margin: 20px 0;
        }
        .code {
            font-size: 48px;
            font-weight: bold;
            letter-spacing: 8px;
            color: #00d4ff;
            font-family: monospace;
        }
        .expiry {
            font-size: 12px;
            color: #666;
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="logo">🔐</div>
            <h1>FitarSelf Verification Code</h1>
            <p>You are verifying your email address <strong>{{ $email }}</strong> for FitarSelf. Use the code below to complete your registration.</p>
            
            <div class="otp-code">
                <div class="code">{{ $otp }}</div>
            </div>
            
            <p>This code will expire in <strong>15 minutes</strong>.</p>
            <p class="expiry">If you didn't request this, please ignore this email.</p>
            <div class="footer">
                © {{ date('Y') }} FitarSelf. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>