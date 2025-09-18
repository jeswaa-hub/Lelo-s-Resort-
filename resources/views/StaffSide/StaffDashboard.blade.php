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
            h1, h2, h3, h4, h5, h6 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
    }

    p {
        font-family: 'Open Sans', sans-serif;
        font-weight: 400;
    }
</style>
<body style="margin: 0; padding: 0; height: 100vh; background-color: white; overflow-x: hidden;">
    @include('Alert.loginSucess')
    @include('Alert.notification')
        <!-- NAVBAR -->
        @include('Navbar.sidenavbarStaff')

        <!-- Main Content -->
        <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width">
            

    <!-- HERO BANNER -->
    <div class="row">
        <div class="col-11 mx-auto">
            <div class="hero-banner" style="
                background-image: url('{{ asset('images/staff-admin-bg.jpg') }}');
                background-size: cover;
                background-position: center;
                height: min(450px, 50vw);
                border-radius: 15px;
                max-width: 100%;
                margin: 0 auto;
                position: relative;">
                
                <!-- Welcome Text Overlay -->
                <div class="position-absolute top-50 start-50 translate-middle text-start" style="width: 90%;">
                    <p class="text-white mb-4" style="
                        font-family: 'Poppins', sans-serif;
                        font-size: clamp(2rem, 4vw, 3.5rem);
                        letter-spacing: 3px;
                        margin-top: 2rem;
                        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                        Hello,
                    </p>
                    <h1 class="text-capitalize fw-bolder" style="
                        font-family: 'Montserrat', sans-serif;
                        font-size: clamp(3.5rem, 8vw, 5.5rem);
                        color: #ffffff;
                        letter-spacing: clamp(3px, 2vw, 12px);
                        white-space: normal;
                        overflow-wrap: break-word;
                        font-weight: 900;
                        text-shadow: 3px 3px 6px rgba(0,0,0,0.6);
                        margin-top: 1rem;">
                        {{ $staffCredentials->username }}!
                    </h1>
                </div>
            </div>
        </div>
    </div>  

        <!-- Reservations Card -->
        <div class="card border-0 shadow-lg mx-auto" style="
            max-width: 80%;
            margin-top: -50px;
            background-color: rgba(255, 255, 255, 0.98);
            border-radius: 15px;">
            
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h2 class="font-heading mb-0 fs-3 fw-bold" style="color: #0b573d;">GUEST INFORMATION OVERVIEW</h2>
            </div>

            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @if($todayReservations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3">Room</th>
                                    <th class="py-3">Room Type</th>
                                    <th class="py-3">Guest Name</th>
                                    <th class="py-3">Arrival Time</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayReservations as $reservation)
                                    <tr>
                                        <td class="py-3">{{ $reservation->room_numbers }}</td>
                                        <td class="py-3">{{ $reservation->accomodation_name }}</td>
                                        <td class="py-3 fw-semibold">{{ $reservation->guest_name }}</td>
                                        <td class="py-3">{{ \Carbon\Carbon::parse($reservation->reservation_check_in)->format('h:i A') }}</td>
                                        <td class="py-3">
                                            <span class="badge rounded-pill text-capitalize px-3 py-2" 
                                                style="background-color: {{ $reservation->reservation_status === 'checked-in' ? '#0b573d' : ($reservation->reservation_status === 'pending' ? '#ffc107' : '#dc3545') }}">
                                                {{ $reservation->reservation_status }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            @if($reservation->reservation_status !== 'checked-in')
                                                <a href="{{ route('staff.reservation') }}" 
                                                    class="btn btn-sm btn-primary"
                                                    style="background-color: #0b573d; border: none; transition: all 0.3s ease;">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-secondary font-paragraph fst-italic mb-0 fs-5">No reservations for today.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

        
        <!-- Dashboard Cards -->
        <div class="col-11 mx-auto my-4" style="margin-top: 120px !important;">
            <div class="row g-4">
                <!-- Stats Grid Container -->
                <div class="col-12 col-lg-4">
                    <div class="row g-4">
                        <!-- Column 1: Total Reservations -->
                        <div class="col-6">
                            <div class="flex-grow-1 p-4 rounded-4 shadow-lg position-relative overflow-hidden" 
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
                        </div>

                        <!-- Column 2: Checked-in Guests -->
                        <div class="col-6">
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

                        <!-- Column 3: Total Rooms Available -->
                        <div class="col-6">
                            <div class="flex-grow-1 p-4 rounded-4 shadow-lg position-relative overflow-hidden" 
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
                        </div>

                        <!-- Column 4: Check-outs Today -->
                        <div class="col-6">
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