<!DOCTYPE html>
<html>
<head>
    <title>Transactions Report</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #0b573d; color: white; }
        .badge { padding: 5px 10px; border-radius: 12px; color: white; font-size: 12px; }
        .bg-success { background-color: #198754; }
        .bg-warning { background-color: #ffc107; color: black; }
        .bg-danger { background-color: #dc3545; }
        .bg-primary { background-color: #0d6efd; }
    </style>
</head>
<body>
    @include('exports.header', ['title' => 'Transactions Report'])

    <table>
        <thead>
            <tr>
                <th>Guest Name</th>
                <th>Rooms Booked</th>
                <th>Amount Paid</th>
                <th>Remaining Balance</th>
                <th>Check In - Out Date</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->user_name ?? $transaction->name }}</td>
                    <td>
                        @php
                            $roomNames = $transaction->accomodation_name ?? '';
                            if (empty($roomNames) && isset($transaction->accomodations)) {
                                if (is_string($transaction->accomodations)) {
                                    $roomNames = $transaction->accomodations;
                                } elseif (is_array($transaction->accomodations)) {
                                    $roomNames = implode(', ', $transaction->accomodations);
                                }
                            }
                        @endphp
                        {{ $roomNames ?: 'N/A' }}
                    </td>
                    <td>&#8369;{{ number_format($transaction->amount, 2) }}</td>
                    <td>&#8369;{{ number_format($transaction->balance, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->reservation_check_in_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($transaction->reservation_check_out_date)->format('M d, Y') }}</td>
                    <td><span class="badge bg-{{ $transaction->payment_status === 'paid' ? 'success' : ($transaction->payment_status === 'partial' ? 'primary' : 'warning') }}">{{ ucfirst($transaction->payment_status) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align: center;">No transactions found.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>