<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <style>
        body { 
            font-family: sans-serif; 
            margin: 0;
            padding: 20px;
        }
        .header-container {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }
        .logo {
            max-height: 80px;
            max-width: 200px;
            margin-bottom: 10px;
        }
        .report-title {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .generated-on {
            text-align: right;
            font-size: 10px;
            color: #777;
            margin-bottom: 15px;
        }
        .report-container { 
            width: 100%; 
        }
        .summary-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        .summary-table th, .summary-table td { 
            border: 1px solid #ddd; 
            padding: 10px; 
            text-align: left; 
        }
        .summary-table th { 
            background-color: #f2f2f2; 
            font-weight: bold; 
        }
        .summary-table .metric { 
            width: 70%; 
        }
        .summary-table .value { 
            width: 30%; 
            text-align: right; 
        }
        .total { 
            font-weight: bold; 
        }
        
        /* Print-specific styles */
        @media print {
            body {
                padding: 0;
            }
            .header-container {
                page-break-after: avoid;
            }
            .summary-table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    @php
        $reportTitle = 'Report';
        if ($filterType == 'monthly') {
            $reportTitle = 'Monthly Report for ' . date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear));
        } elseif ($filterType == 'weekly') {
            $reportTitle = 'Weekly Report for Week ' . substr($selectedWeek, 6) . ', ' . substr($selectedWeek, 0, 4);
        } elseif ($filterType == 'yearly') {
            $reportTitle = 'Yearly Report for ' . $selectedYear;
        }
    @endphp

    <div class="header-container">
        <img src="{{ asset('images/logo new.png') }}" alt="Company Logo" class="logo">
        <h1 class="report-title">{{ $reportTitle }}</h1>
    </div>

    <div class="generated-on">Generated on: {{ now('Asia/Manila')->format('F d, Y h:i A') }}</div>

    <div class="report-container">
        <table class="summary-table">
            <tbody>
                <tr>
                    <td class="metric">Total Sale</td>
                    <td class="value">&#8369;{{ number_format($totalRevenue ?? 0, 2) }}</td>
                </tr>
                <tr>
                    <td class="metric">Total Paid Bookings</td>
                    <td class="value">{{ $confirmedBookings ?? 0 }}</td>
                </tr>
                <tr>
                    <td class="metric">Total Guests (Adults + Children)</td>
                    <td class="value">{{ ($adultGuests ?? 0) + ($childGuests ?? 0) }}</td>
                </tr>
                <tr>
                    <td class="metric">Most Booked Room Type</td>
                    <td class="value">{{ $mostBookedRoomType ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="metric">Cancelled Bookings</td>
                    <td class="value">{{ $cancelledBookings ?? 0 }}</td>
                </tr>
                <tr>
                    <td class="metric">Checked-in Bookings</td>
                    <td class="value">{{ $checkedInCount ?? 0 }}</td>
                </tr>
                <tr>
                    <td class="metric">Checked-out Bookings</td>
                    <td class="value">{{ $checkedOutCount ?? 0 }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>