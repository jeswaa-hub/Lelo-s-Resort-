<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo new.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Add Bootstrap JS from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<style>
    .submit-button {
        background-color: #0B5D3B; 
        color: white;
        font-weight: bold;
        font-size: 0.8rem;
        padding: 5px 10px;
        border: none;
        border-radius: 50px; 
        display: flex;
        align-items: center;
        justify-content: center;
        width: 150px; 
        cursor: pointer;
        margin: 0 auto;
    }

    .submit-button .arrow {
        background-color: white;
        color: #0B5D3B;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 5px;
        font-size: .7rem;
    }
    
    .custom-modal {
        background-color: #6B7546;
        border-radius: 10px;
        padding: 20px;
    }
    
    .modal-header h5 {
        color: #4A4A4A;
        font-size: 20px;
        font-weight: bolder;
        text-align: center;
        width: 100%;
    }
    
    .rating-section {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding-top:15px;
    }
    
    .stars {
        font-size: 40px;
        display: flex;
        gap: 60px;
        padding-left: 70px;
    }
    
    .stars i {
        font-size: 40px;
        cursor: pointer;
        color: #444;
    }
    
    .stars i.active {
        color: #FFD700;
    }
    
    .feedback-label {
        margin-top: 15px;
    }
    
    .feedback-text {
        background-color: #819160;
        border: none;
        border-radius: 5px;
        padding: 8px;
        color: #fff;
        font-size: 1rem;
    }
    
    .submit-btn {
        width: 100%;
        background-color: #4A5E30;
        color: white;
        font-size: 1.2rem;
        font-weight: bold;
        padding: 12px;
        border-radius: 15px;
        border: 2px solid #364220;
        text-transform: uppercase;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        transition: 0.3s ease-in-out;
    }
    
    .submit-btn:hover {
        background-color: #3A4F25;
        box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.5);
        cursor: pointer;
    }
    
    .open-modal-btn {
        background-color: #718355;
        font-size: 1.5rem;
        font-weight: bold;
        padding: 10px 20px;
    }
    
    .feedback-text {
        background-color: #819160;
        color: white;
        height: 80px;
        border-radius: 10px;
        border: none;
        padding: 8px;
        font-size: 1rem;
        resize: none;
    }
    
    /* New integrated styles */
    body {
        background: url('{{ asset('images/newbg.png') }}') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }
    
    .payment-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 20px;
    }
    
    .payment-header {
        color: #e9ffcc;
        font-size: 2.5rem;
        text-align: center;
        margin-bottom: 20px;
    }
    
    .payment-method-section {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .payment-details-section {
        background-color: white;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    
    .form-control {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
    }
    
    .form-control:focus {
        background-color: #e9ffcc;
        border-color: #0B5D3B;
    }
    
    .qr-code-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .total-amount {
        font-size: 1.2rem;
        font-weight: bold;
        color: #0B5D3B;
    }
    
    .duration-display {
        background-color:rgb(165, 168, 171);
        padding: 10px;
        border-radius: 5px;
        margin: 10px 0;
        font-weight: bold;
        text-align: center;
        font-size: 1.1rem;
        color: #0B5D3B;
    }
    
    .room-quantity-badge {
        background-color: #0B5D3B;
        color: white;
        border-radius: 5px;
        padding: 2px 8px;
        font-size: 0.8rem;
        margin-left: 5px;
    }




    .ticket-container {
    background: linear-gradient(180deg, #f2f4f7 0%, #e2e6ea 100%);
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 350px;
    position: relative;
    font-family: Arial, sans-serif;
}

/* Semi-circle ticket cutouts */
.ticket-container::before,
.ticket-container::after {
    content: "";
    position: absolute;
    width: 25px;
    height: 25px;
    background-color: #fff;
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
}

.ticket-container::before {
    left: -12px;
}

.ticket-container::after {
    right: -12px;
}

/* Header Section */
.ticket-header {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 12px;
    text-align: left;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}

/* Body Section */
.ticket-body {
    margin-top: 15px;
    padding-top: 10px;
    border-top: 1px dashed #ccc;
    font-size: 14px;
}

/* Footer Section */
.ticket-footer {
    margin-top: 15px;
    padding-top: 10px;
    border-top: 1px dashed #ccc;
    text-align: left;
}

</style>

<body class="bg-light font-paragraph">
    <x-loading-screen />
    <!-- Toast Container for Notifications -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
        <!-- Toasts will be appended here by JavaScript -->
    </div>
    <div class="container mt-5 px-3">
        <div class="d-flex justify-content-between">
            <h1 class="text-center fw-bold" style="color: #e9ffcc; font-size: 3rem; margin: 0 auto;">RESERVATION PAYMENT</h1>
        </div>

        <div class="payment-container mx-auto" style="width: 90%;">
            <div class="row g-0">
                <div class="col-12">
                    <h5 class="text-center text-md-start fw-bold text-uppercase text-success" style="font-size: 2.5rem;">Payment Details</h5>
                    <hr class="border-success my-3">
                        <!-- LEFT & RIGHT CONTAINER -->
                        <div class="row g-3">
                            <!-- LEFT SIDE -->
                            <div class="col-md-8">
                                <div class="payment-details-section">

                                    @php
                                        // Calculate stay duration from check-in and check-out dates
                                        $checkInDate = new DateTime($reservationDetails['reservation_check_in_date'] ?? '');
                                        $checkOutDate = new DateTime($reservationDetails['reservation_check_out_date'] ?? '');
                                        $stayDuration = $checkInDate && $checkOutDate ? $checkOutDate->diff($checkInDate)->days : 1;
                                        if ($stayDuration < 1) $stayDuration = 1;
 
                                        // Check if it's a one-day stay (same check-in and check-out date)
                                        $isOneDayStay = $reservationDetails['reservation_check_in_date'] === $reservationDetails['reservation_check_out_date'];
 
                                        $durationText = $isOneDayStay
                                            ? "Day Tour ({$stayDuration} day)"
                                            : "Stay Duration: {$stayDuration} " . ($stayDuration > 1 ? 'nights' : 'night');
                                    @endphp

                                    <p class="fw-bold mb-2 fs- .5">Total Payment For Duration of:</p>
                                    <div class="duration-display mb-3">
                                        <p id="duration-text" class="mb-0">
                                            {{ $durationText }}
                                        </p>
                                    </div>
                                    @php
                                        // Get individual room quantities
                                        $rawRoomQuantities = $reservationDetails['room_quantities'] ?? $reservationDetails['quantity'] ?? '{}';
                                        $individualQuantities = [];

                                        if (is_string($rawRoomQuantities) && is_array(json_decode($rawRoomQuantities, true))) {
                                            $individualQuantities = json_decode($rawRoomQuantities, true);
                                        } else {
                                            // Fallback for old format - distribute total quantity among accommodations
                                            $totalQuantity = (int) $rawRoomQuantities > 0 ? (int) $rawRoomQuantities : 1;
                                            $accommodationIds = json_decode($reservationDetails['accomodation_id'] ?? '[]', true);
                                            if (!empty($accommodationIds)) {
                                                $quantityPerRoom = floor($totalQuantity / count($accommodationIds));
                                                $remainder = $totalQuantity % count($accommodationIds);
                                                foreach ($accommodationIds as $index => $accomId) {
                                                    $individualQuantities[$accomId] = $quantityPerRoom + ($index < $remainder ? 1 : 0);
                                                }
                                            }
                                        }
                                    @endphp

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="fst-italic">Rooms Fee:</span>
                                    </div>


                                    <div id="accommodation-list">
                                        @foreach ($accomodations as $accomodation)
                                            @php
                                                $quantity = $individualQuantities[$accomodation->accomodation_id] ?? 1;
                                                $pricePerRoom = floatval($accomodation->accomodation_price) ?? 0;
                                                $roomTotalPrice = $pricePerRoom * $quantity * $stayDuration;
                                            @endphp
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span>
                                                    <span class="room-quantity-badge">{{ $quantity }}x</span>
                                                    <span class="fw-bold">{{ $accomodation->accomodation_name }}</span>
                                                </span>
                                                <span class="fw-bold text-success">₱{{ number_format($roomTotalPrice, 2) }}</span>
                                            </div>
                                        @endforeach
                                    </div>


                                    {{-- Only show entrance fee for one-day stays --}}
                                    @if($isOneDayStay && $totalEntranceFee > 0)
                                    <div class="d-flex justify-content-between mt-3">
                                        <span class="fst-italic">Entrance Fee</span>
                                        <input type="text" class="form-control text-end bg-secondary-subtle border-0 w-50" value="₱{{ number_format($totalEntranceFee, 2) }}" readonly>
                                    </div>
                                    @endif

                                    @if (isset($reservationDetails->package_id))
                                        @php
                                            $selectedPackage = $packages->where('id', $reservationDetails->package_id)->first();
                                            $packagePrice = $selectedPackage->package_price ?? 0;
                                            $packageEntranceFee = ($selectedPackage->package_max_guests ?? 0) * 100;
                                            $totalPackageCost = ($packagePrice * 1) + $packageEntranceFee;
                                        @endphp
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <span class="fst-italic">Package Price (1 day)</span>
                                            <input type="text" class="form-control text-end bg-secondary-subtle border-0 w-50" 
                                                   value="₱ {{ number_format($packagePrice, 2) }}" readonly>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <span class="fst-italic">Package Entrance Fee</span>
                                            <input type="text" class="form-control text-end bg-secondary-subtle border-0 w-50" value="₱ {{ number_format($packageEntranceFee, 2) }}" readonly>
                                        </div>
                                    @endif
                                    <hr class="border-success my-3">

                                    @php
                                        // Calculate total room price with correct duration and individual quantities
                                        $totalPrice = 0;
                                        foreach ($accomodations as $accomodation) {
                                            $quantity = $individualQuantities[$accomodation->accomodation_id] ?? 1;
                                            $pricePerRoom = floatval($accomodation->accomodation_price);
                                            $totalPrice += $pricePerRoom * $quantity * $stayDuration;
                                        }
                                        
                                        // Only add entrance fee for one-day stays
                                        $entranceFeeToAdd = $isOneDayStay ? ($totalEntranceFee ?? 0) : 0;
                                        
                                        // Calculate final amount
                                        $amount = $totalPrice + $entranceFeeToAdd;
                                        
                                        // Calculate downpayment (20% of total amount)
                                        $downpayment = $amount * 0.20;
                                        
                                        // Calculate total quantity (sum of all individual quantities)
                                        $totalQuantity = array_sum($individualQuantities);
                                    @endphp

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="fw-bold text-success">Total Amount To Pay:</h5>
                                        <input type="text" class="form-control text-success text-center bg-secondary-subtle border-0 fw-bold fs-6" 
                                               id="amount-display" style="max-width: 150px;" 
                                               value="₱{{ number_format($amount, 2) }}" 
                                               readonly>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-2 mt-2">
                                        <span class="fst-italic">Required 20% Downpayment</span>
                                        <input type="text" id="downpayment-display" class="form-control text-end bg-secondary-subtle border-0" 
                                               style="max-width: 150px;" value="₱{{ number_format($downpayment, 2) }}" readonly>
                                    </div>

                                    <hr class="border-success my-3">
                                </div>
                            </div>


                        <!-- RIGHT SIDE -->
                        <div class="col-md-4">
                            <div class="ticket-container text-dark mx-auto position-relative">
                                <!-- Question Mark Icon -->
                                <button type="button" class="btn btn-sm btn-success position-absolute top-0 end-0 m-2 rounded-circle shadow-sm d-flex align-items-center justify-content-center" 
                                        data-bs-toggle="modal" data-bs-target="#ticketInfoModal" 
                                        style="width: 32px; height: 32px; z-index: 10;">
                                    <i class="fa-solid fa-circle-question text-white" style="font-size: 1.2rem;"></i>
                                </button>

                                <div class="ticket-header">
                                    <p class="fw-bold mb-0">{{ $user->name ?? 'Guest' }}</p>
                                    <p class="text-muted small mb-0">{{ $user->email ?? 'N/A' }}</p>
                                    <p class="fw-semibold mt-1">{{ optional($reservationDetails['created_at'] ?? null)->format('m/d') }}</p>
                                </div>

                                <div class="ticket-body">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="fw-semibold">Receiver</span>
                                        <span>Lelo's Resort</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-semibold">Availed</span>
                                        <span>Resort Booking</span>
                                    </div>
                                </div>
                            </div>
                            <!-- PayMongo Form -->
                            <form action="{{ route('paymongo.checkout') }}" method="POST" class="mt-4">
                                @csrf
                                <p class="fw-bold text-success mb-2">Choose Payment Option:</p>
                                <div class="list-group">
                                    <!-- Downpayment Option -->
                                    <label for="downpayment_option" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center rounded-3 mb-2 shadow-sm border-2 p-2 payment-option">
                                        <div>
                                            <p class="mb-0 fw-bold">Pay 20% Downpayment</p>
                                            <small class="text-muted">Secure your booking now.</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <strong class="me-3 text-success">₱{{ number_format($downpayment, 2) }}</strong>
                                            <input class="form-check-input fs-5 m-0" type="radio" name="payment_option" id="downpayment_option" value="{{ $downpayment }}" checked>
                                        </div>
                                    </label>
                                    <!-- Full Payment Option -->
                                    <label for="fullpayment_option" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center rounded-3 shadow-sm border-2 p-2 payment-option">
                                        <div>
                                            <p class="mb-0 fw-bold">Pay Full Amount</p>
                                            <small class="text-muted">Settle everything in one go.</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <strong class="me-3 text-success">₱{{ number_format($amount, 2) }}</strong>
                                            <input class="form-check-input fs-5 m-0" type="radio" name="payment_option" id="fullpayment_option" value="{{ $amount }}">
                                        </div>
                                    </label>
                                </div>
 
                                <!-- This hidden input will hold the amount to be sent to PayMongo -->
                                <input type="hidden" name="amount" id="paymongo_amount" value="{{ $downpayment }}">
                                <input type="hidden" name="payment_status" id="payment_status" value="partial">
                                <input type="hidden" name="reservation_id" value="{{ $reservationDetails['id'] }}">
 
                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-success fw-bold py-2">
                                        <i class="fas fa-credit-card me-2"></i>
                                        Proceed to Pay with PayMongo
                                    </button>
                                </div>
                            </form>

                        <!-- End PayMongo Form -->
                            </div>
                        </div>
                    <!-- Ticket Info Modal -->
                    <div class="modal fade" id="ticketInfoModal" tabindex="-1" aria-labelledby="ticketInfoModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title text-white fw-bold" id="ticketInfoModalLabel">Reservation Payment Details</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted small mt-3">Please review the following information before completing your payment.</p>
                                    <ul class="mb-0 ps-3">
                                        <li>Ensure the payment amount is correct before confirming the transaction.</li>
                                        <li>Payment verification may take up to 24 hours to process.</li>
                                        <li>All payments are final — strictly no refund policy.</li>
                                        <li>A security deposit is required; follow-up will be conducted after reservation completion.</li>
                                        <li>For any inquiries or assistance, kindly reach out to our support team.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                        <hr class="border-success my-3">

    <!-- Modal For the Editing the Mobile Number -->
    <!-- Update Profile Modal – hidden by default, triggered via JS -->
    <div class="modal fade" id="updateProfileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold text-white" id="updateProfileModalLabel">Update Profile</h5>
                </div>

                <!-- FORM -->
                <form action="{{ route('profile.update') }}" method="POST" id="updateProfileForm">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted">Please complete your profile details before proceeding with payment.</p>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Full Name</label>
                            <input type="text" class="form-control-plaintext" id="name" name="name"
                                value="{{ $user->name ?? '' }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control-plaintext" id="email" name="email" 
                                value="{{ $user->email ?? '' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="mobileNo" class="form-label fw-bold">Mobile Number</label>
                            <input type="text" class="form-control" id="mobileNo" name="mobileNo"
                                value="{{ $user->mobileNo ?? '' }}" placeholder="09xxxxxxxxx" required
                                maxlength="11"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 11);"
                                pattern="[0-9]{11}" title="Please enter a valid 11-digit mobile number (numbers only)">
                            <div class="invalid-feedback" id="mobileNo-error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label fw-bold">Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ $user->address ?? '' }}" placeholder="Enter your full address" required>
                            <div class="invalid-feedback" id="address-error"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="saveProfileButton" class="btn btn-success w-100 fw-bold">Save and Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
    // Helper function to clear validation errors
    function clearErrors() {
        document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    }

    document.addEventListener("DOMContentLoaded", function () {
        const paymentOptions = document.querySelectorAll('input[name="payment_option"]');
        const paymongoAmountInput = document.getElementById('paymongo_amount');
        const paymentStatusInput = document.getElementById('payment_status');

        paymentOptions.forEach(option => {
            option.addEventListener('change', function() {
                paymongoAmountInput.value = this.value;
                if (this.id === 'downpayment_option') {
                    paymentStatusInput.value = 'partial';
                } else {
                    paymentStatusInput.value = 'paid';
                }
            });
        });

        // Star rating functionality
        document.querySelectorAll(".stars").forEach(starContainer => {
            for (let i = 1; i <= 5; i++) {
                let star = document.createElement("i");
                star.classList.add("fas", "fa-star");
                star.dataset.value = i;
                star.addEventListener("click", function () {
                    let stars = this.parentElement.querySelectorAll("i");
                    stars.forEach(s => s.classList.remove("active"));
                    for (let j = 0; j < i; j++) {
                        stars[j].classList.add("active");
                    }
                });
                starContainer.appendChild(star);
            }
        });
        
        const updateProfileModalEl = document.getElementById('updateProfileModal');
        const updateProfileModal = new bootstrap.Modal(updateProfileModalEl);
        const updateProfileForm = document.getElementById('updateProfileForm');
        const saveProfileButton = document.getElementById('saveProfileButton');
        
        // Only show the modal if the user's mobile number or address is missing.
        @if(empty($user->mobileNo) || empty($user->address))
            updateProfileModal.show();
        @endif
        
        // Handle form submission with AJAX
        updateProfileForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default page reload
            clearErrors();

            const formData = new FormData(this);
            const originalButtonHTML = saveProfileButton.innerHTML;
            saveProfileButton.disabled = true;
            saveProfileButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...`;

            fetch("{{ route('profile.update') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    updateProfileModal.hide(); // Close modal on success
                } else {
                    // This block might not be hit if validation fails, as Laravel returns 422
                    showToast(data.message || 'An error occurred.', 'danger');
                }
            })
            .catch(error => {
                if (error.response && error.response.status === 422) {
                    // Handle Laravel validation errors
                    const errors = error.response.data.errors;
                    for (const field in errors) {
                        const input = document.getElementById(field);
                        const errorDiv = document.getElementById(`${field}-error`);
                        if (input) input.classList.add('is-invalid');
                        if (errorDiv) errorDiv.textContent = errors[field][0];
                    }
                    showToast('Please fix the errors in the form.', 'danger');
                } else {
                    console.error('Error:', error);
                    showToast('An unexpected error occurred. Please try again.', 'danger');
                }
            })
            .finally(() => {
                // Re-enable button
                saveProfileButton.disabled = false;
                saveProfileButton.innerHTML = originalButtonHTML;
            });
        });

        /**
         * Shows a toast notification.
         * @param {string} message - The message to display.
         * @param {string} type - The background color type (e.g., 'danger', 'success').
         */
        function showToast(message, type = 'danger') {
            const toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) return;

            const toastId = 'toast-' + Date.now();
            const toastHTML = `
                <div id="${toastId}" class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body fw-bold">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            toastContainer.insertAdjacentHTML('beforeend', toastHTML);

            const newToast = new bootstrap.Toast(document.getElementById(toastId));
            newToast.show();
        }

        // Listen for attempts to close the mandatory modal
        document.getElementById('updateProfileModal').addEventListener('hidePrevented.bs.modal', function () {
            showToast('Please complete your profile to continue.');
        });
    });
    </script>
</body>
</html>