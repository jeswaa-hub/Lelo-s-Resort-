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
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
    }

    p {
        font-family: 'Open Sans', sans-serif;
        font-weight: 400;
    }

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
             style="background-image:url('{{ asset('images/staff-admin-bg.jpg') }}'); 
                   background-size: cover; background-position: center; min-height: 450px; border-radius: 15px;">

            <div class="row g-3 g-md-4">
                <!-- Left Side -->
                <div class="col-12 col-md-6">
                    <div class="d-flex flex-column gap-3">
                        <!-- Greeting -->
                        <div class="d-flex flex-column align-items-start text-start" 
                            style="padding: 0 20px;">
                            <p class="text-white" style="font-family: 'Poppins', sans-serif; font-size: clamp(2rem, 5vw, 3rem); letter-spacing: 5px;">
                                Hello,
                            </p>
                            <h1 class="text-capitalize fw-bolder" 
                                style="font-family: 'Montserrat', sans-serif; font-size: clamp(3rem, 8vw, 5rem); color:#ffffff; letter-spacing: clamp(5px, 2vw, 15px); white-space: normal; overflow-wrap: break-word; font-weight: 900; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                                STAFF002
                            </h1>
                        </div>
                        
                        <!-- Total Reservations -->
                        <div class="d-flex align-items-center text-dark p-3 p-md-4 p-lg-5 rounded-3 shadow-sm h-100 position-relative overflow-hidden" 
                             style="background: linear-gradient(135deg, #ffffff 50%, #f8f9fa 50%);">
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <div class="d-flex align-items-baseline gap-2">
                                    <h1 class="fw-bold mb-0 text-success" 
                                        style="font-size: clamp(1.5rem, 2.5vw, 3rem);">
                                        {{ $totalRooms ?? 0 }}
                                    </h1>
                                    <p class="mb-0 text-uppercase fw-semibold text-success" 
                                       style="font-size: clamp(0.8rem, 1.2vw, 1.2rem);">
                                        Total Rooms
                                    </p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-bed text-success" 
                                       style="font-size: clamp(2rem, 4vw, 4rem);">
                                    </i>
                                </div>
                            </div>
                            <div class="position-absolute top-0 end-0 opacity-25 d-none d-md-block">
                                <i class="fas fa-bed text-success" 
                                   style="font-size: 5rem; margin: -10px;">
                                </i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="col-12 col-md-6">
                    <div class="row row-cols-1 g-3 g-md-4">
                        <!-- Walk-in Reservation -->
                        <div class="col">
                            <div class="d-flex align-items-center text-dark p-3 p-md-4 p-lg-5 rounded-3 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #ffffff 50%, #f8f9fa 50%);">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="d-flex flex-column gap-2">
                                        <h1 class="fw-bold mb-0 text-success" style="font-size: clamp(1.5rem, 2.5vw, 3rem);">{{ $vacantRooms ?? 0 }}</h1>
                                        <p class="mb-0 text-uppercase fw-semibold text-success" style="font-size: clamp(0.8rem, 1.2vw, 1.2rem);">Vacant Rooms</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-door-open text-success" style="font-size: clamp(2rem, 4vw, 2.5rem);"></i>
                                    </div>
                                </div>
                                <div class="position-absolute top-0 end-0 opacity-25 d-none d-md-block">
                                    <i class="fas fa-door-open text-success" style="font-size: 4rem; margin: -10px;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Checked-out -->
                        <div class="col">
                            <div class="d-flex align-items-center text-dark p-3 p-md-4 p-lg-5 rounded-3 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #ffffff 50%, #f8f9fa 50%);">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="d-flex flex-column gap-2">
                                        <h1 class="fw-bold mb-0 text-success" style="font-size: clamp(1.5rem, 2.5vw, 3rem);">{{ $reservedRooms ?? 0 }}</h1>
                                        <p class="mb-0 text-uppercase fw-semibold text-success" style="font-size: clamp(0.8rem, 1.2vw, 1.2rem);">Reserved Rooms</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-door-closed text-success" style="font-size: clamp(2rem, 4vw, 2.5rem);"></i>
                                    </div>
                                </div>
                                <div class="position-absolute top-0 end-0 opacity-25 d-none d-md-block">
                                    <i class="fas fa-door-closed text-success" style="font-size: 4rem; margin: -10px;"></i>
                                </div>
                            </div>
                        </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<div class="container mt-3">
    <div class="col-13 mx-auto shadow-lg p-3 p-md-4 rounded" style="background: linear-gradient(to top, rgb(211, 209, 209), #ffffff);">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
            <div class="d-flex flex-column gap-3">
                <h2 class="fw-bold mb-3 mb-md-0 border-bottom pb-2" style="font-size: clamp(1.5rem, 4vw, 2.5rem); color: #0b573d;">ROOM OVERVIEW</h2>
                
<div class="filter-controls">
    <!-- Desktop/Tablet View -->
    <div class="d-none d-md-flex justify-content-end align-items-center gap-3">
        <select class="form-select" style="width: 150px;" id="roomFilter">
            <option value="all" selected>All Rooms</option>
            @php
                $types = $accomodations->pluck('accomodation_type')->unique();
            @endphp
            @foreach($types as $type)
                <option value="{{ $type }}">{{ ucfirst($type) }}s</option>
            @endforeach
        </select>

        <select name="filter" class="form-select" style="width: 150px;" id="filterSelect">
            <option value="overview" {{ $filter === 'overview' ? 'selected' : '' }}>Overview</option>
            <option value="daily" {{ $filter === 'daily' ? 'selected' : '' }}>Daily</option>
            <option value="weekly" {{ $filter === 'weekly' ? 'selected' : '' }}>Weekly</option>
            <option value="monthly" {{ $filter === 'monthly' ? 'selected' : '' }}>Monthly</option>
        </select>

        <input type="date" 
               name="date" 
               class="form-control mt-3" 
               id="dateInput" 
               style="width: 150px;"
               value="{{ $date }}" 
               {{ $filter === 'overview' ? 'disabled' : '' }}>

        <button type="button" 
                class="btn text-white" 
                style="background-color: #0b573d; width: 150px;" 
                id="applyFilterBtn">
            Apply
        </button>
    </div>

    <!-- Mobile View -->
    <div class="d-md-none">
        <div class="accordion" id="filterAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false">
                        <i class="fas fa-filter me-2"></i> Filter Options
                    </button>
                </h2>
                <div id="filterCollapse" class="accordion-collapse collapse" data-bs-parent="#filterAccordion">
                    <div class="accordion-body">
                        <div class="d-flex flex-column gap-3">
                            <div class="form-group">
                                <label class="form-label">Room Type</label>
                                <select class="form-select" id="roomFilterMobile">
                                    <option value="all" selected>All Rooms</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type }}">{{ ucfirst($type) }}s</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">View Type</label>
                                <select name="filter" class="form-select" id="filterSelectMobile">
                                    <option value="overview" {{ $filter === 'overview' ? 'selected' : '' }}>Overview</option>
                                    <option value="daily" {{ $filter === 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ $filter === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ $filter === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Select Date</label>
                                <input type="date" 
                                       name="date" 
                                       class="form-control" 
                                       id="dateInputMobile"
                                       value="{{ $date }}" 
                                       {{ $filter === 'overview' ? 'disabled' : '' }}>
                            </div>

                            <button type="button" 
                                    class="btn text-white w-100" 
                                    style="background-color: #0b573d;" 
                                    id="applyFilterBtnMobile"
                                    onclick="$('#filterCollapse').collapse('hide')">
                                <i class="fas fa-check me-2"></i>Apply Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

        <!-- Mobile Cards View -->
        <div class="d-md-none mt-4">
            @foreach ($accomodations as $accomodation)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title mb-0">{{ $accomodation->accomodation_name }}</h5>
                        <span class="badge rounded-pill {{ $accomodation->accomodation_status == 'available' ? 'bg-success' : ($accomodation->accomodation_status == 'maintenance' ? 'bg-warning' : 'bg-danger') }}">
                            {{ ucfirst($accomodation->accomodation_status) }}
                        </span>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}" 
                                 alt="Room Image" 
                                 class="img-fluid rounded"
                                 style="width: 100%; height: 120px; object-fit: cover;">
                        </div>
                        <div class="col-6">
                            <div class="mb-2">
                                <small class="text-muted">Room ID:</small>
                                <div class="fw-semibold">{{ $accomodation->room_id}}</div>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Type:</small>
                                <div class="fw-semibold text-capitalize">{{ $accomodation->accomodation_type }}</div>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Price:</small>
                                <div class="fw-semibold">₱{{ number_format($accomodation->accomodation_price, 2) }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <small class="text-muted">Description:</small>
                        <p class="mb-2">{{ Str::limit($accomodation->accomodation_description, 80) }}</p>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col-6">
                            <small class="text-muted">Quantity:</small>
                            <div class="fw-semibold">{{ $accomodation->quantity }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Capacity:</small>
                            <div class="fw-semibold">{{ $accomodation->accomodation_capacity }}</div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-warning btn-sm text-white" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editRoomModal{{ $accomodation->accomodation_id }}">
                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Desktop Table View -->
        <div class="d-none d-md-block mt-4">
            <div class="table-responsive">
                <table class="table table-hover m-0">
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
                <div class="mt-3 d-flex justify-content-between align-items-center">
        <div class="text-muted">
            @if($accomodations->total() > 0)
                Showing {{ $accomodations->firstItem() }} to {{ $accomodations->lastItem() }} of {{ $accomodations->total() }} results
            @else
                No results found
            @endif
        </div>
        <div class="d-flex gap-3">
            <button type="button" class="btn text-white" style="background-color: #0b573d;" data-bs-toggle="modal" data-bs-target="#activeReservationsModal">
                <i class="fas fa-list me-2"></i>View Active Reservations
            </button>
            
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
                                <a class="page-link" href="{{ $accomodations->previousPageUrl() }}" rel="prev"><i class="fas fa-chevron-left"></i></a>
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