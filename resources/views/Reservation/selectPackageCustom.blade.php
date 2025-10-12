<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stay In Reservation</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo new.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    .select-accommodation {
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .select-accommodation.selected {
        transform: translateY(-5px);
    }

    .select-accommodation.selected::before {
        content: '✓ Selected';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        padding: 10px;
        background-color: #198754;
        color: white;
        text-align: center;
        font-weight: bold;
        z-index: 1;
    }

    .select-accommodation.selected img {
        filter: brightness(0.8);
    }

    .select-accommodation.selected .card-body {
        background-color: #e8f5e9 !important;
        border-top: 3px solid #198754;
    }

    .select-accommodation:hover:not(.unavailable) {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    
    /* Fixed styles for unavailable accommodations */
    .select-accommodation.unavailable {
        cursor: not-allowed;
        opacity: 0.6;
        pointer-events: none; /* Prevent clicking */
    }
    
    .select-accommodation.unavailable .card-body {
        background-color: #ffebee !important;
        border-top: 3px solid #dc3545;
    }
    
    .select-accommodation.unavailable::before {
        content: 'Unavailable';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        padding: 10px;
        background-color: #dc3545;
        color: white;
        text-align: center;
        font-weight: bold;
        z-index: 1;
    }
    
    .select-accommodation.unavailable img {
        filter: grayscale(70%) brightness(0.7);
    }
    
    .select-accommodation.unavailable .text-success {
        color: #dc3545 !important;
    }

    /* Add availability display styling */
    .availability-display {
        font-size: 0.875rem;
        margin-top: 0.5rem;
        padding: 0.25rem;
        border-radius: 0.25rem;
        background-color: rgba(255, 255, 255, 0.8);
    }
</style>
 @include('Alert.errorLogin')
    @include('Alert.loginSuccessUser')
<body class="bg-light font-paragraph" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.8)), url('{{ asset('images/packagebg.JPG') }}') no-repeat center center fixed; background-size: cover;">
<x-loading-screen />    
<div class="d-flex align-items-center ms-5 mt-5">
        <a href="{{ route('calendar') }}"><i class="color-3 fa-2x fa-circle-left fa-solid icon icon-hover ms-4"></i></a><h1 class="text-white text-uppercase font-heading ms-3">Reservation</h1>
    </div>

    <div class="position-absolute top-0 end-0 mt-3 me-5 d-none d-md-block">
        <a class="text-decoration-none">
            <img src="{{ asset('images/logo new.png') }}" alt="Lelo's Resort Logo" width="120" class="rounded-pill">
        </a>
    </div>
    
    <div class="container">
    <h1 class="text-white font-heading fs-2 mt-3 mb-3 ms-2">Select your Room</h1>
    
    <form method="POST" action="{{ route('savePackageSelection') }}">
        @csrf
        <input type="hidden" name="package_type" value="Day Tour">

        <!-- Hidden user information fields -->
        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="hidden" name="mobileNo" value="{{ $user->mobileNo }}">
        <input type="hidden" name="address" value="{{ $user->address }}">
        
        <div class="d-flex justify-content-start mt-4 mb-3 ms-2">
            <button type="button" 
                class="btn text-dark px-4" 
                style="background-color: rgba(255, 255, 255, 0.9);" 
                id="proceedToPayment" 
                data-bs-toggle="modal" 
                data-bs-target="#reservationModal" 
                disabled>
                <i class="fas fa-calendar-check me-2"></i>Booking Details
            </button>
            </div>
    
        <!-- Accommodation Cards Container -->
        <div class="col-md-12 d-flex flex-column">
            <div class="form-group">
                <div class="container">
                    <div class="row g-4" id="accommodationContainer">
                        @foreach($accomodations as $accomodation)
                            @if($accomodation->accomodation_type == 'cabin' || $accomodation->accomodation_type == 'room')
                            <div class="col-md-4 accommodation-card">
                                <div class="card select-accommodation {{ $accomodation->accomodation_status !== 'available' ? 'unavailable' : '' }}"
                                     data-id="{{ $accomodation->accomodation_id }}"
                                     data-price="{{ $accomodation->accomodation_price }}"
                                     data-capacity="{{ $accomodation->accomodation_capacity }}"
                                     data-room-quantity="{{ $accomodation->quantity }}"
                                     data-status="{{ $accomodation->accomodation_status }}">
                                    <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}" class="card-img-top" alt="accommodation image" style="max-width: 100%; height: 250px; object-fit: cover;">
                                    <div class="card-body p-3 position-relative" style="background-color: white;">
                                        <div class="position-absolute top-0 end-0 p-2">
                                            <i class="fas fa-info-circle text-success fs-3 mt-2 me-2" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#roomModal{{ $accomodation->accomodation_id }}"></i>
                                        </div>
                                        <h5 class="text-success text-capitalize font-heading fs-4 fw-bold">{{ $accomodation->accomodation_name }}</h5>
                                        <p class="card-text text-success font-paragraph" style="font-size: smaller;">Description: {{ $accomodation->accomodation_description }}</p>
                                        <p class="card-text text-success font-paragraph">Capacity: {{ $accomodation->accomodation_capacity }} pax</p>
                                        <p class="card-text font-paragraph fw-bold text-success" style="text-align: right;">Price: <span style="background-color: #0b573d; color: white; padding: 2px 5px;">₱{{ $accomodation->accomodation_price }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal for Room Details -->
                            <div class="modal fade" id="roomModal{{ $accomodation->accomodation_id }}" tabindex="-1"
                                    aria-labelledby="roomModalLabel{{ $accomodation->accomodation_id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content rounded-4 shadow border-0">
                                            <!-- Header -->
                                            <div class="modal-header border-0" style="background-color: #0b573d;">
                                                <h5 class="modal-title text-white text-uppercase fw-bold"
                                                    id="roomModalLabel{{ $accomodation->accomodation_id }}"
                                                    style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;">
                                                    {{ $accomodation->accomodation_name }}
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
 
                                            <!-- Body -->
                                            <div class="modal-body p-0">
                                                <div class="row g-0">
                                                    <!-- Left Column (Main + Extra Images) -->
                                                    <div class="col-md-6 position-relative bg-light">
                                                        <!-- Main Image -->
                                                        <div id="roomCarousel{{ $accomodation->accomodation_id }}"
                                                            class="carousel slide" data-bs-ride="carousel">
                                                            @if (!empty($accomodation->extra_images))
                                                                <div class="carousel-indicators">
                                                                    <button type="button" data-bs-target="#roomCarousel{{ $accomodation->accomodation_id }}" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                                    @foreach (explode(',', $accomodation->extra_images) as $index => $extra)
                                                                        <button type="button" data-bs-target="#roomCarousel{{ $accomodation->accomodation_id }}" data-bs-slide-to="{{ $index + 1 }}" aria-label="Slide {{ $index + 2 }}"></button>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        <div class="carousel-inner">
                                                                <!-- Main Image -->
                                                                <div class="carousel-item active">
                                                                    <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}"
                                                                        class="d-block w-100 object-fit-cover"
                                                                        style="height: 450px; border-top-right-radius: 20px; border-bottom-right-radius: 20px; border-top-left-radius: 0px; border-bottom-left-radius: 0px;" alt="Main Image">
                                                                </div>
 
                                                                <!-- Extra Images (if any) -->
                                                                @if (!empty($accomodation->extra_images))
                                                                    @foreach (explode(',', $accomodation->extra_images) as $extra)
                                                                        <div class="carousel-item">
                                                                            <img src="{{ asset('storage/' . trim($extra)) }}"
                                                                                class="d-block w-100 object-fit-cover"
                                                                                style="height: 450px; border-top-right-radius: 20px; border-bottom-right-radius: 20px; border-top-left-radius: 0px; border-bottom-left-radius: 0px;" alt="Extra Image">
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
 
                                                    <!-- Right Column (Details) -->
                                                    <div class="col-md-6 d-flex flex-column p-4">
                                                        <div class="mb-3">
                                                            <h6 class="text-uppercase fw-bold" style="color: #0b573d;"><i class="fas fa-info-circle me-2"></i>Description</h6>
                                                            <p class="text-muted mb-0" style="font-size: 0.9rem;">{{ $accomodation->accomodation_description ?? 'No description available.' }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6 class="text-uppercase fw-bold" style="color: #0b573d;"><i class="fas fa-wifi me-2"></i>Amenities</h6>
                                                            <p class="text-muted mb-0" style="font-size: 0.9rem;">{{ $accomodation->amenities ?? 'No amenities listed.' }}</p>
                                                        </div>
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-6">
                                                                <h6 class="text-uppercase fw-bold" style="color: #0b573d;"><i class="fas fa-users me-2"></i>Capacity</h6>
                                                                <p class="text-muted mb-0">{{ $accomodation->accomodation_capacity }} pax</p>
                                                            </div>
                                                            <div class="col-6">
                                                                <h6 class="text-uppercase fw-bold" style="color: #0b573d;"><i class="fas fa-check-circle me-2"></i>Status</h6>
                                                                <p class="mb-0">
                                                                    @if($accomodation->accomodation_status == 'available')
                                                                        <span class="badge bg-success-subtle text-success-emphasis rounded-pill px-3 py-2">Available</span>
                                                                    @else
                                                                        <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill px-3 py-2">Unavailable</span>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="mt-auto pt-3 border-top">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <span class="text-muted">Price per night</span>
                                                                    <h4 class="fw-bold mb-0" style="color: #0b573d;">₱{{ number_format($accomodation->accomodation_price, 2) }}</h4>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Activities Section -->
        <div>
            <label for="activities" class="text-white font-paragraph fw-semibold mb-3 ms-2 mt-4" style="font-size: 1.5rem;">Activities <span style="font-size: 1rem;">(ALL INCLUDED)</span></label>
            <div class="container">
                <div class="row">
                    @foreach($activities as $activity)
                        <div class="col-md-3 mb-3 mt-3">
                            <div class="card rounded-3 w-100">
                                <img src="{{ asset('storage/' . $activity->activity_image) }}" class="rounded img-fluid mb-2" style="width: 100%; height: 200px; object-fit: cover;" alt="{{ $activity->activity_name }}">
                                <div class="d-flex align-items-center ms-3">
                                    <p class="text-success text-capitalize font-heading fs-4 fw-bold">{{ $activity->activity_name }}</p>
                                </div>
                                <div class="d-none form-check">
                                    <input class="form-check-input" type="checkbox" id="activity{{ $activity->id }}" name="activity_id[]" value="{{ $activity->id }}" {{ old('activity_id') && in_array($activity->id, old('activity_id')) ? 'checked' : 'checked' }}>
                                    <label class="form-check-label" for="activity{{ $activity->id }}"></label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Reservation Modal -->
        <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content shadow-lg rounded-4">
                    <div class="modal-header bg-success text-white py-3">
                        <h5 class="modal-title fw-bold" id="reservationModalLabel">Reservation Summary</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                
                    <div class="modal-body p-4">
                        <!-- Tanggalin ang form tag dito -->
                        @csrf
                        <input type="hidden" name="package_type" value="custom">

                        <div class="mb-4">
                            <div id="selectedRoomsList" class="list-group">
                                <!-- Selected rooms will be dynamically inserted here -->
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <!-- Stay Details -->
                            <div class="col-md-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-success mb-3"><i class="fas fa-calendar-alt me-2"></i>Stay Details</h6>
                                        <div class="mb-3">
                                            <label for="reservation_date" class="form-label fw-medium">Check-in</label>
                                            <div class="input-group">
                                                <input type="date" id="reservation_date" name="reservation_check_in_date" class="form-control m-0" required readonly>
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                <input type="time" id="start_time" name="reservation_check_in" class="form-control m-0" value="14:00" readonly required>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="check_out_date" class="form-label fw-medium">Check-out</label>
                                            <div class="input-group">
                                                <input type="date" id="check_out_date" name="reservation_check_out_date" class="form-control m-0" required readonly>
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                <input type="time" id="end_time" name="reservation_check_out" value="12:00" class="form-control m-0" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Guest Information -->
                            <div class="col-md-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-success mb-3"><i class="fas fa-users me-2"></i>Guest Information</h6>
                                        <div class="row g-3">
                                            <div class="col-sm-6">
                                                <label for="number_of_adults" class="form-label fw-medium">Adults <small class="text-muted">(13+)</small></label>
                                                <input type="number" name="number_of_adults" id="number_of_adults" class="form-control" min="0" value="0" oninput="calculateTotalGuest(); validateInputs();">
                                                @error('number_of_adults')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="number_of_children" class="form-label fw-medium">Children <small class="text-muted">(3-12)</small></label>
                                                <input type="number" name="number_of_children" id="number_of_children" class="form-control" min="0" value="0" oninput="calculateTotalGuest(); validateInputs();">
                                                @error('number_of_children')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <label for="total_guests" class="form-label fw-medium">Total Guests</label>
                                            <input type="number" name="total_guest" id="total_guests" class="form-control bg-light" readonly>
                                            <div id="guestError" class="text-danger mt-1 small" style="display: none;">
                                                Exceeds maximum room capacity!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Special Request -->
                        <div class="card shadow-sm border-0 mt-3">
                            <div class="card-body">
                                <h6 class="fw-bold text-success mb-3"><i class="fas fa-comment-alt me-2"></i>Special Requests</h6>
                                <textarea id="specialRequest" name="special_request" class="form-control" rows="3" placeholder="e.g., late check-in, specific room view..."></textarea>
                            </div>
                        </div>
                        
                        <input type="hidden" name="amount" id="total_amount">
                    
                        <!-- SUBMIT BUTTON -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg fw-bold px-5 py-2 shadow-sm">
                                Continue
                                <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Payment Breakdown Modal -->
    <div class="modal fade" id="paymentBreakdownModal" tabindex="-1" aria-labelledby="paymentBreakdownModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold" id="paymentBreakdownModalLabel"><i class="fas fa-file-invoice-dollar me-2"></i>Booking Summary</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Enhanced No Refund Policy Banner -->
                    <div class="p-3 mb-4 rounded-3" style="background-color: #fffbe6; border: 1px solid #ffe58f;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-3 fs-4" style="color: #faad14;"></i>
                            <div>
                                <h6 class="fw-bold mb-1" style="color: #d46b08;">Important: No Refund Policy</h6>
                                <p class="mb-0 small text-muted">The down payment is non-refundable. Please review your booking details carefully before confirming your reservation.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Date:</strong> <span id="summaryDate"></span></p>
                            <p class="mb-1"><strong>Session:</strong> <span id="summarySession"></span></p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="mb-1"><strong>Total Guests:</strong> <span id="summaryGuests"></span></p>
                        </div>
                    </div>

                    <!-- Room & Entrance Charges -->
                    <h6 class="fw-bold text-success">Charges</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="summaryRoomList">
                                <!-- Dynamic content here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Total Amount -->
                    <hr>
                    <div class="d-flex justify-content-end align-items-center">
                        <h5 class="me-3 mb-0">Total Amount:</h5>
                        <h4 class="fw-bold text-success mb-0" id="totalAmountDisplay">₱0.00</h4>
                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-edit me-2"></i>Edit</button>
                    <button type="button" class="btn btn-success fw-bold" id="confirmPayment"><i class="fas fa-check-circle me-2"></i>Confirm & Proceed</button>
                </div>
            </div>
        </div>
    </div>   

<script>
    // Fixed fetchAvailableQuantities function
    function fetchAvailableQuantities() {
        const checkInDate = document.getElementById('reservation_date').value;
        const checkOutDate = document.getElementById('check_out_date').value;

        if (!checkInDate || !checkOutDate) {
            return;
        }
        const accommodationCards = document.querySelectorAll('.select-accommodation');

        // Set a "loading" state on all cards
        accommodationCards.forEach(card => {
            const quantityText = card.querySelector('.availability-display');
            if (quantityText) {
                quantityText.innerHTML = '<em>Checking availability...</em>';
                quantityText.className = 'availability-display text-warning';
            }
        });

        // Make the AJAX request with enhanced error handling
        fetch(`/get-available-quantities?checkIn=${checkInDate}&checkOut=${checkOutDate}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                // Try to get error message from response
                return response.text().then(text => {
                    console.error('Server response:', text);
                    throw new Error(`HTTP error! Status: ${response.status}. Response: ${text}`);
                });
            }
            return response.json();
        })
        .then(data => {
            // Check if data is in expected format
            if (typeof data !== 'object' || data === null) {
                throw new Error('Invalid response format received from server');
            }

            // Update each accommodation card with the new availability data
            accommodationCards.forEach(card => {
                const accommodationId = card.getAttribute('data-id');
                const originalStatus = card.getAttribute('data-status');
                
                // Handle different response formats
                let availableQuantity = 0;
                
                if (data[accommodationId] !== undefined) {
                    // If the response contains the accommodation ID
                    if (typeof data[accommodationId] === 'number') {
                        availableQuantity = data[accommodationId];
                    } else if (typeof data[accommodationId] === 'object' && data[accommodationId].available_rooms !== undefined) {
                        availableQuantity = data[accommodationId].available_rooms;
                    } else if (typeof data[accommodationId] === 'object' && data[accommodationId].quantity !== undefined) {
                        availableQuantity = data[accommodationId].quantity;
                    }
                }
                
                // Update the card's 'data-room-quantity' attribute for validation logic
                card.setAttribute('data-room-quantity', availableQuantity);
                
                const quantityText = card.querySelector('.availability-display');

                // Update the card's visual state based on BOTH database status AND availability
                if (originalStatus !== 'available') {
                    // Room is disabled in database - keep it unavailable
                    card.classList.add('unavailable');
                    card.classList.remove('selected');
                    if (quantityText) {
                        quantityText.innerHTML = `<strong>Currently unavailable</strong>`;
                        quantityText.className = 'availability-display text-danger fw-bold';
                    }
                } else if (availableQuantity > 0) {
                    // Room is available in database AND has availability for the dates
                    card.classList.remove('unavailable');
                    if (quantityText) {
                        quantityText.innerHTML = `<strong>${availableQuantity}</strong> rooms available`;
                        quantityText.className = 'availability-display text-success';
                    }
                } else {
                    // Room is available in database BUT no availability for selected dates
                    card.classList.add('unavailable');
                    card.classList.remove('selected');
                    if (quantityText) {
                        quantityText.innerHTML = `<strong>Not available</strong> on selected dates`;
                        quantityText.className = 'availability-display text-danger fw-bold';
                    }
                }
            });
            
            // After updating all cards, re-run validations
            calculateTotalGuest();
            updateProceedButton();
        })
        .catch(error => {
            console.error('Detailed error information:', {
                message: error.message,
                stack: error.stack,
                name: error.name
            });
            
            // Reset cards to show error state
            accommodationCards.forEach(card => {
                const quantityText = card.querySelector('.availability-display');
                if (quantityText) {
                    quantityText.innerHTML = '<em>Error checking availability</em>';
                    quantityText.className = 'availability-display text-danger';
                }
            });
            
            Swal.fire({
                icon: 'error',
                title: 'Connection Error',
                text: 'Failed to check room availability. Please check your connection and try again.',
                footer: `<small>Technical details: ${error.message}</small>`,
                confirmButtonColor: '#198754'
            });
        });
    }

    function populateBookingDetailsModal() {
        const selectedRoomsList = document.getElementById('selectedRoomsList');
        const selectedAccommodations = document.querySelectorAll('.select-accommodation.selected');
        
        selectedRoomsList.innerHTML = ''; // Clear previous list

        if (selectedAccommodations.length > 0) {
            const listHeader = document.createElement('h6');
            listHeader.className = 'fw-bold mb-3 text-success';
            listHeader.innerHTML = '<i class="fas fa-bed me-2"></i>Selected Rooms';
            selectedRoomsList.appendChild(listHeader);
        }

        selectedAccommodations.forEach(room => {
            const roomId = room.getAttribute('data-id');
            const roomName = room.querySelector('h5').textContent;
            const availableQuantity = parseInt(room.getAttribute('data-room-quantity')) || 0;

            const roomItem = document.createElement('div');
            roomItem.className = 'card p-2 shadow-sm border-0 mt-2 mb-2';
            roomItem.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-success">${roomName}</span>
                    <div class="d-flex align-items-center">
                        <label for="quantity_${roomId}" class="me-2">Quantity:</label>
                        <input type="number" id="quantity_${roomId}" name="quantity[${roomId}]" class="form-control room-quantity-input m-0" style="width: 80px;" min="1" max="${availableQuantity}" value="1" data-room-id="${roomId}" required>
                    </div>
                </div>
                <small id="quantity_error_${roomId}" class="text-danger mt-1" style="display: none;"></small>
            `;
            selectedRoomsList.appendChild(roomItem);
        });

        // Add event listeners to the new quantity inputs
        document.querySelectorAll('.room-quantity-input').forEach(input => {
            input.addEventListener('input', handleQuantityChange);
        });
    }

    function handleQuantityChange(event) {
        const input = event.target;
        const roomId = input.getAttribute('data-room-id');
        const quantity = parseInt(input.value);
        const maxQuantity = parseInt(input.max);
        const errorElement = document.getElementById(`quantity_error_${roomId}`);

        if (quantity > maxQuantity) {
            errorElement.textContent = `Only ${maxQuantity} rooms of this type are available.`;
            errorElement.style.display = 'block';
            input.value = maxQuantity; // Correct to max value
        } else if (quantity < 1) {
            errorElement.textContent = `Quantity must be at least 1.`;
            errorElement.style.display = 'block';
            input.value = 1; // Correct to min value
        }
        else {
            errorElement.style.display = 'none';
        }

        calculateTotalGuest();
        calculateAndUpdateTotalAmount();
    }

    function calculateTotalGuest() {
        const adultsInput = document.getElementById("number_of_adults");
        const childrenInput = document.getElementById("number_of_children");
        let adults = parseInt(adultsInput.value) || 0;
        let children = parseInt(childrenInput.value) || 0;
    
        let totalCapacity = 0;
        const quantityInputs = document.querySelectorAll('.room-quantity-input');
    
        if (quantityInputs.length > 0) {
            quantityInputs.forEach(input => {
                const roomId = input.getAttribute('data-room-id');
                const roomCard = document.querySelector(`.select-accommodation[data-id="${roomId}"]`);
                if (roomCard) {
                    const roomCapacity = parseInt(roomCard.getAttribute('data-capacity')) || 0;
                    const quantity = parseInt(input.value) || 1; // Assume at least 1
                    totalCapacity += roomCapacity * quantity;
                }
            });
        } else {
            const selectedAccommodations = document.querySelectorAll('.select-accommodation.selected');
            selectedAccommodations.forEach(room => {
                totalCapacity += parseInt(room.getAttribute('data-capacity')) || 0;
            });
        }
    
        let totalGuests = adults + children;
        const guestError = document.getElementById('guestError');
        const totalGuestsInput = document.getElementById("total_guests");
    
        if (totalGuests > totalCapacity && totalCapacity > 0) {
            guestError.textContent = `Exceeds capacity! Correcting to ${totalCapacity} guests.`;
            guestError.style.display = 'block';

            const overBy = totalGuests - totalCapacity;
            if (document.activeElement === adultsInput) {
                adultsInput.value = adults - overBy;
            } else if (document.activeElement === childrenInput) {
                childrenInput.value = children - overBy;
            }

            // Recalculate total guests after correction
            adults = parseInt(adultsInput.value) || 0;
            children = parseInt(childrenInput.value) || 0;
            totalGuests = adults + children;
        } else {
            guestError.style.display = 'none';
        }
    
        totalGuestsInput.value = totalGuests;
        validateInputs();
    }

    // Main DOMContentLoaded event listener
    document.addEventListener("DOMContentLoaded", function () {
        const submitButton = document.querySelector('button[type="submit"]');
        const confirmPaymentBtn = document.getElementById('confirmPayment');
        const reservationModal = new bootstrap.Modal(document.getElementById('reservationModal'));
        const mainForm = document.querySelector('form');
        const proceedButton = document.getElementById("proceedToPayment");
        const checkInDateInput = document.getElementById("reservation_date");
        const checkOutDateInput = document.getElementById("check_out_date");
        
        proceedButton.addEventListener('click', function() {
            populateBookingDetailsModal();
            calculateTotalGuest();
            calculateAndUpdateTotalAmount();
        });

        // Initialize date pickers
        const today = new Date().toISOString().split('T')[0];
        checkInDateInput.min = today;
        checkOutDateInput.min = today;
        
        checkInDateInput.addEventListener("change", function () {
            checkOutDateInput.min = this.value;
            if (checkOutDateInput.value && checkOutDateInput.value < this.value) {
                checkOutDateInput.value = this.value;
            }
            if (this.value && checkOutDateInput.value) {
                fetchAvailableQuantities();
            }
        });

        checkOutDateInput.addEventListener("change", function () {
            if (checkInDateInput.value) {
                fetchAvailableQuantities();
            }
        });

        // Initial validation on page load
        validateInputs();

        // Add event listeners for adult and children inputs
        document.getElementById('number_of_adults').addEventListener('input', calculateTotalGuest);
        document.getElementById('number_of_children').addEventListener('input', calculateTotalGuest);

        // Fixed accommodation card click handlers
        document.addEventListener('click', function(e) {
            const card = e.target.closest('.select-accommodation');
            if (!card) return;
            
            // Prevent selection of unavailable accommodations
            if (card.classList.contains('unavailable')) {
                Swal.fire({
                    title: "Accommodation Unavailable",
                    text: "This accommodation is currently unavailable. Please select another room or different dates.",
                    icon: "warning",
                    confirmButtonColor: '#198754'
                });
                return;
            }

            // Toggle selected class on clicked card
            card.classList.toggle("selected");
            
            updateProceedButton();
            calculateTotalGuest();
        });

        // Form submission handler for booking details modal
        submitButton.addEventListener("click", function(e) {
            e.preventDefault();
            
            // Re-validate before showing modal
            validateInputs();
            if (submitButton.disabled) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please correct the highlighted fields before proceeding.',
                    confirmButtonColor: '#198754'
                });
                return;
            }

            // Additional validations
            const adults = parseInt(document.getElementById('number_of_adults').value) || 0;
            const children = parseInt(document.getElementById('number_of_children').value) || 0;
            
            if (adults <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Number of Adults',
                    text: 'An adult must be included in every booking. Please ensure at least one adult is part of the guest count.',
                    confirmButtonColor: '#198754'
                });
                return;
            }
            
            if (adults + children <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Number of Guests',
                    text: 'The total number of guests must be greater than 0',
                    confirmButtonColor: '#198754'
                });
                return;
            }
            
            // Compute payment details
            const checkInDate = new Date(document.getElementById('reservation_date').value);
            const checkOutDate = new Date(document.getElementById('check_out_date').value);
            const numberOfNights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24)) || 1;
            const totalGuests = document.getElementById('total_guests').value;

            // Update Summary Details
            document.getElementById('summaryCheckIn').textContent = checkInDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            document.getElementById('summaryCheckOut').textContent = checkOutDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            document.getElementById('summaryGuests').textContent = `${totalGuests} guest(s)`;
            document.getElementById('summaryNights').textContent = `${numberOfNights} night(s)`;

            // Update Room List and Calculate Total
            const roomListBody = document.getElementById('summaryRoomList');
            roomListBody.innerHTML = '';
            let finalTotal = 0;

            document.querySelectorAll('.room-quantity-input').forEach(input => {
                const roomId = input.getAttribute('data-room-id');
                const roomCard = document.querySelector(`.select-accommodation[data-id="${roomId}"]`);
                const roomName = roomCard.querySelector('h5').textContent;
                const quantity = parseInt(input.value) || 0;
                const pricePerNight = parseFloat(roomCard.getAttribute('data-price')) || 0;
                const subtotal = quantity * pricePerNight * numberOfNights;
                finalTotal += subtotal;

                const row = `<tr>
                    <td>${roomName}</td>
                    <td class="text-center">${quantity}</td>
                    <td class="text-end">₱${pricePerNight.toFixed(2)}</td>
                    <td class="text-end fw-bold">₱${subtotal.toFixed(2)}</td>
                </tr>`;
                roomListBody.innerHTML += row;
            });
            
            // Update Total Amount Display
            document.getElementById('totalAmountDisplay').textContent = `₱${finalTotal.toFixed(2)}`;
            
            // Hide the current modal before showing the next one
            reservationModal.hide();

            // Show payment breakdown modal
            const paymentBreakdownModal = new bootstrap.Modal(document.getElementById('paymentBreakdownModal'));
            paymentBreakdownModal.show();
        });
        
        // Payment breakdown modal events
        document.getElementById('paymentBreakdownModal').addEventListener('hidden.bs.modal', function () {
            reservationModal.show();
        });
        
        confirmPaymentBtn.addEventListener("click", function() {
            const paymentBreakdownModal = bootstrap.Modal.getInstance(document.getElementById('paymentBreakdownModal'));
            paymentBreakdownModal.hide();
            document.querySelector('form').submit();
        });

        // Main form submission handler
        mainForm.addEventListener("submit", function (e) {
            const selectedAccommodation = document.querySelector(".select-accommodation.selected");
            
            if (!selectedAccommodation) {
                e.preventDefault();
                Swal.fire({
                    title: "No room selected",
                    text: "Please select at least 1 room.",
                    icon: "warning"
                });
                return;
            }
            
            if (!validateInputs()) {
                e.preventDefault();
                Swal.fire({
                    title: "Validation Error",
                    text: "Please correct all errors before submitting.",
                    icon: "error",
                    confirmButtonColor: '#198754'
                });
                return;
            }
        });

        // Get URL parameters and set initial values
        const urlParams = new URLSearchParams(window.location.search);
        const checkIn = urlParams.get("checkIn") || "";
        const checkOut = urlParams.get("checkOut") || "";
        const roomId = urlParams.get('roomid');

        // Set date values
        document.getElementById("reservation_date").value = checkIn;
        document.getElementById("check_out_date").value = checkOut;

        // Pre-select room if specified in URL
        if (roomId) {
            const roomCard = document.querySelector(`.select-accommodation[data-id="${roomId}"]`);
            if (roomCard && !roomCard.classList.contains('unavailable')) {
                roomCard.classList.add("selected");
                roomCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                updateProceedButton();
            }
        }

        // Fetch available quantities if both dates are set
        if (checkIn && checkOut) {
            fetchAvailableQuantities();
        }

        // Initial setup
        updateProceedButton();
        calculateTotalGuest();
    });

    // Utility functions
    function validateInputs() {
        const adultsInput = document.getElementById('number_of_adults');
        const childrenInput = document.getElementById('number_of_children');
        const submitButton = document.querySelector('button[type="submit"]');
        const selectedAccommodation = document.querySelector('.select-accommodation.selected');

        let isValid = true;

        // Validate accommodation selection
        if (!selectedAccommodation) {
            isValid = false;
        }

        // Validate guests
        const totalGuests = (parseInt(adultsInput.value) || 0) + (parseInt(childrenInput.value) || 0);
        if (totalGuests <= 0) {
            adultsInput.classList.add('is-invalid');
            childrenInput.classList.add('is-invalid');
            isValid = false;
        } else {
            adultsInput.classList.remove('is-invalid');
            childrenInput.classList.remove('is-invalid');
        }

        // Check for visible error messages
        const guestError = document.getElementById('guestError');
        if (guestError.style.display === 'block') {
            isValid = false;
        }

        // Update submit button state
        if (isValid) {
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-50');
        } else {
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50');
        }

        return isValid;
    }

    function updateProceedButton() {
        const selectedAccommodation = document.querySelector(".select-accommodation.selected");
        const proceedButton = document.getElementById("proceedToPayment");
        proceedButton.disabled = !selectedAccommodation;
    }

    function calculateAndUpdateTotalAmount() {
        const checkInDateInput = document.getElementById('reservation_date');
        const checkOutDateInput = document.getElementById('check_out_date');
        const totalAmountInput = document.getElementById('total_amount');
        
        let totalAmount = 0;
        
        if (!checkInDateInput.value || !checkOutDateInput.value) {
            totalAmountInput.value = 0;
            return 0;
        }
        
        // Calculate number of nights
        const checkInDate = new Date(checkInDateInput.value);
        const checkOutDate = new Date(checkOutDateInput.value);
        const utc1 = Date.UTC(checkInDate.getFullYear(), checkInDate.getMonth(), checkInDate.getDate());
        const utc2 = Date.UTC(checkOutDate.getFullYear(), checkOutDate.getMonth(), checkOutDate.getDate());
        const numberOfNights = Math.floor((utc2 - utc1) / (1000 * 60 * 60 * 24));

        const quantityInputs = document.querySelectorAll('.room-quantity-input');
        if (quantityInputs.length > 0) {
            quantityInputs.forEach(input => {
                const roomId = input.getAttribute('data-room-id');
                const roomCard = document.querySelector(`.select-accommodation[data-id="${roomId}"]`);
                if (roomCard) {
                    const roomPrice = parseFloat(roomCard.getAttribute('data-price')) || 0;
                    const quantity = parseInt(input.value) || 0;
                    totalAmount += roomPrice * quantity;
                }
            });
        } else { // Fallback for when modal is not open
            const selectedAccommodations = document.querySelectorAll('.select-accommodation.selected');
            selectedAccommodations.forEach(room => {
                const roomPrice = parseFloat(room.getAttribute('data-price')) || 0;
                totalAmount += roomPrice;
            });
        }
        
        totalAmount = totalAmount * numberOfNights;

        // Update the hidden input
        totalAmountInput.value = totalAmount.toFixed(2);
        
        return totalAmount;
    }
</script>
</body>
</html>