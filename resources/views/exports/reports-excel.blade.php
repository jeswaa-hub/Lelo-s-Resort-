
<table>
    <thead>
        <!-- Header Row with Logo and Titles -->
        <tr> <!-- Logo and Title are now in the same cell with spacing. -->
            <th colspan="1"><img src="{{ public_path('images/logo new.png') }}" alt="Logo" height="50" style="vertical-align: middle;"></th>
            <th colspan="4" style="vertical-align: middle; padding-left: 10px;">
                <div style="font-size: 18px; font-weight: bold;">Lelo's Resort Monthly Report</div>
                <div style="font-size: 14px;">
                    {{ date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)) }}
                </div>
            </th>
        </tr>
        <!-- Spacer Row -->
        <tr>
            <th colspan="4"></th>
        </tr>

        <!-- Section: Monthly Overview -->
        <tr>
            <th colspan="5" style="font-size: 14px; font-weight: bold; background-color: #eafaf1; border-bottom: 1px solid #0b573d;">Monthly Overview</th>
        </tr>
        <tr colspan="3">
            <th style="font-weight: bold; background-color: #f8f9fa;"colspan="3">Metric</th>
            <th style="font-weight: bold; background-color: #f8f9fa;" colspan="2">Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="3">Total Sale</td>
            <td colspan="2">₱{{ number_format($totalRevenue ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td colspan="3">Total Paid Bookings</td>
            <td colspan="2">{{ $confirmedBookings }}</td>
        </tr>
        <tr>
            <td colspan="3">Total Guests</td>
            <td colspan="2">{{ ($adultGuests ?? 0) + ($childGuests ?? 0) }}</td>
        </tr>
        <tr>
            <td colspan="3">Adult Guests</td>
            <td colspan="2">{{ $adultGuests }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="3">Child Guests</td>
            <td colspan="2">{{ $childGuests }}</td>
            <td colspan="2"></td>
        </tr>

        <!-- Spacer Row -->
        <tr><td colspan="4"></td></tr>

        <!-- Section: Booking Statistics -->
        <tr>
            <th colspan="5" style="font-size: 14px; font-weight: bold; background-color: #eafaf1; border-bottom: 1px solid #0b573d;">Booking Statistics</th>
        </tr>
        <tr>
            <th style="font-weight: bold; background-color: #f8f9fa;">Metric</th>
            <th style="font-weight: bold; background-color: #f8f9fa;">Value</th>
            <th style="font-weight: bold; background-color: #f8f9fa;" colspan="2">Description</th>
        </tr>
        <tr>
            <td >Most Booked Room</td>
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
    </tbody>
</table>