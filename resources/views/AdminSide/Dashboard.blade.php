<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="icon" type="image/png" href="{{ asset('images/logo new.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    #statusChart {
        max-height: 240px !important;
        height: 240px !important;
    }
    
    .status-chart-container {
        height: 350px !important;
        display: flex;
        flex-direction: column;
    }
    
    .status-chart-container .card-body {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .status-chart-container canvas {
        flex-grow: 1;
        max-height: 280px !important;
    }
    #reservationChart {
        height: 300px !important;
    }

    /* Medium screens and below */
    @media (max-width: 768px) {
        #reservationChart {
            height: 300px !important; /* taller for tablets/small screens */
        }
    }

    /* Extra small screens */
    @media (max-width: 576px) {
        #reservationChart {
            height: 350px !important; /* even taller for phones */
        }
    }
    /* Custom legend styling */
    .custom-legend {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 15px;
        gap:10px;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        margin: 5px;
        background: #f8f9fa;
        padding: 5px 10px;
        border-radius: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .legend-color {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        margin-right: 8px;
    }
    
    .legend-text {
        font-size: 12px;
        font-weight: 500;
    }
    
    .legend-value {
        font-weight: bold;
        margin-left: 5px;
    }
</style>
<x-loading-screen />
<body style="margin: 0; padding: 0; height: 100vh; background-color: white; overflow-x: hidden;">
    @include('Alert.loginSucess')

    <!-- NAVBAR -->
    @include('Navbar.sidenavbar')


<!-- Main Content -->
<div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width">
    <div class="row">
        <div class="col-12 col-lg-11 mx-auto mt-4">
            <div class="hero-banner d-flex align-items-center"
                 style="background-image: url('{{ asset('images/staff-admin-bg.jpg') }}'); 
                        background-size: cover; 
                        background-position: center; 
                        min-height: 450px; 
                        border-radius: 15px; 
                        padding: 40px;">

                <div class="container-fluid">
                    <div class="row g-4">
                        <!-- LEFT SIDE -->
                        <div class="col-12 col-lg-5 d-flex flex-column">
                            <!-- Greeting -->
                            <p class="text-white mb-1" 
                               style="font-family: 'Poppins', sans-serif; font-size: clamp(1.2rem, 3vw, 2rem); letter-spacing: 2px;">
                                Hello,
                            </p>
                            <h1 class="fw-bolder mb-4 text-white text-capitalize" 
                                style="font-family: 'Montserrat', sans-serif; font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 900;">
                                {{ $adminCredentials->username }}
                            </h1>

                            <!-- Pending Reservations -->
                            <div class="bg-white rounded-4 shadow p-3 mb-4" style="max-width: 450px;">
                                <h5 class="fw-bold text-success mb-3">Pending Reservations</h5>
                                <ul class="list-group list-group-flush">
                                    @if(count($latestReservations) > 0)
                                        @foreach ($latestReservations as $reservation)
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                                <span class="fw-semibold">{{ $reservation->name }}</span>
                                                <span class="badge bg-success rounded-pill">
                                                    {{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('M d') }}
                                                </span>
                                            </li>
                                        @endforeach
                                    @else
                                        <li class="list-group-item text-center py-3">
                                            <i class="fas fa-calendar-times text-muted mb-2"></i>
                                            <p class="m-0">No pending reservations</p>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <!-- Total Guest on Site -->
                            <div class="flex-grow-1 p-4 rounded-4 shadow-lg position-relative overflow-hidden" 
                                 style="background: linear-gradient(135deg, #43cea2 0%, #385E3C 100%); border: none; max-width: 450px;">
                                <div class="position-absolute top-0 end-0 opacity-25">
                                    <i class="fas fa-person-booth" style="font-size: 4rem; margin: -10px;"></i>
                                </div>
                                <div class="d-flex align-items-center position-relative">
                                    <div>
                                        <h2 class="fs-1 fw-bold text-white mb-2 position-relative" 
                                            style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                            {{ $guestsOnSite->total ?? 0 }}
                                        </h2>
                                        <p class="text-white text-uppercase mb-0 font-paragraph fw-bold position-relative" 
                                           style="font-size: 0.85rem; opacity: 0.95;">
                                            Total Guest<br>on Site
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT SIDE (STAT BOXES 2x3) -->
                        <div class="col-12 col-lg-7">
                            <div class="row g-3">
                                <!-- Box 1 -->
                                <div class="col-6">
                                    <div class="flex-grow-1 p-4 rounded-4 shadow-lg position-relative overflow-hidden h-100" 
                                         style="background: linear-gradient(135deg, #43cea2 0%, #385E3C 100%); border: none;">
                                        <div class="position-absolute top-0 end-0 opacity-25">
                                            <i class="fas fa-calendar-alt" style="font-size: 4rem; margin: -10px;"></i>
                                        </div>
                                        <div class="d-flex align-items-center position-relative">
                                            <div>
                                                <h2 class="fs-1 fw-bold text-white mb-2 position-relative" 
                                                    style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                                    {{$totalBookings ?? 0 }}
                                                </h2>
                                                <p class="text-white text-uppercase mb-0 font-paragraph fw-bold position-relative" 
                                                   style="font-size: 0.85rem; opacity: 0.95;">
                                                    Total<br>Reservations
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Box 2 -->
                                <div class="col-6">
                                    <div class="flex-grow-1 p-4 rounded-4 shadow-lg position-relative overflow-hidden h-100" 
                                         style="background: linear-gradient(135deg, #36D1DC 0%, #5B86E5 100%); border: none;">
                                        <div class="position-absolute top-0 end-0 opacity-25">
                                            <i class="fas fa-users" style="font-size: 4rem; margin: -10px;"></i>
                                        </div>
                                        <div class="d-flex align-items-center position-relative">
                                            <div>
                                                <h2 class="fs-1 fw-bold text-white mb-2 position-relative" 
                                                    style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                                    {{$totalGuests ?? 0 }}
                                                </h2>
                                                <p class="text-white text-uppercase mb-0 font-paragraph fw-bold position-relative" 
                                                   style="font-size: 0.85rem; opacity: 0.95;">
                                                    Total<br>Guest
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Box 3 -->
                                <div class="col-6">
                                    <div class="flex-grow-1 p-4 rounded-4 shadow-lg position-relative overflow-hidden h-100" 
                                         style="background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%); border: none;">
                                        <div class="position-absolute top-0 end-0 opacity-25">
                                            <i class="fas fa-door-open" style="font-size: 4rem; margin: -10px;"></i>
                                        </div>
                                        <div class="d-flex align-items-center position-relative">
                                            <div>
                                                <h2 class="fs-1 fw-bold text-white mb-2 position-relative" 
                                                    style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                                    {{ $checkInReservations->total ?? 0 }}
                                                </h2>
                                                <p class="text-white text-uppercase mb-0 font-paragraph fw-bold position-relative" 
                                                   style="font-size: 0.85rem; opacity: 0.95;">
                                                    Total<br>Checked-in
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Box 4 -->
                                <div class="col-6">
                                    <div class="flex-grow-1 p-4 rounded-4 shadow-lg position-relative overflow-hidden h-100" 
                                         style="background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%); border: none;">
                                        <div class="position-absolute top-0 end-0 opacity-25">
                                            <i class="fas fa-luggage-cart" style="font-size: 4rem; margin: -10px;"></i>
                                        </div>
                                        <div class="d-flex align-items-center position-relative">
                                            <div>
                                                <h2 class="fs-1 fw-bold text-white mb-2 position-relative" 
                                                    style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                                    {{ $checkOutReservations->total ?? 0 }}
                                                </h2>
                                                <p class="text-white text-uppercase mb-0 font-paragraph fw-bold position-relative" 
                                                   style="font-size: 0.85rem; opacity: 0.95;">
                                                    Total<br>Check-out
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Box 5 -->
                                <div class="col-6">
                                    <div class="flex-grow-1 p-4 rounded-4 shadow-lg position-relative overflow-hidden h-100" 
                                         style="background: linear-gradient(135deg, #F7971E 0%, #FFD200 100%); border: none;">
                                        <div class="position-absolute top-0 end-0 opacity-25">
                                            <i class="fas fa-money-bill" style="font-size: 4rem; margin: -10px;"></i>
                                        </div>
                                        <div class="d-flex align-items-center position-relative">
                                            <div>
                                                <h2 class="fs-1 fw-bold text-white mb-2 position-relative" 
                                                    style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                                    ₱{{ number_format($todayIncome ?? 0, 2) }}
                                                </h2>
                                                <p class="text-white text-uppercase mb-0 font-paragraph fw-bold position-relative" 
                                                   style="font-size: 0.85rem; opacity: 0.95;">
                                                    Total<br>Income
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Box 6 -->
                                <div class="col-6">
                                    <div class="flex-grow-1 p-4 rounded-4 shadow-lg position-relative overflow-hidden h-100" 
                                         style="background: linear-gradient(135deg, #606c88 0%, #3f4c6b 100%); border: none;">
                                        <div class="position-absolute top-0 end-0 opacity-25">
                                            <i class="fas fa-ban" style="font-size: 4rem; margin: -10px;"></i>
                                        </div>
                                        <div class="d-flex align-items-center position-relative">
                                            <div>
                                                <h2 class="fs-1 fw-bold text-white mb-2 position-relative" 
                                                    style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                                    {{ $cancelledReservations->total ?? 0 }}
                                                </h2>
                                                <p class="text-white text-uppercase mb-0 font-paragraph fw-bold position-relative" 
                                                   style="font-size: 0.85rem; opacity: 0.95;">
                                                    Cancelled<br>Reservation
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END RIGHT SIDE -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Online Reservation Section -->
<div class="row mt-4">
    <div class="col-12 col-lg-11 mx-auto">
        <div class="shadow-lg p-4 bg-white rounded">
            <div class="container">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <h2 class="fw-bold text-black mb-0 border-bottom text-center text-md-start" style="font-size: 2rem;">
                        RESERVATION OVERVIEW
                    </h2>

                    <!-- Filter Dropdowns: labels beside select -->
                    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3 w-100 w-md-auto">
                        <!-- Filter By -->
                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2 w-100 w-sm-auto">
                            <label for="timeFilter" class="form-label font-paragraph fw-semibold mb-0" style="white-space: nowrap;">Filter By:</label>
                            <select id="timeFilter" class="form-control" style="min-width: 100px; height: 50px;">
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                        </div>

                        <!-- Year -->
                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2 w-100 w-sm-auto">
                            <label for="yearFilter" class="form-label mb-0 font-paragraph fw-semibold">Year:</label>
                            <select id="yearFilter" class="form-control" style="min-width: 150px; height: 50px;">
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Reservation Type -->
                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2 w-100 w-sm-auto">
                            <label for="reservationType" class="form-label font-paragraph fw-semibold mb-0" style="white-space: nowrap;">Reservation Type:</label>
                            <select id="reservationType" class="form-control" style="min-width: 100px; height: 50px;">
                                <option value="">All Reservations</option>
                                <option value="walkin">Walk-in</option>
                                <option value="online">Online</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Left Side - Graph -->
                    <div class="col-12 col-md-6">
                        <div class="card shadow-lg rounded-4 border-0 h-100">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold mb-4">Reservation Breakdown Status</h5>
                                <canvas id="statusChart"></canvas>
                                <div id="statusLegend" class="custom-legend text-capitalize"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Graph -->
                    <div class="col-12 col-md-6">
                        <div class="card shadow-lg rounded-4 border-0 w-100">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold mb-4">Reservation And Rooms</h5>
                                <canvas id="reservationChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Revenue Overview Section -->
<div class="row mt-4">
    <div class="col-12 col-lg-11 mx-auto">
        <div class="shadow-lg p-4 bg-white rounded">
            <div class="container">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <h2 class="fw-bold text-black mb-0 border-bottom text-center text-md-start" style="font-size: 2rem;">
                        REVENUE OVERVIEW
                    </h2>

                    <!-- Filter Dropdowns for Revenue -->
                    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3 w-100 w-md-auto">
                        <!-- Filter By -->
                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2 w-100 w-sm-auto">
                            <label for="revenueTimeFilter" class="form-label font-paragraph fw-semibold mb-0" style="white-space: nowrap;">Filter By:</label>
                            <select id="revenueTimeFilter" class="form-control" style="min-width: 100px; height: 50px;">
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                        </div>

                        <!-- Year -->
                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2 w-100 w-sm-auto">
                            <label for="revenueYearFilter" class="form-label mb-0 font-paragraph fw-semibold">Year:</label>
                            <select id="revenueYearFilter" class="form-control" style="min-width: 150px; height: 50px;">
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Revenue Type -->
                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2 w-100 w-sm-auto">
                            <label for="revenueType" class="form-label font-paragraph fw-semibold mb-0" style="white-space: nowrap;">Revenue Type:</label>
                            <select id="revenueType" class="form-control" style="min-width: 100px; height: 50px;">
                                <option value="">All Revenue</option>
                                <option value="walkin">Walk-in</option>
                                <option value="online">Online</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-lg rounded-4 border-0">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const dailyData = @json($dailyReservations);
    const weeklyData = @json($weeklyReservations);
    const monthlyData = @json($monthlyReservations);
    const yearlyData = @json($yearlyReservations);
    const dailyWalkinData = @json($dailyWalkins);
    const weeklyWalkinData = @json($weeklyWalkins);
    const monthlyWalkinData = @json($monthlyWalkins);
    const yearlyWalkinData = @json($yearlyWalkins);

    const ctx = document.getElementById('reservationChart').getContext('2d');
    let chart;

    console.log("Initial Data Loaded:", {
        dailyData: dailyData,
        weeklyData: weeklyData,
        monthlyData: monthlyData
    });

    // Build Chart Function
    function buildChart(data, label, timeFilter) {
        if (chart) chart.destroy();
        
        if (data.labels.length === 0) {
            data = {
                labels: ['No Data Available'],
                data: [0],
                rooms: ['No Rooms']
            };
        }
        
        // Format the labels based on the type of view
        const formattedLabels = data.labels.map((dateStr, index) => {
            if (timeFilter === 'daily') {
                // For daily view, show date in a readable format
                const date = new Date(dateStr);
                return date.toLocaleDateString('en-US', { 
                    month: 'short', 
                    day: 'numeric'
                });
            } else if (timeFilter === 'weekly') {
                // For weekly view, show week start date
                return dateStr; // Already formatted in generateAllWeeksData
            } else if (timeFilter === 'monthly') {
                // For monthly view, show month abbreviation
                return dateStr; // Already formatted as 'Jan', 'Feb', etc.
            }
            return dateStr;
        });
        
        const datasets = [];
        
        // Dataset para sa total reservations
        datasets.push({
            label: 'Reservations',
            data: data.data,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            order: 1,
            // Add spacing between bars
            barPercentage: 0.6,
            categoryPercentage: 0.8
        });
        
        // Datasets para sa bawat uri ng room
        if (data.rooms && data.rooms.length > 0) {
            const roomTypes = [...new Set(data.rooms.flat().filter(room => room !== 'No room information'))];
            const roomColors = @json($roomColors);
            
            roomTypes.forEach(roomType => {
                const roomData = data.labels.map((_, index) => {
                    const rooms = data.rooms[index];
                    return Array.isArray(rooms) ? 
                        rooms.filter(room => room === roomType).length : 
                        0;
                });
                
                datasets.push({
                    label: roomType,
                    data: roomData,
                    backgroundColor: roomColors[roomType] || 'rgba(201, 203, 207, 0.5)',
                    borderColor: roomColors[roomType]?.replace('0.5', '1') || 'rgba(201, 203, 207, 1)',
                    borderWidth: 1,
                    order: 2,
                    // Add spacing between bars
                    barPercentage: 0.6,
                    categoryPercentage: 0.8
                });
            });
        }
        
        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: formattedLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                // Add spacing at the top of the chart
                layout: {
                    padding: {
                        top: 10, // Add space at the top for bar values
                        bottom: 15 // Add space at the bottom for labels
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Reservations',
                            padding: {bottom: 10} // Add space below y-axis title
                        },
                        // Add spacing at the top of y-axis
                        grace: '5%',
                        ticks: {
                            padding: 10 // Add space between ticks and axis
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: timeFilter === 'daily' ? 'Date' : 
                                  timeFilter === 'weekly' ? 'Week' : 
                                  timeFilter === 'monthly' ? 'Month' : 'Time Period',
                            padding: {top: 10} // Add space above x-axis title
                        },
                        // Add spacing for x-axis labels
                        ticks: {
                            padding: 10 // Add space between labels and axis
                        }
                    }
                },
                plugins: {
                    legend: { 
                        display: true,
                        position: 'top',
                        // Add spacing for legend
                        labels: {
                            padding: 15, // Add space between legend items
                            usePointStyle: true,
                            pointStyle: 'circle',
                            boxWidth: 10,
                            boxHeight: 10
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if (context.label === 'No Data Available') {
                                    return 'Walang reservations sa napiling panahon';
                                }
                                return `${context.dataset.label}: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        });
        
        // Function to draw values on top of bars
        function drawBarValues() {
            const chartInstance = chart;
            const ctx = chartInstance.ctx;
            
            chartInstance.data.datasets.forEach((dataset, i) => {
                const meta = chartInstance.getDatasetMeta(i);
                
                meta.data.forEach((element, index) => {
                    const value = dataset.data[index];
                    
                    if (value > 0) {
                        ctx.save();
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        ctx.font = 'bold 12px Arial';
                        ctx.fillStyle = '#000';
                        
                        const position = element.tooltipPosition();
                        // Add extra spacing above bars
                        ctx.fillText(value, position.x, position.y - 10);
                        ctx.restore();
                    }
                });
            });
        }
        
        // Draw values after chart is rendered
        chart.options.animation = {
            onComplete: function() {
                drawBarValues();
            }
        };
        
        // Update chart to apply changes
        chart.update();
    }

    // Monthly Data Generator
    function generateAllMonthsData(selectedYear, monthData) {
        const allMonths = [];
        const allMonthLabels = [];
        const allRooms = [];
        
        for (let month = 0; month < 12; month++) {
            const monthDate = new Date(selectedYear, month, 1);
            const monthLabel = monthDate.toLocaleString('default', { month: 'short' });
            allMonthLabels.push(monthLabel);
            
            const foundMonth = monthData.find(item => {
                try {
                    const dataDate = new Date(item.month + '-01');
                    return dataDate.getFullYear() === parseInt(selectedYear) && dataDate.getMonth() === month;
                } catch (e) {
                    console.error("Error parsing month:", item.month, e);
                    return false;
                }
            });
            
            allMonths.push(foundMonth ? foundMonth.total : 0);
            allRooms.push(foundMonth ? foundMonth.rooms : []);
        }
        
        return {
            labels: allMonthLabels,
            data: allMonths,
            rooms: allRooms
        };
    }

    // Weekly Data Generator
    function generateAllWeeksData(selectedYear, filteredData) {
        const allWeeks = Array.from({ length: 52 }, (_, i) => i + 1);
        const weekDataMap = {};
        const weekRoomsMap = {};

        // Store totals and rooms in maps by week number
        filteredData.forEach(item => {
            const weekNum = parseInt(String(item.week).slice(-2));
            weekDataMap[weekNum] = item.total;
            weekRoomsMap[weekNum] = item.rooms || [];
        });

        const allWeekData = [];
        const allWeekLabels = [];
        const allRooms = [];

        allWeeks.forEach(week => {
            const firstDayOfYear = new Date(selectedYear, 0, 1);
            const day = firstDayOfYear.getDay();
            const diff = (day <= 4 ? day - 1 : day - 8);
            const monday = new Date(firstDayOfYear.setDate(firstDayOfYear.getDate() - diff + (week - 1) * 7));

            const label = monday.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });

            allWeekLabels.push(label);
            allWeekData.push(weekDataMap[week] || 0);
            allRooms.push(weekRoomsMap[week] || []);
        });

        return {
            labels: allWeekLabels,
            data: allWeekData,
            rooms: allRooms
        };
    }

    // Main Filter Function
    function filterData(selectedTimeFilter, selectedYear) {
        selectedYear = parseInt(selectedYear);
        const reservationType = document.getElementById('reservationType').value;
        
        let selectedDaily, selectedWeekly, selectedMonthly, selectedYearly;
        if (reservationType === 'walkin') {
            selectedDaily = dailyWalkinData;
            selectedWeekly = weeklyWalkinData;
            selectedMonthly = monthlyWalkinData;
            selectedYearly = yearlyWalkinData;
        } else if (reservationType === 'online') {
            selectedDaily = dailyData;
            selectedWeekly = weeklyData;
            selectedMonthly = monthlyData;
            selectedYearly = yearlyData;
        } else {
            // All - default to online for simplicity
            selectedDaily = dailyData;
            selectedWeekly = weeklyData;
            selectedMonthly = monthlyData;
            selectedYearly = yearlyData;
        }
        
        if (selectedTimeFilter === 'daily') {
            const filteredData = selectedDaily.filter(item => {
                try {
                    const itemDate = new Date(item.date);
                    return itemDate.getFullYear() === selectedYear;
                } catch (e) {
                    console.error("Error parsing date:", item.date, e);
                    return false;
                }
            });
            
            filteredData.sort((a, b) => new Date(a.date) - new Date(b.date));
            
            return {
                labels: filteredData.map(item => new Date(item.date).toLocaleDateString()),
                data: filteredData.map(item => item.total),
                rooms: filteredData.map(item => item.rooms || [])
            };
        } else if (selectedTimeFilter === 'weekly') {
            const filteredData = selectedWeekly.filter(item => {
                try {
                    const weekStr = String(item.week);
                    let yearFromWeek = weekStr.length === 6 ? parseInt(weekStr.substring(0, 4)) : parseInt(weekStr.split('-')[0]);
                    return yearFromWeek === selectedYear;
                } catch (e) {
                    console.error("Error parsing week:", item.week, e);
                    return false;
                }
            });
            
            filteredData.sort((a, b) => parseInt(String(a.week).slice(-2)) - parseInt(String(b.week).slice(-2)));
            
            return generateAllWeeksData(selectedYear, filteredData);
        } else if (selectedTimeFilter === 'monthly') {
            return generateAllMonthsData(selectedYear, selectedMonthly);
        }
        
        return { labels: [], data: [], rooms: [] };
    }

    document.getElementById('timeFilter').addEventListener('change', function () {
        const selectedTimeFilter = this.value;
        const selectedYear = document.getElementById('yearFilter').value;
        
        const chartData = filterData(selectedTimeFilter, selectedYear);
        const label = selectedTimeFilter === 'daily' ? 'Daily Reservations' :
                      selectedTimeFilter === 'weekly' ? 'Weekly Reservations' :
                      selectedTimeFilter === 'monthly' ? 'Monthly Reservations' : '';
        
        buildChart(chartData, label, selectedTimeFilter);
    });
    
    // Reservation Type Filter Event
    document.getElementById('reservationType').addEventListener('change', function () {
        const selectedTimeFilter = document.getElementById('timeFilter').value;
        const selectedYear = document.getElementById('yearFilter').value;
        
        const chartData = filterData(selectedTimeFilter, selectedYear);
        const label = selectedTimeFilter === 'daily' ? 'Daily Reservations' :
                      selectedTimeFilter === 'weekly' ? 'Weekly Reservations' :
                      selectedTimeFilter === 'monthly' ? 'Monthly Reservations' : '';
        
        buildChart(chartData, label, selectedTimeFilter);
    });

    document.getElementById('yearFilter').addEventListener('change', function () {
        const selectedYear = this.value;
        const selectedTimeFilter = document.getElementById('timeFilter').value;
        const selectedReservationType = document.getElementById('reservationType').value;
        window.location.href = `?year=${selectedYear}&timeFilter=${selectedTimeFilter}&reservationType=${selectedReservationType}`;
    });

    const currentYear = new Date().getFullYear();
    const urlParams = new URLSearchParams(window.location.search);
    const yearParam = urlParams.get('year') || currentYear;
    const timeFilterParam = urlParams.get('timeFilter') || 'daily';
    const reservationTypeParam = urlParams.get('reservationType') || '';
    
    document.getElementById('yearFilter').value = yearParam;
    document.getElementById('timeFilter').value = timeFilterParam;
    document.getElementById('reservationType').value = reservationTypeParam;
    
    const initialData = filterData(timeFilterParam, yearParam);
    const initialLabel = timeFilterParam === 'daily' ? 'Daily Reservations' :
                        timeFilterParam === 'weekly' ? 'Weekly Reservations' :
                        timeFilterParam === 'monthly' ? 'Monthly Reservations' : '';
    
    buildChart(initialData, initialLabel, timeFilterParam);
</script>
<!-- Reservation Status Breakdown -->
<script>
    const statusCounts = @json($reservationStatusCounts);
    const statusLabels = Object.keys(statusCounts);
    const statusTotals = Object.values(statusCounts);
    const totalReservations = statusTotals.reduce((sum, value) => sum + value, 0);
    const statusColors = @json(array_values($statusColors));

    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    
    // Create the chart
    const statusChart = new Chart(ctxStatus, {
        type: 'pie',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusTotals,
                backgroundColor: statusColors,
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // We'll use our custom legend
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            const percentage = ((value / totalReservations) * 100).toFixed(1);
                            return `${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
    
    // Function to draw labels directly on the chart
    function drawChartLabels() {
        const chart = statusChart;
        const ctx = chart.ctx;
        const chartArea = chart.chartArea;
        
        // Clear any previous labels
        ctx.clearRect(0, 0, chart.width, chart.height);
        
        // Redraw the chart
        chart.draw();
        
        // Get the metadata for the dataset
        const meta = chart.getDatasetMeta(0);
        
        // Set text style
        ctx.font = 'bold 12px Arial';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        
        // Draw labels on each segment
        meta.data.forEach((element, index) => {
            const value = statusTotals[index];
            if (value === 0) return; // Skip if value is zero
            
            // Calculate percentage
            const percentage = ((value / totalReservations) * 100).toFixed(1);
            
            // Determine text color based on segment color (for contrast)
            const segmentColor = statusColors[index];
            const textColor = getContrastColor(segmentColor);
            
            // Get the position for the label
            const {x, y} = element.tooltipPosition();
            
            // Draw only the percentage on the pie chart
            ctx.fillStyle = textColor;
            ctx.fillText(`${percentage}%`, x, y);
        });
    }
    
    // Helper function to determine text color based on background color
    function getContrastColor(hexColor) {
        // Convert hex to RGB
        const r = parseInt(hexColor.slice(1, 3), 16);
        const g = parseInt(hexColor.slice(3, 5), 16);
        const b = parseInt(hexColor.slice(5, 7), 16);
        
        // Calculate luminance
        const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
        
        // Return black or white based on luminance
        return luminance > 0.5 ? '#000' : '#fff';
    }
    
    // Create custom legend with only labels (no numbers)
    function createCustomLegend() {
        const legendContainer = document.getElementById('statusLegend');
        legendContainer.innerHTML = '';
        
        statusLabels.forEach((label, index) => {
            const legendItem = document.createElement('div');
            legendItem.className = 'legend-item';
            
            const colorBox = document.createElement('div');
            colorBox.className = 'legend-color';
            colorBox.style.backgroundColor = statusColors[index];
            
            const textSpan = document.createElement('span');
            textSpan.className = 'legend-text';
            textSpan.textContent = label; // Only show the label, no numbers
            
            legendItem.appendChild(colorBox);
            legendItem.appendChild(textSpan);
            legendContainer.appendChild(legendItem);
        });
    }
    
    // Draw labels after the chart is rendered
    statusChart.options.animation = {
        onComplete: function() {
            drawChartLabels();
            createCustomLegend();
        }
    };
    
    // Initialize the chart
    statusChart.update();
</script>

<!-- Revenue Chart -->
<script>
    // Revenue Data
    const dailyRevenue = @json($dailyRevenue);
    const weeklyRevenue = @json($weeklyRevenue);
    const monthlyRevenue = @json($monthlyRevenue);
    const dailyWalkinRevenue = @json($dailyWalkinRevenue);
    const weeklyWalkinRevenue = @json($weeklyWalkinRevenue);
    const monthlyWalkinRevenue = @json($monthlyWalkinRevenue);

    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    let revenueChart;

    // Build Revenue Chart Function
    function buildRevenueChart(data, label, timeFilter) {
        if (revenueChart) revenueChart.destroy();
        
        if (data.labels.length === 0) {
            data = {
                labels: ['No Data Available'],
                data: [0]
            };
        }
        
        // Format the labels based on the type of view
        const formattedLabels = data.labels.map((dateStr, index) => {
            if (timeFilter === 'daily') {
                const date = new Date(dateStr);
                return date.toLocaleDateString('en-US', { 
                    month: 'short', 
                    day: 'numeric'
                });
            } else if (timeFilter === 'weekly') {
                const weekNum = parseInt(dateStr.split(' ')[1]);
                return `W${weekNum}`;
            } else if (timeFilter === 'monthly') {
                return dateStr; // Already formatted as 'Jan', 'Feb', etc.
            }
            return dateStr;
        });
        
        // Professional color palette
        const lineColor = 'rgba(56, 94, 60, 1)'; // Dark green
        const fillColor = 'rgba(56, 94, 60, 0.1)'; // Light green with opacity
        const pointColor = 'rgba(56, 94, 60, 1)';
        const pointHighlightColor = 'rgba(255, 255, 255, 1)';
        const pointBorderColor = 'rgba(56, 94, 60, 1)';
        
        revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: formattedLabels,
                datasets: [{
                    label: label,
                    data: data.data,
                    backgroundColor: fillColor,
                    borderColor: lineColor,
                    borderWidth: 3,
                    pointBackgroundColor: pointColor,
                    pointBorderColor: pointBorderColor,
                    pointHoverBackgroundColor: pointHighlightColor,
                    pointHoverBorderColor: lineColor,
                    pointHoverBorderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    fill: true,
                    tension: 0.3, // Smooth curve
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 20,
                        bottom: 15,
                        left: 10,
                        right: 10
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        title: {
                            display: true,
                            text: 'Amount (₱)',
                            padding: {bottom: 10},
                            font: {
                                weight: 'bold',
                                size: 12
                            },
                            color: '#555'
                        },
                        grace: '10%',
                        ticks: {
                            padding: 10,
                            callback: function(value) {
                                if (value >= 1000) {
                                    return '₱' + (value/1000).toFixed(1) + 'k';
                                }
                                return '₱' + value;
                            },
                            font: {
                                size: 11
                            },
                            color: '#666'
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        title: {
                            display: true,
                            text: timeFilter === 'daily' ? 'Date' : 
                                  timeFilter === 'weekly' ? 'Week' : 'Month',
                            padding: {top: 15},
                            font: {
                                weight: 'bold',
                                size: 12
                            },
                            color: '#555'
                        },
                        ticks: {
                            padding: 10,
                            maxRotation: 45,
                            minRotation: 30,
                            font: {
                                size: 11
                            },
                            color: '#666'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 12,
                            boxHeight: 12,
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12,
                                weight: 'bold'
                            },
                            color: '#333'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#333',
                        bodyColor: '#666',
                        borderColor: 'rgba(0, 0, 0, 0.1)',
                        borderWidth: 1,
                        padding: 12,
                        boxPadding: 6,
                        usePointStyle: true,
                        callbacks: {
                            label: function(context) {
                                if (context.label === 'No Data Available') {
                                    return 'No revenue data available';
                                }
                                return `Revenue: ₱${context.raw.toLocaleString()}`;
                            },
                            title: function(context) {
                                return context[0].label;
                            },
                            labelColor: function(context) {
                                return {
                                    borderColor: lineColor,
                                    backgroundColor: lineColor,
                                    borderWidth: 2,
                                    borderRadius: 2,
                                };
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                elements: {
                    line: {
                        tension: 0.3 // Smooth lines
                    }
                },
                animations: {
                    tension: {
                        duration: 1000,
                        easing: 'linear'
                    }
                }
            }
        });
        
        // Function to draw values on top of points
        function drawRevenueValues() {
            const chartInstance = revenueChart;
            const ctx = chartInstance.ctx;
            
            chartInstance.data.datasets.forEach((dataset, i) => {
                const meta = chartInstance.getDatasetMeta(i);
                
                meta.data.forEach((element, index) => {
                    const value = dataset.data[index];
                    
                    if (value > 0) {
                        ctx.save();
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        ctx.font = 'bold 11px Arial';
                        ctx.fillStyle = '#333';
                        
                        const position = element.tooltipPosition();
                        ctx.fillText('₱' + value.toLocaleString(), position.x, position.y - 15);
                        ctx.restore();
                    }
                });
            });
        }
        
        // Draw values after chart is rendered
        revenueChart.options.animation = {
            onComplete: function() {
                drawRevenueValues();
            }
        };
        
        revenueChart.update();
    }

    // Revenue Filter Function
    function filterRevenueData(selectedTimeFilter, selectedYear) {
        selectedYear = parseInt(selectedYear);
        const revenueType = document.getElementById('revenueType').value;
        
        let selectedData;
        
        if (revenueType === 'walkin') {
            if (selectedTimeFilter === 'daily') {
                selectedData = dailyWalkinRevenue;
            } else if (selectedTimeFilter === 'weekly') {
                selectedData = weeklyWalkinRevenue;
            } else if (selectedTimeFilter === 'monthly') {
                selectedData = monthlyWalkinRevenue;
            }
        } else if (revenueType === 'online') {
            if (selectedTimeFilter === 'daily') {
                selectedData = dailyRevenue;
            } else if (selectedTimeFilter === 'weekly') {
                selectedData = weeklyRevenue;
            } else if (selectedTimeFilter === 'monthly') {
                selectedData = monthlyRevenue;
            }
        } else {
            // Combine both online and walk-in data
            if (selectedTimeFilter === 'daily') {
                selectedData = [...dailyRevenue, ...dailyWalkinRevenue];
            } else if (selectedTimeFilter === 'weekly') {
                selectedData = [...weeklyRevenue, ...weeklyWalkinRevenue];
            } else if (selectedTimeFilter === 'monthly') {
                selectedData = [...monthlyRevenue, ...monthlyWalkinRevenue];
            }
        }
        
        // Process the data for the chart
        const labels = selectedData.map(item => item.date || item.week || item.month);
        const data = selectedData.map(item => parseFloat(item.total_revenue) || 0);
        
        return {
            labels: labels,
            data: data
        };
    }

    // Event Listeners for Revenue Chart
    document.getElementById('revenueTimeFilter').addEventListener('change', function() {
        const selectedTimeFilter = this.value;
        const selectedYear = document.getElementById('revenueYearFilter').value;
        
        const chartData = filterRevenueData(selectedTimeFilter, selectedYear);
        const label = selectedTimeFilter === 'daily' ? 'Daily Revenue' :
                      selectedTimeFilter === 'weekly' ? 'Weekly Revenue' : 'Monthly Revenue';
        
        buildRevenueChart(chartData, label, selectedTimeFilter);
    });

    document.getElementById('revenueYearFilter').addEventListener('change', function() {
        const selectedYear = this.value;
        const selectedTimeFilter = document.getElementById('revenueTimeFilter').value;
        const selectedRevenueType = document.getElementById('revenueType').value;
        window.location.href = `?year=${selectedYear}&revenueTimeFilter=${selectedTimeFilter}&revenueType=${selectedRevenueType}`;
    });

    document.getElementById('revenueType').addEventListener('change', function() {
        const selectedTimeFilter = document.getElementById('revenueTimeFilter').value;
        const selectedYear = document.getElementById('revenueYearFilter').value;
        
        const chartData = filterRevenueData(selectedTimeFilter, selectedYear);
        const label = selectedTimeFilter === 'daily' ? 'Daily Revenue' :
                      selectedTimeFilter === 'weekly' ? 'Weekly Revenue' : 'Monthly Revenue';
        
        buildRevenueChart(chartData, label, selectedTimeFilter);
    });

    // Initialize Revenue Chart
    const revenueTimeFilterParam = '{{ request()->input("revenueTimeFilter", "daily") }}';
    const revenueTypeParam = '{{ request()->input("revenueType", "") }}';
    
    document.getElementById('revenueTimeFilter').value = revenueTimeFilterParam;
    document.getElementById('revenueType').value = revenueTypeParam;
    
    const initialRevenueData = filterRevenueData(revenueTimeFilterParam, '{{ $selectedYear }}');
    const initialRevenueLabel = revenueTimeFilterParam === 'daily' ? 'Daily Revenue' :
                               revenueTimeFilterParam === 'weekly' ? 'Weekly Revenue' : 'Monthly Revenue';
    
    // Set a fixed height for the chart container
    document.getElementById('revenueChart').parentElement.style.height = '400px';
    
    buildRevenueChart(initialRevenueData, initialRevenueLabel, revenueTimeFilterParam);
</script>
</body>
</html>