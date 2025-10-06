
<table>
    <thead>
        <!-- Main Title -->
        <tr>
            <th colspan="4" style="font-size: 18px; font-weight: bold; text-align: center;">
                Lelo's Resort Monthly Report
            </th>
        </tr>
        <!-- Subtitle with Date -->
        <tr>
            <th colspan="4" style="font-size: 16px; text-align: center;">
                {{ date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)) }}
            </th>
        </tr>
        <!-- Spacer Row -->
        <tr>
            <th colspan="4"></th>
        </tr>

        <!-- Section: Monthly Overview -->
        <tr>
            <th colspan="4" style="font-size: 14px; font-weight: bold; background-color: #eafaf1; border-bottom: 1px solid #0b573d;">Monthly Overview</th>
        </tr>
        <tr>
            <th style="font-weight: bold; background-color: #f8f9fa;">Metric</th>
            <th style="font-weight: bold; background-color: #f8f9fa;">Value</th>
            <th style="font-weight: bold; background-color: #f8f9fa;" colspan="2">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Total Paid Bookings</td>
            <td>{{ $confirmedBookings }}</td>
            <td colspan="2">Total number of confirmed and fully paid reservations for the month.</td>
        </tr>
        <tr>
            <td>Total Guests</td>
            <td>{{ ($adultGuests ?? 0) + ($childGuests ?? 0) }}</td>
            <td colspan="2">Total number of guests (adults and children) from paid bookings.</td>
        </tr>
        <tr>
            <td>Adult Guests</td>
            <td>{{ $adultGuests }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>Child Guests</td>
            <td>{{ $childGuests }}</td>
            <td colspan="2"></td>
        </tr>

        <!-- Spacer Row -->
        <tr><td colspan="4"></td></tr>

        <!-- Section: Booking Statistics -->
        <tr>
            <th colspan="4" style="font-size: 14px; font-weight: bold; background-color: #eafaf1; border-bottom: 1px solid #0b573d;">Booking Statistics</th>
        </tr>
        <tr>
            <th style="font-weight: bold; background-color: #f8f9fa;">Metric</th>
            <th style="font-weight: bold; background-color: #f8f9fa;">Value</th>
            <th style="font-weight: bold; background-color: #f8f9fa;" colspan="2">Description</th>
        </tr>
        <tr>
            <td>Most Booked Room</td>
            <td>{{ $mostBookedRoomType ?? 'N/A' }}</td>
            <td colspan="2">The most popular room type based on paid bookings.</td>
        </tr>
        <tr>
            <td>Cancelled Bookings</td>
            <td>{{ $cancelledBookings }}</td>
            <td colspan="2">Total number of cancelled reservations. (Rate: {{ number_format($cancellationPercentage ?? 0, 1) }}%)</td>
        </tr>
        <tr>
            <td>Total Checked Out</td>
            <td>{{ $checkedOutCount }}</td>
            <td colspan="2">Reservations successfully completed and checked out.</td>
        </tr>
        <tr>
            <td>Early Checked Out</td>
            <td>{{ $earlyCheckedOutCount }}</td>
            <td colspan="2">Guests who checked out earlier than their scheduled departure date.</td>
        </tr>

        <!-- Spacer Row -->
        <tr><td colspan="4"></td></tr>

        <!-- Section: Payment Status Breakdown -->
        <tr>
            <th colspan="4" style="font-size: 14px; font-weight: bold; background-color: #eafaf1; border-bottom: 1px solid #0b573d;">Payment Status Breakdown</th>
        </tr>
        <tr>
            <th style="font-weight: bold; background-color: #f8f9fa;">Status</th>
            <th style="font-weight: bold; background-color: #f8f9fa;">Count</th>
            <th style="font-weight: bold; background-color: #f8f9fa;" colspan="2">Percentage</th>
        </tr>
        @php
            $totalPayments = array_sum($paymentStatusData);
        @endphp
        @foreach($paymentStatusData as $status => $count)
        <tr>
            <td>{{ ucfirst($status) }}</td>
            <td>{{ $count }}</td>
            <td colspan="2">{{ $totalPayments > 0 ? number_format(($count / $totalPayments) * 100, 1) . '%' : '0%' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>