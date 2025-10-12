<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Reports</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    .transition-width {
        transition: all 0.3s ease;
    }

    #mainContent.full-width {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }

    .transition-width {
        transition: all 0.3s ease;
    }

    #mainContent.full-width {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
</style>

<body
    style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76))">
    @include('Navbar.navbarAdmin')
    <div class="container-fluid min-vh-100 d-flex p-0">
        <div class="d-flex w-100" id="mainLayout" style="min-height: 100vh;">


            <!-- Main Content -->
            <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width" style="transition: all 0.3s ease;">
                <div class="container-fluid mt-4 mb-4 rounded-4 p-5" style="background: url('{{ asset('images/Dashboardbg.png') }}') no-repeat center center; 
                background-size: cover; 
                    width: 100%;
                    height: 100vh;
                    border-radius: 30px;">
                    <!-- CONTENT -->

                    <div class="text-white text-white-start mt-3 mt-md-5" style="
                        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
                        margin-top: clamp(5%, 10%, 10%) !important;
                    ">
                        <h2 class="mb-0 mb-md-1 fw-semibold" style="
                            font-size: clamp(1.8rem, 4vw, 4.5rem);
                            line-height: 1.2;
                        ">
                            Hello,
                        </h2>

                        <h1 class="fw-bold" style="
                            font-size: clamp(2.2rem, 5vw, 5.5rem);
                            line-height: 1.1;
                        ">
                            Admin User!
                        </h1>
                    </div>



                    <div class="d-flex justify-content-end mb-3" style="width: 100%; padding-right: 5px;">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false"
                                style="background: linear-gradient(180deg, #226214, #43cc25); width: 180px;">
                                <i class="fas fa-upload me-2"></i>Export As
                                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                    style="background: linear-gradient(180deg, #226214, #43cc25); width: 180px;">
                                    <i class="fas fa-upload me-2"></i>Export As
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('export.excel', ['month_year' => request('month_year', date('Y-m'))]) }}">
                                            <i class="fas fa-file-excel me-2"></i>Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('export.pdf', ['month_year' => request('month_year', date('Y-m'))]) }}">
                                            <i class="fas fa-file-pdf me-2"></i>PDF
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="printReport()">
                                            <i class="fas fa-print me-2"></i>Print
                                        </a>
                                        <script>
                                            function printReport() {
                                                const monthYearInput = document.getElementById('bookingMonth');
                                                const monthYear = monthYearInput.value;
                                                const printWindow = window.open(`/admin/reports/print?month_year=${monthYear}`, '_blank');
                                                printWindow.onload = function () {
                                                    printWindow.print();
                                                };
                                            }
                                        </script>
                                    </li>
                                </ul>
                        </div>
                        <button type="button" class="btn btn-info ms-2" data-bs-toggle="modal"
                            data-bs-target="#compareModal" style="color: white;">
                            <i class="fas fa-balance-scale me-2"></i>Compare Data
                        </button>
                    </div>

                    <div>
                        <!-- Total Bookings Section -->
                        <div class="card shadow-sm mb-4 mt-5 ">
                            <div class="card-body p-4">
                                <h1 class="text-success fw-bold mb-3"
                                    style="font-size: 1.5rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                    REPORTS OVERVIEW</h1>
                                <hr class="mt-2 mb-4" style="border-color: #black;">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <form action="{{ route('reports') }}" method="GET" id="monthYearForm">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div style="flex: 0 0 200px;">
                                                    <label for="bookingMonth"
                                                        class="form-label mb-2 small text-muted">Select Month &
                                                        Year</label>
                                                    <input type="month" class="form-control form-control-sm"
                                                        id="bookingMonth" name="month_year"
                                                        value="{{ request('month_year', date('Y-m')) }}">
                                                </div>
                                                <div>
                                                    <button type="submit" class="btn btn-primary btn-sm"
                                                        style="height: 31px; width: 100px; background-color: #0d6efd; border: none;">
                                                        Apply Filter</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-7"> <!-- Binago mula sa col-md-8 -->
                                        <div class="row">
                                            <div class="col-md-5 mb-3"> <!-- Binago mula sa col-md-6 -->
                                                <div class="card shadow-sm" style="border-radius: 8px; border: none;">
                                                    <div
                                                        class="card-body text-center d-flex flex-column justify-content-center py-3">
                                                        <h1 class="display-4 fw-bold text-success mb-0"
                                                            id="totalBookingsCount"
                                                            style="font-size: 3.5rem; color: #0b573d;">
                                                            {{ $confirmedBookings ?? 0 }}
                                                        </h1>
                                                        <p class="mb-0 fw-semibold small">Total Paid Bookings</p>
                                                        <p class="text-muted small" style="font-size: 0.75rem;">
                                                            {{ isset($selectedMonth) && isset($selectedYear)
    ? date('F Y', mktime(0, 0, 0, (int) $selectedMonth, 1, (int) $selectedYear))
    : 'Select a date and apply filter' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5 mb-3"> <!-- Binago mula sa col-md-6 -->
                                                <div class="card shadow-sm" style="border-radius: 8px; border: none;">
                                                    <div
                                                        class="card-body text-center d-flex flex-column justify-content-center py-3">
                                                        <h1 class="display-4 fw-bold text-success mb-0"
                                                            style="font-size: 3.5rem; color: #0b573d;">
                                                            {{ ($adultGuests ?? 0) + ($childGuests ?? 0) }}
                                                        </h1>
                                                        <p class="mb-0 fw-semibold small">Total Adults &
                                                            Children</p>
                                                        <p class="text-muted small" style="font-size: 0.75rem;">
                                                            {{ date('F Y', strtotime(request('month_year', date('Y-m')))) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="card shadow-sm"
                                                    style="border-radius: 8px; border: none; max-width: 95%;">
                                                    <!-- Dinagdagan ng max-width -->
                                                    <div class="card-body py-2">
                                                        <canvas id="bookingsTrendChart"
                                                            style="max-height: 150px;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5"> <!-- Binago mula sa col-md-4 -->
                                        <div class="row">
                                            <div class="col-md-6 mb-3"> <!-- Nilagay sa loob ng row at col-md-6 -->
                                                <div class="card shadow-sm h-100"
                                                    style="border-radius: 8px; border: none; min-height: 320px;">
                                                    <div class="card-header py-2"
                                                        style="background-color: #f8f9fa; border-bottom: 1px solid #eee;">
                                                        <h6 class="card-title mb-0 fw-semibold small">Guest Age
                                                            Distribution</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <canvas id="guestsDistributionChart"
                                                            style="max-height: 220px;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3"> <!-- Nilagay sa loob ng row at col-md-6 -->
                                                <div class="card shadow-sm h-100"
                                                    style="border-radius: 8px; border: none; min-height: 320px;">
                                                    <div class="card-header py-2"
                                                        style="background-color: #f8f9fa; border-bottom: 1px solid #eee;">
                                                        <h6 class="card-title mb-0 fw-semibold small">Monthly Revenue
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <canvas id="monthlyRevenueChart"
                                                            style="max-height: 220px;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row px-3 pb-4" style="gap: 10px;">
                                <!-- MOST BOOKED ROOM TYPE -->
                                <div class="col-md-3 mb-3" style="flex: 1;">
                                    <div class="card shadow-sm h-100"
                                        style="border-radius: 12px; border: none; background-color: #3e786d; overflow: hidden; color: white;">
                                        <div class="card-header"
                                            style="background: rgba(255,255,255,0.3); border-bottom: 1px solid rgba(255,255,255,0.4); padding: 8px 12px;">
                                            <h6 class="card-title mb-0 fw-semibold small text-white text-start">
                                                0.0% RATE
                                            </h6>
                                        </div>
                                        <div class="card-body p-3 text-start">
                                            <h6 class="text-uppercase mb-2 small fw-bold text-white">MOST BOOKED ROOM
                                                TYPE</h6>
                                            <h2 class="display-5 fw-bold mb-0 text-white">
                                                {{ $mostBookedRoomType ?? 0 }}
                                            </h2>
                                            <p class="mb-0 small text-white">CABINS</p>
                                            <p class="small text-white">
                                                {{ isset($selectedMonth) && isset($selectedYear)
    ? date('F Y', mktime(0, 0, 0, (int) $selectedMonth, 1, (int) $selectedYear))
    : 'Select a date and apply filter' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- CHECKED-OUT BOOKINGS -->
                                <div class="col-md-3 mb-3" style="flex: 1;">
                                    <div class="card shadow-sm h-100"
                                        style="border-radius: 12px; border: none; background: linear-gradient(180deg, #226214, #43cc25); overflow: hidden; color: white;">
                                        <div class="card-header"
                                            style="background: rgba(255,255,255,0.15); border-bottom: 1px solid rgba(255,255,255,0.2); padding: 8px 12px;">
                                            <h6 class="card-title mb-0 fw-semibold small text-white text-start">
                                                0.0% RATE
                                            </h6>
                                        </div>
                                        <div class="card-body p-3 text-start">
                                            <h6 class="text-uppercase mb-2 small fw-bold text-white">CHECK-OUT BOOKINGS
                                            </h6>
                                            <h2 class="display-5 fw-bold mb-0 text-white">
                                                {{ $checkedOutCount ?? 0 }}
                                            </h2>
                                            <p class="mb-0 small text-white">0</p>
                                            <p class="small text-white">
                                                {{ isset($selectedMonth) && isset($selectedYear)
    ? date('F Y', mktime(0, 0, 0, (int) $selectedMonth, 1, (int) $selectedYear))
    : 'Select a date and apply filter' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- EARLY CHECKED-OUT BOOKINGS -->
                                <div class="col-md-3 mb-3" style="flex: 1;">
                                    <div class="card shadow-sm h-100"
                                        style="border-radius: 12px; border: none; background-color: #3e786d; overflow: hidden; color: white;">
                                        <div class="card-header"
                                            style="background: rgba(255,255,255,0.15); border-bottom: 1px solid rgba(255,255,255,0.2); padding: 8px 12px;">
                                            <h6 class="card-title mb-0 fw-semibold small text-white text-start">
                                                0.0% RATE
                                            </h6>
                                        </div>
                                        <div class="card-body p-3 text-start">
                                            <h6 class="text-uppercase mb-2 small fw-bold text-white">EARLY CHECK-OUT
                                                BOOKINGS</h6>
                                            <h2 class="display-5 fw-bold mb-0 text-white">
                                                {{ $earlyCheckedOutCount ?? 0 }}
                                            </h2>
                                            <p class="mb-0 small text-white">0</p>
                                            <p class="small text-white">
                                                {{ isset($selectedMonth) && isset($selectedYear)
    ? date('F Y', mktime(0, 0, 0, (int) $selectedMonth, 1, (int) $selectedYear))
    : 'Select a date and apply filter' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- CANCELLED BOOKINGS -->
                                <div class="col-md-3 mb-3" style="flex: 1;">
                                    <div class="card shadow-sm h-100"
                                        style="border-radius: 12px; border: none; background: linear-gradient(180deg, #226214, #43cc25); overflow: hidden; color: white;">
                                        <div class="card-header"
                                            style="background: rgba(255,255,255,0.15); border-bottom: 1px solid rgba(255,255,255,0.2); padding: 8px 12px;">
                                            <h6 class="card-title mb-0 fw-semibold small text-white text-start">
                                                {{ number_format($cancellationPercentage ?? 0, 1) }}% RATE
                                            </h6>
                                        </div>
                                        <div class="card-body p-3 text-start">
                                            <h6 class="text-uppercase mb-2 small fw-bold text-white">CANCELLED BOOKINGS
                                            </h6>
                                            <h2 class="display-5 fw-bold mb-0 text-white">
                                                {{ $cancelledBookings ?? 0 }}
                                            </h2>
                                            <p class="mb-0 small text-white">1</p>
                                            <p class="small text-white">
                                                {{ isset($selectedMonth) && isset($selectedYear)
    ? date('F Y', mktime(0, 0, 0, (int) $selectedMonth, 1, (int) $selectedYear))
    : 'Select a date and apply filter' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparison Modal -->
    <div class="modal fade" id="compareModal" tabindex="-1" aria-labelledby="compareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-lg border-0">
                <div class="modal-header text-white border-0"
                    style="background: linear-gradient(135deg, #0b573d, #198754);">
                    <h5 class="modal-title fw-bold" id="compareModalLabel">
                        <i class="fas fa-balance-scale-right me-2"></i>Compare Monthly Reports
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="background-color: #f8f9fa;">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-5">
                                    <label for="compareMonth1" class="form-label fw-semibold small">Select First
                                        Month</label>
                                    <input type="month" class="form-control" id="compareMonth1" name="compare_month_1"
                                        value="{{ date('Y-m', strtotime('-1 month')) }}">
                                </div>
                                <div class="col-md-5">
                                    <label for="compareMonth2" class="form-label fw-semibold small">Select Second
                                        Month</label>
                                    <input type="month" class="form-control" id="compareMonth2" name="compare_month_2"
                                        value="{{ date('Y-m') }}">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success w-100" id="runComparison">
                                        <i class="fas fa-chart-bar me-1"></i> Compare
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="comparisonResult" class="mt-4" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0 fw-bold text-success">Comparison Result</h5>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="printComparison">
                                <i class="fas fa-print me-1"></i> Print
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light text-secondary small text-uppercase"></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div id="comparisonSpinner" class="text-center mt-4" style="display: none;">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let bookingsChart = null;
            let guestsChart = null;

            function initializeBookingsChart() {
                const chartCanvas = document.getElementById('bookingsTrendChart');

                // If we already have a chart, destroy it
                if (bookingsChart) {
                    bookingsChart.destroy();
                }

                @if(isset($selectedYear) && isset($selectedMonth))
                    const daysInMonth = new Date({{ (int) $selectedYear }}, {{ (int) $selectedMonth }}, 0).getDate();
                    const labels = Array.from({ length: daysInMonth }, (_, i) => i + 1);
                    const bookingData = @json($dailyBookings ?? []);
                    const counts = Array(daysInMonth).fill(0);

                    // Fill in the actual counts
                    for (let i = 1; i <= daysInMonth; i++) {
                        counts[i - 1] = bookingData[i] || 0;
                    }

                    bookingsChart = new Chart(chartCanvas, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Daily Bookings',
                                data: counts,
                                borderColor: '#0b573d',
                                backgroundColor: 'rgba(11, 87, 61, 0.2)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                @else
                                                                                                                                                                                                                                                                                                                                                                                                                                    const ctx = chartCanvas.getContext('2d');
                    ctx.clearRect(0, 0, chartCanvas.width, chartCanvas.height);
                    ctx.font = '15px Arial';
                    ctx.fillStyle = '#666';
                    ctx.textAlign = 'center';
                    ctx.fillText('Select a date and apply filter to view chart data', chartCanvas.width / 2, chartCanvas.height / 2);
                @endif
                }

            function initializeGuestsChart() {
                const chartCanvas = document.getElementById('guestsDistributionChart');

                // If we already have a chart, destroy it
                if (guestsChart) {
                    guestsChart.destroy();
                }

                @if(isset($adultGuests) || isset($childGuests))
                    guestsChart = new Chart(chartCanvas, {
                        type: 'pie',
                        data: {
                            labels: ['Adults(18 + age)', 'Children (3 - 17 age)'],
                            datasets: [{
                                data: [{{ $adultGuests ?? 0 }}, {{ $childGuests ?? 0 }}],
                                backgroundColor: [
                                    'rgba(11, 87, 61, 0.8)',   // Adults - dark green
                                    'rgba(11, 87, 61, 0.4)'    // Children - light green
                                ],
                                borderColor: '#ffffff',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        boxWidth: 20,
                                        padding: 15,
                                        font: {
                                            size: 12
                                        }
                                    }
                                }
                            }
                        }
                    });
                @else
                                                                                                                                                                                                                                                                                                    const ctx = chartCanvas.getContext('2d');
                    ctx.clearRect(0, 0, chartCanvas.width, chartCanvas.height);
                    ctx.font = '15px Arial';
                    ctx.fillStyle = '#666';
                    ctx.textAlign = 'center';
                    ctx.fillText('Select a date and apply filter to view chart data', chartCanvas.width / 2, chartCanvas.height / 2);
                @endif
}

            // Initialize both charts
            initializeBookingsChart();
            initializeGuestsChart();

            // Handle form submission
            document.getElementById('monthYearForm').addEventListener('submit', function (e) {
                e.preventDefault();
                this.submit();
            });
        });
    </script>
    <!-- Script for MonthlyIncome Chart -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let monthlyIncomeChart = null;

            function initializeMonthlyIncomeChart() {
                const chartCanvas = document.getElementById('monthlyIncomeChart');

                if (monthlyIncomeChart) {
                    monthlyIncomeChart.destroy();
                }

                @if(isset($dates) && !empty($dates))
                    const monthsWithYear = @json($dates).map(date => {
                        const d = new Date(date);
                        return d.toLocaleString('default', { month: 'long', year: 'numeric' });
                    });

                    monthlyIncomeChart = new Chart(chartCanvas, {
                        type: 'line',
                        data: {
                            labels: monthsWithYear,
                            datasets: [{
                                label: 'Monthly Income',
                                data: @json($income),
                                borderColor: '#0b573d',
                                backgroundColor: 'rgba(11, 87, 61, 0.2)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true,
                                pointRadius: 4,
                                pointBackgroundColor: '#0b573d'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    grid: {
                                        color: 'rgba(255, 255, 255, 0.1)'
                                    },
                                    ticks: {
                                        color: '#666666',
                                        maxRotation: 0,
                                        minRotation: 0,
                                        font: {
                                            size: 11
                                        }
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(255, 255, 255, 0.1)'
                                    },
                                    ticks: {
                                        color: '#666666',
                                        callback: function (value) {
                                            return '₱' + value.toLocaleString();
                                        },
                                        font: {
                                            size: 11
                                        }
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    labels: {
                                        color: '#666666'
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    callbacks: {
                                        label: function (context) {
                                            return '₱' + context.parsed.y.toLocaleString();
                                        }
                                    }
                                }
                            }
                        }
                    });
                @endif
        }

            // Initialize the chart
            initializeMonthlyIncomeChart();
        });
    </script>
</body>

</html>