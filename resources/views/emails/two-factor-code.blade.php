<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your 2FA Verification Code</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f9fafb;
            color: #111827;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: none;
            -ms-text-size-adjust: none;
            line-height: 1.6;
        }
        .wrapper {
            padding: 40px 20px;
            width: 100%;
            background-color: #f9fafb;
            box-sizing: border-box;
        }
        .container {
            max-width: 520px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 40px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        }
        .logo {
            margin-bottom: 32px;
            font-size: 20px;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
        }
        .title {
            font-size: 22px;
            font-weight: 600;
            color: #111827;
            margin: 0 0 16px;
            letter-spacing: -0.5px;
        }
        .text {
            font-size: 15px;
            color: #4b5563;
            margin: 0 0 24px;
        }
        .code-wrapper {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 24px;
            text-align: center;
            margin: 32px 0;
        }
        .code {
            font-size: 36px;
            font-weight: 700;
            letter-spacing: 12px;
            color: #111827;
            margin: 0;
            margin-left: 12px; /* Offset for letter-spacing to center it properly */
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }
        .code-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 12px;
        }
        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 32px 0;
        }
        .footer {
            font-size: 13px;
            color: #6b7280;
        }
        .footer p {
            margin: 0 0 8px;
        }
        .highlight {
            font-weight: 600;
            color: #374151;
        }

        /* Mobile Responsive Styles */
        @media only screen and (max-width: 600px) {
            .wrapper {
                padding: 20px 10px;
            }
            .container {
                padding: 24px;
            }
            .title {
                font-size: 20px;
            }
            .code {
                font-size: 32px;
                letter-spacing: 8px;
                margin-left: 8px;
            }
            .code-wrapper {
                padding: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="logo">
                Client Pivot
            </div>
            
            <h1 class="title">Authenticate your account</h1>
            
            <p class="text">
                Please use the verification code below to sign in. This code is valid for the next <span class="highlight">10 minutes</span>.
            </p>
            
            <div class="code-wrapper">
                <div class="code-label">Verification Code</div>
                <div class="code">{{ $code }}</div>
            </div>
            
            <p class="text" style="font-size: 14px;">
                If you didn't request this email, there's nothing to worry about — you can safely ignore it.
            </p>
            
            <div class="divider"></div>
            
            <div class="footer">
                <p>&copy; {{ date('Y') }} Client Pivot. All rights reserved.</p>
                <p>This is an automated message, please do not reply.</p>
            </div>
        </div>
    </div>
</body>
</html>
