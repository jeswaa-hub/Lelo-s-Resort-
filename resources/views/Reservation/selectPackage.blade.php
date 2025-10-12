<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>One Day Stay Reservation</title>
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

    .select-accommodation:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .select-accommodation.unavailable {
        cursor: not-allowed;
        opacity: 0.8;
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

    .availability-display {
        font-size: 0.9em;
        margin-top: 5px;
        padding: 5px;
        border-radius: 4px;
        background-color: rgba(255, 255, 255, 0.8);
    }

    .modal {
        z-index: 1050;
    }
    .modal-backdrop {
        z-index: 1040;
    }
    #paymentBreakdownModal {
        z-index: 1060;
    }
    #paymentBreakdownModal .modal-backdrop {
        z-index: 1050;
    }
</style>
@if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<body class="bg-light font-paragraph" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('images/packagebg.JPG') }}') no-repeat center center fixed; background-size: cover;">
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
        <h1 class="text-white font-heading fs-3 mt-3 mb-3 ms-2">Select your Room</h1>
        
        <form method="POST" action="{{ route('fixPackagesSelection') }}" id="reservationForm">
            @csrf
            <input type="hidden" name="package_type" value="One day Stay">
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
                                <div class="col-md-4 accommodation-card">
                                    <div class="card select-accommodation
                                        @if($accomodation->accomodation_status == 'unavailable') unavailable @endif"
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
                            <h5 class="modal-title fw-bold" id="reservationModalLabel">Booking Details</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
            
                        <div class="modal-body p-4">
                            <div class="mb-4">
                                <div id="selectedRoomsContainer" class="list-group">
                                    <!-- Dynamically populated -->
                                </div>
                            </div>
            
                            <div class="row g-3 mb-3">
                                <!-- Guest Information -->
                                <div class="col-md-6">
                                    <div class="card h-100 shadow-sm border-0">
                                        <div class="card-body">
                                            <h6 class="fw-bold text-success mb-3"><i class="fas fa-users me-2"></i>Guest Information</h6>
                                            <div class="row g-3">
                                                <div class="col-sm-6"> 
                                                    <label for="number_of_adults" class="form-label fw-medium">Adults <small class="text-muted">(13+)</small></label>
                                                    <input type="number" name="number_of_adults" id="number_of_adults" class="form-control" min="0" value="0">
                                                    <small class="text-muted" id="adult_entrance_fee">Fee: ₱<span id="adult_fee">{{ number_format($adultTransaction->entrance_fee, 2) }}</span></small>
                                                </div>
                                                <div class="col-sm-6"> 
                                                    <label for="number_of_children" class="form-label fw-medium">Children <small class="text-muted">(3-12)</small></label>
                                                    <input type="number" name="number_of_children" id="number_of_children" class="form-control" min="0" value="0">
                                                    <small class="text-muted" id="child_entrance_fee">Fee: ₱<span id="child_fee">{{ number_format($kidTransaction->entrance_fee, 2) }}</span></small>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <label for="total_guests" class="form-label fw-medium">Total Guests</label>
                                                <input type="number" id="total_guests" class="form-control bg-light" readonly>
                                                <small class="text-muted">Total Entrance Fee: ₱<span id="total_entrance_fee">0.00</span></small>
                                                <div id="guestError" class="text-danger mt-1 small" style="display: none;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                                <!-- Stay Details -->
                                <div class="col-md-6">
                                    <div class="card h-100 shadow-sm border-0">
                                        <div class="card-body">
                                            <h6 class="fw-bold text-success mb-3"><i class="fas fa-calendar-alt me-2"></i>Stay Details</h6>
                                            <div class="mb-3">
                                                <label for="session" class="form-label fw-medium">Session</label>
                                                <select id="session" name="session" class="form-select" onchange="updateSessionTimes()">
                                                    <option value="morning" {{ (isset($transactions->session) && $transactions->session == 'morning') ? 'selected' : '' }}>Morning Session</option>
                                                    <option value="evening" {{ (isset($transactions->session) && $transactions->session == 'evening') ? 'selected' : '' }}>Evening Session</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="reservation_date" class="form-label fw-medium">Date</label>
                                                <div class="input-group"> 
                                                    <input type="date" name="reservation_check_in_date" id="reservation_date" class="form-control m-0" required readonly>
                                                    <input type="date" name="reservation_check_out_date" id="check_out_date" class="form-control m-0" readonly hidden>
                                                </div>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <label for="start_time" class="form-label fw-medium">Check-in</label>
                                                    <input type="time" name="reservation_check_in" id="start_time" class="form-control" value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $transactions->start_time)->format('H:i') }}" required readonly>
                                                </div>
                                                <div class="col-6">
                                                    <label for="end_time" class="form-label fw-medium">Check-out</label>
                                                    <input type="time" name="reservation_check_out" id="end_time" value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $transactions->end_time)->format('H:i') }}" class="form-control" required readonly>
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
                            
                            <!-- SUBMIT BUTTON -->
                            <div class="text-center mt-4">
                                <button type="button" id="submitReservation" class="btn btn-success btn-lg fw-bold px-5 py-2 shadow-sm">
                                    Continue
                                    <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form> 
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
                <div class="modal-body p-4">
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
// Global function definitions
function updateProceedButton() {
    const selectedAccommodation = document.querySelector(".select-accommodation.selected");
    const proceedButton = document.getElementById("proceedToPayment");
    if (proceedButton) {
        proceedButton.disabled = !selectedAccommodation;
    }
}

function validateRoomQuantity(inputElement) {
    let quantity = parseInt(inputElement.value) || 0;
    const available = parseInt(inputElement.dataset.available) || 0;
    
    const roomItem = inputElement.closest('.selected-room-item');
    const errorMessage = roomItem.querySelector('.quantity-error-message');

    if (quantity > available) {
        inputElement.value = available;
        quantity = available;
        errorMessage.textContent = `Exceeds available rooms! (Available: ${available})`;
        errorMessage.style.display = 'block';
    } else {
        errorMessage.style.display = 'none';
    }
    
    calculateTotals();
}

function calculateTotals() {
    let totalCapacity = 0;
    const roomItems = document.querySelectorAll('#selectedRoomsContainer .selected-room-item');
    
    roomItems.forEach(item => {
        const id = item.dataset.roomId;
        const roomCard = document.querySelector(`.select-accommodation[data-id="${id}"]`);
        const capacity = parseInt(roomCard.getAttribute('data-capacity')) || 0;
        
        const quantityInput = item.querySelector('.room-quantity-input');
        const quantity = parseInt(quantityInput.value) || 0;
        
        totalCapacity += capacity * quantity;
    });

    const adultsInput = document.getElementById("number_of_adults");
    const childrenInput = document.getElementById("number_of_children");
    let adults = parseInt(adultsInput.value) || 0;
    let children = parseInt(childrenInput.value) || 0;
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

        adults = parseInt(adultsInput.value) || 0;
        children = parseInt(childrenInput.value) || 0;
        totalGuests = adults + children;
    } else {
        guestError.style.display = 'none';
    }

    if (totalGuestsInput) {
        totalGuestsInput.value = totalGuests;
    }

    const adultFeeElement = document.getElementById('adult_fee');
    const childFeeElement = document.getElementById('child_fee');
    const totalEntranceFeeElement = document.getElementById('total_entrance_fee');
    
    if (adultFeeElement && childFeeElement && totalEntranceFeeElement) { 
        const adultFee = parseFloat(adultFeeElement.textContent.replace(/[^0-9.]/g, '')) || 0;
        const childFee = parseFloat(childFeeElement.textContent.replace(/[^0-9.]/g, '')) || 0;
        const totalEntranceFee = (adults * adultFee) + (children * childFee);
        totalEntranceFeeElement.textContent = totalEntranceFee.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
}

function populateBookingModal() {
    const selectedAccommodations = document.querySelectorAll('.select-accommodation.selected');
    const container = document.getElementById('selectedRoomsContainer');
    container.innerHTML = '';

    if (selectedAccommodations.length === 0) {
        container.innerHTML = '<p class="text-center text-muted">No rooms selected.</p>';
        return;
    }

    if (selectedAccommodations.length > 0) {
        const listHeader = document.createElement('h6');
        listHeader.className = 'fw-bold mb-3 text-success';
        listHeader.innerHTML = '<i class="fas fa-bed me-2"></i>Selected Rooms';
        container.appendChild(listHeader);
    }

    selectedAccommodations.forEach(room => {
        const id = room.getAttribute('data-id');
        const name = room.querySelector('.font-heading').textContent;
        const price = room.getAttribute('data-price');
        const availableQuantity = room.getAttribute('data-room-quantity');

        const roomHtml = `
            <div class="card p-2 shadow-sm border-0 mt-2 mb-2 selected-room-item" data-room-id="${id}">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 text-success">${name}</h6>
                    </div>
                    <div class="d-flex align-items-center">
                        <label for="quantity-${id}" class="me-2">Quantity:</label>
                        <input type="number" id="quantity-${id}" name="quantity[${id}]" class="form-control room-quantity-input" style="width: 80px;" min="1" max="${availableQuantity}" value="1" data-available="${availableQuantity}" oninput="validateRoomQuantity(this)" required>
                    </div>
                </div>
                <small class="text-danger quantity-error-message w-100 mt-1" style="display: none;"></small>
            </div> 
        `;
        container.insertAdjacentHTML('beforeend', roomHtml);
    });
    
    calculateTotals();
}

function updateSessionTimes() {
    var session = document.getElementById('session').value;
    fetch('/get-session-times?session=' + session)
        .then(response => response.json())
        .then(data => {
            const adultFee = parseFloat(data.adultFee);
            const kidFee = parseFloat(data.kidFee);

            const adultFeeElement = document.getElementById('adult_fee');
            const childFeeElement = document.getElementById('child_fee');
            
            if (adultFeeElement) adultFeeElement.textContent = ' ' + adultFee.toFixed(2);
            if (childFeeElement) childFeeElement.textContent = ' ' + kidFee.toFixed(2);

            calculateTotals();

            if (data.start_time && data.end_time) {
                const startTimeElement = document.getElementById('start_time');
                const endTimeElement = document.getElementById('end_time');
                
                if (startTimeElement) startTimeElement.value = data.start_time.substring(0,5);
                if (endTimeElement) endTimeElement.value = data.end_time.substring(0,5);
            } else {
                const startTimeElement = document.getElementById('start_time');
                const endTimeElement = document.getElementById('end_time');
                
                if (startTimeElement) startTimeElement.value = '';
                if (endTimeElement) endTimeElement.value = '';
            }
        })
        .catch(error => {
            console.error('Error fetching session times:', error);
            const startTimeElement = document.getElementById('start_time');
            const endTimeElement = document.getElementById('end_time');
            
            if (startTimeElement) startTimeElement.value = '';
            if (endTimeElement) endTimeElement.value = '';
        });
}

function resetFrontendAccommodations() {
    console.log("Resetting accommodations to available...");

    document.querySelectorAll(".select-accommodation").forEach(item => {
        item.classList.remove("disabled");
        item.classList.add("available");

        let statusSpan = item.querySelector(".card-text");
        if (statusSpan) {
            statusSpan.textContent = "Available";
            statusSpan.style.backgroundColor = "#C6F7D0";
        }
    });
}

function fetchAvailableQuantities() {
    const checkInDate = document.getElementById('reservation_date').value;
    const checkOutDate = document.getElementById('check_out_date').value;

    if (!checkInDate || !checkOutDate) {
        console.log('Check-in or check-out date not selected');
        return;
    }
    
    const accommodationCards = document.querySelectorAll('.select-accommodation');

    accommodationCards.forEach(card => {
        const quantityText = card.querySelector('.availability-display');
        if (quantityText) {
            quantityText.innerHTML = '<em>Checking availability...</em>';
            quantityText.className = 'availability-display text-warning';
        }
    });

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
            return response.text().then(text => {
                throw new Error(`HTTP error! Status: ${response.status}. Response: ${text}`);
            });
        }
        return response.json();
    })
    .then(data => {
        accommodationCards.forEach(card => {
            const accommodationId = card.getAttribute('data-id');
            const originalStatus = card.getAttribute('data-status');
            
            let availableQuantity = 0;
            if (data[accommodationId] !== undefined) {
                if (typeof data[accommodationId] === 'number') {
                    availableQuantity = data[accommodationId];
                } else if (typeof data[accommodationId] === 'object' && data[accommodationId].available_rooms !== undefined) {
                    availableQuantity = data[accommodationId].available_rooms;
                } else if (typeof data[accommodationId] === 'object' && data[accommodationId].quantity !== undefined) {
                    availableQuantity = data[accommodationId].quantity;
                }
            }
            
            card.setAttribute('data-room-quantity', availableQuantity);
            
            const quantityText = card.querySelector('.availability-display');

            if (originalStatus !== 'available') {
                card.classList.add('unavailable');
                card.classList.remove('selected');
                if (quantityText) {
                    quantityText.innerHTML = `<strong>Currently unavailable</strong>`;
                    quantityText.className = 'availability-display text-danger fw-bold';
                }
            } else if (availableQuantity > 0) {
                card.classList.remove('unavailable');
                if (quantityText) {
                    quantityText.innerHTML = `<strong>${availableQuantity}</strong> rooms available`;
                    quantityText.className = 'availability-display text-success';
                }
            } else {
                card.classList.add('unavailable');
                card.classList.remove('selected');
                if (quantityText) {
                    quantityText.innerHTML = `<strong>Not available</strong> on selected dates`;
                    quantityText.className = 'availability-display text-danger fw-bold';
                }
            }
        });
        
        calculateTotals();
        updateProceedButton();
    })
    .catch(error => {
        console.error('Error checking availability:', error);
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
            text: 'Failed to check room availability. Please try again.',
            confirmButtonColor: '#198754'
        });
    });
}

document.addEventListener("DOMContentLoaded", function() {
    const reservationForm = document.getElementById('reservationForm');
    const submitReservationBtn = document.getElementById('submitReservation');
    const confirmPaymentBtn = document.getElementById('confirmPayment');
    const reservationModal = new bootstrap.Modal(document.getElementById('reservationModal'));
    const paymentBreakdownModal = new bootstrap.Modal(document.getElementById('paymentBreakdownModal'));
    
    document.getElementById('paymentBreakdownModal').addEventListener('hidden.bs.modal', function () {
        reservationModal.show();
    });

    const proceedButton = document.getElementById("proceedToPayment");
    if(proceedButton) {
        proceedButton.addEventListener('click', populateBookingModal);
    }

    document.getElementById('number_of_adults').addEventListener('input', calculateTotals);
    document.getElementById('number_of_children').addEventListener('input', calculateTotals);

    if (submitReservationBtn) {
        submitReservationBtn.addEventListener("click", function(e) {
            e.preventDefault();
            
            let isFormValid = true;
            const roomItems = document.querySelectorAll('#selectedRoomsContainer .selected-room-item');
            let accommodationData = [];

            if (roomItems.length === 0) {
                Swal.fire({ icon: 'error', title: 'No Rooms', text: 'No rooms were found in your booking details.', confirmButtonColor: '#198754' });
                return;
            }

            roomItems.forEach(item => {
                const quantityInput = item.querySelector('.room-quantity-input');
                const quantity = parseInt(quantityInput.value) || 0;
                const available = parseInt(quantityInput.dataset.available) || 0;
                const id = item.dataset.roomId;

                if (quantity <= 0) {
                    isFormValid = false;
                    const errorMessage = quantityInput.nextElementSibling;
                    errorMessage.textContent = 'Quantity must be at least 1.';
                    errorMessage.style.display = 'block';
                } else if (quantity > available) {
                    isFormValid = false;
                }
                
                accommodationData.push({ id: id, quantity: quantity });
            });

            // REMOVED: Guest error validation since we auto-correct now
            // const guestError = document.getElementById('guestError');
            // if (guestError && guestError.style.display === 'block') {
            //     isFormValid = false;
            // }
            
            const adults = parseInt(document.getElementById('number_of_adults').value) || 0;
            if (adults <= 0) {
                isFormValid = false;
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Number of Adults',
                    text: 'An adult must be included in every booking. Please ensure at least one adult is part of the guest count.',
                    confirmButtonColor: '#198754'
                });
                return;
            }

            if (!isFormValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Details',
                    text: 'Please correct the errors in the form before continuing.',
                    confirmButtonColor: '#198754'
                });
                return;
            }

            // Update Summary Details
            const date = new Date(document.getElementById('reservation_date').value);
            document.getElementById('summaryDate').textContent = date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            const sessionSelect = document.getElementById('session');
            document.getElementById('summarySession').textContent = sessionSelect.options[sessionSelect.selectedIndex].text;
            document.getElementById('summaryGuests').textContent = `${document.getElementById('total_guests').value} guest(s)`;

            // Update Room List and Calculate Total
            const roomListBody = document.getElementById('summaryRoomList');
            roomListBody.innerHTML = '';
            let finalTotal = 0;

            accommodationData.forEach(data => {
                const roomCard = document.querySelector(`.select-accommodation[data-id="${data.id}"]`);
                const price = parseFloat(roomCard.getAttribute('data-price')) || 0;
                const roomName = roomCard.querySelector('h5').textContent;
                const subtotal = price * data.quantity;
                finalTotal += subtotal;

                const row = `<tr>
                    <td>${roomName}</td>
                    <td class="text-center">${data.quantity}</td>
                    <td class="text-end">₱${price.toFixed(2)}</td>
                    <td class="text-end fw-bold">₱${subtotal.toFixed(2)}</td>
                </tr>`;
                roomListBody.innerHTML += row;
            });

            const totalEntranceFeeElement = document.getElementById('total_entrance_fee');
            const totalEntranceFee = totalEntranceFeeElement ? parseFloat(totalEntranceFeeElement.textContent.replace(/[^\d.]/g, '')) || 0 : 0;
            finalTotal += totalEntranceFee;

            if (totalEntranceFee > 0) {
                const entranceRow = `<tr>
                    <td>Entrance Fee</td>
                    <td class="text-center">${document.getElementById('total_guests').value}</td>
                    <td class="text-end">-</td>
                    <td class="text-end fw-bold">₱${totalEntranceFee.toFixed(2)}</td>
                </tr>`;
                roomListBody.innerHTML += entranceRow;
            }
            document.getElementById('totalAmountDisplay').textContent = `₱${finalTotal.toFixed(2)}`;
            
            reservationModal.hide();
            setTimeout(() => {
                paymentBreakdownModal.show();
            }, 300);
        });
    }
    
    if (confirmPaymentBtn) {
        confirmPaymentBtn.addEventListener("click", function() {
            if (reservationForm) reservationForm.submit();
        });
    }

    const accommodationCards = document.querySelectorAll(".select-accommodation:not(.unavailable)");
    const checkInDateInput = document.getElementById("reservation_date");
    const checkOutDateInput = document.getElementById("check_out_date");

    accommodationCards.forEach(card => {
        card.addEventListener("click", function () {
            if (this.classList.contains('unavailable')) {
                Swal.fire({
                    title: "Accommodation Unavailable",
                    text: "This accommodation is currently unavailable. Please select another room.",
                    icon: "warning",
                    confirmButtonColor: '#198754'
                });
                return;
            }

            this.classList.toggle("selected");
            
            updateProceedButton();
        });
    });

    if (checkInDateInput) {
        checkInDateInput.addEventListener("change", function () {
            resetFrontendAccommodations();
            fetchAvailableQuantities();
        });
    }

    if (checkOutDateInput) {
        checkOutDateInput.addEventListener("change", function () {
            fetchAvailableQuantities();
        });
    }

    const urlParams = new URLSearchParams(window.location.search);
    const checkIn = urlParams.get("checkIn") || "";
    const checkOut = urlParams.get("checkOut") || "";
    const roomId = urlParams.get('roomid');

    if (checkInDateInput) checkInDateInput.value = checkIn;
    if (checkOutDateInput) checkOutDateInput.value = checkOut;

    if (checkIn && !checkOut) {
        checkOutDateInput.value = checkIn;
    }

    if (checkIn && checkOutDateInput.value) {
        fetchAvailableQuantities();
    }

    if (roomId) {
        const roomCard = document.querySelector(`.select-accommodation[data-id="${roomId}"]`);
        if (roomCard) {
            document.querySelectorAll(".select-accommodation").forEach(card => {
                card.classList.remove("selected");
            });
            
            roomCard.classList.add("selected");
            roomCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            const proceedButton = document.getElementById("proceedToPayment");
            if (proceedButton) proceedButton.disabled = false;
        }
    }

    updateProceedButton();
});
</script>
</body>
</html>