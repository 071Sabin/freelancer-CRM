<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your 2FA Verification Code</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: none;
            -ms-text-size-adjust: none;
        }
        .container {
            max-width: 500px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #10b981; /* Emerald 500 */
            padding: 32px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.025em;
        }
        .content {
            padding: 32px;
            line-height: 1.6;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        .code-container {
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin: 24px 0;
        }
        .code {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 0.1em;
            color: #0f172a;
            margin: 0;
        }
        .expiry {
            font-size: 13px;
            color: #64748b;
            margin-top: 8px;
        }
        .footer {
            padding: 24px 32px;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #64748b;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Client Pivot</h1>
        </div>
        <div class="content">
            <div class="greeting">Security Verification</div>
            <p>Please use the following 6-digit verification code to complete your sign-in process. For security purposes, this code is only valid for 10 minutes.</p>
            
            <div class="code-container">
                <div class="code">{{ $code }}</div>
                <div class="expiry">Expires in 10 minutes</div>
            </div>
            
            <p>If you did not request this code, you can safely ignore this email. Someone else may have typed your email address by mistake.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Client Pivot. All rights reserved.
        </div>
    </div>
</body>
</html>
