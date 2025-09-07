 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</style>
<body style="margin: 0; padding: 0; height: 100vh; background-color: white; overflow-x: hidden;">
    @include('Alert.loginSucess')

    <!-- NAVBAR -->
    @include('Navbar.navbarAdmin')


<!-- Main Content -->
<div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width">
    <div class="row">
        <div class="col-12 col-lg-11 mx-auto mt-n4">
            <div class="hero-banner d-flex align-items-center"
                 style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(34,34,34,0.5)), url('{{ asset('images/DSCF2777.JPG') }}'); 
                        background-size: cover; 
                        background-position: center; 
                        min-height: 450px; 
                        border-radius: 15px; 
                        padding: 40px;">

                <div class="container-fluid">
                    <div class="row g-4">
                        
                        <!-- LEFT SIDE -->
                        <div class="col-lg-5 d-flex flex-column">
                            <!-- Greeting -->
                            <p class="text-white mb-1" 
                               style="font-family: 'Poppins', sans-serif; font-size: clamp(1.2rem, 3vw, 2rem); letter-spacing: 2px;">
                                Hello,
                            </p>
                            <h1 class="fw-bolder mb-4 text-white" 
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
                        <div class="col-lg-7">
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
<div class="row">
    <div class="col-12 col-lg-11 mx-auto">
        <div class="shadow-lg p-4 bg-white rounded">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-black mb-0 border-bottom" style="font-size: 2.5rem;">RESERVATION OVERVIEW</h2>
                </div>
                <div class="row g-4">
                    <!-- Left Side - Graph -->
                    <div class="col-md-6">
                        <div class="card shadow-lg rounded-4 border-0">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold mb-4">Reservation Trends</h5>
                                <canvas id="reservationChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Graph -->
                    <div class="col-md-6">
                        <div class="card shadow-lg rounded-4 border-0">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold mb-4">Occupancy Rates</h5>
                                <canvas id="occupancyChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





</body>
</html>