<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Reports</title>
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
</style>

<body
    style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76))">
    @include('Navbar.sidenavbar')
    <div class="container-fluid min-vh-100 d-flex p-0">
        <div class="d-flex w-100" id="mainLayout" style="min-height: 100vh;">

            <!-- Main Content -->
            <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width" style="transition: all 0.3s ease;">
                <div class="container-fluid mt-4 mb-4 rounded-4 p-5" style="background: url('{{ asset('images/staff-admin-bg.jpg') }}') no-repeat center center; 
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

                        <h1 class="fw-bold text-capitalize" style="
                            font-size: clamp(2.2rem, 5vw, 5.5rem);
                            line-height: 1.1;
                        ">
                            {{$adminCredentials->username}}
                        </h1>
                    </div>



                    <div class="d-flex justify-content-end align-items-center mb-3" style="width: 100%; padding-right: 5px;">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false"
                                style="background: linear-gradient(180deg, #226214, #43cc25); width: 180px;">
                                <i class="fas fa-upload me-2"></i>Export As
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('export.excel', request()->query()) }}">
                                        <i class="fas fa-file-excel me-2"></i>Excel
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('admin.reports.export-pdf', request()->query()) }}">
                                        <i class="fas fa-file-pdf me-2"></i>PDF
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="printReport()">
                                        <i class="fas fa-print me-2"></i>Print
                                    </a>

                                </li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-info ms-2" data-bs-toggle="modal" data-bs-target="#compareModal" style="color: white;">
                            <i class="fas fa-balance-scale me-2"></i>Compare Data
                        </button>
                    </div>

                    <script>
                        function printReport() {
                            // Get the current filter parameters from the form
                            const params = new URLSearchParams(new FormData(document.getElementById('filterForm'))).toString();
                            // Construct the URL for the print-friendly report summary
                            const printUrl = `{{ route('reports.print') }}?${params}`;
                            // Open the print URL in a new window
                            const printWindow = window.open(printUrl, '_blank');
                            // When the new window loads, trigger the print dialog
                            printWindow.onload = function () {
                                printWindow.print();
                            };
        }
                    </script>

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
                                        <form action="{{ route('reports') }}" method="GET" id="filterForm" class="align-items-end">
                                            <div class="d-flex justify-content-between">
                                                <!-- Left side with filters -->
                                                <div class="d-flex flex-wrap align-items-end gap-3">
                                                    <!-- Filter Type -->
                                                    <div style="min-width: 150px;">
                                                        <label for="filter_type" class="form-label small text-muted">Filter By</label>
                                                        <select name="filter_type" id="filter_type" class="form-select form-select-sm">
                                                            <option value="monthly" {{ $filterType == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                                            <option value="weekly" {{ $filterType == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                                            <option value="yearly" {{ $filterType == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <!-- Year Filter -->
                                                    <div id="year-filter-container" style="min-width: 150px;">
                                                        <label for="year" class="form-label small text-muted">Year</label>
                                                        <select name="year" id="year" class="form-select form-select-sm">
                                                            @foreach($availableYears as $year)
                                                                <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Month Filter -->
                                                    <div id="month-filter-container" style="min-width: 150px;">
                                                        <label for="month" class="form-label small text-muted">Month</label>
                                                        <select name="month" id="month" class="form-select form-select-sm">
                                                            @for ($m = 1; $m <= 12; $m++)
                                                                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ $m == $selectedMonth ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>

                                                    <!-- Week Filter -->
                                                    <div id="week-filter-container" style="min-width: 150px; display: none;">
                                                        <label for="week" class="form-label small text-muted">Week</label>
                                                        <input type="week" id="week" name="week" value="{{ $selectedWeek }}" class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                                <!-- Right side with button -->
                                                <button type="submit" class="btn btn-primary btn-sm w-25" style="height: 38px;">Apply Filter</button>
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
                                                            @if($filterType == 'monthly')
                                                                {{ date('F Y', mktime(0, 0, 0, (int) $selectedMonth, 1, (int) $selectedYear)) }}
                                                            @elseif($filterType == 'weekly')
                                                                Week {{ substr($selectedWeek, 6) }}, {{ substr($selectedWeek, 0, 4) }}
                                                            @elseif($filterType == 'yearly')
                                                                Year {{ $selectedYear }}
                                                            @else
                                                                Select a date and apply filter
                                                            @endif
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
                                                             @if($filterType == 'monthly')
                                                                {{ date('F Y', mktime(0, 0, 0, (int) $selectedMonth, 1, (int) $selectedYear)) }}
                                                            @elseif($filterType == 'weekly')
                                                                Week {{ substr($selectedWeek, 6) }}, {{ substr($selectedWeek, 0, 4) }}
                                                            @elseif($filterType == 'yearly')
                                                                Year {{ $selectedYear }}
                                                            @endif
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
                                                        <h6 class="card-title mb-0 fw-semibold small">Monthly Sale
                                                        </h6>
                                                    </div>
                                                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                                        <h1 class="display-4 fw-bold text-success mb-0" style="font-size: 3.5rem; color: #0b573d;">
                                                            ₱{{ number_format($totalSale ?? 0, 2) }}
                                                        </h1>
                                                        <p class="mb-0 fw-semibold small">Total Sale</p>
                                                        <p class="text-muted small" style="font-size: 0.75rem;">
                                                            @if($filterType == 'monthly')
                                                                {{ date('F Y', mktime(0, 0, 0, (int) $selectedMonth, 1, (int) $selectedYear)) }}
                                                            @elseif($filterType == 'weekly')
                                                                Week {{ substr($selectedWeek, 6) }}, {{ substr($selectedWeek, 0, 4) }}
                                                            @elseif($filterType == 'yearly')
                                                                Year {{ $selectedYear }}
                                                            @endif
                                                        </p>
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
                                                
                                            </h6>
                                        </div>
                                        <div class="card-body p-3 text-start">
                                            <h6 class="text-uppercase mb-2 small fw-bold text-white">MOST BOOKED ROOM
                                                TYPE</h6>
                                            <h2 class="display-5 fw-bold mb-0 text-white">
                                                {{ $mostBookedRoomType ?? 0 }}
                                            </h2>
                                            <p class="small text-white">
                                                @if($filterType == 'monthly')
                                                    {{ date('F Y', mktime(0, 0, 0, (int) $selectedMonth, 1, (int) $selectedYear)) }}
                                                @elseif($filterType == 'weekly')
                                                    Week {{ substr($selectedWeek, 6) }}, {{ substr($selectedWeek, 0, 4) }}
                                                @elseif($filterType == 'yearly')
                                                    Year {{ $selectedYear }}
                                                @else
                                                    Select a date and apply filter
                                                @endif
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
                                                
                                            </h6>
                                        </div>
                                        <div class="card-body p-3 text-start">
                                            <h6 class="text-uppercase mb-2 small fw-bold text-white">CHECK-OUT BOOKINGS
                                            </h6>
                                            <h2 class="display-5 fw-bold mb-0 text-white">
                                                {{ $checkedOutCount ?? 0 }}
                                            </h2>
                                            <p class="small text-white">
                                                @if($filterType == 'monthly')
                                                    {{ date('F Y', mktime(0, 0, 0, (int) $selectedMonth, 1, (int) $selectedYear)) }}
                                                @elseif($filterType == 'weekly')
                                                    Week {{ substr($selectedWeek, 6) }}, {{ substr($selectedWeek, 0, 4) }}
                                                @elseif($filterType == 'yearly')
                                                    Year {{ $selectedYear }}
                                                @else
                                                    Select a date and apply filter
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- CHECKED-IN BOOKINGS -->
                                <div class="col-md-3 mb-3" style="flex: 1;">
                                    <div class="card shadow-sm h-100"
                                        style="border-radius: 12px; border: none; background-color: #3e786d; overflow: hidden; color: white;">
                                        <div class="card-header"
                                            style="background: rgba(255,255,255,0.15); border-bottom: 1px solid rgba(255,255,255,0.2); padding: 8px 12px;">
                                            <h6 class="card-title mb-0 fw-semibold small text-white text-start">
                                            </h6>
                                        </div>
                                        <div class="card-body p-3 text-start">
                                            <h6 class="text-uppercase mb-2 small fw-bold text-white">CHECKED-IN
                                                BOOKINGS</h6>
                                            <h2 class="display-5 fw-bold mb-0 text-white">
                                                {{ $checkedInCount ?? 0 }}
                                            </h2>
                                            <p class="small text-white">
                                                @if($filterType == 'monthly')
                                                    {{ date('F Y', mktime(0, 0, 0, (int) $selectedMonth, 1, (int) $selectedYear)) }}
                                                @elseif($filterType == 'weekly')
                                                    Week {{ substr($selectedWeek, 6) }}, {{ substr($selectedWeek, 0, 4) }}
                                                @elseif($filterType == 'yearly')
                                                    Year {{ $selectedYear }}
                                                @else
                                                    Select a date and apply filter
                                                @endif
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
                                                
                                            </h6>
                                        </div>
                                        <div class="card-body p-3 text-start">
                                            <h6 class="text-uppercase mb-2 small fw-bold text-white">CANCELLED BOOKINGS
                                            </h6>
                                            <h2 class="display-5 fw-bold mb-0 text-white">
                                                {{ $cancelledBookings ?? 0 }}
                                            </h2>
                                            <p class="small text-white">
                                                @if($filterType == 'monthly')
                                                    {{ date('F Y', mktime(0, 0, 0, (int) $selectedMonth, 1, (int) $selectedYear)) }}
                                                @elseif($filterType == 'weekly')
                                                    Week {{ substr($selectedWeek, 6) }}, {{ substr($selectedWeek, 0, 4) }}
                                                @elseif($filterType == 'yearly')
                                                    Year {{ $selectedYear }}
                                                @else
                                                    Select a date and apply filter
                                                @endif
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
                <div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #0b573d, #198754);">
                    <h5 class="modal-title fw-bold" id="compareModalLabel">
                        <i class="fas fa-balance-scale-right me-2"></i>Compare Monthly Reports
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="background-color: #f8f9fa;">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-5">
                                    <label for="compareMonth1" class="form-label fw-semibold small">Select First Month</label>
                                    <input type="month" class="form-control" id="compareMonth1" name="compare_month_1" value="{{ date('Y-m', strtotime('-1 month')) }}">
                                </div>
                                <div class="col-md-5">
                                    <label for="compareMonth2" class="form-label fw-semibold small">Select Second Month</label>
                                    <input type="month" class="form-control" id="compareMonth2" name="compare_month_2" value="{{ date('Y-m') }}">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterTypeSelect = document.getElementById('filter_type');
            const monthFilter = document.getElementById('month-filter-container');
            const weekFilter = document.getElementById('week-filter-container');
            const yearFilter = document.getElementById('year-filter-container');

            function toggleFilters() {
                const filterType = filterTypeSelect.value;
                if (filterType === 'monthly') {
                    monthFilter.style.display = 'block';
                    weekFilter.style.display = 'none';
                    yearFilter.style.display = 'block';
                } else if (filterType === 'weekly') {
                    monthFilter.style.display = 'none';
                    weekFilter.style.display = 'block';
                    yearFilter.style.display = 'none'; // Year is part of week input
                } else if (filterType === 'yearly') {
                    monthFilter.style.display = 'none';
                    weekFilter.style.display = 'none';
                    yearFilter.style.display = 'block';
                }
            }

            filterTypeSelect.addEventListener('change', toggleFilters);
            toggleFilters(); // Initial call to set the correct state on page load
        });

        document.addEventListener('DOMContentLoaded', function () {
    let bookingsChart = null;
    let guestsChart = null;
    let monthlyIncomeChart = null;

    function initializeCharts() {
        // Initialize bookings trend chart
        initializeBookingsChart();
        
        // Initialize guests distribution chart
        initializeGuestsChart();
        
        // Initialize monthly income chart
        initializeMonthlyIncomeChart();
    }

    function initializeBookingsChart() {
        const chartCanvas = document.getElementById('bookingsTrendChart');
        
        if (!chartCanvas) {
            console.error('Bookings trend chart canvas not found');
            return;
        }

        // Ensure canvas has proper dimensions
        const container = chartCanvas.parentElement;
        if (container) {
            chartCanvas.style.width = '100%';
            chartCanvas.style.height = '150px';
        }

        // If we already have a chart, destroy it
        if (bookingsChart) {
            bookingsChart.destroy();
        }

        @if(isset($bookingsTrendData))
            let labels = [];
            let counts = [];
            const bookingData = @json($bookingsTrendData);

            @if($filterType === 'monthly')
                const daysInMonth = new Date({{ (int) $selectedYear }}, {{ (int) $selectedMonth }}, 0).getDate();
                labels = Array.from({ length: daysInMonth }, (_, i) => i + 1);
                counts = Array(daysInMonth).fill(0);
                for (let day in bookingData) {
                    if (day > 0 && day <= daysInMonth) {
                        counts[day - 1] = bookingData[day];
                    }
                }
            @elseif($filterType === 'weekly')
                labels = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                counts = Array(7).fill(0);
                for (let dayOfWeek in bookingData) {
                    // DAYOFWEEK in SQL: 1=Sun, 2=Mon...
                    if (dayOfWeek > 0 && dayOfWeek <= 7) {
                        counts[dayOfWeek - 1] = bookingData[dayOfWeek];
                    }
                }
            @elseif($filterType === 'yearly')
                labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                counts = Array(12).fill(0);
                for (let month in bookingData) {
                    // MONTH in SQL: 1=Jan, 2=Feb...
                    if (month > 0 && month <= 12) {
                        counts[month - 1] = bookingData[month];
                    }
                }
            @endif

            try {
                bookingsChart = new Chart(chartCanvas, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Bookings',
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
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error initializing bookings chart:', error);
            }
        @else
            // Display placeholder message
            const ctx = chartCanvas.getContext('2d');
            ctx.clearRect(0, 0, chartCanvas.width, chartCanvas.height);
            ctx.font = '12px Arial';
            ctx.fillStyle = '#666';
            ctx.textAlign = 'center';
            ctx.fillText('Select a date and apply filter to view chart data', chartCanvas.width / 2, chartCanvas.height / 2);
        @endif
    }

    function initializeGuestsChart() {
        const chartCanvas = document.getElementById('guestsDistributionChart');
        
        if (!chartCanvas) {
            console.error('Guests distribution chart canvas not found');
            return;
        }

        // Ensure canvas has proper dimensions
        const container = chartCanvas.parentElement;
        if (container) {
            chartCanvas.style.width = '100%';
            chartCanvas.style.height = '220px';
        }

        // If we already have a chart, destroy it
        if (guestsChart) {
            guestsChart.destroy();
        }

        @if(isset($adultGuests) || isset($childGuests))
            try {
                guestsChart = new Chart(chartCanvas, {
                    type: 'pie',
                    data: {
                        labels: ['Adults(18 + age)', 'Children (3 - 17 age)'],
                        datasets: [{
                            data: [{{ $adultGuests ?? 0 }}, {{ $childGuests ?? 0 }}],
                            backgroundColor: [
                                'rgba(11, 87, 61, 0.8)',
                                'rgba(11, 87, 61, 0.4)'
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
            } catch (error) {
                console.error('Error initializing guests chart:', error);
            }
        @else
            const ctx = chartCanvas.getContext('2d');
            ctx.clearRect(0, 0, chartCanvas.width, chartCanvas.height);
            ctx.font = '12px Arial';
            ctx.fillStyle = '#666';
            ctx.textAlign = 'center';
            ctx.fillText('Select a date and apply filter to view chart data', chartCanvas.width / 2, chartCanvas.height / 2);
        @endif
    }

    function initializeMonthlyIncomeChart() {
        const chartCanvas = document.getElementById('monthlyRevenueChart');
        
        if (!chartCanvas) {
            console.error('Monthly revenue chart canvas not found');
            return;
        }

        // Ensure canvas has proper dimensions
        const container = chartCanvas.parentElement;
        if (container) {
            chartCanvas.style.width = '100%';
            chartCanvas.style.height = '220px';
        }

        if (monthlyIncomeChart) {
            monthlyIncomeChart.destroy();
        }

        @if(isset($sale) && !empty(array_filter($sale)))
            const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            try {
                monthlyIncomeChart = new Chart(chartCanvas, {
                    type: 'bar',
                    data: {
                        labels: monthLabels,
                        datasets: [{
                            label: 'Monthly Income',
                            data: @json($sale),
                            backgroundColor: 'rgba(11, 87, 61, 0.8)',
                            borderColor: '#0b573d',
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                grid: {
                                    display: false
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
                                    color: 'rgba(0, 0, 0, 0.1)'
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
                                display: false
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
            } catch (error) {
                console.error('Error initializing monthly income chart:', error);
            }
        @else
            const ctx = chartCanvas.getContext('2d');
            ctx.clearRect(0, 0, chartCanvas.width, chartCanvas.height);
            ctx.font = '12px Arial';
            ctx.fillStyle = '#666';
            ctx.textAlign = 'center';
            ctx.fillText('No revenue data available', chartCanvas.width / 2, chartCanvas.height / 2);
        @endif
    }

    // Initialize charts when DOM is loaded
    initializeCharts();

    // Reinitialize charts when window is resized
    window.addEventListener('resize', function() {
        initializeCharts();
    });

    // Comparison Modal Logic
    document.getElementById('runComparison')?.addEventListener('click', function() {
        const month1 = document.getElementById('compareMonth1').value;
        const month2 = document.getElementById('compareMonth2').value;
        const resultDiv = document.getElementById('comparisonResult');
        const spinner = document.getElementById('comparisonSpinner');

        if (!month1 || !month2) {
            alert('Please select both months to compare.');
            return;
        }

        resultDiv.style.display = 'none';
        spinner.style.display = 'block';

        fetch(`{{ route('reports.compare') }}?month1=${month1}&month2=${month2}`)
            .then(response => response.json())
            .then(data => {
                console.log('Comparison Data Received:', data); 
                
                spinner.style.display = 'none';
                resultDiv.style.display = 'block';

                const tableHead = resultDiv.querySelector('thead');
                const tableBody = resultDiv.querySelector('tbody');

                const month1Label = new Date(month1 + '-02').toLocaleString('default', { month: 'long', year: 'numeric' });
                const month2Label = new Date(month2 + '-02').toLocaleString('default', { month: 'long', year: 'numeric' });

                tableHead.innerHTML = `
                    <tr>
                        <th>Metric</th>
                        <th>${month1Label}</th>
                        <th>${month2Label}</th>
                        <th>Change</th>
                    </tr>
                `;

                const metrics = [
                    { 
                        key: 'totalSale', 
                        label: 'Total Sale', 
                        format: 'currency',
                        process: (val) => typeof val === 'number' ? val : 0
                    },
                    { 
                        key: 'confirmedBookings', 
                        label: 'Confirmed Bookings', 
                        format: 'number',
                        process: (val) => typeof val === 'number' ? val : 0
                    },
                    { 
                        key: 'totalGuests', 
                        label: 'Total Guests', 
                        format: 'number',
                        process: (val) => typeof val === 'number' ? val : 0
                    },
                    { 
                        key: 'cancelledBookings', 
                        label: 'Cancelled Bookings', 
                        format: 'number',
                        process: (val) => typeof val === 'number' ? val : 0
                    },
                    { 
                        key: 'mostBookedRoomType', 
                        label: 'Most Booked Room', 
                        format: 'string',
                        process: (val) => val || 'No data'
                    },
                ];

                let bodyHtml = '';
                metrics.forEach(metric => {
                    // Safely get values with fallbacks
                    const val1 = data.month1?.[metric.key] ?? 0;
                    const val2 = data.month2?.[metric.key] ?? 0;
                    let changeHtml = '';

                    if (metric.format === 'number' || metric.format === 'currency') {
                        // Ensure values are numbers
                        const num1 = typeof val1 === 'number' ? val1 : 0;
                        const num2 = typeof val2 === 'number' ? val2 : 0;
                        
                        const diff = num2 - num1;
                        const percentage = num1 !== 0 ? ((diff / num1) * 100).toFixed(1) : (num2 > 0 ? '∞' : '0.0');
                        
                        let color = 'text-muted';
                        let icon = '<i class="fas fa-minus"></i>';
                        if (diff > 0) {
                            color = 'text-success';
                            icon = '<i class="fas fa-arrow-up"></i>';
                        } else if (diff < 0) {
                            color = 'text-danger';
                            icon = '<i class="fas fa-arrow-down"></i>';
                        }
                        
                        // Safely format numbers
                        const absDiff = Math.abs(diff);
                        const formattedDiff = typeof absDiff === 'number' ? absDiff.toLocaleString() : '0';
                        
                        changeHtml = `<span class="${color} fw-bold">${icon} ${formattedDiff} (${percentage}%)</span>`;
                    } else {
                        // For string values
                        const str1 = val1 || 'N/A';
                        const str2 = val2 || 'N/A';
                        changeHtml = str1 === str2 ? '<span class="text-muted">No Change</span>' : `<span class="text-primary">${str2}</span>`;
                    }

                    // Safely format values for display
                    let formattedVal1, formattedVal2;
                    
                    if (metric.format === 'currency') {
                        const num1 = typeof val1 === 'number' ? val1 : 0;
                        const num2 = typeof val2 === 'number' ? val2 : 0;
                        formattedVal1 = `₱${num1.toLocaleString()}`;
                        formattedVal2 = `₱${num2.toLocaleString()}`;
                    } else if (metric.format === 'number') {
                        const num1 = typeof val1 === 'number' ? val1 : 0;
                        const num2 = typeof val2 === 'number' ? val2 : 0;
                        formattedVal1 = num1.toLocaleString();
                        formattedVal2 = num2.toLocaleString();
                    } else {
                        formattedVal1 = val1 || 'N/A';
                        formattedVal2 = val2 || 'N/A';
                    }

                    bodyHtml += `
                        <tr>
                            <td class="fw-semibold">${metric.label}</td>
                            <td>${formattedVal1}</td>
                            <td>${formattedVal2}</td>
                            <td>${changeHtml}</td>
                        </tr>
                    `;
                });

                tableBody.innerHTML = bodyHtml;
            })
            .catch(error => {
                spinner.style.display = 'none';
                alert('An error occurred while fetching comparison data.');
                console.error('Comparison Fetch Error:', error);
            });
    });

    // Print Comparison Logic
    document.getElementById('printComparison')?.addEventListener('click', function() {
        const tableHtml = document.querySelector('#comparisonResult .table-responsive').innerHTML;
        const month1 = document.getElementById('compareMonth1').value;
        const month2 = document.getElementById('compareMonth2').value;

        const month1Label = moment(month1).format('MMMM YYYY');
        const month2Label = moment(month2).format('MMMM YYYY');

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Monthly Report Comparison</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
                    <style>
                        body { font-family: 'Poppins', sans-serif; padding: 2rem; }
                        .header { display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #dee2e6; padding-bottom: 1rem; margin-bottom: 2rem; }
                        .header img { max-height: 70px; }
                        .header-text { text-align: right; }
                        .header-text h3 { margin: 0; font-weight: bold; color: #0b573d; }
                        .header-text p { margin: 0; color: #6c757d; }
                        .table { border: 1px solid #dee2e6; }
                        .table thead { background-color: #f8f9fa; }
                        .table th, .table td { vertical-align: middle; }
                        .text-success { color: #198754 !important; }
                        .text-danger { color: #dc3545 !important; }
                        .text-muted { color: #6c757d !important; }
                        @media print {
                            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                            .btn { display: none; }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <img src="{{ asset('images/logo new.png') }}" alt="Lelo's Resort Logo">
                        <div class="header-text">
                            <h3>Monthly Report Comparison</h3>
                            <p>Comparing ${month1Label} and ${month2Label}</p>
                        </div>
                    </div>
                    ${tableHtml}
                </body>
            </html>
        `);
        printWindow.document.close();
        
        // Use a timeout to ensure content is loaded before printing
        setTimeout(() => {
            printWindow.focus();
            printWindow.print();
        }, 500);
    });
});
    </script>
</body>

</html>