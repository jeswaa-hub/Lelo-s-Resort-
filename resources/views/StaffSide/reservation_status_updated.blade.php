<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Status Update</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.8;
            color: #555;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f4f4f4;
            padding: 20px 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid #eaeaea;
        }
        .header {
            background-color: #0b573d;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .logo {
            max-width: 100px;
            margin-bottom: 15px;
        }
        .header h2 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
        }
        .content {
            padding: 30px 40px;
        }
        .content p {
            font-size: 16px;
            margin: 0 0 1em;
        }
        .status-box {
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
            background-color: #f9f9f9;
            border-left: 5px solid #ccc;
        }
        .status-reserved { background-color: #e9f7ff; border-left-color: #428bca; }
        .status-pending { background-color: #fff8e1; border-left-color: #ffc107; }
        .status-paid { background-color: #e8f5e9; border-left-color: #2a5d34; }
        .status-cancelled { background-color: #fbe9e7; border-left-color: #d9534f; }
        .status-box h5 {
            margin: 0 0 10px;
            font-size: 18px;
            color: #333;
        }
        .status-text {
            font-weight: bold;
            text-transform: capitalize;
        }
        .details-box {
            background-color: #f9f9f9;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .details-box h5 {
            margin: 0 0 15px;
            font-size: 20px;
            color: #0b573d;
            border-bottom: 2px solid #eaeaea;
            padding-bottom: 10px;
        }
        .details-table {
            width: 100%;
        }
        .details-table td {
            padding: 8px 0;
            font-size: 15px;
            vertical-align: top;
        }
        .detail-label {
            font-weight: 600;
            color: #333;
            width: 150px;
        }
        .detail-value {
            color: #555;
            text-align: right;
        }
        .amount-highlight {
            font-weight: bold;
            color: #0b573d;
        }
        .message-box {
            background-color: #e9f7ff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 5px solid #428bca;
        }
        .message-box h5 { margin: 0 0 10px; color: #004a7c; }
        .action-box {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
        }
        .action-box h5 { margin: 0 0 10px; font-size: 20px; }
        .action-button {
            display: inline-block;
            background-color: #ffc107;
            color: #212529;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            padding: 30px;
            color: #999;
            font-size: 12px;
            background-color: #f9f9f9;
        }
        .footer p { margin: 0 0 5px; }
        .policies {
            text-align: left;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .policies h5 { color: #0b573d; margin: 0 0 10px; }
        .policies ul { padding-left: 20px; margin: 0; font-size: 14px; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="header">
                <img src="{{ $message->embed(public_path('images/logo new.png')) }}" alt="Lelo's Resort Logo" class="logo">
                <h2>Reservation Status Update</h2>
            </div>
            <div class="content">
                <p>Dear {{ $reservation->name }},</p>
                <p>Thank you for choosing Lelo's Resort! Here is an update on your reservation <strong>#{{ $reservation->reservation_id }}</strong>.</p>

                @if($reservation->reservation_status === 'on-hold')
                <div class="action-box">
                    <h5>Action Required: Complete Your Reservation</h5>
                    <p>To confirm your booking, a downpayment is required. Please proceed with the payment to secure your spot.</p>
                    <a href="{{route('paymentProcess')}}" class="action-button">Pay Now</a>
                </div>
                @endif

                <div class="status-box 
                    @if($reservation->payment_status === 'paid') status-paid
                    @elseif(in_array($reservation->payment_status, ['pending', 'on-hold'])) status-pending
                    @elseif($reservation->payment_status === 'cancelled') status-cancelled
                    @else status-reserved @endif">
                    <h5>Your payment status is now <span class="status-text">{{ ucfirst($reservation->payment_status) }}</span></h5>
                    <p>Your reservation status is: <strong class="status-text">{{ ucfirst($reservation->reservation_status) }}</strong></p>
                </div>

                @if($customMessage)
                <div class="message-box">
                    <h5>A Message from Lelo's Resort</h5>
                    <p>{{ $customMessage }}</p>
                </div>
                @endif

                <div class="details-box">
                    <h5>Your Information</h5>
                    <table class="details-table" width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td class="detail-label">Mobile No:</td>
                            <td class="detail-value">{{ $reservation->mobileNo ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="detail-label">Address:</td>
                            <td class="detail-value">{{ $reservation->address ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="detail-label">Total Amount:</td>
                            <td class="detail-value amount-highlight">₱ {{ number_format($reservation->amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="detail-label">Balance:</td>
                            <td class="detail-value amount-highlight">
                                @if($reservation->payment_status === 'paid')
                                    ₱ 0.00
                                @else
                                    ₱ {{ number_format($reservation->balance, 2) }}
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                @if($reservationDetails)
                <div class="details-box">
                    <h5>Reservation Details</h5>
                    <table class="details-table" width="100%" cellpadding="0" cellspacing="0" border="0">
                        @if(isset($reservationDetails->package_name))
                            <tr><td class="detail-label">Package:</td><td class="detail-value">{{ $reservationDetails->package_name }}</td></tr>
                        @elseif(isset($accomodations))
                            <tr><td class="detail-label">Room:</td><td class="detail-value">{{ is_array($accomodations) ? implode(', ', $accomodations) : $accomodations }}</td></tr>
                        @endif
                        
                        @if(isset($reservationDetails->package_room_type))
                            <tr><td class="detail-label">Room Type:</td><td class="detail-value">{{ $reservationDetails->package_room_type }}</td></tr>
                        @endif
                        
                        @if(isset($activities) && !empty($activities))
                            <tr><td class="detail-label">Activities:</td><td class="detail-value">{{ is_array($activities) ? implode(', ', $activities) : $activities }}</td></tr>
                        @elseif(isset($reservationDetails->package_activities))
                            <tr><td class="detail-label">Activities:</td><td class="detail-value">{{ $reservationDetails->package_activities }}</td></tr>
                        @endif
                        
                        <tr><td class="detail-label">Check-in:</td><td class="detail-value">{{ date('F j, Y', strtotime($reservationDetails->reservation_check_in_date)) }} at {{ date('g:i A', strtotime($reservationDetails->reservation_check_in)) }}</td></tr>
                        <tr><td class="detail-label">Check-out:</td><td class="detail-value">{{ date('F j, Y', strtotime($reservationDetails->reservation_check_out_date)) }} at {{ date('g:i A', strtotime($reservationDetails->reservation_check_out)) }}</td></tr>
                    </table>
                </div>
                @endif

                <div class="policies">
                    <h5>Booking Policies</h5>
                    <ul>
                        <li>A 50% down payment is required to confirm your reservation.</li>
                        <li>Full payment must be settled upon check-in.</li>
                        <li>No refund for no-show or late cancellation.</li>
                        <li>Early check-in and late check-out are subject to room availability.</li>
                        <li>The resort is not liable for loss of personal belongings.</li>
                        <li>Guests must follow resort rules and regulations during their stay.</li>
                    </ul>
                </div>
            </div>
            <div class="footer">
                <p>If you have any questions, please contact us at:</p>
                <p><strong>Email:</strong> lelosresort@gmail.com | <strong>Phone:</strong> +09297278336</p>
                <p>&copy; {{ date('Y') }} Lelo's Resort. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
