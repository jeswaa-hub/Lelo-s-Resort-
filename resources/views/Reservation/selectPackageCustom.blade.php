<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stay In</title>
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

<body class="bg-light font-paragraph" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.8)), url('{{ asset('images/packagebg.JPG') }}') no-repeat center center fixed; background-size: cover;">
<x-loading-screen />    
<div class="d-flex align-items-center ms-5 mt-5">
        <a href="{{ route('calendar') }}"><i class="color-3 fa-2x fa-circle-left fa-solid icon icon-hover ms-4"></i></a><h1 class="text-white text-uppercase font-heading ms-3">Reservation</h1>
    </div>

    <div class="position-absolute top-0 end-0 mt-3 me-5 d-none d-md-block">
        <a class="text-decoration-none">
            <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="120" class="rounded-pill">
        </a>
    </div>
    
    <div class="container">
    <h1 class="text-white font-heading fs-2 mt-3 mb-3 ms-2">Select your Room</h1>
    
    <form method="POST" action="{{ route('savePackageSelection') }}">
        @csrf
        <input type="hidden" name="package_type" value="One day Stay">

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
                            <div class="modal fade" id="roomModal{{ $accomodation->accomodation_id }}" tabindex="-1" aria-labelledby="roomModalLabel{{ $accomodation->accomodation_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content rounded-4 shadow">
                                        <div class="modal-header border-0" style="background-color: #0b573d;">
                                            <h5 class="modal-title text-white text-uppercase" style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;" id="roomModalLabel{{ $accomodation->accomodation_id }}">{{ $accomodation->accomodation_name }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-0">
                                            <div class="row g-0">
                                                <!-- Left Column - Image -->
                                                <div class="col-md-6">
                                                    <div class="position-relative h-100">
                                                        <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}" 
                                                            class="w-100 h-100 object-fit-cover rounded-start" 
                                                            style="max-height: 400px;" 
                                                            alt="{{ $accomodation->accomodation_name }}">
                                                        <div class="position-absolute bottom-0 start-0 w-100 p-3" 
                                                            style="background: linear-gradient(0deg, rgba(11, 87, 61, 0.9) 0%, rgba(11, 87, 61, 0.7) 100%);">
                                                            <h3 class="text-white mb-0 fw-bold">₱{{ number_format($accomodation->accomodation_price, 2) }}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Right Column - Details -->
                                                <div class="col-md-6 p-4">
                                                    <div class="mb-4">
                                                        <h6 class="text-uppercase fw-bold" style="color: #0b573d;">Description</h6>
                                                        <p class="text-muted mb-0">{{ $accomodation->accomodation_description }}</p>
                                                    </div>
                                                    <div class="mb-4">
                                                        <h6 class="text-uppercase fw-bold" style="color: #0b573d;">Amenities</h6>
                                                        <p class="text-muted mb-0">{{ $accomodation->amenities }}</p>
                                                    </div>
                                                    <div class="mb-4">
                                                        <h6 class="text-uppercase fw-bold" style="color: #0b573d;">Capacity</h6>
                                                        <p class="text-muted mb-0">{{ $accomodation->accomodation_capacity }} pax</p>
                                                    </div>
                                                    <div class="mb-4">
                                                        <h6 class="text-uppercase fw-bold" style="color: #0b573d;">Availability</h6>
                                                        <p class="text-muted mb-0">
                                                            @if($accomodation->accomodation_status == 'available')
                                                                <span class="badge bg-success">Available</span>
                                                            @else
                                                                <span class="badge bg-danger">Unavailable</span>
                                                            @endif
                                                        </p>
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
                        <h5 class="modal-title fw-bold" id="reservationModalLabel">Booking Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                
                    <div class="modal-body px-4">
                        <!-- Tanggalin ang form tag dito -->
                        @csrf
                        <input type="hidden" name="package_type" value="custom">
                        
                        <!-- VISITOR INFO -->
                        <div class="row g-4">
                            <div class="col-md-6">
                             <div class="card p-2 shadow-sm border-0 mt-2 mb-2">
                                <h6 class="fw-bold mb-3 text-success">Number of rooms</h6>
                                    <input type="number" id="quantity" name="quantity" class="form-control" min="1" value="1" required oninput="validateInputs()">
                                    <small id="quantityError" class="text-danger mt-2" style="display: none;"></small>
                                </div>
                                <div class="card p-3 shadow-sm border-0">
                                    <h6 class="fw-bold mb-3 text-success">Number of Visitors</h6>
                                    <div class="form-group mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="number_of_adults">Adults <small style="font-size:10px;">(13 years old and above):</small></label>
                                        </div>
                                        <input type="number" name="number_of_adults" id="number_of_adults" class="form-control p-2" min="0" value="0" oninput="calculateTotalGuest(); validateInputs();">
                                        {{-- Display validation error for adults --}}
                                        @error('number_of_adults')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="number_of_children">Children <small style="font-size:10px;">(3 to 12 years old):</small></label>
                                        </div>
                                        <input type="number" name="number_of_children" id="number_of_children" class="form-control p-2" min="0" value="0" oninput="calculateTotalGuest(); validateInputs();">
                                        {{-- Display validation error for children --}}
                                        @error('number_of_children')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="total_guests">Total Guests:</label>
                                        <input type="number" name="total_guest" id="total_guests" class="form-control p-2" readonly>
                                        <div id="guestError" class="text-danger mt-2" style="display: none;">
                                            Exceeds maximum room capacity!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-md-6 mb-4">
                                <div class="card p-3 shadow-sm border-0">
                                    <h6 class="fw-bold mb-3 text-success">Time</h6>
                                    <div class="form-group">
                                        <label for="start_time">Check-in Time:</label>
                                        <input type="time" id="start_time" name="reservation_check_in" class="form-control" value="14:00" readonly required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="end_time">Check-out Time:</label>
                                        <input type="time" id="end_time" name="reservation_check_out" value="12:00" class="form-control" readonly required>
                                    </div>
                                </div>
                                <!-- DATE SELECTION -->
                                <div class="col-md-12 mt-3">
                                    <div class="card p-2 shadow-sm border-0">
                                        <h6 class="fw-bold text-success">Select Date</h6>
                                        <div class="d-flex flex-column gap-2">
                                            <div>
                                                <label for="reservation_date">Check-in Date:</label>
                                                <input type="date" id="reservation_date" name="reservation_check_in_date" class="form-control" required readonly>
                                            </div>
                                            <div>
                                                <label for="check_out_date" class="form-label">Check-out Date:</label>
                                                <input type="date" id="check_out_date" name="reservation_check_out_date" class="form-control" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <!-- SPECIAL REQUEST -->
                            <div class="col-md-12">
                                <div class="card p-3 shadow-sm border-0 mt-3">
                                    <h6 class="fw-bold mb-3 text-success">Special Request</h6>
                                    <textarea id="specialRequest" name="special_request" class="form-control" rows="4" placeholder="Enter any special requests"></textarea>
                                </div>
                            </div>
                        </div>
                    
                        <input type="hidden" name="total_amount" id="total_amount">
                    
                        <!-- SUBMIT BUTTON -->
                        <div class="text-center mt-2 mb-3">
                            <button type="submit" class="btn btn-success fw-bold px-5 py-2 shadow-sm">
                                Continue to payment
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
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="paymentBreakdownModalLabel">Payment Breakdown</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="payment-details">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Room Price:</span>
                                <span id="roomRate">₱0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Number of Rooms:</span>
                                <span id="numberOfRooms">0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Number of Nights:</span>
                                <span id="numberOfNights">0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total Amount:</span>
                                <span id="totalAmountDisplay">₱0.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Edit</button>
                        <button type="button" class="btn btn-success" id="confirmPayment">Confirm</button>
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
        validateCurrentQuantity();
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

// Function to validate current quantity against newly fetched available quantity
function validateCurrentQuantity() {
    const quantityInput = document.getElementById('quantity');
    const selectedAccommodation = document.querySelector('.select-accommodation.selected');
    const quantityError = document.getElementById('quantityError');
    const currentQuantity = parseInt(quantityInput.value) || 0;
    
    if (selectedAccommodation && currentQuantity > 0) {
        const availableQuantity = parseInt(selectedAccommodation.getAttribute('data-room-quantity')) || 0;
        
        if (currentQuantity > availableQuantity) {
            quantityError.style.display = 'block';
            quantityError.textContent = `Not enough rooms! Only ${availableQuantity} available for selected dates.`;
            quantityError.classList.add('alert', 'alert-danger', 'mt-2', 'p-2');
            quantityInput.classList.add('is-invalid');
            
            // Auto-adjust quantity to maximum available
            quantityInput.value = Math.max(1, availableQuantity);
            
            if (availableQuantity <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Room Not Available',
                    text: 'No rooms available for selected dates. Please choose different dates.',
                    confirmButtonColor: '#198754'
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Quantity Adjusted',
                    text: `We adjusted your quantity to ${availableQuantity} for the selected dates.`,
                    confirmButtonColor: '#198754',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        } else {
            quantityError.style.display = 'none';
            quantityError.classList.remove('alert', 'alert-danger', 'mt-2', 'p-2');
            quantityInput.classList.remove('is-invalid');
        }
    }
}

// Updated calculateTotalGuest function
function calculateTotalGuest() {
    let adults = parseInt(document.getElementById("number_of_adults").value) || 0;
    let children = parseInt(document.getElementById("number_of_children").value) || 0;
    let totalGuests = adults + children;
    let quantity = parseInt(document.getElementById("quantity").value) || 1;
    
    let selectedAccommodation = document.querySelector('.select-accommodation.selected');
    let totalCapacity = 0;
    let availableRoomQuantity = 0;

    if (selectedAccommodation) {
        let roomCapacity = parseInt(selectedAccommodation.getAttribute('data-capacity')) || 0;
        totalCapacity = roomCapacity * quantity;
        availableRoomQuantity = parseInt(selectedAccommodation.getAttribute('data-room-quantity')) || 0;
    }

    let saveButton = document.querySelector('button[type="submit"]');
    let guestError = document.getElementById('guestError');
    let quantityError = document.getElementById('quantityError');
    let totalGuestsInput = document.getElementById("total_guests");

    // Quantity validation against available rooms
    if (quantity > availableRoomQuantity && availableRoomQuantity > 0) {
        quantityError.style.display = 'block';
        quantityError.textContent = `Not enough rooms! Only ${availableRoomQuantity} available for selected dates`;
        quantityError.classList.add('alert', 'alert-danger', 'mt-2', 'p-2');
        document.getElementById('quantity').classList.add('is-invalid');
    } else if (availableRoomQuantity <= 0 && selectedAccommodation) {
        quantityError.style.display = 'block';
        quantityError.textContent = `No rooms available for selected dates!`;
        quantityError.classList.add('alert', 'alert-danger', 'mt-2', 'p-2');
        document.getElementById('quantity').classList.add('is-invalid');
    } else {
        quantityError.style.display = 'none';
        quantityError.classList.remove('alert', 'alert-danger', 'mt-2', 'p-2');
        document.getElementById('quantity').classList.remove('is-invalid');
    }

    // Guest capacity validation
    if (totalGuests > totalCapacity && totalCapacity > 0) {
        guestError.style.display = 'block';
        guestError.textContent = `Exceeds maximum capacity! (Maximum: ${totalCapacity} guests for ${quantity} room(s))`;
        guestError.classList.add('alert', 'alert-danger', 'mt-2', 'p-2');
        totalGuestsInput.style.color = 'red';
        totalGuestsInput.classList.add('is-invalid');
    } else {
        guestError.style.display = 'none';
        guestError.classList.remove('alert', 'alert-danger', 'mt-2', 'p-2');
        totalGuestsInput.style.color = 'black';
        totalGuestsInput.classList.remove('is-invalid');
    }

    // Update total guests
    document.getElementById("total_guests").value = totalGuests;
    
    // Call validateInputs to check overall form validity
    validateInputs();
}

// Main DOMContentLoaded event listener
document.addEventListener("DOMContentLoaded", function () {
    const submitButton = document.querySelector('button[type="submit"]');
    const confirmPaymentBtn = document.getElementById('confirmPayment');
    const reservationModal = new bootstrap.Modal(document.getElementById('reservationModal'));
    const mainForm = document.querySelector('form');
    const proceedButton = document.getElementById("proceedToPayment");
    const quantityInput = document.getElementById("quantity");
    const checkInDateInput = document.getElementById("reservation_date");
    const checkOutDateInput = document.getElementById("check_out_date");
    
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

    // Real-time quantity validation
    quantityInput.addEventListener('input', function() {
        const selectedAccommodation = document.querySelector('.select-accommodation.selected');
        const quantityError = document.getElementById('quantityError');
        const currentQuantity = parseInt(this.value) || 0;
        
        if (selectedAccommodation) {
            const availableQuantity = parseInt(selectedAccommodation.getAttribute('data-room-quantity')) || 0;
            
            if (currentQuantity > availableQuantity) {
                quantityError.style.display = 'block';
                quantityError.textContent = `Not enough rooms! Only ${availableQuantity} available for selected dates`;
                quantityError.classList.add('alert', 'alert-danger', 'mt-2', 'p-2');
                this.classList.add('is-invalid');
                
                // Show SweetAlert for immediate feedback
                Swal.fire({
                    icon: 'warning',
                    title: 'Too many rooms selected!',
                    text: `Only ${availableQuantity} rooms available for selected dates.`,
                    confirmButtonColor: '#198754',
                    timer: 3000,
                    showConfirmButton: false
                });
            } else {
                quantityError.style.display = 'none';
                quantityError.classList.remove('alert', 'alert-danger', 'mt-2', 'p-2');
                this.classList.remove('is-invalid');
            }
        }
        
        calculateTotalGuest();
    });

    // Add event listeners for adult and children inputs
    document.getElementById('number_of_adults').addEventListener('input', calculateTotalGuest);
    document.getElementById('number_of_children').addEventListener('input', calculateTotalGuest);

    // Function to update proceed button state
    function updateProceedButton() {
        const selectedAccommodation = document.querySelector(".select-accommodation.selected");
        proceedButton.disabled = !selectedAccommodation || selectedAccommodation.classList.contains('unavailable');
    }

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

        // Remove selected class from all cards
        document.querySelectorAll('.select-accommodation').forEach(c => c.classList.remove("selected"));
        
        // Add selected class to clicked card
        card.classList.add("selected");
        
        // Validate quantity for newly selected accommodation
        validateCurrentQuantity();
        
        updateProceedButton();
        calculateTotalGuest();
        updateSelectedAccommodation();
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
        const quantity = parseInt(document.getElementById('quantity').value) || 0;
        const adults = parseInt(document.getElementById('number_of_adults').value) || 0;
        const children = parseInt(document.getElementById('number_of_children').value) || 0;
        
        if (quantity <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Quantity',
                text: 'Please enter a quantity greater than 0',
                confirmButtonColor: '#198754'
            });
            return;
        }

        if (adults <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Number of Adults',
                text: 'Please enter the number of adults (must be greater than 0)',
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
        
        // Hide reservation modal and show payment breakdown
        reservationModal.hide();
        
        // Compute payment details
        const selectedAccommodation = document.querySelector('.select-accommodation.selected');
        const roomRate = parseFloat(selectedAccommodation.getAttribute('data-price')) || 0;
        
        // Calculate number of nights
        const checkInDate = new Date(document.getElementById('reservation_date').value);
        const checkOutDate = new Date(document.getElementById('check_out_date').value);
        const numberOfNights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
        
        // Calculate total
        const totalAmount = roomRate * quantity * numberOfNights;
        
        // Update payment breakdown modal
        document.getElementById('roomRate').textContent = `₱${roomRate.toFixed(2)}`;
        document.getElementById('numberOfRooms').textContent = quantity;
        document.getElementById('numberOfNights').textContent = numberOfNights;
        document.getElementById('totalAmountDisplay').textContent = `₱${totalAmount.toFixed(2)}`;
        
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
        
        if (selectedAccommodation.classList.contains('unavailable')) {
            e.preventDefault();
            Swal.fire({
                title: "Selected room is unavailable",
                text: "Please select an available room.",
                icon: "error",
                confirmButtonColor: '#198754'
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
        
        updateSelectedAccommodation();
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
            document.querySelectorAll(".select-accommodation").forEach(card => {
                card.classList.remove("selected");
            });
            
            roomCard.classList.add("selected");
            roomCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            updateProceedButton();
            updateSelectedAccommodation();
        }
    }

    // Fetch available quantities if both dates are set
    if (checkIn && checkOut) {
        fetchAvailableQuantities();
    }

    // Initial setup
    updateProceedButton();
    calculateTotalGuest();

    // Enhanced quantity input restrictions
    quantityInput.addEventListener('keydown', function(e) {
        // Allow: backspace, delete, tab, escape, enter
        if ([46, 8, 9, 27, 13].indexOf(e.keyCode) !== -1 ||
            // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
            (e.keyCode === 65 && e.ctrlKey === true) ||
            (e.keyCode === 67 && e.ctrlKey === true) ||
            (e.keyCode === 86 && e.ctrlKey === true) ||
            (e.keyCode === 88 && e.ctrlKey === true)) {
            return;
        }
        // Ensure that it's a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    // Prevent pasting non-numeric values
    quantityInput.addEventListener('paste', function(e) {
        setTimeout(() => {
            let value = this.value.replace(/[^0-9]/g, '');
            if (value !== this.value) {
                this.value = value;
                calculateTotalGuest();
            }
        }, 1);
    });

    // Auto-correct quantity on blur
    quantityInput.addEventListener('blur', function() {
        const selectedAccommodation = document.querySelector('.select-accommodation.selected');
        const currentQuantity = parseInt(this.value) || 0;
        
        if (selectedAccommodation && currentQuantity > 0) {
            const availableQuantity = parseInt(selectedAccommodation.getAttribute('data-room-quantity')) || 0;
            
            if (currentQuantity > availableQuantity) {
                this.value = Math.max(1, availableQuantity);
                calculateTotalGuest();
            }
        }
    });
});

// Utility functions
function validateInputs() {
    const quantityInput = document.getElementById('quantity');
    const adultsInput = document.getElementById('number_of_adults');
    const childrenInput = document.getElementById('number_of_children');
    const submitButton = document.querySelector('button[type="submit"]');
    const selectedAccommodation = document.querySelector('.select-accommodation.selected');

    let isValid = true;

    // Validate accommodation selection
    if (!selectedAccommodation || selectedAccommodation.classList.contains('unavailable')) {
        isValid = false;
    }

    // Validate quantity
    if (!quantityInput.value || parseInt(quantityInput.value) <= 0 || isNaN(parseInt(quantityInput.value))) {
        quantityInput.classList.add('is-invalid');
        isValid = false;
    } else {
        if (selectedAccommodation) {
            const availableQuantity = parseInt(selectedAccommodation.getAttribute('data-room-quantity')) || 0;
            if (parseInt(quantityInput.value) > availableQuantity) {
                quantityInput.classList.add('is-invalid');
                isValid = false;
            } else {
                quantityInput.classList.remove('is-invalid');
            }
        }
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
    const quantityError = document.getElementById('quantityError');

    if (guestError.style.display === 'block' || quantityError.style.display === 'block') {
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

function updateSelectedAccommodation() {
    const mainForm = document.querySelector('form');
    
    // Remove existing accommodation input
    mainForm.querySelectorAll('input[name="accomodation_id[]"]').forEach(input => input.remove());
    
    // Add new input for selected accommodation
    const selectedCard = document.querySelector(".select-accommodation.selected");
    if (selectedCard) {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "accomodation_id[]";
        input.value = selectedCard.getAttribute("data-id");
        mainForm.appendChild(input);
    }
}

function updateProceedButton() {
    const selectedAccommodation = document.querySelector(".select-accommodation.selected");
    const proceedButton = document.getElementById("proceedToPayment");
    proceedButton.disabled = !selectedAccommodation || (selectedAccommodation && selectedAccommodation.classList.contains('unavailable'));
}
// Add this function to calculate and update total amount
function calculateAndUpdateTotalAmount() {
    const selectedAccommodation = document.querySelector('.select-accommodation.selected');
    const quantityInput = document.getElementById('quantity');
    const checkInDateInput = document.getElementById('reservation_date');
    const checkOutDateInput = document.getElementById('check_out_date');
    const totalAmountInput = document.getElementById('total_amount');
    
    if (!selectedAccommodation || !checkInDateInput.value || !checkOutDateInput.value) {
        totalAmountInput.value = 0;
        return;
    }
    
    // Get room price
    const roomPrice = parseFloat(selectedAccommodation.getAttribute('data-price')) || 0;
    
    // Get quantity
    const quantity = parseInt(quantityInput.value) || 1;
    
    // Calculate number of nights
    const checkInDate = new Date(checkInDateInput.value);
    const checkOutDate = new Date(checkOutDateInput.value);
    const numberOfNights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
    
    // Calculate total amount: room price × quantity × number of nights
    const totalAmount = roomPrice * quantity * numberOfNights;
    
    // Update the hidden input
    totalAmountInput.value = totalAmount.toFixed(2);
    
    console.log(`Calculation: ₱${roomPrice} × ${quantity} rooms × ${numberOfNights} nights = ₱${totalAmount.toFixed(2)}`);
    
    return totalAmount;
}

// Update the existing calculateTotalGuest function to also calculate total amount
function calculateTotalGuest() {
    let adults = parseInt(document.getElementById("number_of_adults").value) || 0;
    let children = parseInt(document.getElementById("number_of_children").value) || 0;
    let totalGuests = adults + children;
    let quantity = parseInt(document.getElementById("quantity").value) || 1;
    
    let selectedAccommodation = document.querySelector('.select-accommodation.selected');
    let totalCapacity = 0;
    let availableRoomQuantity = 0;

    if (selectedAccommodation) {
        let roomCapacity = parseInt(selectedAccommodation.getAttribute('data-capacity')) || 0;
        totalCapacity = roomCapacity * quantity;
        availableRoomQuantity = parseInt(selectedAccommodation.getAttribute('data-room-quantity')) || 0;
    }

    let saveButton = document.querySelector('button[type="submit"]');
    let guestError = document.getElementById('guestError');
    let quantityError = document.getElementById('quantityError');
    let totalGuestsInput = document.getElementById("total_guests");

    // Quantity validation against available rooms
    if (quantity > availableRoomQuantity && availableRoomQuantity > 0) {
        quantityError.style.display = 'block';
        quantityError.textContent = `Not enough rooms! Only ${availableRoomQuantity} available for selected dates`;
        quantityError.classList.add('alert', 'alert-danger', 'mt-2', 'p-2');
        document.getElementById('quantity').classList.add('is-invalid');
    } else if (availableRoomQuantity <= 0 && selectedAccommodation) {
        quantityError.style.display = 'block';
        quantityError.textContent = `No rooms available for selected dates!`;
        quantityError.classList.add('alert', 'alert-danger', 'mt-2', 'p-2');
        document.getElementById('quantity').classList.add('is-invalid');
    } else {
        quantityError.style.display = 'none';
        quantityError.classList.remove('alert', 'alert-danger', 'mt-2', 'p-2');
        document.getElementById('quantity').classList.remove('is-invalid');
    }

    // Guest capacity validation
    if (totalGuests > totalCapacity && totalCapacity > 0) {
        guestError.style.display = 'block';
        guestError.textContent = `Exceeds maximum capacity! (Maximum: ${totalCapacity} guests for ${quantity} room(s))`;
        guestError.classList.add('alert', 'alert-danger', 'mt-2', 'p-2');
        totalGuestsInput.style.color = 'red';
        totalGuestsInput.classList.add('is-invalid');
    } else {
        guestError.style.display = 'none';
        guestError.classList.remove('alert', 'alert-danger', 'mt-2', 'p-2');
        totalGuestsInput.style.color = 'black';
        totalGuestsInput.classList.remove('is-invalid');
    }

    // Update total guests
    document.getElementById("total_guests").value = totalGuests;
    
    // Calculate and update total amount
    calculateAndUpdateTotalAmount();
    
    // Call validateInputs to check overall form validity
    validateInputs();
}

// Update the DOMContentLoaded event listener to include total amount calculation
document.addEventListener("DOMContentLoaded", function () {
    const submitButton = document.querySelector('button[type="submit"]');
    const confirmPaymentBtn = document.getElementById('confirmPayment');
    const reservationModal = new bootstrap.Modal(document.getElementById('reservationModal'));
    const mainForm = document.querySelector('form');
    const proceedButton = document.getElementById("proceedToPayment");
    const quantityInput = document.getElementById("quantity");
    const checkInDateInput = document.getElementById("reservation_date");
    const checkOutDateInput = document.getElementById("check_out_date");
    
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
            calculateAndUpdateTotalAmount(); // Add this line
        }
    });

    checkOutDateInput.addEventListener("change", function () {
        if (checkInDateInput.value) {
            fetchAvailableQuantities();
            calculateAndUpdateTotalAmount(); // Add this line
        }
    });

    // Initial validation on page load
    validateInputs();

    // Real-time quantity validation with total amount calculation
    quantityInput.addEventListener('input', function() {
        const selectedAccommodation = document.querySelector('.select-accommodation.selected');
        const quantityError = document.getElementById('quantityError');
        const currentQuantity = parseInt(this.value) || 0;
        
        if (selectedAccommodation) {
            const availableQuantity = parseInt(selectedAccommodation.getAttribute('data-room-quantity')) || 0;
            
            if (currentQuantity > availableQuantity) {
                quantityError.style.display = 'block';
                quantityError.textContent = `Not enough rooms! Only ${availableQuantity} available for selected dates`;
                quantityError.classList.add('alert', 'alert-danger', 'mt-2', 'p-2');
                this.classList.add('is-invalid');
                
                // Show SweetAlert for immediate feedback
                Swal.fire({
                    icon: 'warning',
                    title: 'Too many rooms selected!',
                    text: `Only ${availableQuantity} rooms available for selected dates.`,
                    confirmButtonColor: '#198754',
                    timer: 3000,
                    showConfirmButton: false
                });
            } else {
                quantityError.style.display = 'none';
                quantityError.classList.remove('alert', 'alert-danger', 'mt-2', 'p-2');
                this.classList.remove('is-invalid');
            }
        }
        
        calculateTotalGuest(); // This now includes total amount calculation
    });

    // Add event listeners for adult and children inputs
    document.getElementById('number_of_adults').addEventListener('input', calculateTotalGuest);
    document.getElementById('number_of_children').addEventListener('input', calculateTotalGuest);

    // Function to update proceed button state
    function updateProceedButton() {
        const selectedAccommodation = document.querySelector(".select-accommodation.selected");
        proceedButton.disabled = !selectedAccommodation || selectedAccommodation.classList.contains('unavailable');
    }

    // Fixed accommodation card click handlers with total amount calculation
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

        // Remove selected class from all cards
        document.querySelectorAll('.select-accommodation').forEach(c => c.classList.remove("selected"));
        
        // Add selected class to clicked card
        card.classList.add("selected");
        
        // Validate quantity for newly selected accommodation
        validateCurrentQuantity();
        
        updateProceedButton();
        calculateTotalGuest(); // This now includes total amount calculation
        updateSelectedAccommodation();
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
        const quantity = parseInt(document.getElementById('quantity').value) || 0;
        const adults = parseInt(document.getElementById('number_of_adults').value) || 0;
        const children = parseInt(document.getElementById('number_of_children').value) || 0;
        
        if (quantity <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Quantity',
                text: 'Please enter a quantity greater than 0',
                confirmButtonColor: '#198754'
            });
            return;
        }

        if (adults <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Number of Adults',
                text: 'Please enter the number of adults (must be greater than 0)',
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
        
        // Hide reservation modal and show payment breakdown
        reservationModal.hide();
        
        // Get the calculated total amount
        const totalAmount = calculateAndUpdateTotalAmount();
        
        // Compute payment details for display
        const selectedAccommodation = document.querySelector('.select-accommodation.selected');
        const roomRate = parseFloat(selectedAccommodation.getAttribute('data-price')) || 0;
        
        // Calculate number of nights
        const checkInDate = new Date(document.getElementById('reservation_date').value);
        const checkOutDate = new Date(document.getElementById('check_out_date').value);
        const numberOfNights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
        
        // Update payment breakdown modal
        document.getElementById('roomRate').textContent = `₱${roomRate.toFixed(2)}`;
        document.getElementById('numberOfRooms').textContent = quantity;
        document.getElementById('numberOfNights').textContent = numberOfNights;
        document.getElementById('totalAmountDisplay').textContent = `₱${totalAmount.toFixed(2)}`;
        
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
        
        if (selectedAccommodation.classList.contains('unavailable')) {
            e.preventDefault();
            Swal.fire({
                title: "Selected room is unavailable",
                text: "Please select an available room.",
                icon: "error",
                confirmButtonColor: '#198754'
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
        
        // Ensure total amount is calculated before submission
        calculateAndUpdateTotalAmount();
        
        updateSelectedAccommodation();
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
            document.querySelectorAll(".select-accommodation").forEach(card => {
                card.classList.remove("selected");
            });
            
            roomCard.classList.add("selected");
            roomCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            updateProceedButton();
            updateSelectedAccommodation();
        }
    }

    // Fetch available quantities if both dates are set
    if (checkIn && checkOut) {
        fetchAvailableQuantities();
        // Calculate total amount after fetching quantities
        setTimeout(() => {
            calculateAndUpdateTotalAmount();
        }, 1000);
    }

    // Initial setup
    updateProceedButton();
    calculateTotalGuest(); // This now includes total amount calculation

    // Enhanced quantity input restrictions
    quantityInput.addEventListener('keydown', function(e) {
        // Allow: backspace, delete, tab, escape, enter
        if ([46, 8, 9, 27, 13].indexOf(e.keyCode) !== -1 ||
            // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
            (e.keyCode === 65 && e.ctrlKey === true) ||
            (e.keyCode === 67 && e.ctrlKey === true) ||
            (e.keyCode === 86 && e.ctrlKey === true) ||
            (e.keyCode === 88 && e.ctrlKey === true)) {
            return;
        }
        // Ensure that it's a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    // Prevent pasting non-numeric values
    quantityInput.addEventListener('paste', function(e) {
        setTimeout(() => {
            let value = this.value.replace(/[^0-9]/g, '');
            if (value !== this.value) {
                this.value = value;
                calculateTotalGuest(); // This now includes total amount calculation
            }
        }, 1);
    });

    // Auto-correct quantity on blur
    quantityInput.addEventListener('blur', function() {
        const selectedAccommodation = document.querySelector('.select-accommodation.selected');
        const currentQuantity = parseInt(this.value) || 0;
        
        if (selectedAccommodation && currentQuantity > 0) {
            const availableQuantity = parseInt(selectedAccommodation.getAttribute('data-room-quantity')) || 0;
            
            if (currentQuantity > availableQuantity) {
                this.value = Math.max(1, availableQuantity);
                calculateTotalGuest(); // This now includes total amount calculation
            }
        }
    });
});
</script>
</body>
</html>