<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <title>Staff Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
    
</style>
<body style="margin: 0; padding: 0; height: 100vh; background-color: white; overflow-x: hidden;">
    @include('Alert.loginSucess')
    @include('Alert.notification')
        <!-- NAVBAR -->
        @include('Navbar.sidenavbarStaff')

        <!-- Main Content -->
        <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width">
            

            <!-- After the Pending Bookings Section -->
            <div class="row">
                <div class="col-11  mx-auto">
                    <div class="hero-banner" style="background-image:url('{{ asset('images/staff-admin-bg.jpg') }}');  background-size: cover; background-position: center; height: 450px; border-radius: 15px;">
                    </div>
                </div>
            </div>

            
<div class="position-absolute d-flex flex-column align-items-start text-start" 
    style="top: 50%; left: 61%; transform: translate(-50%, -50%); width: 100%; padding: 0 20px;">

    <p class="text-white" style="font-family: 'Poppins', sans-serif; font-size: clamp(2rem, 5vw, 3rem); letter-spacing: 5px;">
        Hello,
    </p>
    <h1 class="text-capitalize fw-bolder" 
        style="font-family: 'Montserrat', sans-serif; font-size: clamp(3rem, 8vw, 5rem); color:#ffffff; letter-spacing: clamp(5px, 2vw, 15px); white-space: normal; overflow-wrap: break-word; font-weight: 900; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
        {{ $staffCredentials->username }}!
    </h1>
</div>
            <div class="position-absolute w-100" style="top: 450px; left: 0;">
                <div class="d-flex justify-content-center">
                    <div class="w-75">
                        <div class="card border-2 shadow-lg" style="background-color: rgba(255, 255, 255, 0.95);">
                            <div class="card-header bg-white py-3">
                                <h2 class="font-heading mb-0 fs-3 fw-bold" style="color: #0b573d;">Today's Reservations</h2>
                            </div>
                            <div style="height: 150px; overflow-y: auto;">
                            <div class="card-body">
                                @if($todayReservations->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Room</th>
                                                    <th>Room Type</th>
                                                    <th>Guest Name</th>
                                                    <th>Arrival Time</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($todayReservations as $reservation)
                                                    <tr>
                                                        <td>{{ $reservation->room_numbers }}</td>
                                                        <td>{{ $reservation->accomodation_name}}</td>
                                                        <td>{{ $reservation->guest_name }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($reservation->reservation_check_in)->format('h:i A') }}</td>
                                                        <td>
                                                            <span class="badge text-capitalize" style="background-color: {{ $reservation->reservation_status === 'checked-in' ? '#0b573d' : ($reservation->reservation_status === 'pending' ? '#ffc107' : '#dc3545') }}">
                                                                {{ $reservation->reservation_status }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @if($reservation->reservation_status !== 'checked-in')
                                                                <a href="{{ route('staff.reservation') }}" 
                                                                class="btn btn-sm color-background8 text-white"
                                                                style="transition: all 0.3s ease;">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-secondary font-paragraph fst-italic opacity-50 fs-5">No reservations for today.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="my-5"></div>
        
        <!-- Dashboard Cards -->
        <div class="col-11 mx-auto my-4" style="margin-top: 120px !important;">
            <div class="row g-4">
                <!-- Column 1: Total Reservations and Checked-in Guests -->
                <div class="col-12 col-sm-6 col-lg-2">
                    <!-- Total Reservations -->
                    <div class="flex-grow-1 p-4 rounded-4 shadow-lg position-relative overflow-hidden mb-4" 
                        style="background: linear-gradient(135deg,rgb(75, 96, 7) 0%,rgb(129, 235, 48) 100%); border: none;">
                        
                        <div class="position-absolute top-0 end-0 opacity-25">
                            <i class="fas fa-clock" style="font-size: 4rem; margin: -10px;"></i>
                        </div>

                        <div class="d-flex align-items-center position-relative">
                            <div>
                                <h2 class="fs-1 fw-bold text-white mb-2 position-relative" 
                                    style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                    {{$pendingReservations ?? 0}}
                                </h2>
                                <p class="text-white text-uppercase mb-0 font-paragraph fw-bold position-relative" 
                                style="font-size: 0.85rem; opacity: 0.95;">
                                    Pending<br>Reservations
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Checked-in Guests -->
                    <div class="flex-grow-1 p-4 rounded-4 shadow-lg position-relative overflow-hidden" 
                    style="background: linear-gradient(135deg, #43cea2 0%, #385E3C 100%); border: none;">
                        
                        <div class="position-absolute top-0 end-0 opacity-25">
                            <i class="fas fa-user-check" style="font-size: 4rem; margin: -10px;"></i>
                        </div>

                        <div class="d-flex align-items-center position-relative">
                            <div>
                                <h2 class="fs-1 fw-bold text-white mb-2 position-relative" 
                                    style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                    {{ $checkedInGuests ?? 0}}
                                </h2>
                                <p class="text-white text-uppercase mb-0 font-paragraph fw-bold position-relative" 
                                style="font-size: 0.85rem; opacity: 0.95;">
                                    Checked-in<br>Guests
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 2: Pending Payments and Available Accommodations -->
                <div class="col-12 col-sm-6 col-lg-2">
                    <!-- Total Rooms Available -->
                    <div class="flex-grow-1 p-4 rounded-4 shadow-lg position-relative overflow-hidden mb-4" 
                        style="background: linear-gradient(135deg, #43cea2 0%, #385E3C 100%); border: none;">
                        
                        <div class="position-absolute top-0 end-0 opacity-25">
                            <i class="fas fa-bed" style="font-size: 4rem; margin: -10px;"></i>
                        </div>

                        <div class="d-flex align-items-center position-relative">
                            <div>
                                <h2 class="fs-1 fw-bold text-white mb-2 position-relative" 
                                    style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                    {{ $availableAccommodations ?? 0 }}
                                </h2>
                                <p class="text-white text-uppercase mb-0 font-paragraph fw-bold position-relative" 
                                style="font-size: 0.85rem; opacity: 0.95;">
                                    Total Rooms<br>Available
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Check-outs Today -->
                    <div class="flex-grow-1 p-4 rounded-4 shadow-lg position-relative overflow-hidden" 
                    style="background: linear-gradient(135deg,rgb(75, 96, 7) 0%,rgb(129, 235, 48) 100%); border: none;">
                        
                        <div class="position-absolute top-0 end-0 opacity-25">
                            <i class="fas fa-sign-out-alt" style="font-size: 4rem; margin: -10px;"></i>
                        </div>

                        <div class="d-flex align-items-center position-relative">
                            <div>
                                <h2 class="fs-1 fw-bold text-white mb-2 position-relative" 
                                    style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                    {{ $checkedOutGuests ?? 0 }}
                                </h2>
                                <p class="text-white text-uppercase mb-0 font-paragraph fw-bold position-relative" 
                                style="font-size: 0.85rem; opacity: 0.95;">
                                    Check-outs<br>Today
                                </p>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Column 3: Pending Bookings -->
                <div class="col-12 col-lg-8">
                    <div class="p-4 rounded-4 border border-4" 
                        style="background: linear-gradient(to top, rgb(211, 209, 209), #ffffff); min-height: 300px; height: 100%;">
                        
                        <h2 class="font-heading mb-3 text-center fw-bold fs-4 fs-md-3 fs-lg-1" style="color: #0b573d;">
                            Pending Bookings
                        </h2>

                        @if($pendingReservationsList && count($pendingReservationsList) > 0)
                            <div class="overflow-auto" style="max-height: 300px;">
                                @foreach($pendingReservationsList as $reservation)
                                    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-2 p-2 border-bottom">
                                        <div>
                                            <p class="mb-0 font-paragraph fw-bold">{{ $reservation->guest_name }}</p>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('M d, Y') }}
                                                - {{ \Carbon\Carbon::parse($reservation->reservation_check_in)->format('h:i A') }}
                                            </small>
                                        </div>
                                        <span class="badge bg-warning text-dark mt-2 mt-sm-0">Pending</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-secondary text-center font-paragraph fst-italic">No pending reservations.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

</body>
</html>