<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Cancellation Notice</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #0b573d;
            color: #ffffff;
            padding: 25px 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .email-body {
            padding: 30px;
        }
        .email-footer {
            background-color: #f1f1f1;
            padding: 20px 30px;
            text-align: center;
            font-size: 14px;
            color: #666666;
        }
        .divider {
            height: 1px;
            background-color: #eaeaea;
            margin: 25px 0;
        }
        .highlight-box {
            background-color: #f8f9f7;
            border-left: 4px solid #0b573d;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
        }
        .contact-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            margin-top: 25px;
            text-align: center;
            border: 1px solid #eeeeee;
        }
        .button {
            display: inline-block;
            background-color: #0b573d;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 4px;
            margin: 15px 0;
            font-weight: 500;
        }
        .logo {
            max-width: 180px;
            margin-bottom: 15px;
        }
        .text-center {
            text-align: center;
        }
        .reason {
            font-style: italic;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Reservation Cancellation Notice</h1>
        </div>
        
        <div class="email-body">
            <p>Dear {{ $data['customer_name'] }},</p>
            
            <p>We regret to inform you that your reservation (ID: <strong>{{ $data['reservation_id'] }}</strong>) has been automatically cancelled.</p>
            
            <div class="highlight-box">
                <p><strong>Reason for cancellation:</strong><br>
                <span class="reason">{{ $data['cancellation_reason'] }}</span></p>
            </div>
            
            <div class="divider"></div>
            
            <p><strong>Reservation Date:</strong> {{ \Carbon\Carbon::parse($data['reservation_date'])->format('F j, Y g:i A') }}</p>
            <p><strong>Cancellation Time:</strong> {{ \Carbon\Carbon::parse($data['cancellation_time'])->format('F j, Y g:i A') }}</p>
            
            <div class="divider"></div>
            
            <p>If you believe this is a mistake or if you have any questions, please contact our customer support team immediately.</p>
            
            <div class="contact-info">
                <p><strong>Customer Support</strong><br>
                Email: support@yourcompany.com<br>
                Phone: (800) 123-4567<br>
                Hours: Monday-Friday, 9AM-5PM</p>
            </div>
            
            <p class="text-center">
                <a href="#" class="button">Make a New Reservation</a>
            </p>
        </div>
        
        <div class="email-footer">
            <p>Thank you for your understanding.</p>
            <p>Best regards,<br>
            <strong>{{ config('app.name') }} Team</strong></p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>