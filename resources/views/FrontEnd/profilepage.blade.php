<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$user->name}} - Profile</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            font-family: 'Montserrat';
        }
        #time .meridiem{
            font-size: .8em;
        }
        .main-content {
            max-width: 800px; /* adjust as needed */
            margin: 0 auto;   /* keep it centered */
        }
        

        .info-card-responsive {
            background: linear-gradient(to top, rgba(0,0,0,0.2), white);
            width: 90%;
            max-width: 500px;
            height: auto;
            border-radius: 15px;
            margin-top: 1.5rem;
        }

        @media (min-width: 992px) { /* lg breakpoint */
            .info-card-responsive {
                width: auto;
                min-width: 700px;
                max-width: 700px;
                height: 550px;
                border-top-right-radius: 15px;
                border-bottom-right-radius: 15px;
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                margin-top: 0;
            }
        }

        .profile-image-wrapper {
            width: 100%;
            max-width: 400px;
            height: 300px; /* Default height for small screens */
        }

        @media (min-width: 992px) { /* lg breakpoint */
            .profile-image-wrapper {
                height: 570px; /* Revert to original height on large screens */
            }
        }
    </style>
</head>
<x-loading-screen />
<body
    style="margin: 0; padding: 0; background:url('{{ asset('images/profileBG.png') }}') no-repeat; background-size: cover;">
    @include('Alert.infoNotif')
    @include('Alert.errorLogin')
    @include('Alert.loginSuccessUser')
    <div class="d-flex justify-content-between mt-2 p-3">
         <!-- Back Button to Homepage-->
        <a href="{{ route('homepage') }}" class="text-decoration-none">
            <i class="fa-solid fa-circle-chevron-left text-color-2 fs-2 mb-3 ms-5 mt-2"></i>
        </a>
        <!-- Logout Button -->
        <a href="{{ route('logout.user') }}" class="text-decoration-none text-white">
        <i class="fa-solid fa-right-from-bracket ms-2 text-color-2 fs-2 mb-3 me-5 mt-2"></i>
        </a>
    </div>
    @php
        $firstName = explode(' ', trim($user->name))[0];
    @endphp
    <!-- Main Content -->
    <div class="d-flex justify-content-center">
        <div class="mt-5 d-block d-lg-flex align-items-lg-center">
        <!-- Left Side Profile Image -->
            <div class="profile-image-wrapper border border-white overflow-hidden position-relative rounded-3 rounded-lg-end-0 mx-auto">

                <!-- Profile Image -->
                <img src="{{ $user->image ? url('storage/' . $user->image) : asset('images/default-profile.jpg') }}"
                    alt="Profile Image" class="img-fluid w-100 h-100 object-fit-cover">

                <!-- Greeting Text -->
                <div class="position-absolute bottom-0 start-0 m-2 m-md-3 text-start text-white">
                    <h3 class="fw-bold mb-0 fs-6 fs-md-5 fs-lg-4">Hello,</h3>
                    <h1 class="fw-bold fs-4 fs-md-3 fs-lg-2 ">{{ $firstName }}!</h1>
                </div>
            </div>


        <!-- Right Side Information with White Background -->
            <div class="info-card-responsive text-dark p-4 mx-auto bg-white">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center m-2">
                <!-- Left Side: Name -->
                <h1 class="fw-bold text-uppercase text-color-2 mb-2 mb-sm-0 text-center text-sm-start">{{$user->name}}</h1>

                <!-- Right Side: Buttons -->
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <!-- Edit Button -->
                    <a href="#" data-bs-toggle="modal" data-bs-target="#editModal" 
                    class="btn btn-outline-dark btn-sm d-flex align-items-center" style="height: 38px;" title="Edit Your Profile">
                        <i class="fas fa-pencil me-1"></i>
                    </a>

                    <!-- View Button -->
                    <a type="button" class="btn btn-outline-dark btn-sm d-flex align-items-center"
                        data-bs-toggle="modal" data-bs-target="#viewReservationModal" style="height: 38px;" title="View Your Reservation">
                        <i class="fas fa-eye me-1"></i>
                    </a>
                    @if(!in_array($latestReservation->reservation_status, ['reserved', 'checked-in', 'cancelled', 'early-checked-out']))
                        <button type="button" 
                                class="btn btn-danger btn-sm d-flex align-items-center" 
                                data-bs-toggle="modal" 
                                data-bs-target="#cancelReservationModal" 
                                style="height: 38px;" 
                                title="Cancel Your Reservation">
                            <i class="fas fa-times-circle me-1"></i>
                        </button>
                    @endif

                </div>
            </div>

            <hr style="border-color: #8a848f; border-width: 2px; margin: 0;">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center text-center text-lg-start">
                <!-- Left Side -->
                <div class="d-flex align-items-center justify-content-center mt-2">
                    <h1 class="text-uppercase fs-6 fw-bold fs-xs-5" style="color:#8a848f;">
                        Check-In Details
                    </h1>
                    <span class="badge text-capitalize mb-2 ms-2
                        @if($latestReservation->reservation_status === 'checked-in')
                            bg-success
                        @elseif($latestReservation->reservation_status === 'pending' || $latestReservation->reservation_status === 'on-hold')
                            bg-warning
                        @elseif($latestReservation->reservation_status === 'reserved')
                            bg-primary
                        @else
                            bg-danger
                        @endif">
                        {{ ucfirst($latestReservation->reservation_status) }}
                    </span>
                </div>

                <!-- Right Side -->
                <div id="dateTimeDisplay" class="me-lg-2 mt-3 mt-lg-0" style="z-index: 100; font-family: 'Montserrat', sans-serif; text-align: center;">
                    <div id="time" class="fw-bold fs-1 time-merediem"></div>
                    <div id="date" class="" style="font-size: .8em;"></div>
                </div>
            </div>
            <div class="bg-white d-flex flex-column flex-md-row justify-content-between align-items-center rounded shadow-sm m-2">
                <!-- Check-in -->
                <div class="p-3 d-flex align-items-center flex-fill justify-content-center">
                    <i class="fa-solid fa-calendar-check text-color-2 fs-3"></i>
                    <div class="ms-3">
                        <h1 class="fw-bold text-color-2" style="font-size: 1rem;">Check-in</h1>
                        <h1 class="fw-semibold" style="font-size: .9rem;">
                            {{ date('j M Y', strtotime($latestReservation->reservation_check_in_date)) }}
                        </h1>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-start d-none d-md-block" style="height: 50px;"></div>

                <!-- Check-out -->
                <div class="p-3 d-flex align-items-center flex-fill justify-content-center">
                    <i class="fa-solid fa-calendar-check text-color-2 fs-3"></i>
                    <div class="ms-3">
                        <h1 class="fw-bold text-color-2" style="font-size: 1rem;">Check-out</h1>
                        <h1 class="fw-semibold" style="font-size: .9rem;">
                            {{ date('j M Y', strtotime($latestReservation->reservation_check_out_date)) }}
                        </h1>
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <h1 class="text-uppercase fs-6 fw-bold ms-2 mt-2" style="color:#8a848f;">
                    Rooms And Activities
                </h1>
            </div>
            <div class="bg-white d-flex flex-column flex-md-row justify-content-between align-items-center rounded shadow-sm m-2">
                <!-- Check-in -->
                <div class="p-2 d-flex align-items-center flex-fill justify-content-center">
                    <i class="fa-solid fa-house text-color-2 fs-3"></i>
                    <div class="ms-3">
                        <h1 class="fw-bold text-color-2" style="font-size: 1rem;">@foreach($accommodations as $accommodation){{ $accommodation }}@endforeach</h1>
                        
                        <h1 class="fw-semibold" style="font-size: .9rem;">
                            <span class="">Quantity :</span>{{ ($latestReservation->quantity?? 0 ) }}
                        </h1>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-start d-none d-md-block" style="height: 50px;"></div>

                <!-- Check-out -->
                <div class="p-3 d-flex align-items-center flex-fill justify-content-center">
                    <i class="fa-solid fa-water-ladder text-color-2 fs-3"></i>
                    <div class="ms-3">
                        <h1 class="fw-bold text-color-2" style="font-size: 1rem;">{{ $activities[0] ?? '' }}</h1>
                        <h1 class="fw-semibold text-capitalize" style="font-size: .8rem;">
                            {{ $activities[2] ?? '' }}, {{ $activities[1] ?? '' }}
                        </h1>
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <h1 class="text-uppercase fs-6 fw-bold ms-2 mt-2" style="color:#8a848f;">
                    Guest Details
                </h1>
            </div>
            <div class="bg-white d-flex flex-column flex-md-row justify-content-between align-items-center rounded shadow-sm m-2">
                <!-- Check-in -->
                <div class="p-3 d-flex align-items-center flex-fill justify-content-center">
                    <i class="fa-solid fa-envelope text-color-2 fs-3"></i>
                    <div class="ms-3">
                        <h1 class="fw-bold text-color-2" style="font-size: 1rem;">Email Address</h1>
                        <h1 class="fw-semibold fs-xs-5" style="font-size: .9rem;">
                            {{($user->email)}}
                        </h1>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-start d-none d-md-block" style="height: 50px;"></div>

                <!-- Check-out -->
                <div class="p-3 d-flex align-items-center flex-fill justify-content-center">
                    <i class="fa-solid fa-phone text-color-2 fs-3"></i>
                    <div class="ms-3">
                        <h1 class="fw-bold text-color-2" style="font-size: 1rem;">Contact Number</h1>
                        <h1 class="fw-semibold" style="font-size: .9rem;">
                            {{($user->mobileNo)}}
                        </h1>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    
    <!-- Modal For edit Information -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 shadow-lg border-0">

                <!-- Header -->
                <div class="modal-header border-0 text-center w-100"
                    style="background: linear-gradient(135deg, #0b573d, #118a5c); border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                    <h4 class="modal-title text-white text-uppercase fw-bold mx-auto"
                        style="font-family: 'Poppins', sans-serif; letter-spacing: 0.06em;">
                        Edit Your Profile
                    </h4>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body p-5 bg-light">
                    <form action="{{ route('editProfile', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Profile Picture -->
                        <div class="mb-4 text-center">
                            <label for="image" class="form-label fw-semibold text-uppercase small"
                                style="color: #0b573d;">Profile Picture</label>
                            <div class="d-flex flex-column align-items-center gap-3">
                                <div class="position-relative">
                                    <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/default-profile.jpg') }}"
                                        alt="Profile Image"
                                        class="rounded-circle shadow border border-3 border-white"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                    <label for="image"
                                        class="btn btn-sm position-absolute bottom-0 end-0 rounded-circle shadow"
                                        style="background-color: #0b573d; color: #fff;">
                                        <i class="fa-solid fa-pencil"></i>
                                    </label>
                                </div>
                                <input type="file" class="form-control d-none" name="image" id="image"
                                    accept="image/*">
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold small text-uppercase"
                                style="color: #0b573d;">Full Name</label>
                            <input type="text" class="form-control rounded-3 shadow-sm p-3" id="name" name="name"
                                value="{{ $user->name }}" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small text-uppercase"
                                style="color: #0b573d;">Email Address</label>
                            <input type="email" class="form-control rounded-3 shadow-sm p-3" id="email" name="email"
                                value="{{ $user->email }}" required>
                        </div>

                        <!-- Mobile Number -->
                        <div class="mb-3">
                            <label for="mobileNo" class="form-label fw-semibold small text-uppercase"
                                style="color: #0b573d;">Mobile Number</label>
                            <input type="text" class="form-control rounded-3 shadow-sm p-3" id="mobileNo" name="mobileNo"
                                value="{{ substr($user->mobileNo, 0, 11) }}" required maxlength="11"
                                onkeypress="return (event.charCode >= 48 && event.charCode <= 57) && event.charCode != 45;"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 11);"
                                pattern="[0-9]{11}" title="Please enter a valid 11-digit mobile number (numbers only)">
                        </div>

                        <!-- Address -->
                        <div class="mb-4">
                            <label for="address" class="form-label fw-semibold small text-uppercase"
                                style="color: #0b573d;">Address</label>
                            <input type="text" class="form-control rounded-3 shadow-sm p-3" id="address" name="address"
                                value="{{ $user->address }}" required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="btn w-100 py-3 fw-bold text-uppercase rounded-3 shadow-sm transition"
                            style="background: linear-gradient(135deg, #0b573d, #118a5c); color: white; letter-spacing: 0.05em;">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal for the Reservation -->
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
               

<!-- Script Part -->

<!-- For Going to Payment Page -->
<script>
    function proceedToPayment() {
        // Example: Redirect to payment page with reservation ID
        const reservationId = '{{ $latestReservation->reservation_id ?? '' }}';

        if (reservationId) {
            // Replace this with your actual payment route
            window.location.href = `/payment/${reservationId}`;
        } else {
            alert('Unable to process payment. Please try again.');
        }
    }

    // Date and Time
    (function () {
        function getConfig(root) {
            const ds = root?.dataset || {};
            const locale = ds.locale || navigator.language || 'en-US';
            const timeZone = ds.timezone || Intl.DateTimeFormat().resolvedOptions().timeZone;
            // data-hour12 can be "true" | "false" | undefined; convert to boolean or undefined
            let hour12;
            if (typeof ds.hour12 !== 'undefined') {
            hour12 = String(ds.hour12).toLowerCase() === 'true';
            }
            return { locale, timeZone, hour12 };
        }

        function update(timeEl, dateEl, cfg) {
            const now = new Date();

            // Time: "9:26 PM" (12-hour, no seconds)
            const timeFormatter = new Intl.DateTimeFormat('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: (cfg.hour12 ?? true), // default to 12-hour unless data-hour12 overrides
            timeZone: cfg.timeZone
            });

            // Date: "16/09/2025" (DD/MM/YYYY)
            const dateFormatter = new Intl.DateTimeFormat('en-US', 
            { weekday: 'long', month: 'long', day: 'numeric', timeZone: cfg.timeZone });
            const parts = timeFormatter.formatToParts(now);
            let html = "";
            parts.forEach(p => {
                if (p.type === "dayPeriod") {
                    html += `<span class="meridiem">${p.value}</span>`;
                } else {
                    html += p.value;
                }
            });
            timeEl.innerHTML = html;
            dateEl.textContent = dateFormatter.format(now);
        }

        function startDateTimeDisplay(rootId = 'dateTimeDisplay') {
            const root = document.getElementById(rootId);
            if (!root) return;

            const timeEl = root.querySelector('#time') || document.getElementById('time');
            const dateEl = root.querySelector('#date') || document.getElementById('date');
            if (!timeEl || !dateEl) return;

            const cfg = getConfig(root);

            // Align updates to the top of the second to avoid drift
            function tick() {
                update(timeEl, dateEl, cfg);
                // schedule next update aligned to the next second
                const now = Date.now();
                const delay = 1000 - (now % 1000) + 5; // small fudge factor
                timer = setTimeout(tick, delay);
                }

                // Start immediately
                let timer = null;
                tick();

                // Pause updates when tab is hidden to save resources
                function handleVisibility() {
                if (document.hidden) {
                    if (timer) {
                    clearTimeout(timer);
                    timer = null;
                    }
                } else {
                    tick();
                }
                }
                document.addEventListener('visibilitychange', handleVisibility);
            }

        // Auto-start when DOM is ready
        document.addEventListener('DOMContentLoaded', function () {
            startDateTimeDisplay();
        });

        // Expose manual starter if needed
        window.startDateTimeDisplay = startDateTimeDisplay;
        })();
</script>
<!-- Qr Code -->
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

</body>
</html>