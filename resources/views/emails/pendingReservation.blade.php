<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Reservation!</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333333;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid #e0e0e0;
        }
        .header {
            background-color: #0b573d;
            padding: 30px;
            text-align: center;
        }
        .header img {
            max-width: 90px;
        }
        .content {
            padding: 35px;
        }
        .content h1 {
            color: #0b573d;
            font-size: 24px;
            margin-top: 0;
            font-weight: 600;
        }
        .content p {
            line-height: 1.6;
            font-size: 16px;
            color: #555;
        }
        .reservation-details {
            margin-top: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #eeeeee;
        }
        .reservation-details h2 {
            font-size: 20px;
            color: #0b573d;
            margin-bottom: 15px;
            margin-top: 0;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table td {
            padding: 10px 0;
            font-size: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        .details-table tr:last-child td {
            border-bottom: none;
        }
        .details-table .label {
            font-weight: 600;
            color: #333;
            width: 40%;
        }
        .details-table .value {
            text-align: right;
            color: #555;
        }
        .payment-info {
            background-color: #e8f5e9;
            border-left: 4px solid #28a745;
            padding: 20px;
            margin-top: 20px;
            border-radius: 4px;
        }
        .payment-info h3 {
            margin-top: 0;
            color: #0b573d;
            font-size: 20px;
        }
        .footer {
            background-color: #f9f9f9;
            text-align: center;
            padding: 30px;
            font-size: 13px;
            color: #777777;
            border-top: 1px solid #e0e0e0;
        }
        .total {
            font-weight: bold;
            font-size: 18px;
            color: #28a745;
        }
        .accommodation-list {
            margin: 5px 0 0 0;
            padding: 0;
            list-style-type: none;
            text-align: right;
        }
        .custom-message-box {
            background-color: #fffbe6;
            border-left: 4px solid #ffc107;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
        }
        .accommodation-list li {
            background-color: #f0f8ff;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 5px;
            font-size: 14px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="{{ $message->embed(public_path('images/logo new.png')) }}" alt="Lelo's Resort Logo" />
        </div>
        <div class="content">
            <h1>Thank You for Choosing Lelo's Resort!</h1>
            <p>Dear {{ $reservation->name }},</p>
            <p>Your booking status has been updated. Below is the summary of your reservation details. We look forward to welcoming you!</p>

            <div class="reservation-details">
                <h2>Reservation Summary</h2>
                <table class="details-table">
                    <tr>
                        <td class="label">Reservation ID:</td>
                        <td class="value">{{ $reservation->reservation_id }}</td>
                    </tr>
                    <tr>
                        <td class="label">Check-in:</td>
                        <td class="value">{{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('F d, Y') }} at {{ \Carbon\Carbon::parse($reservation->reservation_check_in)->format('h:i A') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Check-out:</td>
                        <td class="value">{{ \Carbon\Carbon::parse($reservation->reservation_check_out_date)->format('F d, Y') }} at {{ \Carbon\Carbon::parse($reservation->reservation_check_out)->format('h:i A') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Guests:</td>
                        <td class="value">{{ $reservation->total_guest }} ({{$reservation->number_of_adults}} Adults, {{$reservation->number_of_children}} Children)</td>
                    </tr>
                    <tr>
                        <td class="label" style="vertical-align: top;">Accommodations:</td>
                        <td class="value">
                            @if(!empty($accommodationDetails))
                            <ul class="accommodation-list">
                                @foreach($accommodationDetails as $detail)
                                    <li>{{ $detail['name'] }} (x{{ $detail['quantity'] }})</li>
                                @endforeach
                            </ul>
                            @else
                                @php
                                    $accom_names = DB::table('accomodations')->whereIn('accomodation_id', json_decode($reservation->accomodation_id, true) ?? [])->pluck('accomodation_name')->implode(', ');
                                @endphp
                                <p class="value" style="margin:0;">{{ $accom_names ?: 'N/A' }}</p>
                            @endif

                        </td>
                    </tr>
                </table>
            </div>

            <div class="payment-info">
                <h3>Payment Overview</h3>
                <table class="details-table">
                    <tr>
                        <td class="label">Total Amount:</td>
                        <td class="value total">₱{{ number_format($reservation->amount ?? $reservation->total_amount, 2) }}</td>
                    </tr>

                    {{-- Show Downpayment only if status is partial --}}
                    @if($reservation->payment_status == 'partial')
                        <tr>
                            <td class="label">Downpayment (20%):</td>
                            <td class="value">₱{{ number_format($reservation->downpayment, 2) }}</td>
                        </tr>
                    @endif

                    {{-- Show Remaining Balance only if status is partial --}}
                    @if($reservation->payment_status == 'partial')
                        <tr>
                            <td class="label">Remaining Balance:</td>
                            <td class="value total">₱{{ number_format($reservation->balance, 2) }}</td>
                        </tr>
                    {{-- Show Balance as 0 if status is paid --}}
                    @elseif($reservation->payment_status == 'paid')
                        <tr>
                            <td class="label">Balance:</td>
                            <td class="value total">₱0.00</td>
                        </tr>
                    @endif
                </table>

                @if($reservation->payment_status == 'partial')
                    <p style="font-size: 14px; margin-top: 15px;"><strong>Next Step:</strong> Please settle the remaining balance upon your arrival at the resort. Thank you!</p>
                @elseif($reservation->payment_status == 'paid')
                    <p style="font-size: 14px; margin-top: 15px;"><strong>All Set!</strong> Your booking is fully paid and confirmed. We are excited to see you soon!</p>
                @endif

                @if(isset($reservation->custom_message) && !empty($reservation->custom_message))
                    <p style="font-size: 14px; margin-top: 15px; padding: 10px; background-color: #f0f0f0; border-radius: 4px;"><strong>A message from our staff:</strong><br>{{ $reservation->custom_message }}</p>
                @endif
            </div>
        </div>
        <div class="footer">
            <p>If you have any questions, feel free to contact us at lelosresort@gmail.com.</p>
            <p>&copy; {{ date('Y') }} Lelo's Resort. All rights reserved.</p>
        </div>
    </div>

</body>
</html>