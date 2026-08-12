<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verification Code</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #eef2f6;
        }
        .header {
            background-color: #0d6efd;
            color: #ffffff;
            text-align: center;
            padding: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
            color: #555555;
        }
        .otp-code {
            display: inline-block;
            font-size: 36px;
            font-weight: 700;
            letter-spacing: 6px;
            color: #0d6efd;
            background-color: #f0f4fd;
            padding: 15px 30px;
            border-radius: 8px;
            border: 1px dashed #0d6efd;
            margin-bottom: 30px;
        }
        .footer {
            background-color: #fafbfc;
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #888888;
            border-top: 1px solid #eef2f6;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Gulf Hajj & Umrah Services</h1>
        </div>
        <div class="content">
            <p>Assalam-o-Alaikum,</p>
            <p>Thank you for registering on our application. Please use the verification code below to verify your account and complete registration:</p>
            <div class="otp-code">{{ $otp }}</div>
            <p>If you did not request this code, please ignore this email.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Gulf Hajj & Umrah Services. All rights reserved.
        </div>
    </div>
</body>
</html>
