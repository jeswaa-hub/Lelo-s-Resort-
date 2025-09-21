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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    .pending-highlight {
        background-color: #fff3cd !important;
        border-left: 4px solid #ffc107 !important;
    }
    
    .status-filter-active {
        border-color: #ffc107 !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25) !important;
    }
    
</style>

<body style="margin: 0; padding: 0; height: 100vh; background-color: white; overflow-x: hidden;">
    @include('Alert.errorLogin')
    @include('Alert.loginSuccessUser')
        <!-- NAVBAR -->
        @include('Navbar.sidenavbarStaff')

        <!-- Status Alert Banner for Pending Reservations - Top Right Corner -->
        @if(request('status') == 'pending')
            <div class="alert alert-warning shadow-lg" 
                style="position: fixed; 
                        top: 20px; 
                        right: 20px; 
                        z-index: 1050; 
                        max-width: 350px; 
                        min-width: 300px;
                        background: linear-gradient(135deg, #fff3cd, #ffeaa7); 
                        border: 2px solid #d4a017;
                        border-radius: 10px;
                        animation: slideInRight 0.5s ease-out;" 
                id="pendingAlert">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="d-flex align-items-center flex-grow-1">
                        <i class="fas fa-exclamation-triangle me-3" style="color: #856404; font-size: 2.5rem;"></i>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: #856404; font-size: 0.9rem;">Pending Reservations</h6>
                            <p class="mb-0 small" style="color: #856404; font-size: 0.8rem;">These require immediate attention for processing.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-sm ms-2 align-self-start" aria-label="Close" onclick="closePendingAlert()" style="font-size: 0.7rem;"></button>
                </div>
            </div>

            <style>
                @keyframes slideInRight {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                
                @keyframes slideOutRight {
                    from {
                        transform: translateX(0);
                        opacity: 1;
                    }
                    to {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                }
                
                .slide-out {
                    animation: slideOutRight 0.5s ease-in forwards;
                }
            </style>

            <script>
                function closePendingAlert() {
                    const alert = document.getElementById('pendingAlert');
                    if (alert) {
                        alert.classList.add('slide-out');
                        setTimeout(function() {
                            alert.style.display = 'none';
                        }, 500);
                    }
                }

                // Auto-hide alert after 5 seconds
                setTimeout(function() {
                    closePendingAlert();
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
                                {{$staffCredentials->username}}
                            </h1>
                        </div>
                        
                        <!-- Total Reservations -->
                        <div class="d-flex align-items-center text-dark p-3 p-md-4 p-lg-5 rounded-3 shadow-sm h-100 position-relative overflow-hidden" 
                             style="background: linear-gradient(135deg, #ffffff 50%, #f8f9fa 50%);">
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <div class="d-flex align-items-baseline gap-2">
                                    <h1 class="fw-bold mb-0 text-success" 
                                        style="font-size: clamp(1.5rem, 2.5vw, 3rem);">
                                        {{ $totalCount ?? 0 }}
                                    </h1>
                                    <p class="mb-0 text-uppercase fw-semibold text-success" style="font-size: clamp(0.8rem, 1.2vw, 1.2rem);">
                                        Total Reservations
                                    </p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-check text-success" 
                                       style="font-size: clamp(2rem, 4vw, 4rem);">
                                    </i>
                                </div>
                            </div>
                            <div class="position-absolute top-0 end-0 opacity-25 d-none d-md-block">
                                <i class="fas fa-calendar-check text-success" 
                                   style="font-size: 5rem; margin: -10px;">
                                </i>
                            </div>
                        </div>
                    </div>
                </div>
                

                <!-- Right Side -->
                <div class="col-12 col-md-6">
                    <div class="row row-cols-1 row-cols-sm-2 g-3 g-md-4">
                        <!-- Checked-in -->
                        <div class="col">
                            <div class="d-flex align-items-center text-dark p-3 p-md-4 p-lg-5 rounded-3 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #ffffff 50%, #f8f9fa 50%);">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="d-flex flex-column gap-2">
                                        <h1 class="fw-bold mb-0 text-success" style="font-size: clamp(1.5rem, 2.5vw, 3rem);">{{ $checkedInCount ?? 0 }}</h1>
                                        <p class="mb-0 text-uppercase fw-semibold text-success" style="font-size: clamp(0.8rem, 1.2vw, 1.2rem);">Check-in</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-check text-success" style="font-size: clamp(2rem, 4vw, 2.5rem);"></i>
                                    </div>
                                </div>
                                <div class="position-absolute top-0 end-0 opacity-25 d-none d-md-block">
                                    <i class="fas fa-user-check text-success" style="font-size: 4rem; margin: -10px;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Checked-out -->
                        <div class="col">
                            <div class="d-flex align-items-center text-dark p-3 p-md-4 p-lg-5 rounded-3 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #ffffff 50%, #f8f9fa 50%);">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="d-flex flex-column gap-2">
                                        <h1 class="fw-bold mb-0 text-success" style="font-size: clamp(1.5rem, 2.5vw, 3rem);">{{ $checkedOutCount ?? 0 }}</h1>
                                        <p class="mb-0 text-uppercase fw-semibold text-success" style="font-size: clamp(0.8rem, 1.2vw, 1.2rem);">Check-out</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-sign-out-alt text-success" style="font-size: clamp(2rem, 4vw, 5rem);"></i>
                                    </div>
                                </div>
                                <div class="position-absolute top-0 end-0 opacity-25 d-none d-md-block">
                                    <i class="fas fa-sign-out-alt text-success" style="font-size: 4rem; margin: -10px;"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Pending -->
                        <div class="col">
                            <div class="d-flex align-items-center text-dark p-3 p-md-4 p-lg-5 rounded-3 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #ffffff 50%, #f8f9fa 50%);">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="d-flex flex-column gap-2">
                                        <h1 class="fw-bold mb-0 text-success" style="font-size: clamp(1.5rem, 2.5vw, 3rem);">{{ $pendingCount ?? 0 }}</h1>
                                        <p class="mb-0 text-uppercase fw-semibold text-success" style="font-size: clamp(0.8rem, 1.2vw, 1.2rem);">Pending</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clock text-success" style="font-size: clamp(2rem, 4vw, 2.5rem);"></i>
                                    </div>
                                </div>
                                <div class="position-absolute top-0 end-0 opacity-25 d-none d-md-block">
                                    <i class="fas fa-clock text-success" style="font-size: 4rem; margin: -10px;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Reserved -->
                        <div class="col">
                            <div class="d-flex align-items-center text-dark p-3 p-md-4 p-lg-5 rounded-3 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #ffffff 50%, #f8f9fa 50%);">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="d-flex flex-column gap-2">
                                        <h1 class="fw-bold mb-0 text-success" style="font-size: clamp(1.5rem, 2.5vw, 3rem);">{{ $reservedCount ?? 0 }}</h1>
                                        <p class="mb-0 text-uppercase fw-semibold text-success" style="font-size: clamp(0.8rem, 1.2vw, 1.2rem);">Reserved</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-bookmark text-success" style="font-size: clamp(2rem, 4vw, 2.5rem);"></i>
                                    </div>
                                </div>
                                <div class="position-absolute top-0 end-0 opacity-25 d-none d-md-block">
                                    <i class="fas fa-bookmark text-success" style="font-size: 4rem; margin: -10px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Hero Banner -->
        <div class="container-fluid mt-4 shadow-lg p-4 bg-white rounded" style="max-width: 100%; margin: 0 auto;">
            <div class="container">
                <!-- Desktop Layout -->
                <div class="d-none d-lg-block">
                    <!-- Single Row with Title, Filters, and QR Button -->
                    <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                        <!-- Title on the left -->
                        <div class="flex-shrink-0">
                            <h2 class="fw-bold text-black mb-0" style="font-size: 2.5rem; border-bottom: 2px solid #0b573d; padding-bottom: 5px;">ONLINE RESERVATION</h2>
                        </div>
                        
                        <!-- Filters and QR Button on the right -->
                        <div class="d-flex align-items-center gap-3">
                            <form action="{{ route('staff.reservation') }}" method="GET" class="d-flex gap-3 align-items-center" id="filterForm">
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                
                                <select class="form-select {{ request('status', 'pending') == 'pending' ? 'status-filter-active' : '' }}" 
                                        name="status" onchange="this.form.submit()" 
                                        style="border-color: #0b573d; font-weight: 500; min-width: 200px;">
                                    <option value="pending" {{ (!request('status') || request('status') == 'pending') ? 'selected' : '' }}>📋 Pending ({{ $pendingCount ?? 0 }})</option>
                                    <option value="on-hold" {{ request('status') == 'on-hold' ? 'selected' : '' }}>⏸️ On-Hold ({{ $OnHoldCount ?? 0 }})</option>
                                    <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>📅 Reserved ({{ $reservedCount ?? 0 }})</option>
                                    <option value="checked-in" {{ request('status') == 'checked-in' ? 'selected' : '' }}>🏨 Checked-in ({{ $checkedInCount ?? 0 }})</option>
                                    <option value="checked-out" {{ request('status') == 'checked-out' ? 'selected' : '' }}>✅ Checked-out ({{ $checkedOutCount ?? 0 }})</option>
                                    <option value="early-checked-out" {{ request('status') == 'early-checked-out' ? 'selected' : '' }}>⏰ Early Out</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                </select>
                                
                                <select name="stay_type" class="form-select" onchange="this.form.submit()" 
                                        style="border-color: #0b573d; font-weight: 500; min-width: 160px;">
                                    <option value="">All Stay Types</option>
                                    <option value="overnight" {{ request('stay_type') == 'overnight' ? 'selected' : '' }}>🌙 Overnight</option>
                                    <option value="one_day" {{ request('stay_type') == 'one_day' ? 'selected' : '' }}>☀️ Day Stay</option>
                                </select>
                                
                                <button type="button" class="btn btn-success px-4 py-2" 
                                        data-bs-toggle="modal" data-bs-target="#qrScannerModal"
                                        style="background-color: #0b573d; white-space: nowrap;">
                                    <i class="fas fa-qrcode me-2"></i>Open QR Scanner
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Search Row -->
                    <div class="d-flex justify-content-end">
                        <div class="position-relative" style="width: 400px;">
                            <input type="text" name="search" id="searchInputDesktop" class="form-control form-control-lg pe-5" 
                                placeholder="Search reservations..." value="{{ request('search') }}"
                                style="border-color: #0b573d; font-weight: 500; height: 48px;">
                            <button type="button" id="searchButtonDesktop" class="btn position-absolute top-50 end-0 translate-middle-y me-2" 
                                    style="background: none; border: none; color: #0b573d; z-index: 10;">
                                <i class="fas fa-search fs-5"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tablet Layout (md to lg) -->
                <div class="d-none d-md-block d-lg-none">
                    <div class="row g-3">
                        <!-- Title Row -->
                        <div class="col-12 text-center">
                            <h2 class="fw-bold text-black mb-0 border-bottom" style="font-size: 2.2rem;">ONLINE RESERVATION</h2>
                        </div>
                        
                        <!-- Filters Row -->
                        <div class="col-12">
                            <form action="{{ route('staff.reservation') }}" method="GET" id="filterForm">
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                
                                <div class="row g-3">
                                    <!-- Filters -->
                                    <div class="col-md-5">
                                        <select class="form-select {{ request('status', 'pending') == 'pending' ? 'status-filter-active' : '' }}" 
                                                name="status" onchange="this.form.submit()" 
                                                style="border-color: #0b573d; font-weight: 500;">
                                            <option value="pending" {{ (!request('status') || request('status') == 'pending') ? 'selected' : '' }}>📋 Pending ({{ $pendingCount ?? 0 }})</option>
                                            <option value="on-hold" {{ request('status') == 'on-hold' ? 'selected' : '' }}>⏸️ On-Hold ({{ $OnHoldCount ?? 0 }})</option>
                                            <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>📅 Reserved ({{ $reservedCount ?? 0 }})</option>
                                            <option value="checked-in" {{ request('status') == 'checked-in' ? 'selected' : '' }}>🏨 Checked-in ({{ $checkedInCount ?? 0 }})</option>
                                            <option value="checked-out" {{ request('status') == 'checked-out' ? 'selected' : '' }}>✅ Checked-out ({{ $checkedOutCount ?? 0 }})</option>
                                            <option value="early-checked-out" {{ request('status') == 'early-checked-out' ? 'selected' : '' }}>⏰ Early Out</option>
                                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <select name="stay_type" class="form-select" onchange="this.form.submit()" 
                                                style="border-color: #0b573d; font-weight: 500;">
                                            <option value="">All Stay Types</option>
                                            <option value="overnight" {{ request('stay_type') == 'overnight' ? 'selected' : '' }}>🌙 Overnight</option>
                                            <option value="one_day" {{ request('stay_type') == 'one_day' ? 'selected' : '' }}>☀️ Day Stay</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-success w-100" 
                                                data-bs-toggle="modal" data-bs-target="#qrScannerModal"
                                                style="background-color: #0b573d;">
                                            <i class="fas fa-qrcode me-2"></i>QR Scanner
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Search Row -->
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <div class="position-relative" style="max-width: 400px; width: 100%;">
                                    <input type="text" name="search" id="searchInputTablet" class="form-control form-control-lg pe-5" 
                                        placeholder="Search reservations..." value="{{ request('search') }}"
                                        style="border-color: #0b573d; font-weight: 500;">
                                    <button type="button" id="searchButtonTablet" class="btn position-absolute top-50 end-0 translate-middle-y me-2" 
                                            style="background: none; border: none; color: #0b573d; z-index: 10;">
                                        <i class="fas fa-search fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Layout (sm and below) -->
                <div class="d-block d-md-none">
                    <div class="d-flex flex-column gap-3">
                        <!-- Title -->
                        <div class="text-center">
                            <h2 class="fw-bold text-black mb-0 border-bottom" style="font-size: 1.8rem;">ONLINE RESERVATION</h2>
                        </div>
                        
                        <form action="{{ route('staff.reservation') }}" method="GET" id="filterForm">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            
                            <!-- Status Filter -->
                            <div class="mb-3">
                                <select class="form-select {{ request('status', 'pending') == 'pending' ? 'status-filter-active' : '' }}" 
                                        name="status" onchange="this.form.submit()" 
                                        style="border-color: #0b573d; font-weight: 500;">
                                    <option value="pending" {{ (!request('status') || request('status') == 'pending') ? 'selected' : '' }}>📋 Pending ({{ $pendingCount ?? 0 }})</option>
                                    <option value="on-hold" {{ request('status') == 'on-hold' ? 'selected' : '' }}>⏸️ On-Hold ({{ $OnHoldCount ?? 0 }})</option>
                                    <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>📅 Reserved ({{ $reservedCount ?? 0 }})</option>
                                    <option value="checked-in" {{ request('status') == 'checked-in' ? 'selected' : '' }}>🏨 Checked-in ({{ $checkedInCount ?? 0 }})</option>
                                    <option value="checked-out" {{ request('status') == 'checked-out' ? 'selected' : '' }}>✅ Checked-out ({{ $checkedOutCount ?? 0 }})</option>
                                    <option value="early-checked-out" {{ request('status') == 'early-checked-out' ? 'selected' : '' }}>⏰ Early Out</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                </select>
                            </div>
                            
                            <!-- Stay Type and QR Button Row -->
                            <div class="d-flex gap-2 mb-3">
                                <select name="stay_type" class="form-select flex-grow-1" onchange="this.form.submit()" 
                                        style="border-color: #0b573d; font-weight: 500;">
                                    <option value="">All Stay Types</option>
                                    <option value="overnight" {{ request('stay_type') == 'overnight' ? 'selected' : '' }}>🌙 Overnight</option>
                                    <option value="one_day" {{ request('stay_type') == 'one_day' ? 'selected' : '' }}>☀️ Day Stay</option>
                                </select>
                                
                                <button type="button" class="btn btn-success px-3" 
                                        data-bs-toggle="modal" data-bs-target="#qrScannerModal"
                                        style="background-color: #0b573d; white-space: nowrap;">
                                    <i class="fas fa-qrcode"></i>
                                </button>
                            </div>
                        </form>
                        
                        <!-- Search -->
                        <div class="d-flex justify-content-end">
                            <div class="position-relative" style="width: 100%;">
                                <input type="text" name="search" id="searchInputMobile" class="form-control pe-5" 
                                    placeholder="Search reservations..." value="{{ request('search') }}"
                                    style="border-color: #0b573d; font-weight: 500;">
                                <button type="button" id="searchButtonMobile" class="btn position-absolute top-50 end-0 translate-middle-y me-2" 
                                        style="background: none; border: none; color: #0b573d; z-index: 10;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <!-- Table -->
                    <div class="card shadow-sm border-0 rounded-4 mb-4 mt-4 p-2">
                        <div style="overflow-x: auto;">
                            <table class="table table-hover table-striped table-responsive table-sm">
                                <thead style="background-color: #0b573d; color: white;">
                                    <tr>
                                        <th class="text-center align-middle">ResID</th>
                                        <th class="text-center align-middle">Name</th>
                                        <th class="text-center align-middle">Phone Number</th>
                                        <th class="text-center align-middle">Room</th>
                                        <th class="text-center align-middle">Room Qty</th>
                                        <th class="text-center align-middle">Ref Num</th>
                                        <th class="text-center align-middle">Amount</th>
                                        <th class="text-center align-middle">Balance</th>
                                        <th class="text-center align-middle">Stay Type</th>
                                        <th class="text-center align-middle">Reservation Status</th>
                                        <th class="text-center align-middle">Payment Status</th>
                                        <th class="text-center align-middle">Proof of Payment</th>
                                        <th class="text-center align-middle">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reservations as $reservation)
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
                                                @php
                                                    // Use the same logic as the controller to determine stay type
                                                    $checkInDate = \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('Y-m-d');
                                                    $checkOutDate = \Carbon\Carbon::parse($reservation->reservation_check_out_date)->format('Y-m-d');
                                                    
                                                    if ($checkInDate === $checkOutDate) {
                                                        $stayType = 'one_day';
                                                        $displayStayType = 'Day Stay';
                                                        $icon = '☀️';
                                                    } else {
                                                        $stayType = 'overnight';
                                                        $displayStayType = 'Overnight';
                                                        $icon = '🌙';
                                                    }
                                                @endphp
                                                <span class="badge rounded-pill" style="background-color: #e8f5e9; color: #0b573d;">
                                                    {{ $icon }} {{ $displayStayType }}
                                                </span>
                                            </td>

                                            <td class="text-center align-middle">
                                                @if($reservation->reservation_status == 'pending')
                                                <span class="badge rounded-pill py-2 px-2 bg-warning" style="font-size: .7rem;">
                                                    Pending
                                                    <i class="fas fa-clock ms-1"></i>
                                                </span>
                                                @elseif($reservation->reservation_status == 'reserved')
                                                <span class="badge rounded-pill py-2 px-2 bg-primary" style="font-size: .7rem;">
                                                    Reserved
                                                    <i class="fas fa-bookmark ms-1"></i>
                                                </span>
                                                @elseif($reservation->reservation_status == 'checked-in')
                                                <span class="badge rounded-pill py-2 px-2 bg-success" style="font-size: .7rem;">
                                                    Checked-in
                                                    <i class="fas fa-user-check ms-1"></i>
                                                </span>
                                                @elseif($reservation->reservation_status == 'checked-out')
                                                <span class="badge rounded-pill py-2 px-2 bg-info" style="font-size: .7rem;">
                                                    Checked-out
                                                    <i class="fas fa-sign-out-alt ms-1"></i>
                                                </span>
                                                @elseif($reservation->reservation_status == 'cancelled')
                                                <span class="badge rounded-pill py-2 px-2 bg-danger" style="font-size: .7rem;">
                                                    Cancelled
                                                    <i class="fas fa-times ms-1"></i>
                                                </span>
                                                @else
                                                <span class="badge rounded-pill py-2 px-2 bg-secondary" style="font-size: .7rem;">
                                                    {{ ucfirst($reservation->reservation_status) }}
                                                </span>
                                                @endif
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
                                                @if ($reservation->upload_payment && file_exists(public_path('storage/payments/' . basename($reservation->upload_payment))))
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#paymentProofModal{{ $reservation->id }}">
                                                        <img src="{{ asset('storage/payments/' . basename($reservation->upload_payment)) }}" alt="Proof of Payment" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;">
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

                                        <!-- Payment Proof Modal -->
                                        @if ($reservation->upload_payment)
                                        <div class="modal fade" id="paymentProofModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="paymentProofModalLabel{{ $reservation->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content border-0 shadow-lg rounded-4">
                                                    <div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #0b573d, #198754);">
                                                        <h5 class="modal-title fw-bold" id="paymentProofModalLabel{{ $reservation->id }}">
                                                            <i class="fas fa-receipt me-2"></i>Payment Proof for Reservation #{{ $reservation->reservation_id }}
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4 text-center" style="background-color: #f8f9fa;">
                                                        <img src="{{ asset('storage/payments/' . basename($reservation->upload_payment)) }}" alt="Proof of Payment" class="img-fluid rounded shadow-sm" style="max-height: 75vh; object-fit: contain; border: 3px solid white;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
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
                                    @empty
                                        <tr>
                                            <td colspan="13" class="text-center py-5">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="fas fa-calendar-times fs-1 text-muted mb-3"></i>
                                                    <h5 class="text-muted">No Reservations Found</h5>
                                                    <p class="text-muted">There are no reservations.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 px-3">
                        <!-- Pagination Info -->
                        <div class="text-muted small mb-2 mb-md-0">
                            @if($reservations->total() > 0)
                                Showing <strong>{{ $reservations->firstItem() }}</strong> to <strong>{{ $reservations->lastItem() }}</strong> of <strong>{{ $reservations->total() }}</strong> entries
                            @else
                                No entries found
                            @endif
                        </div>

                        <!-- Custom Pagination -->
                        @if ($reservations->hasPages())
                            <nav>
                                <ul class="pagination pagination-sm mb-0">
                                    {{-- Previous Page Link --}}
                                    <li class="page-item {{ $reservations->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $reservations->appends(request()->query())->previousPageUrl() }}" aria-label="Previous" style="color: #0b573d;">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>

                                    {{-- Pagination Elements --}}
                                    @foreach ($reservations->links()->elements as $element)
                                        @if (is_string($element))
                                            <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                                        @endif
                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $reservations->currentPage())
                                                    <li class="page-item active"><span class="page-link" style="background-color: #0b573d; border-color: #0b573d;">{{ $page }}</span></li>
                                                @else
                                                    <li class="page-item"><a class="page-link" href="{{ $reservations->appends(request()->query())->url($page) }}" style="color: #0b573d;">{{ $page }}</a></li>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    <li class="page-item {{ !$reservations->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $reservations->appends(request()->query())->nextPageUrl() }}" aria-label="Next" style="color: #0b573d;">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-4"></div>
    </div>
</div>

<!-- QR Scanner Modal -->
<div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="background: white; border-radius: 20px;">
            <!-- Header -->
            <div class="modal-header border-0 text-white position-relative" style="background: linear-gradient(135deg, #0b573d, #0d6b47); backdrop-filter: blur(10px); border-radius: 20px 20px 0 0;">
                <div class="d-flex align-items-center">
                    <div class="scanner-icon-container me-3">
                        <i class="fas fa-qrcode fs-2 text-warning"></i>
                    </div>
                    <div>
                        <h4 class="modal-title fw-bold mb-0" id="qrScannerModalLabel">QR Code Scanner</h4>
                        <small class="text-light opacity-75">Scan reservation QR codes</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white opacity-75" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Body -->
            <div class="modal-body p-4" style="background: white;">
                <!-- Scanner Container -->
                <div class="scanner-container position-relative mb-4">
                    <div class="scanner-frame position-relative">
                        <!-- Video Preview -->
                        <video id="preview" class="w-100 rounded-3 shadow-sm" 
                               style="height: 350px; object-fit: cover; background: #1a1a1a; border: 3px solid rgba(0,0,0,0.1);">
                        </video>
                        
                        <!-- Scanner Overlay -->
                        <div class="scanner-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                            <!-- Scanning Frame -->
                            <div class="scanning-frame position-relative">
                                <div class="scan-corners">
                                    <div class="corner corner-tl"></div>
                                    <div class="corner corner-tr"></div>
                                    <div class="corner corner-bl"></div>
                                    <div class="corner corner-br"></div>
                                </div>
                                <!-- Scanning Line -->
                                <div class="scan-line"></div>
                            </div>
                        </div>
                        
                        <!-- Status Indicator -->
                        <div class="scanner-status position-absolute top-0 end-0 m-3">
                            <div class="status-indicator" id="scannerStatus">
                                <i class="fas fa-circle text-danger me-2"></i>
                                <span class="text-white small fw-semibold">Camera Off</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Controls -->
                <div class="scanner-controls text-center mb-4">
                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" id="toggleCamera" class="btn btn-success btn-lg px-4 py-2 shadow-sm">
                            <i class="fas fa-camera me-2 text-white"></i>
                            <span class="fw-semibold">Start Scanner</span>
                        </button>
                        <button type="button" id="stopScanner" class="btn btn-outline-danger btn-lg px-4 py-2" style="display: none;">
                            <i class="fas fa-stop me-2"></i>
                            <span class="fw-semibold">Stop Scanner</span>
                        </button>
                    </div>
                </div>
                
                <!-- Instructions -->
                <div class="scanner-instructions text-center mb-4">
                    <div class="alert alert-light border shadow-sm" style="background: #f8f9fa;">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-info-circle text-primary me-3 fs-5"></i>
                            <div class="text-start">
                                <strong class="text-dark">How to scan:</strong>
                                <p class="mb-0 text-muted small">Position the QR code within the scanning frame above. The scanner will automatically detect and process the code.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Scanner Styles -->
<style>
    /* Scanner Frame Styles */
    .scanner-frame {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .scanner-overlay {
        pointer-events: none;
        border-radius: 12px;
    }
    
    /* Scanning Frame */
    .scanning-frame {
        width: 250px;
        height: 250px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 15px;
    }
    
    /* Corner Indicators */
    .scan-corners .corner {
        position: absolute;
        width: 30px;
        height: 30px;
        border: 3px solid #ffc107;
    }
    
    .corner-tl {
        top: -2px;
        left: -2px;
        border-right: none;
        border-bottom: none;
        border-radius: 15px 0 0 0;
    }
    
    .corner-tr {
        top: -2px;
        right: -2px;
        border-left: none;
        border-bottom: none;
        border-radius: 0 15px 0 0;
    }
    
    .corner-bl {
        bottom: -2px;
        left: -2px;
        border-right: none;
        border-top: none;
        border-radius: 0 0 0 15px;
    }
    
    .corner-br {
        bottom: -2px;
        right: -2px;
        border-left: none;
        border-top: none;
        border-radius: 0 0 15px 0;
    }
    
    /* Scanning Line Animation */
    .scan-line {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #ffc107, transparent);
        animation: scanLine 2s linear infinite;
        opacity: 0.8;
    }
    
    @keyframes scanLine {
        0% {
            top: 0;
            opacity: 1;
        }
        50% {
            opacity: 1;
        }
        100% {
            top: 100%;
            opacity: 0;
        }
    }
    
    /* Status Indicator */
    .status-indicator {
        background: rgba(0, 0, 0, 0.7);
        padding: 8px 12px;
        border-radius: 20px;
        backdrop-filter: blur(10px);
    }
    
    /* Scanner Controls */
    .scanner-controls .btn {
        border-radius: 25px;
        transition: all 0.3s ease;
        font-weight: 600;
    }
    
    .scanner-controls .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }
    
    /* Results Container */
    .result-container {
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }
    
    .result-display {
        min-height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    /* Success Animation */
    .scan-success {
        animation: scanSuccess 0.6s ease-in-out;
    }
    
    @keyframes scanSuccess {
        0% {
            background: rgba(255, 255, 255, 0.1);
        }
        50% {
            background: rgba(40, 167, 69, 0.3);
            transform: scale(1.02);
        }
        100% {
            background: rgba(255, 255, 255, 0.1);
        }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .scanning-frame {
            width: 200px;
            height: 200px;
        }
        
        .scanner-controls .btn {
            padding: 10px 20px;
            font-size: 14px;
        }
    }
</style>

<script>
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    let isCameraOn = false;
    let cameras = [];

    // Initialize cameras when page loads
    Instascan.Camera.getCameras().then(function (availableCameras) {
        cameras = availableCameras;
        if (cameras.length === 0) {
            swal("Error", "No cameras found.", "error");
        }
    }).catch(function (e) {
        console.error(e);
        swal("Error", "An error occurred while accessing the cameras.", "error");
    });

    scanner.addListener('scan', function (content) {
        try {
            console.log('Scanned content:', content);
            
            // Extract reservation ID from the QR content
            let reservationId = null;
            
            // Method 1: Direct match for reservation ID pattern (RES followed by numbers)
            const reservationPattern = /RES\d{4,}/i;
            const directMatch = content.match(reservationPattern);
            
            if (directMatch) {
                reservationId = directMatch[0].toUpperCase();
            } else {
                // Method 2: Look for reservation ID in structured text
                const lines = content.split('\n');
                for (let line of lines) {
                    // Check if line contains "Reservation ID:" or similar
                    if (line.toLowerCase().includes('reservation') && line.toLowerCase().includes('id')) {
                        const match = line.match(/RES\d{4,}/i);
                        if (match) {
                            reservationId = match[0].toUpperCase();
                            break;
                        }
                    }
                    // Also check for just the reservation ID pattern in any line
                    const lineMatch = line.match(/RES\d{4,}/i);
                    if (lineMatch) {
                        reservationId = lineMatch[0].toUpperCase();
                        break;
                    }
                }
            }
            
            if (reservationId) {
                // Update QR result display - with null check
                const qrResultElement = document.getElementById("qrResult");
                if (qrResultElement) {
                    qrResultElement.innerText = reservationId;
                }
                
                // Set the reservation ID in ALL search inputs across different layouts
                const allSearchInputs = [
                    document.getElementById("searchInputDesktop"),
                    document.getElementById("searchInputTablet"),
                    document.getElementById("searchInputMobile")
                ];
                
                allSearchInputs.forEach(input => {
                    if (input) {
                        input.value = reservationId;
                    }
                });
                
                // Stop scanner and close modal
                stopScanner();
                $('#qrScannerModal').modal('hide');
                
                // Show success message and automatically search
                swal("QR Code Scanned!", "Searching for Reservation ID: " + reservationId, "success").then(() => {
                    // Automatically trigger search after success message
                    performQRSearch(reservationId);
                });
            } else {
                swal("Error", "No reservation ID found in QR code", "error");
                console.log('QR Content for debugging:', content);
            }
        } catch (e) {
            console.error('Error processing QR code:', e);
            swal("Error", "Failed to process QR code", "error");
        }
    });

    // Fixed: Add event listeners to buttons with proper event handling
    document.addEventListener('DOMContentLoaded', function() {
        // Handle search input functionality for all layouts
        const searchInputs = [
            { input: document.getElementById('searchInputDesktop'), button: document.getElementById('searchButtonDesktop') },
            { input: document.getElementById('searchInputTablet'), button: document.getElementById('searchButtonTablet') },
            { input: document.getElementById('searchInputMobile'), button: document.getElementById('searchButtonMobile') }
        ];

        searchInputs.forEach(({ input, button }) => {
            if (input) {
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        performSearch(this.value);
                    }
                });

                // Add search button functionality
                input.addEventListener('input', function() {
                    // Optional: Add debounced search functionality here
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(() => {
                        if (this.value.length >= 3 || this.value.length === 0) {
                            performSearch(this.value);
                        }
                    }, 500);
                });
            }

            // Add click event for search button
            if (button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (input) {
                        performSearch(input.value);
                    }
                });
            }
        });

        function performSearch(searchValue) {
            const currentUrl = new URL(window.location);
            
            if (searchValue.trim() === '') {
                currentUrl.searchParams.delete('search');
            } else {
                currentUrl.searchParams.set('search', searchValue);
            }
            
            window.location.href = currentUrl.toString();
        }

        // Special function for QR search with result checking
        window.performQRSearch = function(reservationId) {
            const currentUrl = new URL(window.location);
            
            // Clear ALL filters to search across entire database
            currentUrl.searchParams.delete('status');
            currentUrl.searchParams.delete('stay_type');
            currentUrl.searchParams.delete('page'); // Reset pagination to page 1
            
            // Set search parameter to find the specific reservation
            currentUrl.searchParams.set('search', reservationId);
            
            // Navigate to search results - this will search ALL reservations globally
            window.location.href = currentUrl.toString();
        }
        
        // Toggle Camera Button Event Listener
        const toggleCameraBtn = document.getElementById('toggleCamera');
        if (toggleCameraBtn) {
            toggleCameraBtn.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation(); // Prevent event bubbling
                
                if (cameras.length === 0) {
                    swal("Error", "No cameras available.", "error");
                    return;
                }
                
                if (isCameraOn) {
                    stopScanner();
                } else {
                    startScanner();
                }
            });
        }

        // Stop Scanner Button Event Listener  
        const stopScannerBtn = document.getElementById('stopScanner');
        if (stopScannerBtn) {
            stopScannerBtn.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation(); // Prevent event bubbling
                stopScanner();
            });
        }
    });

    // Start scanner function
    function startScanner() {
        if (cameras.length > 0) {
            scanner.start(cameras[0]).then(() => {
                isCameraOn = true;
                const toggleBtn = document.getElementById("toggleCamera");
                const stopBtn = document.getElementById("stopScanner");
                
                if (toggleBtn) toggleBtn.style.display = 'none';
                if (stopBtn) stopBtn.style.display = 'block';
                
                // Update status indicator
                updateScannerStatus('active', 'Camera Active', 'text-success');
                
                // Update result status
                updateResultStatus('scanning', 'Scanning...', 'bg-primary');
            }).catch((err) => {
                console.error('Error starting scanner:', err);
                swal("Error", "Failed to start camera.", "error");
                updateScannerStatus('error', 'Camera Error', 'text-danger');
            });
        }
    }

    // Stop scanner function
    function stopScanner() {
        scanner.stop();
        isCameraOn = false;
        const toggleBtn = document.getElementById("toggleCamera");
        const stopBtn = document.getElementById("stopScanner");
        
        if (toggleBtn) toggleBtn.style.display = 'block';
        if (stopBtn) stopBtn.style.display = 'none';
        
        // Update status indicator
        updateScannerStatus('inactive', 'Camera Off', 'text-danger');
        
        // Update result status
        updateResultStatus('ready', 'Ready to scan', 'bg-secondary');
    }

    // Update scanner status indicator
    function updateScannerStatus(status, text, colorClass) {
        const statusElement = document.getElementById('scannerStatus');
        if (statusElement) {
            const icon = statusElement.querySelector('i');
            const span = statusElement.querySelector('span');
            
            if (icon && span) {
                // Remove existing color classes
                icon.className = 'fas fa-circle me-2';
                icon.classList.add(colorClass);
                span.textContent = text;
            }
        }
    }

    // Update result status badge
    function updateResultStatus(status, text, badgeClass) {
        const resultStatus = document.getElementById('resultStatus');
        if (resultStatus) {
            const badge = resultStatus.querySelector('.badge');
            if (badge) {
                // Remove existing badge classes
                badge.className = 'badge';
                badge.classList.add(badgeClass);
                badge.textContent = text;
            }
        }
    }

    // Auto-stop scanner when modal is closed
    $('#qrScannerModal').on('hidden.bs.modal', function () {
        if (isCameraOn) {
            stopScanner();
        }
    });

    // Reset camera state when modal is opened
    $('#qrScannerModal').on('shown.bs.modal', function () {
        // Reset QR result display
        const qrResultElement = document.getElementById("qrResult");
        if (qrResultElement) {
            qrResultElement.innerText = "No QR code scanned yet";
        }
        
        // Reset status indicators
        updateScannerStatus('inactive', 'Camera Off', 'text-danger');
        updateResultStatus('ready', 'Ready to scan', 'bg-secondary');
        
        // Ensure buttons are in correct state
        const toggleBtn = document.getElementById("toggleCamera");
        const stopBtn = document.getElementById("stopScanner");
        
        if (toggleBtn) toggleBtn.style.display = 'block';
        if (stopBtn) stopBtn.style.display = 'none';
        isCameraOn = false;
    });
</script>

</body>
</html>