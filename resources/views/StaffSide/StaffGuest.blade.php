<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>

</style>
<body style="margin: 0; padding: 0; height: 100vh; background-color: white; overflow-x: hidden;">
    @include('Alert.loginSucess')

    <!-- NAVBAR -->
    @include('Navbar.sidenavbarStaff')

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
    
<!-- GUEST INFORMATION OVERVIEW CARD -->
<div class="card border-0 shadow-lg mx-auto" style="
            max-width: 80%;
            margin-top: -50px;
            background-color: rgba(255, 255, 255, 0.98);
            border-radius: 15px;">
            
<div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
    <h2 class="font-heading mb-0 fs-3 fw-bold" style="color: #0b573d;">GUEST INFORMATION OVERVIEW</h2>
    
    <div class="position-relative">
        <form action="{{ route('staff.guests') }}" method="GET">
            <!-- Desktop Search Box -->
            <div class="input-group shadow-sm shadow-hover d-none d-md-flex" 
                 style="border-radius: 8px; 
                        overflow: hidden;
                        width: clamp(250px, 30vw, 350px);
                        transition: all 0.3s ease-in-out;
                        background: rgba(255, 255, 255, 0.95);
                        backdrop-filter: blur(5px);
                        border: 1px solid rgba(0, 0, 0, 0.1);">
                <input type="text" 
                       name="search" 
                       class="form-control border-0 ps-4" 
                       placeholder="🔍 Search guest..." 
                       value="{{ request('search') }}" 
                       oninput="toggleClearButton(this)"
                       style="border-radius: 0; height: 30px;">
                <button type="submit" 
                        class="btn px-4"
                        style="border-radius: 0; 
                               height: 45px; 
                               transition: 0.3s;
                               background-color: #0b573d;
                               color: white;">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <!-- Mobile Search Icon -->
            <div class="d-md-none">
                <button type="button" 
                        class="btn rounded-circle p-3"
                        data-bs-toggle="modal" 
                        data-bs-target="#mobileSearchModal"
                        style="background: #0b573d;
                               color: white;
                               border: none;
                               box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <i class="fas fa-search" style="font-size: 1.2rem;"></i>
                </button>

                <!-- Mobile Search Modal -->
                <div class="modal fade" id="mobileSearchModal" tabindex="-1" aria-labelledby="mobileSearchModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mobileSearchModalLabel">Search Guest</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="input-group">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Enter guest name..."
                                           value="{{ request('search') }}">
                                    <button type="submit" 
                                            class="btn"
                                            style="background-color: #0b573d; color: white;">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card-body" style="max-height: 400px; overflow-y: auto;">
    <!-- Desktop View -->
    <div class="table-responsive d-none d-md-block">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="py-3">Guest Name</th>
                    <th class="py-3">Phone Number</th>
                    <th class="py-3">Address</th>
                    <th class="py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($guests as $guest)
                <tr>
                    <td class="py-3">
                        <div class="fw-semibold">{{ $guest->name }}</div>
                        <div class="text-muted small">{{ $guest->email }}</div>
                    </td>
                    <td class="py-3"><strong>{{ $guest->mobileNo }}</strong></td>
                    <td class="py-3"><strong>{{ $guest->address }}</strong></td>
                    <td class="py-3">
                        <button type="button" class="btn btn-sm btn-primary" style="background-color: #0b573d; border: none; transition: all 0.3s ease;" data-bs-toggle="modal" data-bs-target="#viewReservations{{ $guest->id }}">
                            <i class="fas fa-eye"></i> View
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Mobile View -->
    <div class="d-md-none">
        @foreach($guests as $guest)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold">{{ $guest->name }}</h5>
                <p class="card-text text-muted mb-2">{{ $guest->email }}</p>
                <div class="d-flex flex-column gap-2">
                    <div>
                        <small class="text-muted">Phone:</small>
                        <div class="fw-semibold">{{ $guest->mobileNo }}</div>
                    </div>
                    <div>
                        <small class="text-muted">Address:</small>
                        <div class="fw-semibold">{{ $guest->address }}</div>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary mt-2 align-self-start" style="background-color: #0b573d; border: none;" data-bs-toggle="modal" data-bs-target="#viewReservations{{ $guest->id }}">
                        <i class="fas fa-eye"></i> View Reservations
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($guests->isEmpty())
    <div class="text-center py-4">
        <p class="mb-0">No guests found.</p>
    </div>
    @endif

    <!-- Modals (Shared between desktop and mobile) -->
    @foreach($guests as $guest)
    <div class="modal fade" id="viewReservations{{ $guest->id }}" tabindex="-1" aria-labelledby="viewReservationsLabel{{ $guest->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(to right, #0b573d, #43cea2);">
                    <h5 class="modal-title" id="viewReservationsLabel{{ $guest->id }}">Reservations for {{ $guest->name }}</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($guest->reservations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Reservation ID</th>
                                        <th>Check-in Date</th>
                                        <th>Check-out Date</th>
                                        <th>Status</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($guest->reservations as $reservation)
                                        <tr>
                                            <td>{{ $reservation->id }}</td>
                                            <td>{{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('M d, Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($reservation->reservation_check_out_date)->format('M d, Y') }}</td>
                                            <td>
                                                <span class="badge rounded-pill text-capitalize px-3 py-2 
                                                    {{ $reservation->reservation_status === 'checked-in' ? 'bg-success' : ($reservation->reservation_status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ ucfirst($reservation->reservation_status) }}
                                                </span>
                                            </td>
                                            <td>₱{{ number_format($reservation->amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 mb-2">
                                <div class="text-muted mb-3 mb-md-0">
                                    Showing {{ $guest->reservations->firstItem() ?? 0 }} to {{ $guest->reservations->lastItem() ?? 0 }} of {{ $guest->reservations->total() }} results
                                </div>
                                <nav aria-label="Reservation pagination">
                                    <div class="pagination pagination-sm">
                                        {{ $guest->reservations->links('pagination::bootstrap-4') }}
                                    </div>
                                </nav>
                            </div>
                        </div>
                    @else
                        <p class="text-center">No reservations found for this guest.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @if($guests->isNotEmpty())
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4">
        <div class="text-muted mb-3 mb-md-0">
            Showing {{ $guests->firstItem() ?? 0 }} to {{ $guests->lastItem() ?? 0 }} of {{ $guests->total() }} entries
        </div>
        <div class="pagination-container">
            {{ $guests->links('pagination::bootstrap-4') }}
        </div>
    </div>
    @endif
</div>
</div>
> <!-- Added margin bottom spacing -->





</body>
</html>