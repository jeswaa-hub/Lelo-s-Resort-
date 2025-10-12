<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        
        .header {
            background-color: #0b573d;
            padding: 25px;
            text-align: center;
            color: white;
        }
        
        .header img {
            max-width: 80px;
            margin-bottom: 15px;
        }
        
        h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        
        .content {
            padding: 35px;
        }
        
        p {
            margin-bottom: 20px;
            font-size: 16px;
            color: #555;
        }
        
        .otp-container {
            margin: 30px 0;
            text-align: center;
        }
        
        .otp {
            display: inline-block;
            font-size: 36px;
            font-weight: 700;
            letter-spacing: 5px;
            color: #0b573d;
            background-color: #eaffcc;
            padding: 18px 30px;
            border-radius: 8px;
            border: 2px dashed #0b573d;
        }
        
        .note {
            font-size: 14px;
            color: #777;
            text-align: center;
            margin-top: 25px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 6px;
        }
        
        .footer {
            background-color: #f4f7f6;
            padding: 25px;
            text-align: center;
            font-size: 13px;
            color: #888;
            border-top: 1px solid #e0e0e0;
        }
        
        .divider {
            height: 1px;
            background-color: #e5e5e5;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ $message->embed(public_path('images/logo new.png')) }}" alt="Lelo's Resort Logo">
            <h1>Verification Code</h1>
        </div>
        
        <div class="content">
            <p>Hello!</p>
            <p>Please use the following One-Time Password (OTP) to complete your verification. This code is essential for securing your account.</p>
            
            <div class="otp-container">
                <div class="otp">{{ $otp }}</div>
            </div>
            
            <p class="note">This OTP is valid for <strong>5 minutes</strong>. For your security, please do not share this code with anyone.</p>
            
            <div class="divider"></div>
            
            <p>If you didn't request this OTP, please ignore this email or contact our support team immediately.</p>
            
            <p>Best regards,<br>The Lelo's Resort Team</p>
        </div>
        
        <div class="footer">
            <p>© 2025 Lelo's Resort. All rights reserved.</p>
            <p>Laur, Nueva Ecija, Philippines</p>
        </div>
    </div>
</body>
</html>