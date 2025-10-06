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
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        margin: 10px 0;
        font-weight: bold;
        text-align: center;
        font-size: 1.1rem;
    }
    
    .room-quantity-badge {
        background-color: #0B5D3B;
        color: white;
        border-radius: 10px;
        padding: 2px 8px;
        font-size: 0.8rem;
        margin-left: 5px;
    }
</style>

<body class="bg-light font-paragraph">
    <x-loading-screen />
    <div class="container mt-5 px-3">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="text-center fw-bold" style="color: #e9ffcc; font-size: 2.5rem; margin: 0 auto;">RESERVATION PAYMENT</h1>
        </div>

        <div class="bg-white p-3 shadow rounded-1 mx-auto d-flex flex-column flex-md-row g-0 mt-4" style="width: 90%;">
            <div class="w-100 w-md-50 bg-white p-3 rounded text-dark border">
                <h5 class="text-center text-md-center fw-bold text-success">Payment Details</h5>
                <hr class="border-success my-2">
                    <div class="d-flex flex-column gap-2">
                        <div class="duration-display">
                            <p id="duration-text">Stay Duration</p>
                        </div>

                        @php
                            // Calculate stay duration from check-in and check-out dates
                            $checkInDate = new DateTime($reservationDetails['reservation_check_in_date'] ?? '');
                            $checkOutDate = new DateTime($reservationDetails['reservation_check_out_date'] ?? '');
                            $stayDuration = $checkInDate && $checkOutDate ? $checkOutDate->diff($checkInDate)->days : 1;
                            if ($stayDuration < 1) $stayDuration = 1;
                            
                            // Check if it's a one-day stay (same check-in and check-out date)
                            $isOneDayStay = $reservationDetails['reservation_check_in_date'] === $reservationDetails['reservation_check_out_date'];
                            
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

                        <div class="d-flex justify-content-between">
                            <span class="fst-italic">Room</span>
                            <div class="text-end" id="accommodation-list">
                                @foreach ($accomodations as $accomodation)
                                    @php
                                        $quantity = $individualQuantities[$accomodation->accomodation_id] ?? 1;
                                        $pricePerRoom = floatval($accomodation->accomodation_price) ?? 0;
                                        $roomTotalPrice = $pricePerRoom * $quantity * $stayDuration;
                                    @endphp
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>
                                            {{ $accomodation->accomodation_name }}
                                            <span class="room-quantity-badge">{{ $quantity }}x</span>
                                        </span>
                                        <span class="fw-bold">₱{{ number_format($roomTotalPrice, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        {{-- Only show entrance fee for one-day stays --}}
                        @if($isOneDayStay && $totalEntranceFee > 0)
                        <div class="d-flex justify-content-between">
                            <span class="fst-italic">Entrance Fee</span>
                            <input type="text" class="form-control text-end bg-secondary-subtle border-0 w-75" value="₱{{ number_format($totalEntranceFee, 2) }}" readonly>
                        </div>
                        @endif

                        @if (isset($reservationDetails->package_id))
                            @php
                                $selectedPackage = $packages->where('id', $reservationDetails->package_id)->first();
                                $packagePrice = $selectedPackage->package_price ?? 0;
                                $packageEntranceFee = ($selectedPackage->package_max_guests ?? 0) * 100;
                                $totalPackageCost = ($packagePrice * 1) + $packageEntranceFee;
                            @endphp
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fst-italic">Package Price (1 day)</span>
                                <input type="text" class="form-control text-end bg-secondary-subtle border-0" 
                                       value="₱ {{ number_format($packagePrice, 2) }}" readonly>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fst-italic">Package Entrance Fee</span>
                                <input type="text" class="form-control text-end bg-secondary-subtle border-0" value="₱ {{ number_format($packageEntranceFee, 2) }}" readonly>
                            </div>
                        @endif

                        <hr class="border-success my-2">
                        
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
                            
                            // Calculate downpayment (50% of total amount)
                            $downpayment = $amount * 0.20;
                            
                            // Calculate total quantity (sum of all individual quantities)
                            $totalQuantity = array_sum($individualQuantities);
                        @endphp

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fst-italic">Total Rooms: {{ $totalQuantity }}</span>
                            <span class="fw-bold text-success">{{ $totalQuantity }} room(s)</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fst-italic">Required 20% Downpayment</span>
                            <input type="text" id="downpayment-display" class="form-control text-end bg-secondary-subtle border-0" 
                                   style="max-width: 150px;" value="₱{{ number_format($downpayment, 2) }}" readonly>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-success">Total Amount</h5>
                            <input type="text" class="form-control text-center bg-secondary-subtle border-0 fw-bold fs-5" 
                                   id="amount-display" style="max-width: 150px;" 
                                   value="₱{{ number_format($amount, 2) }}" 
                                   readonly>
                        </div>

                        <!-- PayMongo Form -->
                        <form action="{{ route('paymongo.checkout') }}" method="POST" class="mt-3">
                            @csrf
                            <h6 class="fw-bold text-success">Choose Payment Option:</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_option" id="downpayment_option" value="{{ $downpayment }}" checked>
                                <label class="form-check-label" for="downpayment_option">
                                    Pay 20% Downpayment: <strong>₱{{ number_format($downpayment, 2) }}</strong>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_option" id="fullpayment_option" value="{{ $amount }}">
                                <label class="form-check-label" for="fullpayment_option">
                                    Pay Full Amount: <strong>₱{{ number_format($amount, 2) }}</strong>
                                </label>
                            </div>

                            <!-- This hidden input will hold the amount to be sent to PayMongo -->
                            <input type="hidden" name="amount" id="paymongo_amount" value="{{ $downpayment }}">
                            <input type="hidden" name="payment_status" id="payment_status" value="partial">
                            <input type="hidden" name="reservation_id" value="{{ $reservationDetails['id'] }}">

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary fw-bold">
                                    <i class="fas fa-credit-card me-2"></i>
                                    Proceed to Pay with PayMongo
                                </button>
                            </div>
                        </form>
                        <!-- End PayMongo Form -->

                    </div>
            </div>
            <div class="w-100 w-md-50 bg-light p-3 text-white">
                <h5 class="text-center text-md-center text-success">GCash QR Codes</h5>
                    <hr class="bg-light my-2">
                    
                    <!-- Payment Method Tabs -->
                    <ul class="nav nav-tabs justify-content-center mb-3" id="paymentTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="gcash1-tab" data-bs-toggle="tab" data-bs-target="#gcash1-content" type="button" role="tab" aria-controls="gcash1-content" aria-selected="true" style="color: #0B5D3B; transition: all 0.3s ease;">
                                GCash 1
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="gcash2-tab" data-bs-toggle="tab" data-bs-target="#gcash2-content" type="button" role="tab" aria-controls="gcash2-content" aria-selected="false" style="color: #0B5D3B; transition: all 0.3s ease;">
                                GCash 2
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="gcash3-tab" data-bs-toggle="tab" data-bs-target="#gcash3-content" type="button" role="tab" aria-controls="gcash3-content" aria-selected="false" style="color: #0B5D3B; transition: all 0.3s ease;">
                                GCash 3
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="paymentTabContent">
                        <!-- GCash 1 Content -->
                        <div class="tab-pane fade show active" id="gcash1-content" role="tabpanel" aria-labelledby="gcash1-tab">
                            <div class="d-flex flex-column align-items-center">
                                <input class="form-check-input d-none" type="radio" name="payment_method" id="gcash1" value="gcash" checked>
                                <div class="bg-secondary p-1 d-flex align-items-center justify-content-center rounded-2" style="width: 100%; max-width: 300px; height: auto; aspect-ratio: 1/1; background-image: url('{{ asset('images/logosheesh.png') }}'); background-size: cover; background-position: center;">
                                    <img src="{{ asset('images/qrcode.JPG') }}" alt="GCash QR Code 1" style="width: 80%; height: auto;">
                                </div>
                                <div class="text-center mt-3">
                                    <p class="fw-bold text-success mb-0">GCash Number:</p>
                                    <p class="text-dark">0912-345-6789</p>
                                    <p class="text-dark">Lelo's R. (AR***E M** A.)</p>

                                </div>
                                <div class="alert mt-3 p-2" role="alert" style="background-color: #0B5D3B; color: white; font-size: 0.9rem;">
                                    <h6 class="fw-bold">Important Payment Instructions:</h6>
                                    <ul class="mb-0 ps-3">
                                        <li>Please ensure to scan the correct QR code for payment</li>
                                        <li>Double check the amount before confirming the transaction</li>
                                        <li>Save your reference number and screenshot of payment</li>
                                        <li>Payment confirmation may take up to 24 hours</li>
                                        <li>No Refund Policy</li>
                                        <li>Required security deposit. "Follow up will be done after done the reservation"</li>
                                        <li>For assistance, contact our support team</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- GCash 2 Content -->
                        <div class="tab-pane fade" id="gcash2-content" role="tabpanel" aria-labelledby="gcash2-tab">
                            <div class="d-flex flex-column align-items-center">
                                <input class="form-check-input d-none" type="radio" name="payment_method" id="gcash" value="gcash">
                                <div class="bg-secondary p-1 d-flex align-items-center justify-content-center rounded-2" style="width: 100%; max-width: 300px; height: auto; aspect-ratio: 1/1; background-image: url('{{ asset('images/logosheesh.png') }}'); background-size: cover; background-position: center;">
                                    <img src="{{ asset('images/qrcode.JPG') }}" alt="GCash QR Code 2" style="width: 80%; height: auto;">
                                </div>
                                <div class="text-center mt-3">
                                    <p class="fw-bold text-success mb-0">GCash Number:</p>
                                    <p class="text-dark">0923-456-7890</p>
                                    <p class="text-dark">Lelo's R. (AR***E M** A.)</p>
                                </div>
                                <div class="alert mt-3 p-2" role="alert" style="background-color: #0B5D3B; color: white; font-size: 0.9rem;">
                                    <h6 class="fw-bold">Important Payment Instructions:</h6>
                                    <ul class="mb-0 ps-3">
                                        <li>Please ensure to scan the correct QR code for payment</li>
                                        <li>Double check the amount before confirming the transaction</li>
                                        <li>Save your reference number and screenshot of payment</li>
                                        <li>Payment confirmation may take up to 24 hours</li>
                                        <li>No Refund Policy</li>
                                        <li>Required security deposit. "Follow up will be done after done the reservation"</li>
                                        <li>For assistance, contact our support team</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- GCash 3 Content -->
                        <div class="tab-pane fade" id="gcash3-content" role="tabpanel" aria-labelledby="gcash3-tab">
                            <div class="d-flex flex-column align-items-center">
                                <input class="form-check-input d-none" type="radio" name="payment_method" id="gcash3" value="gcash">
                                <div class="bg-secondary p-1 d-flex align-items-center justify-content-center rounded-2" style="width: 100%; max-width: 300px; height: auto; aspect-ratio: 1/1; background-image: url('{{ asset('images/logosheesh.png') }}'); background-size: cover; background-position: center;">
                                    <img src="{{ asset('images/qrcode.JPG') }}" alt="GCash QR Code 3" style="width: 80%; height: auto;">
                                </div>
                                <div class="text-center mt-3">
                                    <p class="fw-bold text-success mb-0">GCash Number:</p>
                                    <p class="text-dark">0934-567-8901</p>
                                    <p class="text-dark">Lelo's R. (AR***E M** A.)</p>
                                </div>
                                <div class="alert mt-3 p-2" role="alert" style="background-color: #0B5D3B; color: white; font-size: 0.9rem;">
                                    <h6 class="fw-bold">Important Payment Instructions:</h6>
                                    <ul class="mb-0 ps-3">
                                        <li>Please ensure to scan the correct QR code for payment</li>
                                        <li>Double check the amount before confirming the transaction</li>
                                        <li>Save your reference number and screenshot of payment</li>
                                        <li>Payment confirmation may take up to 24 hours</li>
                                        <li>No Refund Policy</li>
                                        <li>Required security deposit. "Follow up will be done after done the reservation"</li>
                                        <li>For assistance, contact our support team</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal For the Editing the Mobile Number -->
    <div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="updateProfileModalLabel">Update Profile</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- FORM -->
            <form action="{{ route('editProfile', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted">Please complete your profile details before proceeding with payment.</p>

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $user->name ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                            value="{{ $user->email ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="mobileNo" class="form-label fw-bold">Mobile Number</label>
                        <input type="text" class="form-control" id="mobileNo" name="mobileNo"
                            value="{{ $user->mobileNo ?? '' }}" placeholder="09xxxxxxxxx" required
                            maxlength="11"
                            onkeypress="return (event.charCode >= 48 && event.charCode <= 57) && event.charCode != 45;"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 11);"
                            pattern="[0-9]{11}" title="Please enter a valid 11-digit mobile number (numbers only)">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label fw-bold">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ $user->address ?? '' }}" placeholder="Enter your full address" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100 fw-bold">Save and Continue</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
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
        
        // Ensure GCash is selected by default
        document.getElementById('gcash1').checked = true;

        // Calculate proper stay duration
        const checkInDate = "{{ $reservationDetails['reservation_check_in_date'] ?? '' }}";
        const checkOutDate = "{{ $reservationDetails['reservation_check_out_date'] ?? '' }}";
        const isOneDayStay = "{{ $isOneDayStay ? 'true' : 'false' }}" === 'true';
        
        let stayDuration = 1;
        if(checkInDate && checkOutDate) {
            const start = new Date(checkInDate);
            const end = new Date(checkOutDate);
            stayDuration = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
            if (stayDuration < 1) stayDuration = 1;
        }

        // Update duration display and hidden input
        const durationText = isOneDayStay ? 
            `Day Tour (${stayDuration} day)` : 
            `Stay Duration: ${stayDuration} ${stayDuration > 1 ? 'nights' : 'night'}`;
        
        document.getElementById('duration-text').textContent = durationText;

        // Auto-open modal if mobileNo is empty
        const userMobile = "{{ $user->mobileNo ?? '' }}";
        const userAddress = "{{ $user->address ?? '' }}";
        if (!userMobile || userMobile.trim() === '' || !userAddress || userAddress.trim() === '') {
            const updateProfileModal = new bootstrap.Modal(document.getElementById('updateProfileModal'));
            updateProfileModal.show();
        }

    });
    </script>
</body>
</html>