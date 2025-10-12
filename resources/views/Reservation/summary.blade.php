<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Summary</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('images/logo new.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
     <script>
// Clean back button prevention
(function() {
    'use strict';
    
    // Remove any existing hash from URL
    if (window.location.hash) {
        history.replaceState(null, null, window.location.pathname + window.location.search);
    }
    
    // Set initial clean state
    history.replaceState(null, null, window.location.href.split('#')[0]);
    
    // Prevent back navigation
    window.onpopstate = function() {
        // Replace state without hash
        history.replaceState(null, null, window.location.pathname + window.location.search);
        
        // Create a pointing arrow to the home icon
        createPointerArrow();
        
        Swal.fire({
            icon: 'info',
            title: 'Click Here to Go Home →',
            text: 'Follow the arrow to the home icon in the top left corner.',
            confirmButtonText: 'I See It!',
            confirmButtonColor: '#198754',
            willClose: () => {
                removePointerArrow();
            }
        });
    };
    
    function createPointerArrow() {
        const homeIcon = document.querySelector('a[href="{{ route("homepage") }}"]');
        if (homeIcon) {
            // Create arrow element
            const arrow = document.createElement('div');
            arrow.innerHTML = '⬅️';
            arrow.style.position = 'fixed';
            arrow.style.top = '60px';
            arrow.style.left = '180px';
            arrow.style.fontSize = '40px';
            arrow.style.zIndex = '10000';
            arrow.style.animation = 'bounce 1s infinite';
            arrow.id = 'home-icon-pointer';
            
            // Add bounce animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes bounce {
                    0%, 100% { transform: translateX(0); }
                    50% { transform: translateX(-10px); }
                }
            `;
            document.head.appendChild(style);
            
            document.body.appendChild(arrow);
            
            // Also highlight the home icon
            homeIcon.style.animation = 'pulse 1s infinite';
            homeIcon.style.borderRadius = '50%';
        }
    }
    
    function removePointerArrow() {
        const arrow = document.getElementById('home-icon-pointer');
        if (arrow) {
            arrow.remove();
        }
        const homeIcon = document.querySelector('a[href="{{ route("homepage") }}"]');
        if (homeIcon) {
            homeIcon.style.animation = '';
        }
    }
    
})();
</script>
</head>
<body class="bg-light font-paragraph" style="background: url('{{ asset('images/newbg.png') }}') no-repeat center center fixed; background-size: cover;">
    <x-loading-screen />
    @include('Alert.loginSuccessUser')
    <div class="container mt-5 px-3">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('homepage') }}" class="text-decoration-none">
                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fa-solid fa-home text-white fs-4"></i>
                </div>
            </a>
            <h1 class="me-auto ms-3 font-paragraph fw-bold" style="color: #e9ffcc; font-size: 2.5rem;">RESERVATION SUMMARY</h1>
            <a href="#" class="d-none d-md-block">
                <img src="{{ asset('images/logo new.png') }}" alt="Logo" style="width: 90px; height: 90px;" class="rounded-circle">
            </a>
        </div>
    </div>

    <div class="container mt-4 p-4 bg-white rounded shadow-lg">
        <div class="row g-3">
            <!-- Left 50% -->
            <div class="col-12 col-md-6">
                <h2 class="fw-bold text-uppercase text-success mb-3" style="font-size: 2rem;">Important Information</h2>
                <hr class="border-success border-2 mb-3">
                
                @if(!empty($reservationDetails))
                    @if(!empty($reservationDetails->reservation_id))
                    <div class="row mb-3">
                        <div class="col-12 fw-bold text-success text-break fs-5">RESERVATION ID: {{ strtoupper($reservationDetails->reservation_id) }}</div>
                    </div>
                    @endif
                    
                    @if(!empty($reservationDetails->name) || !empty($reservationDetails->email))
                    <div class="row mb-2 gx-2">
                        <div class="col-6">
                            <div class="fw-bold text-success text-break" style="font-size: 0.875rem;">Name:</div>
                            <div class="text-break fw-bold text-lowercase">{{ strtoupper($reservationDetails->name ?? '') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-success text-break" style="font-size: 0.875rem;">Email:</div>
                            <div class="text-break fw-bold">{{ $reservationDetails->email ?? '' }}</div>
                        </div>
                    </div>
                    @endif

                    @if(!empty($reservationDetails->mobileNo))
                    <div class="row mb-2">
                        <div class="fw-bold text-success text-break" style="font-size: 0.875rem;">Mobile No:</div>
                        <div class="col-8 fw-bold text-break">{{ $reservationDetails->mobileNo }}</div>
                    </div>
                    @endif
                    
                    @if((!empty($reservationDetails->package_room_type) && !empty($roomNames)) || (!empty($accommodations)))
                    <div class="row mb-2 gx-2">
                        <div class="col-6">
                            <div class="fw-bold text-success text-break" style="font-size: 0.875rem;">Room:</div>
                            <div class="text-break fw-bold">
                                @if(!empty($reservationDetails->package_room_type))
                                    {{ implode(', ', $roomNames) }}
                                @else
                                    {{ implode(', ', $accommodations) }}
                                @endif
                            </div>
                        </div>
                        @if(!empty($reservationDetails->total_guest) || !empty($reservationDetails->package_max_guests))
                        <div class="col-6">
                            <div class="fw-bold text-success text-break" style="font-size: 0.875rem;">Guests:</div>
                            <div class="text-break fw-bold">{{ $reservationDetails->total_guest ?? $reservationDetails->package_max_guests }}</div>
                        </div>
                        @endif
                    </div>
                    @endif

                        @if(!empty($reservationDetails->package_activities) || !empty($activities))
                        <div class="row mb-2 gx-2">
                            <div class="col-6">
                                <div class="fw-bold text-success text-break" style="font-size: 0.875rem;">Activities:</div>
                                <div class="text-break fw-bold">{{ $reservationDetails->package_activities ?? implode(', ', $activities) }}</div>
                            </div>
                            <div class="col-6">
                                <div class="fw-bold text-success text-break" style="font-size: 0.875rem;">Date:</div>
                                <div class="text-break fw-bold">{{ \Carbon\Carbon::parse($reservationDetails->reservation_check_in_date)->format('l, F jS, Y') }}</div>
                            </div>
                        </div>
                        @endif

                    @if(!empty($reservationDetails->reservation_check_in) || !empty($reservationDetails->reservation_check_out))
                    <div class="row mb-2 gx-2">
                        <div class="col-6">
                            <div class="fw-bold text-success text-break" style="font-size: 0.875rem;">Check-in:</div>
                            <div class="text-break fw-bold">
                                {{ \Carbon\Carbon::parse($reservationDetails->reservation_check_in_date ?? '')->format('F j, Y') }}
                                <br>
                                <span class="text-muted">{{ date('h:i A', strtotime($reservationDetails->reservation_check_in ?? '')) }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-success text-break" style="font-size: 0.875rem;">Check-out:</div>
                            <div class="text-break fw-bold">
                                {{ \Carbon\Carbon::parse($reservationDetails->reservation_check_out_date ?? '')->format('F j, Y') }}
                                <br>
                                <span class="text-muted">{{ date('h:i A', strtotime($reservationDetails->reservation_check_out ?? '')) }}</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(!empty($reservationDetails->special_request))
                    <div class="row mb-2">
                        <div class="col-4 fw-bold text-success text-break">Special Request:</div>
                        <div class="col-8 text-break">{{ $reservationDetails->special_request }}</div>
                    </div>
                    @endif

                    @if(!empty($reservationDetails->payment_method))
                    <div class="row mb-2">
                        <div class="col-4 fw-bold text-success text-break">Payment Method:</div>
                        <div class="col-8 text-break">{{ $reservationDetails->payment_method }}</div>
                    </div>
                    @endif

                    <!-- @if(isset($reservationDetails->amount))
                    <div class="row mb-2">
                        <div class="col-4 fw-bold text-success text-break">Amount:</div>
                        <div class="col-8 text-break">₱{{ number_format($reservationDetails->amount, 2) }}</div>
                    </div>
                    @endif-->
                    @if(!empty($reservationDetails->reference_num))
                    <div class="row mb-2">
                        <div class="col-4 fw-bold text-success text-break">Reference No:</div>
                        <div class="col-8 text-break">{{ $reservationDetails->reference_num }}</div>
                    </div>
                    @endif

                    @if(!empty($reservationDetails->upload_payment))
                    <div class="row mb-2">
                        <div class="col-4 fw-bold text-success text-break">Payment Proof:</div>
                        <div class="col-8 text-break">
                            <a href="{{ asset('storage/payments/' . basename($reservationDetails->upload_payment)) }}"
                            target="_blank" 
                            class="text-decoration-none text-success">
                                View Proof
                            </a>
                        </div>
                    </div>
                    @endif

                    @if(!empty($reservationDetails->created_at))
                    <div class="row mt-3">
                        <div class="col-12 text-muted text-end" style="font-size: 0.8rem;">Date Reserved: {{ \Carbon\Carbon::parse($reservationDetails->created_at)->format('F d, Y') }}</div>
                    </div>
                    @endif

                @else
                <div class="alert alert-warning">No reservations found</div>
                @endif
                <hr class="border-success border-2 mb-3">
            </div>

            <!-- Right 50% -->
            <div class="col-12 col-md-6">
                <h2 class="fw-bold text-uppercase text-success mb-3" style="font-size: 2rem;">Status</h2>
                <hr class="border-success border-2 mb-3">
                <div class="d-flex align-items-center mb-3">
                        <button type="button" class="btn btn-success rounded-circle d-flex align-items-center justify-content-center" style="width: 2rem; height: 2rem;" data-bs-toggle="modal" data-bs-target="#instructionsModal">
                            <i class="fa-solid fa-question text-white" style="font-size: 1rem;"></i>
                        </button>
                        

                    <!-- Modal -->
                    <div class="modal fade" id="instructionsModal" tabindex="-1" aria-labelledby="instructionsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow-lg border-0" style="border-radius: 16px; overflow: hidden; background: linear-gradient(135deg, #1b6e47 0%, #28a745 100%); color: #ffffff;">

                        <!-- Header -->
                        <div class="modal-header border-0 pb-2" style="background: rgba(0,0,0,0.05);">
                            <h5 class="modal-title fw-bold text-uppercase tracking-wide" id="instructionsModalLabel" style="letter-spacing: 1px;">Check-in Instructions</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body px-4 py-4">
                            <div class="row align-items-center gx-4">
                            <!-- Left column -->
                            <div class="col-12 col-md-6 text-center">
                                <div class="qr-wrapper d-inline-block p-2 bg-white rounded-3 shadow-sm">
                                <canvas id="qr-code" class="d-block mx-auto" style="max-width: 140px; max-height: 140px;"></canvas>
                                </div>
                            </div>
                            <!-- Right column -->
                            <div class="col-12 col-md-6">
                                <p class="mb-3 d-flex align-items-start">
                                <span class="badge bg-light text-success me-2 mt-1">1</span>
                                <span>Download your QR code by clicking the button below.</span>
                                </p>
                                <p class="mb-0 d-flex align-items-start">
                                <span class="badge bg-light text-success me-2 mt-1">2</span>
                                <span>Present this QR code upon check-in at our resort.</span>
                                </p>
                            </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer border-0 p-0">
                            <div class="d-flex w-100">
                            <button type="button" class="btn btn-link text-white text-decoration-none fw-semibold flex-fill py-3" data-bs-dismiss="modal">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </button>
                            <div class="vr bg-white opacity-50"></div>
                            <button type="button" id="download-qr" class="btn btn-link text-white text-decoration-none fw-semibold flex-fill py-3" onclick="downloadQRCode()">
                                <i class="fas fa-download me-2"></i>Download QR
                            </button>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                        @if(isset($reservationDetails->reservation_status))
                        <span class="ms-3 fw-bold text-black text-uppercase" style="font-size: 1.5rem;">Instructions</span>
                        <span id="status-badge" class="ms-auto badge fs-5
                            @if($reservationDetails->reservation_status == 'checked-in') bg-success 
                            @elseif($reservationDetails->reservation_status == 'pending') bg-warning
                            @elseif($reservationDetails->reservation_status == 'on-hold') bg-warning
                            @elseif($reservationDetails->reservation_status == 'reserved') bg-primary
                            @else bg-danger 
                            @endif text-white">
                            {{ ucfirst($reservationDetails->reservation_status) }}
                        </span>
                        @endif
                </div>
                <!-- Additional header below the button -->
                <h3 class="fw-bold text-uppercase text-success mb-3 mt-2" style="font-size: 1.75rem;">PAYMENT DETAIls</h3>
                <hr class="border-success border-2 mb-3">

                @if(isset($reservationDetails->reservation_status) && in_array($reservationDetails->reservation_status, ['pending', 'on-hold']))
                    <div class="alert alert-info mt-4">
                        <h5 class="alert-heading fw-bold">Thank You for Your Reservation!</h5>
                        <p>Your booking is currently being processed. We will notify you via email once it is confirmed.</p>
                        <hr>
                        <p class="mb-0">Please wait for the staff to approve your reservation before proceeding with any payment.</p>
                    </div>
                @elseif(isset($reservationDetails->payment_status) && $reservationDetails->payment_status == 'paid')
                    <div class="alert alert-success mt-4">
                        <h5 class="alert-heading fw-bold"><i class="fas fa-check-circle me-2"></i>Payment Complete!</h5>
                        <p>Your payment has been successfully processed. Thank you for your reservation!</p>
                        <hr>
                        <p class="mb-0">Your booking is now confirmed. We look forward to welcoming you!</p>
                    </div>
                @elseif(isset($reservationDetails->payment_status) && $reservationDetails->payment_status == 'partial')
                    <div class="alert alert-info mt-4">
                        <h5 class="alert-heading fw-bold"><i class="fas fa-hourglass-half me-2"></i>Partial Payment Made</h5>
                        <p>You have successfully paid the 20% downpayment. Your reservation is now secured.</p>
                        <hr>
                        <p class="mb-0">Please settle the remaining balance upon arrival at the resort.</p>
                    </div>

                    <div class="row mb-2 mt-4">
                        <div class="col-6 text-black text-uppercase text-break">Total Amount:</div>
                        <div class="col-6 text-break text-end">
                            <div class="bg-secondary text-white rounded px-2 py-1 d-inline-block">
                                ₱{{ number_format($reservationDetails->amount, 2) }}
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-black text-uppercase text-break fw-bold">Remaining Balance:</div>
                        <div class="col-6 text-break text-end">
                            <div class="bg-success text-white rounded px-2 py-1 d-inline-block fw-bold fs-5">
                                ₱{{ number_format($reservationDetails->balance, 2) }}
                            </div>
                        </div>
                    </div>
                @else
                @if(isset($reservationDetails->amount))
                    <div class="row mb-2 mt-4 ">
                        <div class="col-4 text-black text-uppercase text-break ">Total Room Price:</div>
                        <div class="col-8 text-break text-end">
                            <div class="bg-success text-white rounded px-2 py-1 d-inline-block">
                                @php
                                    $totalRoomPrice = 0;
                                    $accommodationIds = json_decode($reservationDetails->accomodation_id, true) ?? [];
                                    $roomDetails = DB::table('accomodations')->whereIn('accomodation_id', $accommodationIds)->get()->keyBy('accomodation_id');
                                    $rawQuantity = $reservationDetails->quantity ?? 1;
                                    $checkIn = new \DateTime($reservationDetails->reservation_check_in_date);
                                    $checkOut = new \DateTime($reservationDetails->reservation_check_out_date);
                                    $nights = $checkIn->diff($checkOut)->days > 0 ? $checkIn->diff($checkOut)->days : 1;

                                    if (is_string($rawQuantity) && is_array(json_decode($rawQuantity, true))) {
                                        $quantities = json_decode($rawQuantity, true);
                                        foreach ($quantities as $id => $qty) {
                                            $totalRoomPrice += ($roomDetails[$id]->accomodation_price ?? 0) * $qty * $nights;
                                        }
                                    } else {
                                        $totalRoomPrice = $roomDetails->sum('accomodation_price') * (int)$rawQuantity * $nights;
                                    }
                                @endphp
                                ₱{{ number_format($totalRoomPrice, 2) }}
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2 mt-2">
                        <div class="col-4 text-black text-uppercase text-break ">Room price:</div>
                        <div class="col-8 text-break text-end">
                            <div class="bg-success text-white rounded px-2 py-1 d-inline-block">
                                ₱{{ number_format($reservationDetails->amount, 2) }}
                            </div>
                        </div>
                    </div>
                    @endif
                               
                    <hr class="border-success border-2 mb-2"> <!--line-->

                    @if(isset($reservationDetails->amount))
                    <div class="row mb-2 justify-content-center text-center">
                        <div class="col-12 fw-bold text-uppercase text-black text-break">total amount to pay:</div>
                        <div class="col-12">
                            <div class="bg-success text-white rounded mt-1 px-2 py-1 d-inline-block">
                                ₱{{ number_format($reservationDetails->amount, 2) }}
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if(isset($reservationDetails->amount))
                    <div class="row mb-2">
                        <div class="col-8 text-black text-uppercase text-break ">Required 20% Downpayment:</div>
                        <div class="col-4 text-break text-end">
                            <div class="bg-success text-white rounded px-2 py-1 d-inline-block">
                                ₱{{ number_format($reservationDetails->downpayment, 2) }}
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
                </div>
            </div>
        </div>
    </div><!-- /container-sm -->
    <!-- Banner -->
    <div class="container mt-1 mb-2 px-3">
        <div class="row g-3">
            <div class="col-12">
                <div class="py-5 bg-success text-white text-center rounded-0 shadow-lg" 
                     style="background: linear-gradient(135deg, #0b573d 0%, #28a745 100%);">
                    <h3 class="mb-2 fw-bold text-uppercase tracking-wide" style="letter-spacing: 1px;">
                        Thank You for Choosing Lelo's Resort!
                    </h3>
                    <p class="mb-0 fs-5">
                        We look forward to providing you with an exceptional experience during your stay.
                    </p>
                </div>
            </div>
        </div>
    </div>
        
    <div class="pb-5"></div> <!-- Add padding at the bottom -->

    <!-- Feedback Modal -->
    @if(isset($reservationDetails) && isset($reservationDetails->id))
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header bg-success text-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title" id="feedbackModalLabel">We Value Your Feedback!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="feedbackForm" action="{{ route('feedback.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                    <input type="hidden" name="reservation_id" value="{{ $reservationDetails->id }}">
                        <div class="mb-3">
                            <label for="rating" class="form-label">How would you rate your experience?</label>
                            <div class="d-flex justify-content-center gap-2 mb-3">
                                <div class="rating">
                                    <input type="radio" name="rating" id="rating5" value="5" class="star-input" required>
                                    <label for="rating5" class="star-label">
                                        <i class="fas fa-star"></i>
                                    </label>
                                    
                                    <input type="radio" name="rating" id="rating4" value="4" class="star-input">
                                    <label for="rating4" class="star-label">
                                        <i class="fas fa-star"></i>
                                    </label>
                                    
                                    <input type="radio" name="rating" id="rating3" value="3" class="star-input">
                                    <label for="rating3" class="star-label">
                                        <i class="fas fa-star"></i>
                                    </label>
                                    
                                    <input type="radio" name="rating" id="rating2" value="2" class="star-input">
                                    <label for="rating2" class="star-label">
                                        <i class="fas fa-star"></i>
                                    </label>
                                    
                                    <input type="radio" name="rating" id="rating1" value="1" class="star-input">
                                    <label for="rating1" class="star-label">
                                        <i class="fas fa-star"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="feedbackText" class="form-label">Your feedback</label>
                            <textarea class="form-control" id="feedbackText" name="comment" rows="3" placeholder="Please share your thoughts..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <style>
    .rating {
        display: flex;
        flex-direction: row-reverse;
        gap: 0.3rem;
    }

    .star-input {
        display: none;
    }

    .star-label {
        color: #ddd;
        font-size: 1.5rem;
        cursor: pointer;
        transition: color 0.2s ease-in-out;
    }

    .star-input:checked ~ .star-label {
        color: #ffd700;
    }

    .star-label:hover,
    .star-label:hover ~ .star-label {
        color: #ffd700;
    }
    </style>

    <script>
    // Your existing JavaScript functionality
    $(document).ready(function() {
        // Check if modal has been shown before
        if (!sessionStorage.getItem('feedbackModalShown')) {
            setTimeout(function() {
                $('#feedbackModal').modal('show');
                sessionStorage.setItem('feedbackModalShown', 'true');
            }, 3000);
        }
    });

    // Generate QR code on page load
    window.onload = function() {
        let reservationId = '{{ $reservationDetails->reservation_id ?? '' }}';
        if (reservationId) {
            let qr = new QRious({
                element: document.getElementById('qr-code'),
                value: reservationId,
                size: 200
            });

            let qrCodeContainer = document.getElementById('qr-code').parentElement;
            qrCodeContainer.style.display = 'flex';
            qrCodeContainer.style.flexDirection = 'column';
            qrCodeContainer.style.justifyContent = 'center';
            qrCodeContainer.style.alignItems = 'center';

            document.getElementById('download-qr').style.display = 'inline-block';
        }
    };

    function generateQRCode() {
        let reservationId = '{{ $reservationDetails->reservation_id ?? '' }}';
        if (!reservationId) {
            alert('No reservation ID available!');
            return;
        }

        let qr = new QRious({
            element: document.getElementById('qr-code'),
            value: reservationId,
            size: 300
        });

        let qrCodeContainer = document.getElementById('qr-code').parentElement;
        qrCodeContainer.style.display = 'flex';
        qrCodeContainer.style.flexDirection = 'column';
        qrCodeContainer.style.justifyContent = 'center';
        qrCodeContainer.style.alignItems = 'center';

        document.getElementById('download-qr').style.display = 'inline-block';
    }

    function downloadQRCode() {
        let canvas = document.getElementById('qr-code');
        let link = document.createElement('a');
        link.href = canvas.toDataURL("image/png");
        link.download = "reservation_qr.png";
        link.click();
    }
    </script>
</body>
</html>