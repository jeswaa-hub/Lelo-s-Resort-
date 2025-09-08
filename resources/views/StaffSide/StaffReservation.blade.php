<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>

</style>

<body style="margin: 0; padding: 0; height: 100vh; background-color: white; overflow-x: hidden;">
    @include('Alert.errorLogin')
    @include('Alert.loginSuccessUser')
        <!-- NAVBAR -->
        @include('Navbar.sidenavbarStaff')

                    <!-- Status Alert Banner for Pending Reservations -->
                    @if(!request('status') || request('status') == 'pending')
            <div class="alert alert-warning border-0 mb-4" style="background: linear-gradient(135deg, #fff3cd, #ffeaa7); border-left: 5px solid #ffc107;" id="pendingAlert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle fs-4 me-3" style="color: #856404;"></i>
                    <div>
                        <h6 class="fw-bold mb-1" style="color: #856404;">Showing Pending Reservations</h6>
                        <p class="mb-0 small" style="color: #856404;">These reservations require your immediate attention for approval or processing.</p>
                    </div>
                </div>
            </div>

            <script>
                // Hide alert after 5 seconds
                setTimeout(function() {
                    document.getElementById('pendingAlert').style.transition = 'opacity 1s';
                    document.getElementById('pendingAlert').style.opacity = '0';
                    setTimeout(function() {
                        document.getElementById('pendingAlert').style.display = 'none';
                    }, 1000);
                }, 5000);
            </script>
            @endif  

        <!-- HERO BANNER -->
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
                                
                            </h1>
                        </div>
                        
                        <!-- Total Reservations -->
                        <div class="d-flex align-items-center rounded-3 shadow-sm mt-4" style="background: linear-gradient(135deg,rgb(75, 96, 7) 0%,rgb(129, 235, 48) 100%);">
                            <div class="p-3 p-md-4 p-lg-5">
                                <div class="d-flex align-items-baseline gap-2">
                                    <h1 class="fw-bold mb-0 text-white" style="font-size: clamp(1.8rem, 3vw, 3rem);">{{ $totalCount ?? 0 }}</h1>
                                    <p class="text-white text-uppercase mb-0 font-paragraph " style="font-size: 1.8rem; letter-spacing: 1px;">Total Reservations</p>
                                </div>
                            </div>
                            <div class="ms-auto p-3 p-md-4 p-lg-5 position-relative">
                                <i class="fas fa-calendar-check text-white opacity-25" style="font-size: 4rem; margin: -10px;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="col-12 col-md-6">
                    <div class="row row-cols-1 row-cols-sm-2 g-3 g-md-4">
                        <!-- Checked-in -->
                        <div class="col">
                            <div class="d-flex align-items-center text-dark p-3 p-md-4 p-lg-5 rounded-3 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #43cea2 0%, #385E3C 100%);">
                                <div>
                                    <h1 class="fw-bold mb-0 text-white" style="font-size: clamp(1.8rem, 3vw, 3rem);">{{ $checkedInCount ?? 0 }}</h1>
                                    <p class="mb-0 fw-semibold text-white" style="font-size: clamp(0.9rem, 1.5vw, 1.2rem);">Checked-in</p>
                                </div>
                                <div class="position-absolute top-0 end-0 opacity-25">
                                    <i class="fas fa-user-check text-white" style="font-size: 4rem; margin: -10px;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Checked-out -->
                        <div class="col">
                            <div class="d-flex align-items-center text-dark p-3 p-md-4 p-lg-5 rounded-3 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg,rgb(75, 96, 7) 0%,rgb(129, 235, 48) 100%);">
                                <div>
                                    <h1 class="fw-bold mb-0 text-white" style="font-size: clamp(1.8rem, 3vw, 3rem);">{{ $checkedOutCount ?? 0 }}</h1>
                                    <p class="mb-0 fw-semibold text-white" style="font-size: clamp(0.9rem, 1.5vw, 1.2rem);">Check-out</p>
                                </div>
                                <div class="position-absolute top-0 end-0 opacity-25">
                                    <i class="fas fa-sign-out-alt text-white" style="font-size: 4rem; margin: -10px;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Pending -->
                        <div class="col">
                            <div class="d-flex align-items-center text-dark p-3 p-md-4 p-lg-5 rounded-3 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg,rgb(75, 96, 7) 0%,rgb(129, 235, 48) 100%);">
                                <div>
                                    <h1 class="fw-bold mb-0 text-white" style="font-size: clamp(1.8rem, 3vw, 3rem);">{{ $pendingCount ?? 0 }}</h1>
                                    <p class="mb-0 fw-semibold text-white" style="font-size: clamp(0.9rem, 1.5vw, 1.2rem);">Pending</p>
                                </div>
                                <div class="position-absolute top-0 end-0 opacity-25">
                                    <i class="fas fa-clock text-white" style="font-size: 4rem; margin: -10px;"></i>
                                </div>
                            </div>
                        </div>

                            <!-- Reserved -->
                            <div class="col">
                                <div class="d-flex align-items-center text-dark p-3 p-md-4 p-lg-5 rounded-3 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #43cea2 0%, #385E3C 100%);">
                                    <div>
                                        <h1 class="fw-bold mb-0 text-white" style="font-size: clamp(1.8rem, 3vw, 3rem);">{{ $reservedCount ?? 0 }}</h1>
                                        <p class="mb-0 fw-semibold text-white" style="font-size: clamp(0.9rem, 1.5vw, 1.2rem);">Reserved</p>
                                    </div>
                                    <div class="position-absolute top-0 end-0 opacity-25">
                                        <i class="fas fa-bookmark text-white" style="font-size: 4rem; margin: -10px;"></i>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Additional Hero Banner -->
<div class="container-fluid mt-4 shadow-lg p-4 rounded" style="max-width: 100%; margin: 0 auto; background: linear-gradient(to top, rgb(211, 209, 209), #ffffff);">
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="fw-bold mb-0 border-bottom" style="font-size: 2.5rem; color: #0b573d;">ONLINE RESERVATION</h2>
        

        <div class="d-flex gap-2">
            <form action="{{ route('staff.reservation') }}" method="GET" class="d-flex gap-2" id="filterForm">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <select class="form-select {{ request('status', 'pending') == 'pending' ? 'status-filter-active' : '' }}" name="status" onchange="this.form.submit()" style="border-color: #0b573d; font-weight: 500;">
                    <option value="pending" {{ (!request('status') || request('status') == 'pending') ? 'selected' : '' }}>📋 Pending ({{ $pendingCount ?? 0 }})</option>
                    <option value="on-hold" {{ request('status') == 'on-hold' ? 'selected' : '' }}>⏸️ On-Hold ({{ $OnHoldCount ?? 0 }})</option>
                    <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>📅 Reserved ({{ $reservedCount ?? 0 }})</option>
                    <option value="checked-in" {{ request('status') == 'checked-in' ? 'selected' : '' }}>🏨 Checked-in ({{ $checkedInCount ?? 0 }})</option>
                    <option value="checked-out" {{ request('status') == 'checked-out' ? 'selected' : '' }}>✅ Checked-out ({{ $checkedOutCount ?? 0 }})</option>
                    <option value="early-checked-out" {{ request('status') == 'early-checked-out' ? 'selected' : '' }}>⏰ Early Out</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                </select>
                <select name="stay_type" class="form-select" onchange="this.form.submit()" style="border-color: #0b573d; font-weight: 500;">
                    <option value="">All Stay Types</option>
                    <option value="overnight" {{ request('stay_type') == 'overnight' ? 'selected' : '' }}>🌙 Overnight</option>
                    <option value="one_day" {{ request('stay_type') == 'one_day' ? 'selected' : '' }}>☀️ Day Stay</option>
                </select>
                <button type="button" id="qrScannerBtn" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#qrScannerModal" style="background-color: #0b573d">
                    <i class="fas fa-qrcode me-2"></i>Open QR Scanner
                </button>

                            <!-- QR Scanner Modal -->
            <div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px; border: none;">
                        <div class="modal-header" style="background-color: #0b573d; color: white; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                            <h5 class="modal-title" id="qrScannerModalLabel">
                                <i class="fas fa-qrcode me-2"></i>QR Code Scanner
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center p-4">
                            <div class="card mx-auto border-0 shadow-sm">
                                <div class="card-body">
                                    <video id="preview" class="img-fluid mb-4 rounded" width="100%" height="auto" style="border: 2px solid #0b573d;"></video>
                                    <div class="alert alert-info mb-3" style="background-color: #e8f5e9; border-color: #0b573d; color: #0b573d;">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Scanned Reservation ID: <span id="qrResult" class="fw-bold">None</span>
                                    </div>
                                    <button id="toggleCamera" class="btn mb-3 w-100" 
                                        style="background-color: #0b573d; color: white; transition: all 0.3s ease;"
                                        onmouseover="this.style.backgroundColor='#083d2a'" 
                                        onmouseout="this.style.backgroundColor='#0b573d'"
                                        onclick="toggleCamera()">
                                        <i class="fas fa-camera me-2"></i>Toggle Camera
                                    </button>
                                    <button id="stopScanner" class="btn w-100" 
                                        style="background-color: #dc3545; color: white; display: none; transition: all 0.3s ease;"
                                        onmouseover="this.style.backgroundColor='#bb2d3b'" 
                                        onmouseout="this.style.backgroundColor='#dc3545'"
                                        onclick="stopScanner()">
                                        <i class="fas fa-stop-circle me-2"></i>Stop Scanner
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <script>
                let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
                let isCameraOn = false;

                scanner.addListener('scan', function (content) {
                    try {
                        console.log('Scanned content:', content);
                        
                        // Extract reservation ID from the QR content
                        // Look for patterns like RES005, RES001, etc.
                        let reservationId = null;
                        
                        // Method 1: Direct match for reservation ID pattern (RES followed by numbers)
                        const reservationPattern = /RES\d{3,}/i;
                        const directMatch = content.match(reservationPattern);
                        
                        if (directMatch) {
                            reservationId = directMatch[0].toUpperCase();
                        } else {
                            // Method 2: Look for reservation ID in structured text
                            const lines = content.split('\n');
                            for (let line of lines) {
                                // Check if line contains "Reservation ID:" or similar
                                if (line.toLowerCase().includes('reservation') && line.toLowerCase().includes('id')) {
                                    const match = line.match(/RES\d{3,}/i);
                                    if (match) {
                                        reservationId = match[0].toUpperCase();
                                        break;
                                    }
                                }
                                // Also check for just the reservation ID pattern in any line
                                const lineMatch = line.match(/RES\d{3,}/i);
                                if (lineMatch) {
                                    reservationId = lineMatch[0].toUpperCase();
                                    break;
                                }
                            }
                        }
                        
                        if (reservationId) {
                            // Update QR result display
                            document.getElementById("qrResult").innerText = reservationId;
                            
                            // Set the reservation ID in search input
                            document.getElementById("searchInput").value = reservationId;
                            
                            // Submit the form automatically
                            document.querySelector('form').submit();
                            
                            // Stop scanner and close modal
                            stopScanner();
                            $('#qrScannerModal').modal('hide');
                            
                            // Show success message
                            swal("Success!", "Reservation ID found: " + reservationId, "success");
                        } else {
                            swal("Error", "No reservation ID found in QR code", "error");
                            console.log('QR Content for debugging:', content);
                        }
                    } catch (e) {
                        console.error('Error processing QR code:', e);
                        swal("Error", "Failed to process QR code", "error");
                    }
                });

                Instascan.Camera.getCameras().then(function (cameras) {
                    if (cameras.length > 0) {
                        // Toggle camera on and off
                        document.getElementById("toggleCamera").addEventListener("click", function() {
                            if (isCameraOn) {
                                stopScanner();
                            } else {
                                scanner.start(cameras[0]);
                                isCameraOn = true;
                                document.getElementById("toggleCamera").style.display = 'none';
                                document.getElementById("stopScanner").style.display = 'block';
                            }
                        });
                    } else {
                        swal("Error", "No cameras found.", "error");
                    }
                }).catch(function (e) {
                    console.error(e);
                    swal("Error", "An error occurred while accessing the cameras.", "error");
                });

                // Stop scanner function
                function stopScanner() {
                    scanner.stop();
                    isCameraOn = false;
                    document.getElementById("toggleCamera").style.display = 'block';
                    document.getElementById("stopScanner").style.display = 'none';
                }

                // Auto-stop scanner when modal is closed
                $('#qrScannerModal').on('hidden.bs.modal', function () {
                    if (isCameraOn) {
                        stopScanner();
                    }
                });
            </script>



            </form>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card shadow-sm border-0 rounded-4 mb-4 mt-4 p-2">
    <div style="overflow-x: auto;">
        <table class="table table-hover table-striped table-responsive table-sm">
        <thead style="background-color: #0b573d; color: white;">
        <tr>
            <th class="text-center align-middle" style="color: #0b573d">ResID</th>
            <th class="text-center align-middle" style="color: #0b573d">Name</th>
            <th class="text-center align-middle" style="color: #0b573d">Phone Number</th>
            <th class="text-center align-middle" style="color: #0b573d">Room</th>
            <th class="text-center align-middle" style="color: #0b573d">Room Qty</th>
            <th class="text-center align-middle" style="color: #0b573d">Ref Num</th>
            <th class="text-center align-middle" style="color: #0b573d">Amount</th>
            <th class="text-center align-middle" style="color: #0b573d">Balance</th>
            <th class="text-center align-middle" style="color: #0b573d">Stay Type</th>
            <th class="text-center align-middle" style="color: #0b573d">Reservation Status</th>
            <th class="text-center align-middle" style="color: #0b573d">Payment Status</th>
            <th class="text-center align-middle" style="color: #0b573d">Proof of Payment</th>
            <th class="text-center align-middle" style="color: #0b573d">Action</th>
        </tr>
        </thead>
        <tbody>
            @php
                $currentStatus = request('status', 'pending');
            @endphp
            
            @forelse ($reservations as $reservation)
                @if($reservation->reservation_status == $currentStatus)
                <tr class="{{ $reservation->reservation_status == 'pending' ? 'pending-highlight' : '' }}">
                    <td class="text-center align-middle">
                        <span class="fw-bold" style="color: #0b573d;">{{ $reservation->reservation_id }}</span>
                    </td>
                    <td class="text-center align-middle">{{ $reservation->name }}</td>
                    <td class="text-center align-middle">{{ $reservation->mobileNo }}</td>
                    <td class="text-center align-middle">
                    @php
                        $accommodationNames = is_array($reservation->accommodations) ? $reservation->accommodations : [];
                    @endphp
                    {{ implode(', ', $accommodationNames) }}
                    </td>
                    <td class="text-center align-middle">{{$reservation->quantity}}</td>
                    <td class="text-center align-middle">{{ $reservation->reference_num }}</td>
                    <td class="text-center align-middle">₱{{ number_format($reservation->amount ?? 0, 2)  }}</td>
                    <td class="text-center align-middle">₱{{ number_format($reservation->balance ?? 0, 2)  }}</td>
                    <td class="text-center align-middle">
                        <span class="badge rounded-pill" style="background-color: #e8f5e9; color: #0b573d;">
                            {{ $reservation->stay_type ?? "Unknown" }}
                        </span>
                    </td>

                    <td class="text-center align-middle">
                        <span class="badge rounded-pill py-2 px-2
                            {{ $reservation->reservation_status == 'reserved' ? 'bg-primary' : 
                            ($reservation->reservation_status == 'checked-in' ? 'bg-success' : 
                            ($reservation->reservation_status == 'checked-out' ? 'bg-danger' :
                            ($reservation->reservation_status == 'cancelled' ? 'bg-danger' : 'bg-warning'))) }}" style="font-size: .7rem;">
                            {{ ucfirst($reservation->reservation_status) }}
                            @if($reservation->reservation_status == 'pending')
                                <i class="fas fa-clock ms-1"></i>
                            @endif
                        </span>
                    </td>
                    <td class="text-center align-middle">
                        <span class="badge rounded-pill py-2 px-3
                            {{ $reservation->payment_status == 'pending' ? 'bg-warning' : 
                            ($reservation->payment_status == 'paid' ? 'bg-success' : 
                            ( $reservation->payment_status == 'on-hold' ? 'bg-warning' : 
                            ($reservation->payment_status == 'booked' ? 'bg-primary' : 'bg-danger'))) }}" style="font-size: .7rem;">
                            {{ ucfirst($reservation->payment_status) }}
                        </span>
                    </td>
                    <td class="text-center align-middle">
                        @if ($reservation->upload_payment)
                            <a href="{{ route('payment.proof', ['filename' => basename($reservation->upload_payment)]) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-image me-1"></i>View
                            </a>
                        @else
                            <span class="text-muted small">No proof uploaded</span>
                        @endif
                    </td>
                    <td class="d-flex align-items-center gap-2" style="height: 100px;">
                        <button type="button" 
                            class="btn" 
                            style="background-color: #0b573d; color: white; transition: all 0.3s ease; height: 38px;"
                            onmouseover="this.style.backgroundColor='#083d2a'; this.style.transform='scale(1.05)'" 
                            onmouseout="this.style.backgroundColor='#0b573d'; this.style.transform='scale(1)'"
                            data-bs-toggle="modal" 
                            data-bs-target="#updateReservationStatusModal{{ $reservation->id }}"
                            title="Update Status">
                            <i class="fa-pencil fa-solid"></i>
                        </button>
                        <button type="button" 
                                class="btn btn-info"
                                onmouseover="this.style.backgroundColor='#083d2a'; this.style.transform='scale(1.05)'" 
                                onmouseout="this.style.backgroundColor='#0b573d'; this.style.transform='scale(1)'"
                                data-bs-toggle="modal" 
                                data-bs-target="#viewReservationModal{{ $reservation->id }}"
                                style="background-color: #0b573d; color: white; border: none; height: 38px;"
                                title="View Details">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
                <!-- Update Reservation and Payment Status Modal -->
                <div class="modal fade" id="updateReservationStatusModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="updateReservationStatusModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-success text-white" style="background-color: #0b573d !important;">
                                <h5 class="modal-title fw-bold" id="updateReservationStatusModalLabel">
                                    <i class="fas fa-edit me-2"></i>Update Status - {{ $reservation->reservation_id }}
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <form action="{{ route('staff.updateStatus', $reservation->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="payment_status" class="form-label fw-semibold text-muted">
                                            <i class="fas fa-money-bill me-2"></i>Payment Status
                                        </label>
                                        <select class="form-select form-select-lg border-2" name="payment_status" id="payment_status" style="border-color: #0b573d">
                                            <option value="" disabled selected hidden>Choose payment status</option>
                                             <option value="on-hold" {{ old('payment_status', $reservation->payment_status) == 'on-hold' ? 'selected' : '' }}>On-Hold</option>
                                            <option value="paid" {{ old('payment_status', $reservation->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="partial" {{ old('payment_status', $reservation->payment_status) == 'partial' ? 'selected' : '' }}>Partial</option>
                                            <option value="unpaid" {{ old('payment_status', $reservation->payment_status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label for="reservation_status" class="form-label fw-semibold text-muted">
                                            <i class="fas fa-calendar-check me-2"></i>Reservation Status
                                        </label>
                                    <select class="form-select form-select-lg border-2" name="reservation_status" id="reservation_status" style="border-color: #0b573d">
                                        <option value="" disabled selected hidden>Choose reservation status</option>
                                        <option value="on-hold" {{ $reservation->reservation_status == 'on-hold' ? 'selected' : '' }}>On-Hold</option>
                                        <option value="reserved" {{ $reservation->reservation_status == 'reserved' ? 'selected' : '' }}>Reserved</option>
                                        <option value="checked-in" {{ $reservation->reservation_status == 'checked-in' ? 'selected' : '' }}>Checked-In</option>
                                        <option value="early-checked-out" {{ $reservation->reservation_status == 'early-checked-out' ? 'selected' : '' }}>Early Checked-Out</option>
                                        <option value="checked-out" {{ $reservation->reservation_status == 'checked-out' ? 'selected' : '' }}>Checked-Out</option>
                                        <option value="cancelled" {{ $reservation->reservation_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    </div>

                                    <div class="mb-4">
                                        <label for="custom_message" class="form-label fw-semibold text-muted">
                                            <i class="fas fa-comment-alt me-2"></i>Custom Message
                                        </label>
                                        <textarea class="form-control border-2" name="custom_message" id="custom_message" rows="3" style="border-color: #0b573d" placeholder="Enter additional notes or message..."></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-success w-100 py-3 fw-bold text-uppercase" style="background-color: #0b573d">
                                        <i class="fas fa-check-circle me-2"></i>Update Status
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- View Reservation Details Modal -->
                <div class="modal fade" id="viewReservationModal{{ $reservation->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0">
                            <div class="modal-header" style="background-color: #0b573d; color: white;">
                                <h5 class="modal-title">
                                    <i class="fas fa-calendar-plus me-2"></i>Extend Reservation Stay - {{ $reservation->reservation_id }}
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('staff.extendReservation', $reservation->id) }}" method="POST">
                                @csrf
                                <div class="modal-body p-4" style="background-color: #f8f9fa;">
                                    <input type="hidden" name="additional_payment" id="additional_payment" value="0">
                                    <div class="row g-3">
                                        <!-- Current Reservation Details -->
                                        <div class="col-md-6">
                                            <div class="card h-100 shadow-sm border-0">
                                                <div class="card-header" style="background-color: #0b573d; color: white;">
                                                    <h6 class="fw-bold mb-0"><i class="fas fa-info-circle me-2"></i>Current Reservation</h6>
                                                </div>
                                                <div class="card-body">
                                                    <p class="mb-2"><strong>Guest Name:</strong> {{ $reservation->name }}</p>
                                                    <p class="mb-2"><strong>Email:</strong> {{ $reservation->email }}</p>
                                                    <p class="mb-2"><strong>Room Name:</strong> {{ $reservation->accomodation_name }}</p>
                                                    <p class="mb-2"><strong>Current Check-in:</strong> {{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('F j, Y') }}</p>
                                                    <p class="mb-2"><strong>Current Check-out:</strong> {{ \Carbon\Carbon::parse($reservation->reservation_check_out_date)->format('F j, Y') }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Extension Form -->
                                        <div class="col-md-6">
                                            <div class="card h-100 shadow-sm border-0">
                                                <div class="card-header" style="background-color: #0b573d; color: white;">
                                                    <h6 class="fw-bold mb-0"><i class="fas fa-calendar-plus me-2"></i>Extend Stay</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">New Check-out Date</label>
                                                        <input type="date" class="form-control" name="new_checkout_date" 
                                                            min="{{ \Carbon\Carbon::parse($reservation->reservation_check_out_date)->addDay()->format('Y-m-d') }}"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Additional Charges Card -->
                                        <div class="col-12">
                                            <div class="card shadow-sm border-0">
                                                <div class="card-header" style="background-color: #0b573d; color: white;">
                                                    <h6 class="fw-bold mb-0"><i class="fas fa-money-bill me-2"></i>Extension Charges</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="mb-2"><strong>Current Total:</strong> ₱{{ number_format($reservation->amount, 2) }}</p>
                                                            <p class="mb-2"><strong>Extension Fee (per night):</strong> ₱<span id="extension_fee">{{ number_format($reservation->accomodation_price, 2) ?? '0.00' }}</span></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-2"><strong>Additional Nights:</strong> <span id="additional_nights">0</span></p>
                                                            <p class="mb-2"><strong>Total Extension Cost:</strong> ₱<span id="total_extension_cost" name="additional_payment">0.00</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer" style="background-color: #f8f9fa;">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn text-white" style="background-color: #0b573d;">
                                        <i class="fas fa-check me-2"></i>Confirm Extension
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            @empty
                <tr>
                    <td colspan="16" class="text-center py-5">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-calendar-times fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">No {{ ucfirst($currentStatus) }} Reservations Found</h5>
                            <p class="text-muted">
                                @if($currentStatus == 'pending')
                                    Great! All reservations have been processed.
                                @else
                                    No reservations with {{ $currentStatus }} status at the moment.
                                @endif
                            </p>
                            @if($currentStatus != 'pending')
                                <a href="{{ route('staff.reservation', ['status' => 'pending']) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-clock me-2"></i>View Pending Reservations
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted small">
                Showing reservations with status: {{ ucfirst($currentStatus) }}
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm">
                    {{ $reservations->links('pagination::bootstrap-4') }}
                </ul>
            </nav>
        </div>

    </div>
</div>
                </div>
            </div>
        </div>
        <div class="mb-4"></div>
    </div>
</div>




<script>
        // Auto-load pending reservations on page load
        document.addEventListener('DOMContentLoaded', function() {
            // If no status is specified in URL, ensure pending is selected
            const urlParams = new URLSearchParams(window.location.search);
            if (!urlParams.has('status')) {
                // Update the URL to include status=pending without reloading
                const newUrl = new URL(window.location);
                newUrl.searchParams.set('status', 'pending');
                window.history.replaceState({}, '', newUrl);
            }
            
            // Highlight pending status card
            const pendingCard = document.querySelector('[style*="background-color: #ffc107"]');
            if (pendingCard && (!urlParams.get('status') || urlParams.get('status') === 'pending')) {
                pendingCard.style.animation = 'pulse 2s infinite';
            }
        });

        // Add pulse animation for pending reservations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulse {
                0% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7); }
                70% { box-shadow: 0 0 0 10px rgba(255, 193, 7, 0); }
                100% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0); }
            }
        `;
        document.head.appendChild(style);

        function openModal(id) {
            document.getElementById('id').value = id;
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();
        }

        function closeModal() {
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.hide();
        }
        function openReservationStatusModal(id) {
            document.getElementById('reservation_id').value = id;
            var myModal = new bootstrap.Modal(document.getElementById('reservationStatusModal'));
            myModal.show();
        }

        function closeReservationStatusModal() {
            var myModal = new bootstrap.Modal(document.getElementById('reservationStatusModal'));
            myModal.hide();
        }
        
    </script>

<script>
        // Extension date calculation script
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listener for each reservation's date input
            document.querySelectorAll('input[name="new_checkout_date"]').forEach(function(input) {
                input.addEventListener('change', function() {
                    const modal = this.closest('.modal');
                    const reservationId = modal.id.replace('viewReservationModal', '');
                    
                    // You'll need to pass the reservation data to calculate this properly
                    // This is a simplified version - you may need to adjust based on your data structure
                    const currentCheckOut = new Date(this.getAttribute('min')).getTime() - (24 * 60 * 60 * 1000);
                    const newCheckOut = new Date(this.value);
                    
                    const diffTime = newCheckOut - currentCheckOut;
                    const diffDays = Math.max(0, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));
                    
                    // Update the display elements in this specific modal
                    const additionalNights = modal.querySelector('#additional_nights');
                    const totalExtensionCost = modal.querySelector('#total_extension_cost');
                    const additionalPaymentInput = modal.querySelector('#additional_payment');
                    
                    if (additionalNights && totalExtensionCost && additionalPaymentInput) {
                        const extensionFeeText = modal.querySelector('#extension_fee').textContent;
                        const extensionFee = parseFloat(extensionFeeText.replace(/[^0-9.-]+/g, ""));
                        const totalCost = extensionFee * diffDays;
                        
                        additionalNights.textContent = diffDays;
                        totalExtensionCost.textContent = totalCost.toFixed(2);
                        additionalPaymentInput.value = totalCost.toFixed(2);
                    }
                });
            });
        });
    </script>

</body>
</html>