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
        <div class="hero-banner" 
             style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(34, 34, 34, 0.5)), url('{{ asset('images/DSCF2777.JPG') }}'); 
                    background-size: cover; 
                    background-position: center; 
                    height: 450px; 
                    border-radius: 15px;">
            <div class="d-flex justify-content-start align-items-center h-100">
                <div class="ms-5">
                    <p class="text-white mb-0" style="font-size: 2.5rem; font-family: 'Poppins', sans-serif; margin-left: 5rem;">Hello,</p>
                    <h1 class="text-white fw-bold" style="font-size: 4.5rem; font-family: 'Poppins', sans-serif; margin-left: 5rem;">
                        Staff002!
                    </h1>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- SEARCH BOX -->
    <div class="row mt-4">
        <div class="col-11 mx-auto">
            <div class="position-relative">
                <form action="{{ route('staff.guests') }}" method="GET" class="d-flex gap-2 position-absolute" style="bottom: 180px; right: 125px;">
                    <div class="input-group shadow-sm shadow-hover" 
                         style="border-radius: 8px; 
                                overflow: hidden;
                                min-width: 350px;
                                transition: all 0.3s ease-in-out;
                                background: rgba(255, 255, 255, 0.95);
                                backdrop-filter: blur(5px);
                                border: 1px solid rgba(0, 0, 0, 0.1);">
                        <!-- Search Box -->
                        <input type="text" 
                               name="search" 
                               class="form-control border-0 ps-4" 
                               placeholder="🔍 Search guest..." 
                               value="{{ request('search') }}" 
                               oninput="toggleClearButton(this)"
                               style="border-radius: 0; height: 50px;">
                        <!-- Search Button -->
                        <button type="submit" 
                                class="btn bg-white px-4"
                                style="border-radius: 0; height: 50px; transition: 0.3s;">
                            <i class="fas fa-search" style="color: black;"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- TABLE SECTION -->
<div class="position-relative w-100" style="margin-top: -150px; margin-bottom: 50px;">
    <div class="d-flex justify-content-center">
        <div class="w-75">
            <div class="card border-2 shadow-lg" style="background-color: rgba(255, 255, 255, 0.95);">
                <div class="card-header bg-white py-3">
                    <h2 class="font-heading mb-0 fs-3 fw-bold" style="color: #0b573d;">GUEST INFORMATION OVERVIEW</h2>
                </div>
                <div style="height: 400px; overflow-y: auto;">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead style="background-color: #f5f5f5;">
                                    <tr>
                                        <th style="color: #0b573d; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); background-color: #f8f9fa; border-radius: 4px;">Guest Name</th>
                                        <th style="color: #0b573d; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); background-color: #f8f9fa; border-radius: 4px;">Phone Number</th>
                                        <th style="color: #0b573d; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); background-color: #f8f9fa; border-radius: 4px;">Address</th>
                                        <th style="color: #0b573d; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); background-color: #f8f9fa; border-radius: 4px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($guests as $guest)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $guest->name }}</div>
                                            <div class="text-muted small">{{ $guest->email }}</div>
                                        </td>
                                        <td><strong>{{ $guest->mobileNo }}</strong></td>
                                        <td><strong>{{ $guest->address }}</strong></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm" style="background-color:#0b573d;" data-bs-toggle="modal" data-bs-target="#viewReservations{{ $guest->id }}">
                                                    <i class="fas fa-eye text-white"></i>
                                                </button>
                                            </div>
                                            <!-- View Guest Reservations Modal -->
                                            <div class="modal fade" id="viewReservations{{ $guest->id }}" tabindex="-1" aria-labelledby="viewReservationsLabel{{ $guest->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header text-white" style="background-color: #0b573d;">
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
                                                                                        <span class="badge {{ $reservation->reservation_status === 'checked-in' ? 'bg-success' : ($reservation->reservation_status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                                                                            {{ ucfirst($reservation->reservation_status) }}
                                                                                        </span>
                                                                                    </td>
                                                                                    <td>₱{{ number_format($reservation->amount, 2) }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>

                                                                    <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
                                                                        <div class="text-muted">
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
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            @if($guests->isEmpty())
                            <div class="text-center p-3">
                                <p>No guests found.</p>
                            </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted">
                                    Showing {{ $guests->firstItem() ?? 0 }} to {{ $guests->lastItem() ?? 0 }} of {{ $guests->total() }} entries
                                </div>
                                <div class="pagination-container">
                                    {{ $guests->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4"></div> <!-- Added margin bottom spacing -->
        </div>
    </div>
</div>





</body>
</html>