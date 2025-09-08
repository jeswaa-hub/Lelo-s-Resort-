<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        h1,
        h5 {
            font-family: 'Anton', sans-serif;
        }

        body,
        p,
        h6,
        li,
        span {
            font-family: 'Montserrat', sans-serif;
        }

        /* Ensure the burger menu button is always on the right for mobile */
        @media (max-width: 767.98px) {
            #sidebarToggle {
                position: fixed;
                top: 1rem;
                right: 1rem;
                z-index: 1050;
            }

            #profileSidebar {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background-color: #0b573d;
                overflow-y: auto;
                z-index: 1040;
                transition: transform 0.3s ease-in-out;
                transform: translateX(-100%);
                display: block !important;
            }

            #profileSidebar.show {
                transform: translateX(0);
            }

            .row.g-0 {
                margin-left: 0 !important;
                flex-direction: column;
            }

            #mainContent {
                width: 100%;
                position: relative;
                height: auto;
                background: inherit;
            }

            body.sidebar-open #mainContent {
                margin-top: 1rem;
            }
        }

        }

        @media (max-width: 767.98px) {
            .col-12 {
                position: static !important;
                height: auto !important;
            }

            .offset-md-4 {
                margin-left: 0 !important;
            }

            .offset-lg-3 {
                margin-left: 0 !important;
            }

            .px-5 {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }

            /* Styling for mobile sidebar */
            #profileSidebar {
                position: relative;
                width: 100%;
                height: auto;
                min-height: auto;
                overflow-y: hidden;
                display: none;
                background-color: #0b573d;
            }

            #profileSidebar.show {
                display: block;
            }

            /* Main content styling for mobile */
            #mainContent {
                width: 100%;
                position: relative;
                height: auto;
                background: inherit;
            }

            /* Remove any transitions or transformations */
            body.sidebar-open #mainContent {
                margin-top: 1rem;
            }

            /* Ensure no blank space */
            .row.g-0 {
                margin-left: 0 !important;
                flex-direction: column;
            }
        }

        @media (min-width: 768px) {
            #desktopSidebarToggle {
                position: relative;
                z-index: 1050;
            }
        }

        @media (min-width: 768px) {
            #profileSidebar {
                transform: none !important;
            }

            /* Reset order for desktop view */
            .order-md-1 {
                order: 1 !important;
            }

            .order-md-2 {
                order: 2 !important;
            }
        }

        .current-reservation {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 1rem 2rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            color: #0b573d;
            font-family: 'Poppins', sans-serif;
        }

        .current-reservation table {
            width: 100%;
            border-collapse: collapse;
        }

        .current-reservation th,
        .current-reservation td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .current-reservation th {
            font-weight: 700;
            text-transform: uppercase;
            border-bottom: 2px solid #0b573d;
            letter-spacing: 0.1em;
        }

        #profileSidebar.collapsed {
            width: 0;
            overflow: hidden;
            transition: width 0.3s ease;
        }

        @media (min-width: 768px) and (max-width: 991.98px) {
            #reservation-list-section .row.align-items-center>div.col-md-2 {
                flex: 0 0 100% !important;
                max-width: 50% !important;
                margin-bottom: 0.5rem;
            }

            #reservation-list-section .row.align-items-center>div.col-md-2.d-grid.text-end {
                text-align: left !important;
            }
        }

        #desktopSidebarToggle.collapsed {
            position: fixed;
            top: 1.5rem;
            left: 0rem;
            z-index: 1050;
            background-color: transparent !important;
            color: white !important;
            border: none !important;
            padding: 10px 15px !important;
            border-radius: 4px;
        }

        /* Custom animations and hover effects */
        .modal-content {
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }

        #download-qr:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(11, 87, 61, 0.3);
        }

        .badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }

            100% {
                opacity: 1;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .modal-dialog {
                margin: 0.5rem;
            }

            .modal-header {
                padding: 1.5rem 1rem 0.5rem;
            }

            .card-body {
                padding: 1rem;
            }
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        /* Payment button hover effect */
        .btn:hover {
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }

        /* Custom animations and hover effects */
        .modal-content {
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }

        #download-qr:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(11, 87, 61, 0.3);
        }

        .badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }

            100% {
                opacity: 1;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .modal-dialog {
                margin: 0.5rem;
            }

            .modal-header {
                padding: 1.5rem 1rem 0.5rem;
            }

            .card-body {
                padding: 1rem;
            }
        }
    </style>
</head>

<body
    style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
    @include('Alert.infoNotif')
    <x-loading-screen />

    <!-- Flash Messages -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <!-- Error Messages -->
        @if ($errors->any())
            <div class="toast show align-items-center text-white bg-danger border-0 mb-2" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Please fix these errors:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        @endif

        <!-- Success Message -->
        @if (session('success'))
            <div class="toast show align-items-center text-white bg-success border-0" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>{{ session('success') }}</strong>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header border-0" style="background-color: #0b573d;">
                    <h5 class="modal-title text-white text-uppercase"
                        style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;" id="editModalLabel">Edit
                        Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('editProfile', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="image" class="form-label text-uppercase fw-bold" style="color: #0b573d;">Profile
                                Picture</label>
                            <div class="row g-3 align-items-center">
                                <div class="col-12 col-md-8">
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="image" id="image"
                                            accept="image/*">
                                    </div>
                                </div>
                                @if ($user->image)
                                    <div class="col-12 col-md-4">
                                        <div class="d-flex justify-content-center justify-content-md-start">
                                            <img src="{{ asset('storage/' . $user->image) }}" alt="Profile Image"
                                                class="img-fluid rounded shadow-sm"
                                                style="width: 100%; height: 120px; object-fit: cover;" required>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                </div>
                <div class="mb-4">

                    <label for="name" class="form-label text-uppercase fw-bold" style="color: #0b573d;">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label text-uppercase fw-bold" style="color: #0b573d;">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                        required>
                </div>
                <div class="mb-2">
                    <div class="mb-3">
                        <label for="mobileNo" class="form-label text-uppercase fw-bold" style="color: #0b573d;">Mobile
                            Number</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="mobileNo" name="mobileNo"
                                value="{{ substr($user->mobileNo, 0, 11) }}" required maxlength="11"
                                onkeypress="return (event.charCode >= 48 && event.charCode <= 57) && event.charCode != 45;"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 11);"
                                pattern="[0-9]{11}" title="Please enter a valid 11-digit mobile number (numbers only)">
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="address" class="form-label text-uppercase fw-bold"
                        style="color: #0b573d;">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}"
                        required>
                </div>
                <button type="submit" class="btn text-white w-100" style="background-color: #0b573d;">Save
                    changes</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Main Layout: Profile & Reservation Section -->
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Burger Menu Button (Visible only on mobile) -->
            <div class="d-md-none position-fixed top-0 end-0 p-3" style="z-index: 1030;">
                <button class="btn btn-success" type="button" id="sidebarToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            <!-- Profile Card -->
            <div class="col-12 col-md-4 col-lg-3" id="profileSidebar"
                style="background-color: #0b573d; min-height: 100vh; z-index: 1020;">
                <div class="p-4 text-white d-flex flex-column">
                    <!-- Back Arrow -->
                    <!-- Modify the toggle button container to use flex with justify-content-between -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        @if(!empty($user->mobileNo) && strlen($user->mobileNo) >= 11)
                            <!-- Allow navigation if mobile number exists and is valid -->
                            <a href="{{ route('homepage') }}" class="text-decoration-none">
                                <i class="text-white fa-2x fa-house fa-solid"></i>
                            </a>
                        @else
                            <!-- Disable navigation if no mobile number -->
                            <span class="text-muted" style="cursor: not-allowed;" onclick="showMobileRequiredAlert()"
                                title="Please add your mobile number first">
                                <i class="fa-2x fa-house fa-solid" style="opacity: 0.5;"></i>
                            </span>
                        @endif

                        <button id="desktopSidebarToggle" class="btn btn-xl btn-light d-none d-md-block"
                            style="background-color: #0b573d; color: white; border: none; padding: 15px 20px;">
                            <i class="fa-solid fa-bars fa-2x"></i>
                        </button>
                    </div>

                    <!-- Profile Image -->
                    <div class="text-center mb-3">
                        <div class="rounded-circle border border-white overflow-hidden mx-auto"
                            style="width: 150px; height: 150px;">
                            <img src="{{ $user->image ? url('storage/' . $user->image) : asset('images/default-profile.jpg') }}"
                                alt="Profile Image" class="img-fluid rounded-circle w-100 h-100 object-fit-cover">
                        </div>
                        <!-- Edit Button -->
                        <div class="mt-2">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#editModal" class="text-decoration-none">
                                <u class="text-white">Edit Profile</u>
                            </a>
                        </div>
                    </div>

                    <div class="mb-1">
                        <hr style="height: 2px; background-color: white; opacity: 0.8;">
                    </div>

                    <div class="text-center mb-4">
                        <h4 class="text-uppercase fw-bold">Personal Details</h4>
                    </div>

                    <div class="mt-2">
                        <div class="d-flex mb-3">
                            <div style="width: 30px;">
                                <i class="fa-solid fa-envelope fa-lg"></i>
                            </div>
                            <span class="text-break ms-3"
                                style="font-size: clamp(0.875rem, 2vw, 1rem);">{{ $user->email }}</span>
                        </div>
                        <div class="d-flex mb-3">
                            <div style="width: 30px;">
                                <i class="fa-solid fa-phone fa-lg"></i>
                            </div>
                            <span class="ms-3"
                                style="font-size: clamp(0.875rem, 2vw, 1rem);">{{ $user->mobileNo }}</span>
                        </div>
                        <div class="d-flex mb-3">
                            <div style="width: 30px;">
                                <i class="fa-solid fa-location-dot fa-lg"></i>
                            </div>
                            <span class="text-break ms-3"
                                style="font-size: clamp(0.875rem, 2vw, 1rem);">{{ $user->address }}</span>
                        </div>
                    </div>

                    <!-- Buttons: Logout -->
                    <div class="mt-5 text-end">
                        <a href="{{ route('logout.user') }}" class="text-decoration-none text-white">
                            Log Out <i class="fa-solid fa-right-from-bracket ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-12 col-md-8 col-lg-9 px-5 py-3" id="mainContent">
                <div>
                    <p class="fw-bold text-start display-4"><span class="text-white fs-1">Hello,<br></span><span
                            class="text-color-2">{{ $user->name }}</span></p>
                </div>

                <div id="dateTimeDisplay" class="position-absolute mt-0 end-0 p-2 pe-5 text-end d-none d-lg-block"
                    style="top: 4rem; z-index: 100; font-family: 'Montserrat', sans-serif;">
                    <div id="time" class="fw-bold fs-1"></div>
                    <div id="date" class="fs-5"></div>
                </div>

                <div class="current-reservation">
                    <h2 class="fw-bold" style="color: #0b573d;">CURRENT RESERVATION</h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" style="color: #0b573d;">Room Type</th>
                                    <th scope="col" style="color: #0b573d;">Reservation Type</th>
                                    <th scope="col" style="color: #0b573d;">Check IN</th>
                                    <th scope="col" style="color: #0b573d;">Check Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Reservation rows go here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="row">
                    <!-- Reservation Section -->
                    <div class="col-12 col-xl-10 mx-auto" style="max-width: 100%; width: 100%;">
                        <div class="p-3 shadow text-white background-color mt-1">
                            <!-- Navigation Tabs -->
                            <ul class="nav nav-tabs">
                                <li class="nav-item w-60">
                                    <a class="nav-link active w-100 text-center" href="#" id="reservation-tab"
                                        onclick="toggleTab(event, 'reservation-list-section', 'reservation-tab', 'history-tab')"
                                        style="background-color: #0b573d; color: white;">Reservation</a>
                                </li>
                            </ul>

                            <!-- Reservation List -->
                            <section id="reservation-list-section" class="p-3 p-md-4 w-100">
                                <h5 class="mb-4 text-color-2 border-bottom pb-2"
                                    style="color: #0b573d; letter-spacing: 0.2em;">RESERVATION</h5>
                                @if ($latestReservation && $latestReservation->reservation_status !== 'cancelled')
                                    <div class="card shadow-sm border-0 w-100"
                                        style="background-color: rgba(255, 255, 255, 0.9);">
                                        <div class="card-body p-3 p-md-4">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-3 fw-semibold text-success">Room Type</div>
                                                <div class="col-12 col-md-5 text-success">
                                                    @foreach($accommodations as $accommodation){{ $accommodation }}@endforeach
                                                </div>
                                                <div class="col-12 col-md-2 mb-2 mb-md-0">
                                                    <span class="badge text-capitalize px-3 py-2 @if($latestReservation->reservation_status == 'checked in') bg-success 
                                                    @elseif($latestReservation->reservation_status == 'pending') bg-warning 
                                                        @elseif($latestReservation->reservation_status == 'reserved') bg-primary
                                                            @else bg-danger @endif">
                                                        {{ $latestReservation->reservation_status }}
                                                    </span>
                                                </div>
                                                <div class="col-12 col-md-2 d-grid text-end">
                                                    <button type="button" class="btn btn-outline-success w-100 w-md-auto"
                                                        data-bs-toggle="modal" data-bs-target="#viewReservationModal">
                                                        View
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="viewReservationModal" tabindex="-1"
                                        aria-labelledby="viewReservationModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg">
                                                <!-- Enhanced Header -->
                                                <div class="modal-header border-0 position-relative"
                                                    style="background: linear-gradient(135deg, #0b573d 0%, #0d6b47 100%); padding: 2rem 2rem 1rem;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                                            <img src="{{ asset('images/logo2.png') }}" alt="" height="40"
                                                                width="40">
                                                        </div>
                                                        <div>
                                                            <h4 class="modal-title text-white mb-1 fw-bold"
                                                                id="viewReservationModalLabel">
                                                                Reservation Details
                                                            </h4>
                                                            <p class="text-white-50 mb-0 small">Reservation ID:
                                                                {{ $latestReservation->reservation_id ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <button type="button"
                                                        class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>

                                                    <!-- Decorative wave -->
                                                    <div class="position-absolute bottom-0 start-0 w-100"
                                                        style="height: 20px; overflow: hidden;">
                                                        <svg viewBox="0 0 1200 120" preserveAspectRatio="none"
                                                            style="height: 100%; width: 100%;">
                                                            <path
                                                                d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                                                                opacity=".25" fill="white"></path>
                                                        </svg>
                                                    </div>
                                                </div>

                                                <div class="modal-body p-0">
                                                    <!-- Reservation Type Badge -->
                                                    <div class="px-4 pt-3 pb-2">
                                                        @php
                                                            $checkInDate = \Carbon\Carbon::parse($latestReservation->reservation_check_in_date);
                                                            $checkOutDate = \Carbon\Carbon::parse($latestReservation->reservation_check_out_date);
                                                            $daysDiff = $checkInDate->diffInDays($checkOutDate);
                                                        @endphp
                                                        <div class="d-flex justify-content-center mb-3">
                                                            @if($daysDiff == 0)
                                                                <span class="badge bg-info fs-6 px-4 py-2 rounded-pill">
                                                                    <i class="fas fa-sun me-2"></i>One Day Stay
                                                                </span>
                                                            @else
                                                                <span class="badge fs-6 px-4 py-2 rounded-pill"
                                                                    style="background-color: #0b573d;">
                                                                    <i class="fas fa-bed me-2"></i>Stay In - {{ $daysDiff }}
                                                                    {{ Str::plural('Night', $daysDiff) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <!-- Main Content -->
                                                    <div class="px-4 pb-4">
                                                        <div class="row g-4">
                                                            <!-- Left Column - Booking Information -->
                                                            <div class="col-lg-6">
                                                                <div class="card border-0 shadow-sm h-100"
                                                                    style="background-color: #f8f9fa;">
                                                                    <div class="card-header border-0 bg-transparent">
                                                                        <h6 class="mb-0 fw-bold" style="color: #0b573d;">
                                                                            <i class="fas fa-info-circle me-2"></i>Booking
                                                                            Information
                                                                        </h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <!-- Check-in Time -->
                                                                        <div
                                                                            class="d-flex align-items-center mb-3 p-3 bg-white rounded-3 shadow-sm">
                                                                            <div
                                                                                class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                                                                <i class="fas fa-clock text-success"></i>
                                                                            </div>
                                                                            <div class="flex-grow-1">
                                                                                <small class="text-muted d-block">Check-in
                                                                                    Time</small>
                                                                                <strong style="color: #0b573d;">
                                                                                    {{ date('h:i A', strtotime($latestReservation->reservation_check_in)) }}
                                                                                    -
                                                                                    {{ date('h:i A', strtotime($latestReservation->reservation_check_out)) }}
                                                                                </strong>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Check-in Dates -->
                                                                        <div
                                                                            class="d-flex align-items-center mb-3 p-3 bg-white rounded-3 shadow-sm">
                                                                            <div
                                                                                class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                                                <i
                                                                                    class="fas fa-calendar-alt text-primary"></i>
                                                                            </div>
                                                                            <div class="flex-grow-1">
                                                                                <small class="text-muted d-block">Stay
                                                                                    Duration</small>
                                                                                <strong style="color: #0b573d;">
                                                                                    {{ \Carbon\Carbon::parse($latestReservation->reservation_check_in_date)->format('M j, Y') }}
                                                                                    <i
                                                                                        class="fas fa-arrow-right mx-2 text-muted"></i>
                                                                                    {{ \Carbon\Carbon::parse($latestReservation->reservation_check_out_date)->format('M j, Y') }}
                                                                                </strong>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Guest Information -->
                                                                        <div
                                                                            class="d-flex align-items-center mb-3 p-3 bg-white rounded-3 shadow-sm">
                                                                            <div
                                                                                class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                                                                <i class="fas fa-users text-warning"></i>
                                                                            </div>
                                                                            <div class="flex-grow-1">
                                                                                <small class="text-muted d-block">Total
                                                                                    Guests</small>
                                                                                <strong style="color: #0b573d;">
                                                                                    {{ $latestReservation->total_guest ?? 'N/A' }}
                                                                                    <small class="text-muted">
                                                                                        ({{ $latestReservation->number_of_adults ?? 0 }}
                                                                                        Adults,
                                                                                        {{ $latestReservation->number_of_children ?? 0 }}
                                                                                        Children)
                                                                                    </small>
                                                                                </strong>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Room Quantity -->
                                                                        <div
                                                                            class="d-flex align-items-center p-3 bg-white rounded-3 shadow-sm">
                                                                            <div
                                                                                class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                                                                <i class="fas fa-door-open text-info"></i>
                                                                            </div>
                                                                            <div class="flex-grow-1">
                                                                                <small class="text-muted d-block">Rooms
                                                                                    Reserved</small>
                                                                                <strong style="color: #0b573d;">
                                                                                    {{ $latestReservation->quantity ?? 1 }}
                                                                                    {{ Str::plural('Room', $latestReservation->quantity ?? 1) }}
                                                                                </strong>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Right Column - Additional Details -->
                                                            <div class="col-lg-6">
                                                                <div class="card border-0 shadow-sm h-100"
                                                                    style="background-color: #f8f9fa;">
                                                                    <div class="card-header border-0 bg-transparent">
                                                                        <h6 class="mb-0 fw-bold" style="color: #0b573d;">
                                                                            <i class="fas fa-file-alt me-2"></i>Additional
                                                                            Details
                                                                        </h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <!-- Special Request -->
                                                                        <div class="mb-4 p-3 bg-white rounded-3 shadow-sm">
                                                                            <div class="d-flex align-items-start">
                                                                                <div
                                                                                    class="bg-secondary bg-opacity-10 rounded-circle p-2 me-3 mt-1">
                                                                                    <i
                                                                                        class="fas fa-comment-dots text-secondary"></i>
                                                                                </div>
                                                                                <div class="flex-grow-1">
                                                                                    <small
                                                                                        class="text-muted d-block mb-1">Special
                                                                                        Request</small>
                                                                                    <div style="color: #0b573d;">
                                                                                        @if($latestReservation->special_request)
                                                                                            <p class="mb-0">
                                                                                                {{ $latestReservation->special_request }}
                                                                                            </p>
                                                                                        @else
                                                                                            <em class="text-muted">No special
                                                                                                requests</em>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Total Amount -->
                                                                        <div class="p-4 rounded-3 shadow-sm mb-3"
                                                                            style="background: linear-gradient(135deg, #0b573d 0%, #0d6b47 100%);">
                                                                            <div class="text-center text-white">
                                                                                <h3 class="mb-1 fw-bold">
                                                                                    ₱{{ number_format($latestReservation->amount, 2) }}
                                                                                </h3>
                                                                                <small class="opacity-75">Total
                                                                                    Amount</small>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Payment Button Section -->
                                                                        @if($latestReservation->reservation_status === 'on-hold')
                                                                            <div class="mb-3">
                                                                                <div class="d-grid">
                                                                                    <a href="{{route('paymentProcess')}}"
                                                                                        class="btn btn-lg shadow-lg position-relative overflow-hidden text-decoration-none d-block"
                                                                                        style="background: linear-gradient(45deg, #28a745, #20c997); border: none; color: white; padding: 15px 20px;">
                                                                                        <div
                                                                                            class="d-flex align-items-center justify-content-center">
                                                                                            <div class="me-3">
                                                                                                <i
                                                                                                    class="fas fa-credit-card fs-4"></i>
                                                                                            </div>
                                                                                            <div class="text-start">
                                                                                                <div class="fw-bold fs-5">
                                                                                                    PROCEED TO PAYMENT</div>
                                                                                                <small class="opacity-75">Secure
                                                                                                    payment processing</small>
                                                                                            </div>
                                                                                            <div class="ms-3">
                                                                                                <i
                                                                                                    class="fas fa-arrow-right fs-5"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- Animated background effect -->
                                                                                        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25"
                                                                                            style="background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.2) 50%, transparent 70%); 
                                                                                                            animation: shimmer 2s infinite;">
                                                                                        </div>
                                                                                    </a>
                                                                                </div>
                                                                                <div class="text-center mt-2">
                                                                                    <small class="text-muted">
                                                                                        <i class="fas fa-shield-alt me-1"></i>
                                                                                        Secure payment by GCash
                                                                                    </small>
                                                                                </div>
                                                                            </div>
                                                                        @elseif($latestReservation->payment_status === 'paid')
                                                                            <div class="mb-3">
                                                                                <div class="alert alert-success border-0 shadow-sm"
                                                                                    style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <i
                                                                                            class="fas fa-check-circle fs-4 text-success me-3"></i>
                                                                                        <div>
                                                                                            <h6
                                                                                                class="mb-1 text-success fw-bold">
                                                                                                Payment Completed</h6>
                                                                                            <small class="text-success">Your
                                                                                                reservation has been fully
                                                                                                paid</small>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif

                                                                        <!-- Status Badge -->
                                                                        <div class="text-center">
                                                                            @php
                                                                                $statusClass = match ($latestReservation->reservation_status ?? 'pending') {
                                                                                    'checked-in' => 'bg-success',
                                                                                    'cancelled' => 'bg-danger',
                                                                                    'checked-out' => 'bg-danger',
                                                                                    'reserved' => 'bg-primary',
                                                                                    default => 'bg-warning'
                                                                                };
                                                                            @endphp
                                                                            <span
                                                                                class="badge {{ $statusClass }} px-3 py-2 rounded-pill">
                                                                                <i class="fas fa-circle me-1"
                                                                                    style="font-size: 0.5rem;"></i>
                                                                                {{ ucfirst($latestReservation->reservation_status ?? 'Pending') }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- QR Code Section -->
                                                        <div class="mt-4">
                                                            <div class="card border-0 shadow-sm"
                                                                style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                                                <div class="card-header border-0 bg-transparent">
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-center">
                                                                        <div
                                                                            class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                                                            <i class="fas fa-qrcode text-success fs-5"></i>
                                                                        </div>
                                                                        <h6 class="mb-0 fw-bold" style="color: #0b573d;">QR
                                                                            Code for Check-in</h6>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body text-center">
                                                                    <!-- Instructions -->
                                                                    <div class="alert alert-light border-0 shadow-sm mb-4"
                                                                        style="background-color: rgba(11, 87, 61, 0.05);">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-md-8">
                                                                                <ol class="mb-0 text-start"
                                                                                    style="color: #0b573d;">
                                                                                    <li class="mb-2">
                                                                                        <i
                                                                                            class="fas fa-download me-2 text-success"></i>
                                                                                        Download your QR code by clicking
                                                                                        the button below
                                                                                    </li>
                                                                                    <li class="mb-0">
                                                                                        <i
                                                                                            class="fas fa-mobile-alt me-2 text-success"></i>
                                                                                        Present this QR code upon check-in
                                                                                        at our resort
                                                                                    </li>
                                                                                </ol>
                                                                            </div>
                                                                            <div class="col-md-4 text-center">
                                                                                <i
                                                                                    class="fas fa-shield-alt text-success fs-1 opacity-25"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- QR Code Display -->
                                                                    <div
                                                                        class="d-inline-block p-3 bg-white rounded-3 shadow-sm mb-3">
                                                                        <canvas id="qr-code"
                                                                            class="border rounded"></canvas>
                                                                    </div>

                                                                    <!-- Download Button -->
                                                                    <div class="d-grid gap-2 col-md-6 mx-auto">
                                                                        <button id="download-qr"
                                                                            class="btn btn-lg shadow-sm"
                                                                            style="background: linear-gradient(135deg, #0b573d 0%, #0d6b47 100%); border: none; color: white;"
                                                                            onclick="downloadQRCode()">
                                                                            <i class="fas fa-download me-2"></i>
                                                                            <span class="fw-bold">DOWNLOAD QR CODE</span>
                                                                        </button>
                                                                    </div>

                                                                    <small class="text-muted mt-2 d-block">
                                                                        <i class="fas fa-info-circle me-1"></i>
                                                                        Keep this QR code safe and accessible on your mobile
                                                                        device
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Enhanced Footer -->
                                                <div class="modal-footer border-0 bg-light">
                                                    <div class="d-flex justify-content-between align-items-center w-100">
                                                        <small class="text-muted">
                                                            <i class="fas fa-calendar me-1"></i>
                                                            Created:
                                                            {{ \Carbon\Carbon::parse($latestReservation->created_at)->format('M j, Y') }}
                                                        </small>
                                                        <button type="button" class="btn btn-outline-secondary px-4"
                                                            data-bs-dismiss="modal">
                                                            <i class="fas fa-times me-2"></i>Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center p-4 p-md-5 w-100">
                                        <i class="fas fa-calendar-times fa-3x mb-3" style="color: #0b573d;"></i>
                                        <p class="text-muted">No reservations yet.</p>
                                    </div>
                                @endif
                            </section>

                            <section id="history-section" class="p-3 p-md-4" style="display: none;">
                                <h5 class="text-center mt-3">Your Reservation History</h5>
                                @forelse ($pastReservations as $reservation)
                                    <div class="card mb-3 mt-4">
                                        <div class="card-body p-3 p-md-4">
                                            <div
                                                class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                                                <p class="mb-0"><strong>Status:</strong>
                                                    <span class="badge ms-2 @if(isset($reservation) && $reservation->payment_status == 'paid') bg-success 
                                                    @elseif(isset($reservation) && $reservation->payment_status == 'pending') bg-warning 
                                                        @elseif(isset($reservation) && $reservation->payment_status == 'booked') bg-primary 
                                                            @else bg-danger @endif">
                                                        {{ isset($reservation) ? $reservation->payment_status : 'N/A' }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="mt-3">
                                                <p class="mb-2"><strong>Check-in:</strong>
                                                    {{ $reservation->reservation_check_in }}</p>
                                                <p class="mb-2"><strong>Check-out:</strong>
                                                    {{ $reservation->reservation_check_out }}</p>
                                                <p class="mb-2"><strong>Guests:</strong> {{ $reservation->total_guest }}</p>
                                                <p class="mb-0"><strong>Amount:</strong>
                                                    ₱{{ number_format($reservation->amount, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center p-4 p-md-5">
                                        <p class="text-muted mb-0">No reservation history found.</p>
                                    </div>
                                @endforelse
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Reservation Modal -->
    <div class="modal fade" id="cancelReservationModal" tabindex="-1" aria-labelledby="cancelReservationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-white" style="background-color: #0b573d;">
                    <h5 class="modal-title" id="cancelReservationModalLabel">Cancel Reservation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this reservation?</p>
                    @if(isset($latestReservation) && $latestReservation && $latestReservation->id)
                        <form method="POST"
                            action="{{ route('guestcancelReservation', ['id' => $latestReservation->id]) }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="cancel_reason" class="form-label">Reason for cancellation:</label>
                                <select class="form-select" id="cancel_reason" name="cancel_reason" required>
                                    <option value="">Select a reason</option>
                                    <option value="Change of plans">Change of plans</option>
                                    <option value="Found a better deal">Found a better deal</option>
                                    <option value="Travel restrictions">Travel restrictions</option>
                                    <option value="Emergency">Emergency</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Confirm Cancel</button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning">
                            No active reservation found to cancel.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('profileSidebar');
            const mainContent = document.getElementById('mainContent');
            const desktopToggleBtn = document.getElementById('desktopSidebarToggle');
            const mobileToggleBtn = document.getElementById('sidebarToggle');
            let isSidebarOpen = true;

            // Add smooth transition for sidebar collapse/expand
            sidebar.style.transition = 'all 0.3s ease';
            if (mainContent) {
                mainContent.style.transition = 'all 0.3s ease';
            }

            // Function to handle sidebar toggle for desktop
            if (desktopToggleBtn) {
                desktopToggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('collapsed');
                    desktopToggleBtn.classList.toggle('collapsed');

                    // Force the main content to adjust immediately
                    if (sidebar.classList.contains('collapsed')) {
                        mainContent.style.width = '100%';
                        mainContent.style.maxWidth = '100%';
                    } else {
                        // Reset to Bootstrap's default classes
                        mainContent.style.width = '';
                        mainContent.style.maxWidth = '';
                    }
                });
            }

            // Mobile sidebar toggle
            function openSidebar() {
                sidebar.classList.add('show');
                document.body.classList.add('sidebar-open');
                isSidebarOpen = true;
            }

            function closeSidebar() {
                sidebar.classList.remove('show');
                document.body.classList.remove('sidebar-open');
                isSidebarOpen = false;
            }

            if (mobileToggleBtn) {
                mobileToggleBtn.addEventListener('click', function () {
                    if (isSidebarOpen) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                });
            }

            // Close sidebar when window is resized to desktop view
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 768) {
                    closeSidebar();
                }
            });

            // Initialize state
            if (window.innerWidth < 768) {
                closeSidebar(); // Ensure sidebar is closed initially on mobile
            }
        });

        // TIMER OF THE EARTH
        function updateDateTime() {
            const now = new Date();

            // Format time as h:mm AM/PM
            let hours = now.getHours();
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            const timeString = hours + ':' + minutes + ' ' + ampm;

            // Format date as Weekday, Month Day
            const options = { weekday: 'long', month: 'long', day: 'numeric' };
            const dateString = now.toLocaleDateString(undefined, options);

            document.getElementById('time').textContent = timeString;
            document.getElementById('date').textContent = dateString;
        }

        updateDateTime();
        setInterval(updateDateTime, 60000); // Update every minute

        // Cancel modal function
        function openCancelModal(reservationId) {
            // Check if reservationId is valid
            if (!reservationId) {
                console.error("No valid reservation ID provided.");
                return;
            }

            // Optionally set the reservation ID in a hidden field if you want to use it later
            // document.getElementById('reservationIdInput').value = reservationId;

            // Show the modal using Bootstrap 5
            var modal = new bootstrap.Modal(document.getElementById('cancelReservationModal'));
            modal.show();
        }

        // Existing tab toggle function
        function toggleTab(event, showSectionId, activeTabId, inactiveTabId) {
            // ... existing code ...
        }
    </script>
    <script>
        function showMobileRequiredAlert() {
            alert('Please add your mobile number first before navigating back to homepage.');
            // Optionally, automatically open the edit modal
            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
            // Focus on mobile number input
            setTimeout(() => {
                document.getElementById('mobileNo').focus();
            }, 500);
        }

        function preventNavigation() {
            showMobileRequiredAlert();
            return false; // Prevent the link from navigating
        }

        // Also disable browser back button if mobile number is empty
        @if(empty($user->mobileNo) || strlen($user->mobileNo) < 11)
            window.addEventListener('beforeunload', function (e) {
                // This won't prevent back button but will show a warning
                e.returnValue = 'Please complete your profile by adding your mobile number.';
            });

            // Prevent back button navigation
            history.pushState(null, null, location.href);
            window.addEventListener('popstate', function (event) {
                alert('Please add your mobile number first before leaving this page.');
                history.pushState(null, null, location.href);
            });
        @endif
    </script>
    <script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>
    <script>
        // Generate QR code when modal is shown
        document.getElementById('viewReservationModal').addEventListener('shown.bs.modal', function () {
            let reservationId = '{{ $latestReservation->reservation_id ?? '' }}';
            if (reservationId) {
                let qr = new QRious({
                    element: document.getElementById('qr-code'),
                    value: reservationId,
                    size: 200
                });

                // Center the QR code
                let qrCodeContainer = document.getElementById('qr-code').parentElement;
                qrCodeContainer.style.display = 'flex';
                qrCodeContainer.style.flexDirection = 'column';
                qrCodeContainer.style.justifyContent = 'center';
                qrCodeContainer.style.alignItems = 'center';

                // Show download button
                document.getElementById('download-qr').style.display = 'inline-block';
            } else {
                console.error('No reservation ID available');
            }
        });

        function downloadQRCode() {
            let canvas = document.getElementById('qr-code');
            if (!canvas) {
                alert('QR code not generated yet!');
                return;
            }

            let link = document.createElement('a');
            link.href = canvas.toDataURL("image/png");
            link.download = "reservation_qr.png";
            link.click();
        }
    </script>
    <script>
        function proceedToPayment() {
            // You can customize this function based on your payment integration
            // For example, redirect to payment page or open payment modal

            // Example: Redirect to payment page with reservation ID
            const reservationId = '{{ $latestReservation->reservation_id ?? '' }}';

            if (reservationId) {
                // Replace this with your actual payment route
                window.location.href = `/payment/${reservationId}`;

                // Or you can show a confirmation dialog first
                // if (confirm('Proceed to payment for reservation ' + reservationId + '?')) {
                //     window.location.href = `/payment/${reservationId}`;
                // }
            } else {
                alert('Unable to process payment. Please try again.');
            }
        }
    </script>

</html>