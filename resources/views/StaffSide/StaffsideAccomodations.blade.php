<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
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
    .availability-table {
        margin-top: 20px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .availability-table th {
        background-color: #0b573d;
        color: white;
    }
    .availability-table .text-success {
        font-weight: bold;
    }
    .availability-table .text-danger {
        font-weight: bold;
    }
</style>
<body style="margin: 0; padding: 0; height: 100vh; background-color: white; overflow-x: hidden;">
    @include('Alert.loginSucess')
        <!-- NAVBAR -->
        @include('Navbar.sidenavbarStaff')

        <div class="row">
        <div class="col-11 mx-auto">
            <div class="hero-banner d-flex flex-column justify-content-center text-white p-3 p-sm-4 p-md-5"
             style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(34, 34, 34, 0.5)), url('{{ asset('images/staff-admin-bg.jpg') }}'); 
                   background-size: cover; background-position: center; min-height: 450px; border-radius: 15px;">

            <div class="row g-3 g-md-4">
                <!-- Left Side -->
                <div class="col-12 col-md-6">
                    <div class="d-flex flex-column gap-3">
                        <!-- Greeting -->
                        <div class="text-start">
                            <h1 class="mb-1 display-1 fs-1 fs-md-1" style="font-size: 3.7rem !important;">Hello,</h1>
                            <h1 class="fw-bold display-1 fs-1 fs-md-1" style="font-size: 5rem !important;">Staff User!</h1>
                        </div>
                        
                        <!-- Total Reservations -->
                        <div class="d-flex align-items-center rounded-3 shadow-sm" style="background: linear-gradient(135deg, #ffffff 50%, #f8f9fa 50%);">
                            <div class="p-3 p-md-4 p-lg-5 mt-2">
                                <h1 class="fw-bold mb-0" style="font-size: clamp(2rem, 4vw, 3rem); color: #198754;">{{ $totalRooms ?? 0 }}</h1>
                                <p class="mb-0 fw-semibold" style="font-size: clamp(1rem, 2vw, 1.5rem); color: #198754;">Total Rooms</p>
                            </div>
                            <div class="ms-auto p-3 p-md-4 p-lg-5">
                                <i class="fas fa-bed" style="font-size: clamp(2.5rem, 4vw, 4rem); background: linear-gradient(45deg, #343a40, #6c757d); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="col-12 col-md-6">
                    <div class="row row-cols-1 g-3 g-md-4">
                        <!-- Walk-in Reservation -->
                        <div class="col">
                            <div class="d-flex align-items-center text-dark p-3 p-md-4 p-lg-5 rounded-3 shadow-sm h-100" style="background-color: #3E776E;">
                                <div>
                                    <h1 class="fw-bold mb-0 text-white" style="font-size: clamp(1.8rem, 3vw, 3rem);">{{ $vacantRooms  ?? 0 }}</h1>
                                    <p class="text-white text-uppercase mb-0 font-paragraph" style="font-size: 0.8rem;">Vacant<br>Rooms
                                    </p>
                                </div>
                                <div class="ms-auto">
                                    <i class="fas fa-door-open fs-1 text-white ms-auto"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Checked-out -->
                        <div class="col">
                            <div class="d-flex align-items-center text-dark p-3 p-md-4 p-lg-5 rounded-3 shadow-sm h-100" style="background-color: #37A51F;">
                                <div>
                                    <h2 class="fs-1 fw-bold text-white mb-0">{{ $reservedRooms ?? 0 }}</h2>
                                    <p class="text-white text-uppercase mb-0 font-paragraph" style="font-size: 0.8rem;">
                                    Reserved<br>Rooms
                                    </p>
                                </div>
                                <i class="fas fa-door-closed fs-1 text-white ms-auto"></i>
                            </div>
                        </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<div class="container-fluid mt-4 shadow-lg p-4 bg-white rounded" style="max-width: 91.67%; margin: 0 auto;">
    <div class="container">
        <!-- FILTER CONTROLS -->
        <div class="filter-controls mb-4">
            <form id="availabilityFilterForm" method="GET" action="{{ route('staff.accomodations') }}">
                <div class="row align-items-center">
                    <div class="col-md-3 mb-2">
                        <select name="filter" class="form-control" id="filterSelect">
                            <option value="overview" {{ $filter === 'overview' ? 'selected' : '' }}>Overview</option>
                            <option value="daily" {{ $filter === 'daily' ? 'selected' : '' }}>Daily Availability</option>
                            <option value="weekly" {{ $filter === 'weekly' ? 'selected' : '' }}>Weekly Availability</option>
                            <option value="monthly" {{ $filter === 'monthly' ? 'selected' : '' }}>Monthly Availability</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="date" name="date" class="form-control" id="dateInput" 
                               value="{{ $date }}" {{ $filter === 'overview' ? 'disabled' : '' }}>
                    </div>
                    <div class="col-md-2 mb-2">
                        <button type="button" class="btn btn-primary" id="applyFilterBtn">
                            Apply Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3">
                <h2 class="fw-bold text-success mb-0 border-bottom" style="font-size: 2.5rem;">ROOM OVERVIEW</h2>
                <select class="form-select" style="width: auto;" id="roomFilter">
                    <option value="all" selected>All Rooms</option>
                    @php
                        $types = $accomodations->pluck('accomodation_type')->unique();
                    @endphp
                    @foreach($types as $type)
                        <option value="{{ $type }}">{{ ucfirst($type) }}s</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Availability Modal -->
        <div class="modal fade" id="availabilityModal" tabindex="-1" aria-labelledby="availabilityModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #0b573d;">
                        <h5 class="modal-title text-white" id="availabilityModalLabel">
                            <i class="fas fa-calendar-check me-2"></i>Room Availability
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="availabilityResults">
                            <!-- Results will be loaded here via AJAX -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-body">
                    <table class="table table-hover table-responsive m-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-center">Room ID</th>
                                <th scope="col" class="text-center">Room Image</th>
                                <th scope="col">Room Name</th>
                                <th scope="col">Room Description</th>
                                <th scope="col">Room Type</th>
                                <th scope="col">Room Qty</th>
                                <th scope="col" class="text-center">Price</th>
                                <th scope="col" class="text-center">Capacity</th>
                                <th scope="col" class="text-center">Availability</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accomodations as $accomodation)
                                <tr>
                                    <td class="text-center align-middle">{{ $accomodation->room_id}}</td>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}" 
                                            alt="Room Image" 
                                            class="img-thumbnail rounded"
                                            style="width: 80px; height: 80px; object-fit: cover;">
                                    </td>
                                    <td class="align-middle">{{ $accomodation->accomodation_name }}</td>
                                    <td class="align-middle">{{ Str::limit($accomodation->accomodation_description, 50) }}</td>
                                    <td class="align-middle text-capitalize">{{ $accomodation->accomodation_type }}</td>
                                    <td class="align-middle">{{ $accomodation->quantity }}</td>
                                    <td class="text-center align-middle">₱{{ number_format($accomodation->accomodation_price, 2) }}</td>
                                    <td class="text-center align-middle">{{ $accomodation->accomodation_capacity }}</td>
                                    <td class="text-center align-middle">
                                        <span class="badge rounded-pill {{ $accomodation->accomodation_status == 'available' ? 'bg-success' : ($accomodation->accomodation_status == 'maintenance' ? 'bg-warning' : 'bg-danger') }}">
                                            {{ ucfirst($accomodation->accomodation_status) }}
                                        </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-warning btn-sm text-white" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editRoomModal{{ $accomodation->accomodation_id }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        <button type="button" class="btn text-white" style="background-color: #0b573d;" data-bs-toggle="modal" data-bs-target="#activeReservationsModal">
                            <i class="fas fa-list me-2"></i>View Active Reservations
                        </button>

                        <!-- Active Reservations Modal -->
            <div class="modal fade" id="activeReservationsModal" tabindex="-1" aria-labelledby="activeReservationsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #0b573d;">
                            <h5 class="modal-title text-white" id="activeReservationsModalLabel">
                                <i class="fas fa-calendar-check me-2"></i>Active Reservations
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if(isset($activeReservations) && $activeReservations->count() > 0)
                                @foreach($activeReservations as $reservation)
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h3 class="h5 mb-1">{{ $reservation->name }}</h3>
                                                <p class="text-muted mb-0">
                                                    <span class="fw-medium">{{ $reservation->reserved_quantity }}</span> of 
                                                    <span class="fw-medium">{{ $reservation->total_quantity }}</span> rooms occupied
                                                </p>
                                            </div>
                                            <span class="badge {{ $reservation->status == 'checked-in' ? 'bg-success' : 'bg-warning' }}">
                                                {{ ucfirst($reservation->status) }}
                                            </span>
                                        </div>
                                        
                                        <hr>
                                        
                                        <div class="d-flex align-items-center text-muted mb-2">
                                            <i class="far fa-calendar-alt me-2"></i>
                                            Check-out: {{ \Carbon\Carbon::parse($reservation->next_available_time)->format('M j, Y H:i') }}
                                        </div>
                                        
                                        <div class="d-flex align-items-center">
                                            <i class="far fa-clock me-2"></i>
                                            <div class="countdown-timer" data-checkout="{{ $reservation->next_available_time }}" id="countdown-{{ $loop->index }}">
                                                <span class="countdown-display text-primary fw-medium">Calculating time remaining...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <i class="far fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <h3 class="h5">No active reservations</h3>
                                    <p class="text-muted mb-0">There are currently no reservations with 'reserved' or 'checked-in' status.</p>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                function updateCountdown(element, checkoutDate) {
                    const now = new Date();
                    const checkout = new Date(checkoutDate);
                    const distance = checkout - now;

                    if (distance < 0) {
                        element.querySelector('.countdown-display').innerHTML = 
                            '<span class="text-danger fw-bold">CHECKOUT OVERDUE</span>';
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    let countdownText = '';
                    if (days > 0) countdownText += days + 'd ';
                    countdownText += hours.toString().padStart(2, '0') + 'h ';
                    countdownText += minutes.toString().padStart(2, '0') + 'm ';
                    countdownText += seconds.toString().padStart(2, '0') + 's';

                    element.querySelector('.countdown-display').innerHTML = 
                        '<span class="fw-medium">' + countdownText + ' remaining</span>';
                }

                const countdownElements = document.querySelectorAll('.countdown-timer');
                countdownElements.forEach(element => {
                    const checkoutDate = element.getAttribute('data-checkout');
                    updateCountdown(element, checkoutDate);
                    setInterval(() => updateCountdown(element, checkoutDate), 1000);
                });
            });
            </script>

            <style>
            .countdown-display {
                transition: color 0.3s ease;
            }
            </style>
                    </div>
                </div>
            </div>
        </div>

         <!-- Pagination Section -->
         <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                @if($accomodations->total() > 0)
                                    Showing {{ $accomodations->firstItem() }} to {{ $accomodations->lastItem() }} of {{ $accomodations->total() }} results
                                @else
                                    No results found
                                @endif
                            </div>
                            <div>
                                @if ($accomodations->hasPages())
                                    <nav>
                                        <ul class="pagination mb-0">
                                            {{-- Previous Page Link --}}
                                            @if ($accomodations->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $accomodations->previousPageUrl() }}" rel="prev"><i class="fas fa-chevron-left"></i>  </a>
                                                </li>
                                            @endif

                                            {{-- Pagination Elements --}}
                                            @foreach ($accomodations->getUrlRange(1, $accomodations->lastPage()) as $page => $url)
                                                <li class="page-item {{ $page == $accomodations->currentPage() ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if ($accomodations->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $accomodations->nextPageUrl() }}" rel="next"><i class="fas fa-chevron-right"></i></a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Room type filter
            const filterSelect = document.getElementById('roomFilter');
            const tableRows = document.querySelectorAll('tbody tr');

            filterSelect.addEventListener('change', function() {
                const filterValue = this.value;

                tableRows.forEach(row => {
                    const roomType = row.querySelector('td:nth-child(5)').textContent.toLowerCase().trim();
                    
                    if (filterValue === 'all' || roomType === filterValue) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Availability filter controls
            const filterSelectElement = document.getElementById('filterSelect');
            const dateInput = document.getElementById('dateInput');
            
            filterSelectElement.addEventListener('change', function() {
                dateInput.disabled = this.value === 'overview';
            });

            // AJAX for availability filter
            const applyFilterBtn = document.getElementById('applyFilterBtn');
            const availabilityModal = new bootstrap.Modal(document.getElementById('availabilityModal'));
            
            applyFilterBtn.addEventListener('click', function() {
                const filter = document.getElementById('filterSelect').value;
                const date = document.getElementById('dateInput').value;
                
                if (filter === 'overview') {
                    // If overview is selected, just submit the form normally
                    document.getElementById('availabilityFilterForm').submit();
                    return;
                }
                
                if (!date) {
                    alert('Please select a date for the availability check.');
                    return;
                }
                
                // Show loading state
                document.getElementById('availabilityResults').innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Checking availability...</p>
                    </div>
                `;
                
                // Make AJAX request
                fetch(`/staff/accomodations/availability?filter=${filter}&date=${date}`)
                    .then(response => response.json())
                    .then(data => {
                        let html = `
                            <h4>Availability for ${filter} period starting ${date}</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Accommodation</th>
                                            <th>Total Rooms</th>
                                            <th>Booked</th>
                                            <th>Available</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        `;
                        
                        if (data.length > 0) {
                            data.forEach(item => {
                                html += `
                                    <tr>
                                        <td>${item.name}</td>
                                        <td>${item.total_rooms}</td>
                                        <td>${item.booked}</td>
                                        <td class="${item.available > 0 ? 'text-success fw-bold' : 'text-danger fw-bold'}">
                                            ${item.available}
                                        </td>
                                    </tr>
                                `;
                            });
                        } else {
                            html += `
                                <tr>
                                    <td colspan="4" class="text-center">No availability data found</td>
                                </tr>
                            `;
                        }
                        
                        html += `
                                    </tbody>
                                </table>
                            </div>
                        `;
                        
                        document.getElementById('availabilityResults').innerHTML = html;
                        availabilityModal.show();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('availabilityResults').innerHTML = `
                            <div class="alert alert-danger">
                                Error loading availability data. Please try again.
                            </div>
                        `;
                        availabilityModal.show();
                    });
            });
        });

        // Function to update countdown for a specific element
        function updateCountdown(element, checkoutDate) {
            const now = new Date().getTime();
            const checkout = new Date(checkoutDate).getTime();
            const distance = checkout - now;

            if (distance < 0) {
                element.querySelector('.countdown-display').innerHTML = '<span class="text-danger">OVERDUE</span>';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            let countdownText = '';
            if (days > 0) {
                countdownText += days + 'd ';
            }
            countdownText += hours.toString().padStart(2, '0') + 'h ';
            countdownText += minutes.toString().padStart(2, '0') + 'm ';
            countdownText += seconds.toString().padStart(2, '0') + 's';

            element.querySelector('.countdown-display').innerHTML = 
                '<span class="badge bg-primary">' + countdownText + '</span>';
        }

        // Initialize all countdown timers
        document.addEventListener('DOMContentLoaded', function() {
            const countdownElements = document.querySelectorAll('.countdown-timer');
            
            countdownElements.forEach(function(element) {
                const checkoutDate = element.getAttribute('data-checkout');
                
                // Update immediately
                updateCountdown(element, checkoutDate);
                
                // Update every second
                setInterval(function() {
                    updateCountdown(element, checkoutDate);
                }, 1000);
            });
        });
    </script>
</body>
</html>