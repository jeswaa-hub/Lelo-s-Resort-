<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; padding: 0; height: 100vh; background-color: white; overflow-x: hidden;">
    @include('Alert.errorLogin')
    @include('Alert.loginSuccessUser')
        <!-- NAVBAR -->
        @include('Navbar.sidenavbarStaff')
        <!-- Main Content  -->

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
                                STAFF002
                            </h1>
                        </div>
                        
                        <!-- Total Reservations -->
                        <div class="d-flex align-items-center rounded-3 shadow-sm mt-4" 
                             style="background: linear-gradient(135deg,rgb(75, 96, 7) 0%,rgb(129, 235, 48) 100%);">
                            <div class="p-3 p-md-4 p-lg-5">
                                <div class="d-flex align-items-baseline gap-2">
                                    <h1 class="fw-bold mb-0 text-white" 
                                        style="font-size: clamp(1.8rem, 3vw, 3rem);">
                                        {{ $totalCount ?? 0 }}
                                    </h1>
                                    <p class="text-white text-uppercase mb-0 font-paragraph "
                                       style="font-size: 1.8rem; letter-spacing: 1px;">
                                        Total Reservations
                                    </p>
                                </div>
                            </div>
                            <div class="ms-auto p-3 p-md-4 p-lg-5 position-relative">
                                <i class="fas fa-calendar-check text-white opacity-25" 
                                   style="font-size: 4rem; margin: -10px;">
                                </i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="col-12 col-md-6">
                    <div class="row row-cols-1 row-cols-sm-2 g-3 g-md-4">
                        <!-- Walk-in Reservation -->
                        <div class="col">
                            <div class="d-flex align-items-center text-dark p-3 p-md-4 p-lg-5 rounded-3 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #43cea2 0%, #385E3C 100%);">
                                <div>
                                    <h1 class="fw-bold mb-0 text-white" style="font-size: clamp(1.8rem, 3vw, 3rem);">{{ $totalWalkInGuests ?? 0 }}</h1>
                                    <p class="text-white text-uppercase mb-0 font-paragraph" style="font-size: 0.8rem;">Total Walk-In<br>Reservations
                                    </p>
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
                                    <h1 class="fw-bold mb-0 text-white" style="font-size: clamp(1.8rem, 3vw, 3rem);">{{ $totalCheckedOutGuests ?? 0 }}</h1>
                                    <p class="text-white text-uppercase mb-0 font-paragraph" style="font-size: 0.8rem;">
                                        Check-out<br>Reservations
                                    </p>
                                </div>
                                <div class="position-absolute top-0 end-0 opacity-25">
                                    <i class="fas fa-sign-out-alt text-white" style="font-size: 4rem; margin: -10px;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Checked-in Reservations -->
                        <div class="col">
                            <div class="d-flex align-items-center text-dark p-3 p-md-4 p-lg-5 rounded-3 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg,rgb(75, 96, 7) 0%,rgb(129, 235, 48) 100%);">
                                <div>
                                    <h1 class="fw-bold mb-0 text-white" style="font-size: clamp(1.8rem, 3vw, 3rem);">{{ $totalCheckedInGuests ?? 0 }}</h1>
                                    <p class="text-white text-uppercase mb-0 font-paragraph" style="font-size: 0.8rem;">
                                        Checked-in<br>Reservations
                                    </p>
                                </div>
                                <div class="position-absolute top-0 end-0 opacity-25">
                                    <i class="fas fa-user-check text-white" style="font-size: 4rem; margin: -10px;"></i>
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<div class="container-fluid mt-4 shadow-lg p-4 bg-white rounded" style="max-width: 91.67%; margin: 0 auto;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-black mb-0 border-bottom" style="font-size: 2.5rem;">WALK-IN RESERVATION</h2>
            <button type="button" class="btn ms-auto text-white" style="width: 200px; background-color: #0b573d;" data-bs-toggle="modal" data-bs-target="#addWalkInModal">
                <i class="fas fa-user-plus me-2"></i>Add Walk-in Guest
            </button>
        </div>

        <div class="card shadow-sm border-0 rounded-4 mb-4 mt-4 p-2">
            <table class="table table-hover table-striped table-responsive table-sm">
                <thead>
                <tr>
                    <th class="text-center align-middle" style="font-size: 0.85rem;">Name</th>
                    <th class="text-center align-middle" style="font-size: 0.85rem;">Address</th>
                    <th class="text-center align-middle" style="font-size: 0.85rem;">Phone Number</th>
                    <th class="text-center align-middle" style="font-size: 0.85rem;">Date</th>
                    <th class="text-center align-middle" style="font-size: 0.85rem;">Check In-Out</th>
                    <th class="text-center align-middle" style="font-size: 0.85rem;">Room</th>
                    <th class="text-center align-middle" style="font-size: 0.85rem;">Room Qty</th>
                    <th class="text-center align-middle" style="font-size: 0.85rem;">Total Guest</th>
                    <th class="text-center align-middle" style="font-size: 0.85rem;">Amount</th>
                    <th class="text-center align-middle" style="font-size: 0.85rem;">Payment Method</th>
                    <th class="text-center align-middle" style="font-size: 0.85rem;">Reservation Status</th>
                    <th class="text-center align-middle" style="font-size: 0.85rem;">Payment Status</th>
                    <th class="text-center align-middle" style="font-size: 0.85rem;">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($walkinGuest as $guest)
                    <tr class="align-middle">
                        <td class="text-center">{{ $guest->name }}</td>
                        <td class="text-center">{{ $guest->address }}</td>
                        <td class="text-center">{{ $guest->mobileNo }}</td>
                        <td class="text-center">{{ date('M d, Y', strtotime($guest->reservation_check_in_date)) }}</td>
                        <td class="text-center">{{ date('h:i A', strtotime($guest->check_in_time)) }} - {{ date('h:i A', strtotime($guest->check_out_time)) }}</td>
                        <td class="text-center">{{ $guest->accomodation_name }}</td>
                        <td class="text-center">{{ $guest->quantity}}</td>
                        <td class="text-center">{{ $guest->total_guests }}</td>
                        <td class="text-center">₱{{ number_format($guest->amount, 2) }}</td>
                        <td class="text-center">{{ $guest->payment_method }}</td>
                        <td class="text-center">
                            @if($guest->reservation_status == 'checked-in')
                                <span class="badge bg-success">{{ $guest->reservation_status }}</span>
                            @elseif($guest->reservation_status == 'checked-out')
                                <span class="badge bg-danger">{{ $guest->reservation_status }}</span>
                            @else
                                <span class="badge bg-secondary">{{ $guest->reservation_status }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($guest->payment_status == 'Paid')
                                <span class="badge bg-success ">{{ $guest->payment_status }}</span>
                            @elseif($guest->payment_status == 'partially-paid')
                                <span class="badge bg-warning">{{ $guest->payment_status }}</span>
                            @else
                                <span class="badge bg-danger">{{ $guest->payment_status }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm" style="background-color: #0b573d; color: white;"
                                data-bs-toggle="modal" data-bs-target="#editModal{{ $guest->id }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $guest->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $guest->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-success bg-gradient text-white border-0">
                                            <h5 class="modal-title" id="editModalLabel{{ $guest->id }}">
                                                <i class="fas fa-edit me-2"></i>Update Reservation Status
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('staff.updateWalkInStatus', $guest->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body p-4">
                                                <div class="mb-4">
                                                    <label for="payment_status{{ $guest->id }}" class="form-label text-muted fw-bold">
                                                        <i class="fas fa-money-bill-wave me-2"></i>Payment Status
                                                    </label>
                                                    <select class="form-select form-select-lg border-success bg-light" id="payment_status{{ $guest->id }}" name="payment_status" required>
                                                        <option value="Paid" {{ old('payment_status', $guest->payment_status) == 'Paid' ? 'selected' : '' }}>
                                                            <i class="fas fa-check-circle text-success"></i> Paid
                                                        </option>
                                                        <option value="Partially Paid" {{ old('payment_status', $guest->payment_status) == 'Partially Paid' ? 'selected' : '' }}>
                                                            <i class="fas fa-clock text-warning"></i> Partially Paid
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="reservation_status{{ $guest->id }}" class="form-label text-muted fw-bold">
                                                        <i class="fas fa-calendar-check me-2"></i>Reservation Status
                                                    </label>
                                                    <select class="form-select form-select-lg border-success bg-light" id="reservation_status{{ $guest->id }}" name="reservation_status" required>
                                                        <option value="checked-in" {{ old('reservation_status', $guest->reservation_status) == 'checked-in' ? 'selected' : '' }}>
                                                            <i class="fas fa-door-open text-success"></i> Checked In
                                                        </option>
                                                        <option value="checked-out" {{ old('reservation_status', $guest->reservation_status) == 'checked-out' ? 'selected' : '' }}>
                                                            <i class="fas fa-door-closed text-danger"></i> Checked Out
                                                        </option>
                                                        <option value="cancelled" {{ old('reservation_status', $guest->reservation_status) == 'cancelled' ? 'selected' : '' }}>
                                                            <i class="fas fa-ban text-danger"></i> Cancelled
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-2"></i>Cancel
                                                </button>
                                                <button type="submit" class="btn btn-success fw-bold">
                                                    <i class="fas fa-save me-2"></i>Save Changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mb-4"></div>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
    <!-- Pagination Info -->
    <div class="d-flex align-items-center">
        <span class="badge bg-primary me-2">
            <i class="fas fa-info-circle"></i>
        </span>
        <small class="text-muted">
            Showing {{ $walkinGuest->firstItem() ?? 0 }} to {{ $walkinGuest->lastItem() ?? 0 }} 
            of {{ $walkinGuest->total() }} entries
        </small>
    </div>

    <!-- Simple Bootstrap Pagination -->
    <nav aria-label="Walk-in Guest Pagination">
        <ul class="pagination pagination-sm mb-0">
            <!-- Previous Button -->
            <li class="page-item {{ $walkinGuest->onFirstPage() ? 'disabled' : '' }}">
                @if($walkinGuest->onFirstPage())
                    <span class="page-link bg-light text-muted" style="width: 70px;">
                        <i class="fas fa-chevron-left me-1"></i>Prev
                    </span>
                @else
                    <a class="page-link text-white" style="background-color: #0b573d; width: 70px;" 
                       href="{{ $walkinGuest->previousPageUrl() }}">
                        <i class="fas fa-chevron-left me-1"></i>Prev
                    </a>
                @endif
            </li>

            <!-- Page Numbers -->
            @foreach ($walkinGuest->getUrlRange(1, $walkinGuest->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $walkinGuest->currentPage() ? 'active' : '' }}">
                    @if($page == $walkinGuest->currentPage())
                        <span class="page-link text-white fw-bold" style="background-color: #0b573d;">
                            {{ $page }}
                        </span>
                    @else
                        <a class="page-link text-dark bg-light" href="{{ $url }}">
                            {{ $page }}
                        </a>
                    @endif
                </li>
            @endforeach

            <!-- Next Button -->
            <li class="page-item {{ !$walkinGuest->hasMorePages() ? 'disabled' : '' }}">
                @if($walkinGuest->hasMorePages())
                    <a class="page-link text-white" style="background-color: #0b573d; width: 70px;" 
                       href="{{ $walkinGuest->nextPageUrl() }}">
                        Next<i class="fas fa-chevron-right ms-1"></i>
                    </a>
                @else
                    <span class="page-link bg-light text-muted" style="width: 70px;">
                        Next<i class="fas fa-chevron-right ms-1"></i>
                    </span>
                @endif
            </li>
        </ul>
    </nav>
</div>

        </div>
    </div>
</div>


<!-- Modal for adding walkin guest -->
<div class="modal fade" id="addWalkInModal" tabindex="-1" aria-labelledby="addWalkInModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <!-- Compact Header -->
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #0b573d 0%, #0d6b47 100%); padding: 1rem 1.5rem;">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <img src="{{ asset('images/logo2.png') }}" alt="Logo" style="width: 40px; height: 40px;">
                    </div>
                    <div>
                        <h5 class="modal-title text-white mb-0 fw-bold" id="addWalkInModalLabel">
                            Walk-in Guest Reservation
                        </h5>
                        <small class="text-white-50">Create a new walk-in reservation</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Compact Body -->
            <div class="modal-body p-3" style="background: #f8f9fa;">
                <form action="{{ route('staff.walkin.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="row g-3">
                        <!-- Left Side - Personal Information -->
                        <div class="col-md-6">
                            <!-- Section Header -->
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2">
                                    <i class="fas fa-user" style="color: #0b573d; font-size: 14px;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">Personal Information</h6>
                                    <small class="text-muted">Guest details</small>
                                </div>
                            </div>
                            
                            <!-- Personal Info Card -->
                            <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
                                <div class="card-body p-3">
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-semibold text-dark mb-1">
                                            <i class="fas fa-user-circle me-2" style="color: #0b573d;"></i>Full Name
                                        </label>
                                        <input type="text" class="form-control border-0 shadow-sm" 
                                                id="name" name="name" required 
                                                style="background: #f8f9fa; border-radius: 8px;"
                                                placeholder="Enter guest's full name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label fw-semibold text-dark mb-1">
                                            <i class="fas fa-map-marker-alt me-2" style="color: #0b573d;"></i>Address
                                        </label>
                                        <input type="text" class="form-control border-0 shadow-sm" 
                                                id="address" name="address" required 
                                                style="background: #f8f9fa; border-radius: 8px;"
                                                placeholder="Enter complete address">
                                    </div>
                                    <div class="mb-0">
                                        <label for="phone" class="form-label fw-semibold text-dark mb-1">
                                            <i class="fas fa-phone me-2" style="color: #0b573d;"></i>Phone Number
                                        </label>
                                        <input type="tel" class="form-control border-0 shadow-sm" 
                                                id="phone" name="mobileNo" required 
                                                style="background: #f8f9fa; border-radius: 8px;"
                                                placeholder="Enter 11-digit phone number"
                                                maxlength="11"
                                                pattern="[0-9]{11}"
                                                oninput="validatePhoneNumber(this)"
                                                onkeypress="return isNumberKey(event)">
                                        <div class="invalid-feedback mt-1" id="phone_error" style="display: none;">
                                            <i class="fas fa-exclamation-circle me-1" style="color: #dc3545;"></i>
                                            Phone number must be exactly 11 digits.
                                        </div>
                                        <small class="text-muted mt-1 d-block" style="font-size: 12px;">
                                            <i class="fas fa-info-circle me-1" style="color: #0b573d;"></i>
                                            Enter 11-digit phone number (e.g., 09123456789)
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Guest Count Card -->
                            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                                <div class="card-header border-0 bg-success bg-opacity-10 py-2" style="border-radius: 10px 10px 0 0;">
                                    <h6 class="mb-0 fw-bold" style="color: #0b573d;">
                                        <i class="fas fa-users me-2"></i>Guest Information
                                    </h6>
                                </div>
                                <div class="card-body p-3">
                                    <!-- Room Selection and Quantity - Moved to top -->
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <label for="room_type" class="form-label fw-semibold text-dark mb-1">
                                                <i class="fas fa-home me-2" style="color: #0b573d;"></i>Room Type
                                            </label>
                                            <select class="form-select border-0 shadow-sm" 
                                                    id="room_type" name="accomodation_id" required onchange="updateAmountAndTotal()" 
                                                    style="background: #f8f9fa; border-radius: 8px;">
                                                <option value="">Select Room Type</option>
                                                @foreach($accomodations as $accomodation)
                                                    @if($accomodation->accomodation_status === 'available'))
                                                        <option value="{{ $accomodation->accomodation_id }}" 
                                                                data-price="{{ $accomodation->accomodation_price }}"
                                                                data-capacity="{{ $accomodation->accomodation_capacity }}">
                                                            {{ $accomodation->accomodation_name }} - ₱{{ number_format($accomodation->accomodation_price, 2) }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="quantity" class="form-label fw-semibold text-dark mb-1">
                                                <i class="fas fa-hashtag me-2" style="color: #0b573d;"></i>Quantity
                                            </label>
                                            <input type="number" class="form-control border-0 shadow-sm" 
                                                    id="quantity" name="quantity" min="1" value="1" required 
                                                    oninput="validateQuantity()" 
                                                    style="background: #f8f9fa; border-radius: 8px;">
                                            <div class="invalid-feedback mt-1" id="quantity_error">
                                                Quantity exceeds available rooms.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Guest Count Fields -->
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label for="number_of_adult" class="form-label fw-semibold text-dark mb-1">
                                                <i class="fas fa-user-friends me-2" style="color: #0b573d;"></i>Adults
                                            </label>
                                            <input type="number" class="form-control border-0 shadow-sm" 
                                                    id="number_of_adult" name="number_of_adult" min="0" value="0" required 
                                                    onchange="calculateTotalGuests()" 
                                                    style="background: #f8f9fa; border-radius: 8px;">
                                            <small class="text-muted mt-1 d-block" id="adult_entrance_fee">
                                                <i class="fas fa-receipt me-1" style="color: #0b573d;"></i>Fee: ₱<span id="adult_fee">0.00</span>
                                            </small>
                                        </div>
                                        <div class="col-6">
                                            <label for="number_of_children" class="form-label fw-semibold text-dark mb-1">
                                                <i class="fas fa-child me-2" style="color: #0b573d;"></i>Children
                                            </label>
                                            <input type="number" class="form-control border-0 shadow-sm" 
                                                    id="number_of_children" name="number_of_children" min="0" value="0" required 
                                                    onchange="calculateTotalGuests()" 
                                                    style="background: #f8f9fa; border-radius: 8px;">
                                            <small class="text-muted mt-1 d-block" id="child_entrance_fee">
                                                <i class="fas fa-receipt me-1" style="color: #0b573d;"></i>Fee: ₱<span id="child_fee">0.00</span>
                                            </small>
                                        </div>
                                        <div class="col-6">
                                            <label for="num_guests" class="form-label fw-semibold text-dark mb-1">
                                                <i class="fas fa-calculator me-2" style="color: #0b573d;"></i>Total Guests
                                            </label>
                                            <input type="number" class="form-control border-0 shadow-sm" 
                                                    id="num_guests" name="total_guest" readonly 
                                                    style="background: #e9ecef; border-radius: 8px;">
                                        </div>
                                        <div class="col-6">
                                            <label for="total_fee" class="form-label fw-semibold text-dark mb-1">
                                                <i class="fas fa-money-bill-wave me-2" style="color: #0b573d;"></i>Entrance Fee
                                            </label>
                                            <input type="text" class="form-control border-0 shadow-sm" 
                                                    id="total_fee" name="total_fee" value="₱0.00" readonly 
                                                    style="background: #e9ecef; border-radius: 8px;">
                                        </div>
                                    </div>
                                    <div class="alert alert-danger mt-2" id="capacity_error" style="display:none; border-radius: 8px; ">
                                        <i class="fas fa-exclamation-triangle me-2" style="color: #0b573d;"></i>
                                        <small style="font-size:12px;"><strong>Capacity Exceeded!</strong> Maximum allowed: <span id="max_capacity"></span> guests</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side - Reservation Details -->
                        <div class="col-md-6">
                            <!-- Section Header -->
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2">
                                    <i class="fas fa-calendar-alt" style="color: #0b573d; font-size: 14px;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">Reservation Details</h6>
                                    <small class="text-muted">Booking information</small>
                                </div>
                            </div>

                            <!-- Date & Time Card -->
                            <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
                                <div class="card-body p-3">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label for="check_in_date" class="form-label fw-semibold text-dark mb-1">
                                                <i class="fas fa-calendar-check me-2" style="color: #0b573d;"></i>Check-in Date
                                            </label>
                                            <input type="date" class="form-control border-0 shadow-sm" 
                                                    id="check_in_date" name="check_in_date" required
                                                    onchange="checkAvailability(this.value)" 
                                                    style="background: #f8f9fa; border-radius: 8px;">
                                            <div class="invalid-feedback mt-1" id="date_error" style="display: none;">
                                                <i class="fas fa-exclamation-circle me-1" style="color: #0b573d;"></i>
                                                This date is fully booked.
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="check_out_date" class="form-label fw-semibold text-dark mb-1">
                                                <i class="fas fa-calendar-times me-2" style="color: #0b573d;"></i>Check-out Date
                                            </label>
                                            <input type="date" class="form-control border-0 shadow-sm" 
                                                    id="check_out_date" name="check_out_date" required 
                                                    style="background: #f8f9fa; border-radius: 8px;">
                                        </div>
                                        <div class="col-12">
                                            <label for="stay_type" class="form-label fw-semibold text-dark mb-1">
                                                <i class="fas fa-moon me-2" style="color: #0b573d;"></i>Stay Duration
                                            </label>
                                            <select class="form-select border-0 shadow-sm" 
                                                    id="stay_type" name="stay_type" required onchange="handleStayTypeChange()" 
                                                    style="background: #f8f9fa; border-radius: 8px;">
                                                <option value="">Select Stay Type</option>
                                                <option value="day">Day Stay (One Day)</option>
                                                <option value="overnight">Overnight Stay</option>
                                            </select>
                                        </div>
                                        <div class="col-12" id="sessionDiv">
                                            <label for="session" class="form-label fw-semibold text-dark mb-1">
                                                <i class="fas fa-clock me-2" style="color: #0b573d;"></i>Session
                                            </label>
                                            <select class="form-select border-0 shadow-sm" 
                                                    id="session" name="session" required onchange="updateTimes()" 
                                                    style="background: #f8f9fa; border-radius: 8px;">
                                                <option value="">Select Session</option>
                                                @if($morningSession = $transactions->firstWhere('session', 'Morning'))
                                                <option value="{{ $morningSession->session }}" 
                                                        data-start="{{ date('H:i:s', strtotime($morningSession->start_time)) }}" 
                                                        data-end="{{ date('H:i:s', strtotime($morningSession->end_time)) }}">
                                                    Morning Session
                                                </option>
                                                @endif
                                                @if($eveningSession = $transactions->firstWhere('session', 'Evening'))
                                                <option value="{{ $eveningSession->session }}" 
                                                        data-start="{{ date('H:i:s', strtotime($eveningSession->start_time)) }}" 
                                                        data-end="{{ date('H:i:s', strtotime($eveningSession->end_time)) }}">
                                                    Evening Session
                                                </option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="check_in_time" class="form-label fw-semibold text-dark mb-1">
                                                <i class="fas fa-hourglass-start me-2" style="color: #0b573d;"></i>Check-in Time
                                            </label>
                                            <input type="time" class="form-control border-0 shadow-sm" 
                                                    id="check_in_time" name="check_in_time" readonly 
                                                    style="background: #e9ecef; border-radius: 8px;">
                                        </div>
                                        <div class="col-6">
                                            <label for="check_out_time" class="form-label fw-semibold text-dark mb-1">
                                                <i class="fas fa-hourglass-end me-2" style="color: #0b573d;"></i>Check-out Time
                                            </label>
                                            <input type="time" class="form-control border-0 shadow-sm" 
                                                    id="check_out_time" name="check_out_time" readonly 
                                                    style="background: #e9ecef; border-radius: 8px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invalid-feedback mt-1" id="checkout_date_error" style="display: none;"></div>

                            <!-- Payment Details Card -->
                            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                                <div class="card-header border-0 bg-success bg-opacity-10 py-2" style="border-radius: 10px 10px 0 0;">
                                    <h6 class="mb-0 fw-bold" style="color: #0b573d;">
                                        <i class="fas fa-credit-card me-2"></i>Payment Details
                                    </h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label for="payment_method" class="form-label fw-semibold text-dark mb-1" style="font-size:14px;">
                                                <i class="fas fa-credit-card me-2" style="color: #0b573d;"></i>Payment Method
                                            </label>
                                            <select class="form-select border-0 shadow-sm" 
                                                    id="payment_method" name="payment_method" required 
                                                    style="background: #f8f9fa; border-radius: 8px;">
                                                <option value="">Select Payment Method</option>
                                                <option value="cash">Cash</option>
                                                <option value="gcash">GCash</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="amount_paid" class="form-label fw-semibold text-dark mb-1">
                                                <i class="fas fa-file-invoice-dollar me-2" style="color: #0b573d;"></i>Total Amount
                                            </label>
                                            <input type="number" class="form-control border-0 shadow-sm" 
                                                    id="amount_paid" name="amount" step="0.01" required readonly 
                                                    style="background: #e9ecef; border-radius: 8px;">
                                        </div>
                                        <div class="col-6">
                                            <label for="payment_status" class="form-label fw-semibold text-dark mb-1">
                                                <i class="fas fa-money-check-alt me-2" style="color: #0b573d;"></i>Payment Status
                                            </label>
                                            <select class="form-select border-0 shadow-sm" 
                                                    id="payment_status" name="payment_status" required 
                                                    style="background: #f8f9fa; border-radius: 8px;">
                                                <option value="">Select Payment Status</option>
                                                <option value="paid">Paid</option>
                                                <option value="partially-paid">Partially Paid</option>
                                                <option value="unpaid">Unpaid</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="reservation_status" class="form-label fw-semibold text-dark mb-1" style="font-size:14px;">
                                                <i class="fas fa-bookmark me-2" style="color: #0b573d;"></i>Reservation Status
                                            </label>
                                            <select class="form-select border-0 shadow-sm" 
                                                    id="reservation_status" name="reservation_status" required 
                                                    style="background: #f8f9fa; border-radius: 8px;">
                                                <option value="">Select Status</option>
                                                <option value="reserved">Reserved</option>
                                                <option value="checked-in">Checked In</option>
                                                <option value="checked-out">Checked Out</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Compact Footer -->
                    <div class="modal-footer border-0 bg-light p-3 mt-3" style="border-radius: 0 0 10px 10px;">
                        <div class="d-flex gap-2 ms-auto">
                            <button type="submit" class="btn text-white px-3 py-2" 
                                    style="background: linear-gradient(135deg, #0b573d 0%, #0d6b47 100%); border-radius: 8px; border: none;" 
                                    id="submitButton" disabled>
                                <i class="fas fa-save me-2"></i>Create Reservation
                            </button>
                        </div>
                    </div>

                    <script>
                        function handleStayTypeChange() {
                            const stayType = document.getElementById('stay_type').value;
                            const sessionDiv = document.getElementById('sessionDiv');
                            const sessionSelect = document.getElementById('session');
                            const checkInTime = document.getElementById('check_in_time');
                            const checkOutTime = document.getElementById('check_out_time');
                            
                            if (stayType === 'overnight') {
                                sessionDiv.style.display = 'none';
                                sessionSelect.value = ''; // Clear session selection
                                checkInTime.value = '14:00'; // 2:00 PM
                                checkOutTime.value = '12:00'; // 12:00 PM
                                
                                // Calculate total guests even without session for overnight stays
                                calculateTotalGuestsForOvernight();
                            } else {
                                sessionDiv.style.display = 'block';
                                checkInTime.value = '';
                                checkOutTime.value = '';
                                
                                // Reset fees when switching back to day stay
                                document.getElementById('adult_fee').textContent = '0.00';
                                document.getElementById('child_fee').textContent = '0.00';
                                document.getElementById('total_fee').value = '₱0.00';
                                updateAmount();
                            }
                        }

                        function calculateTotalGuestsForOvernight() {
                            const adults = parseInt(document.getElementById('number_of_adult').value) || 0;
                            const children = parseInt(document.getElementById('number_of_children').value) || 0;
                            const totalGuests = adults + children;
                            
                            // Set total guests
                            document.getElementById('num_guests').value = totalGuests;
                            
                            // For overnight stays, you might want to set entrance fees to 0 or a fixed amount
                            // Adjust this based on your business logic
                            document.getElementById('adult_fee').textContent = '0.00';
                            document.getElementById('child_fee').textContent = '0.00';
                            document.getElementById('total_fee').value = '₱0.00';
                            
                            // Update the total amount
                            updateAmount();
                            validateCapacity();
                        }
                    </script>
                </form>
            </div>
        </div>
    </div>
</div>
 <script>
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
    function updateTimes() {
        const sessionSelect = document.getElementById('session');
        const selectedOption = sessionSelect.options[sessionSelect.selectedIndex];
        
        if (selectedOption.value) {
            const startTime = selectedOption.getAttribute('data-start');
            const endTime = selectedOption.getAttribute('data-end');
            
            document.getElementById('check_in_time').value = startTime;
            document.getElementById('check_out_time').value = endTime;
        } else {
            document.getElementById('check_in_time').value = '';
            document.getElementById('check_out_time').value = '';
        }
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateTimes();
    });
</script>
<script>
    function updateAmount() {
        var roomSelect = document.getElementById('room_type');
        var amountInput = document.getElementById('amount_paid');
        var quantityInput = document.getElementById('quantity');
        var selectedOption = roomSelect.options[roomSelect.selectedIndex];
        var price = selectedOption.getAttribute('data-price');
        var quantity = parseInt(quantityInput.value) || 1;
        
        // Get the total entrance fee (remove the ₱ symbol and convert to number)
        var totalFeeText = document.getElementById('total_fee').value;
        var totalFee = parseFloat(totalFeeText.replace('₱', '')) || 0;
        
        if (price) {
            var roomAmount = parseFloat(price) * quantity;
            var totalAmount = roomAmount + totalFee;
            amountInput.value = totalAmount.toFixed(2);
        } else {
            amountInput.value = totalFee.toFixed(2);
        }
    }

    // Add event listener for quantity changes
    document.getElementById('quantity').addEventListener('change', updateAmount);
</script>
<script>
function calculateTotalGuests() {
    const adults = parseInt(document.getElementById('number_of_adult').value) || 0;
    const children = parseInt(document.getElementById('number_of_children').value) || 0;
    const quantity = parseInt(document.getElementById('quantity').value) || 1;
    const stayType = document.getElementById('stay_type').value;
    
    const sessionSelect = document.getElementById('session');
    const accommodationSelect = document.getElementById('room_type');
    
    // If overnight stay, use the overnight calculation
    if (stayType === 'overnight') {
        calculateTotalGuestsForOvernight();
        return;
    }
    
    if (!sessionSelect || !sessionSelect.value) {
        document.getElementById('adult_fee').textContent = '0.00';
        document.getElementById('child_fee').textContent = '0.00';
        document.getElementById('total_fee').value = '₱0.00';
        document.getElementById('capacity_error').style.display = 'none';
        updateAmount();
        validateCapacity();
        return;
    }

    // Only check capacity if a room is selected
    if (accommodationSelect && accommodationSelect.value) {
        const selectedAccommodation = accommodationSelect.options[accommodationSelect.selectedIndex];
        const capacity = selectedAccommodation ? parseInt(selectedAccommodation.getAttribute('data-capacity')) || 0 : 0;
        const maxCapacity = capacity * quantity;
        
        const totalGuests = adults + children;
        
        // Validate capacity
        if (totalGuests > maxCapacity) {
            document.getElementById('capacity_error').style.display = 'block';
            document.getElementById('max_capacity').textContent = maxCapacity;
        } else {
            document.getElementById('capacity_error').style.display = 'none';
        }
    } else {
        document.getElementById('capacity_error').style.display = 'none';
    }

    const selectedSession = sessionSelect.value;

    $.ajax({
        url: "{{ route('session.fees') }}",
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            session: selectedSession
        },
        success: function(response) {
            try {
                const adultFee = parseFloat(response.adult_fee) || 0;
                const childFee = parseFloat(response.child_fee) || 0;

                document.getElementById('adult_fee').textContent = adultFee.toFixed(2);
                document.getElementById('child_fee').textContent = childFee.toFixed(2);

                const totalGuests = adults + children;
                const totalFee = (adults * adultFee) + (children * childFee);

                document.getElementById('num_guests').value = totalGuests;
                document.getElementById('total_fee').value = '₱' + totalFee.toFixed(2);
                
                // Update the total amount after calculating fees
                updateAmount();
                validateCapacity();
            } catch (error) {
                console.error('Error processing response:', error);
                document.getElementById('adult_fee').textContent = '0.00';
                document.getElementById('child_fee').textContent = '0.00';
                document.getElementById('total_fee').value = '₱0.00';
                updateAmount();
                validateCapacity();
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            document.getElementById('adult_fee').textContent = '0.00';
            document.getElementById('child_fee').textContent = '0.00';
            document.getElementById('total_fee').value = '₱0.00';
            updateAmount();
            validateCapacity();
        }
    });
}

function validateCapacity() {
    const roomTypeSelect = document.getElementById('room_type');
    const quantityInput = document.getElementById('quantity');
    const adultsInput = document.getElementById('number_of_adult');
    const childrenInput = document.getElementById('number_of_children');
    const submitButton = document.getElementById('submitButton');
    const capacityError = document.getElementById('capacity_error');

    if (!roomTypeSelect.value) {
        submitButton.disabled = false;
        return true;
    }

    const selectedOption = roomTypeSelect.options[roomTypeSelect.selectedIndex];
    const capacity = parseInt(selectedOption.getAttribute('data-capacity')) || 0;
    const quantity = parseInt(quantityInput.value) || 1;
    const adults = parseInt(adultsInput.value) || 0;
    const children = parseInt(childrenInput.value) || 0;
    const totalGuests = adults + children;
    const maxCapacity = capacity * quantity;

    if (totalGuests > maxCapacity) {
        submitButton.disabled = true;
        capacityError.style.display = 'block';
        capacityError.textContent = `Total guests exceeds accommodation capacity! Maximum allowed: ${maxCapacity}`;
        return false;
    } else {
        submitButton.disabled = false;
        capacityError.style.display = 'none';
        return true;
    }
}

function validateQuantity() {
    const roomTypeSelect = document.getElementById('room_type');
    const quantityInput = document.getElementById('quantity');
    const quantityError = document.getElementById('quantity_error');
    const selectedOption = roomTypeSelect.options[roomTypeSelect.selectedIndex];

    if (selectedOption.value) {
        const availableCapacity = parseInt(selectedOption.getAttribute('data-capacity'));
        const enteredQuantity = parseInt(quantityInput.value);

        if (enteredQuantity > availableCapacity) {
            quantityInput.classList.add('is-invalid');
            quantityError.style.display = 'block';
        } else {
            quantityInput.classList.remove('is-invalid');
            quantityError.style.display = 'none';
        }
    } else {
        // If no room type is selected, hide the error
        quantityInput.classList.remove('is-invalid');
        quantityError.style.display = 'none';
    }
    validateCapacity();
    updateAmount();
}

function updateAmountAndTotal() {
    // Update the amount paid based on selected room
    updateAmount();
    validateQuantity(); // Call validation when room type or other related fields change
    validateCapacity();
}

// Update all event listeners
document.getElementById('room_type').addEventListener('change', function() {
    updateAmountAndTotal();
});

document.getElementById('quantity').addEventListener('input', function() {
    updateAmountAndTotal();
});

document.getElementById('number_of_adult').addEventListener('input', function() {
    calculateTotalGuests();
});

document.getElementById('number_of_children').addEventListener('input', function() {
    calculateTotalGuests();
});

// Form submission handler
document.querySelector('form').addEventListener('submit', function(e) {
    if (!validateCapacity()) {
        e.preventDefault();
        alert('Cannot submit form: Total guests exceeds accommodation capacity!');
    }
});

// Initial validation on page load
document.addEventListener('DOMContentLoaded', function() {
    updateAmountAndTotal();
    validateCapacity();
});
</script>

<!-- SCRIPT FOR ADDING RESERVATION -->
 <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('.needs-validation');
        const submitBtn = document.getElementById('submitButton');

        const requiredFields = form.querySelectorAll('[required]');

        function checkFormValidity() {
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value || (field.type === 'select-one' && field.selectedIndex === 0)) {
                    isValid = false;
                }
            });

            submitBtn.disabled = !isValid;
        }

        requiredFields.forEach(field => {
            field.addEventListener('input', checkFormValidity);
            field.addEventListener('change', checkFormValidity);
        });

        // Initial check (in case browser pre-fills anything)
        checkFormValidity();
    });
</script>
<!-- SCRIPT FOR CHECKING THE DATE AVAILABILITY -->
<script>
function checkAvailability(date, accommodationId = null, quantity = 1) {
    if (!date) return;
    
    const dateInput = document.getElementById('check_in_date');
    const errorElement = document.getElementById('date_error');
    const submitBtn = document.getElementById('submitButton');
    
    // Get values from form if not provided
    if (!accommodationId) {
        const roomSelect = document.getElementById('room_type');
        accommodationId = roomSelect?.value;
    }
    if (quantity === 1) {
        const quantityInput = document.getElementById('quantity');
        quantity = parseInt(quantityInput?.value) || 1;
    }
    
    // Show loading state
    showStatus('loading', 'Checking availability...', dateInput, errorElement);
    
    // Fixed URL - make sure this matches your route
    fetch('/check-availability', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json' // Important: tell server we expect JSON
        },
        body: JSON.stringify({
            date: date,
            accommodation_id: accommodationId,
            quantity: quantity
        })
    })
    .then(response => {
        // Check if response is actually JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Server returned HTML instead of JSON. Check your route.');
        }
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        return response.json();
    })
    .then(data => {
        if (data.available) {
            showStatus('success', data.message || 'Available', dateInput, errorElement);
            submitBtn.disabled = false;
        } else {
            showStatus('error', data.message || 'Not available', dateInput, errorElement);
            submitBtn.disabled = true;
        }
    })
    .catch(error => {
        console.error('Availability check failed:', error);
        showStatus('error', 'Unable to check availability. Please try again.', dateInput, errorElement);
        submitBtn.disabled = true;
    });
}

function showStatus(type, message, dateInput, errorElement) {
    const icons = {
        loading: '<i class="fas fa-spinner fa-spin me-1"></i>',
        success: '<i class="fas fa-check-circle me-1"></i>',
        error: '<i class="fas fa-exclamation-triangle me-1"></i>'
    };
    
    const styles = {
        loading: { border: '#ffc107', class: 'text-warning' },
        success: { border: '#28a745', class: 'text-success' },
        error: { border: '#dc3545', class: 'text-danger' }
    };
    
    dateInput.style.borderColor = styles[type].border;
    errorElement.innerHTML = icons[type] + message;
    errorElement.className = `invalid-feedback ${styles[type].class}`;
    errorElement.style.display = 'block';
    
    // Hide success message after 3 seconds
    if (type === 'success') {
        setTimeout(() => errorElement.style.display = 'none', 3000);
    }
}

// Initialize event listeners
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    const dateInput = document.getElementById('check_in_date');
    dateInput.setAttribute('min', today);
    
    // Check availability when inputs change
    dateInput.addEventListener('change', function() {
        if (this.value) checkAvailability(this.value);
    });
    
    const roomSelect = document.getElementById('room_type');
    const quantityInput = document.getElementById('quantity');
    
    roomSelect?.addEventListener('change', function() {
        const date = dateInput.value;
        if (date) checkAvailability(date);
    });
    
    quantityInput?.addEventListener('input', function() {
        const date = dateInput.value;
        if (date) checkAvailability(date);
    });
});

// Additional modal event handlers to prevent scrollbar issues
document.addEventListener('DOMContentLoaded', function() {
    // Handle all modals on the page
    const modals = document.querySelectorAll('.modal');
    
    modals.forEach(function(modal) {
        // When modal is about to show
        modal.addEventListener('show.bs.modal', function() {
            // Force hide horizontal scrollbar
            document.body.style.overflowX = 'hidden';
            document.documentElement.style.overflowX = 'hidden';
        });
        
        // When modal is shown
        modal.addEventListener('shown.bs.modal', function() {
            // Ensure no horizontal scrollbar
            document.body.style.overflowX = 'hidden';
            document.documentElement.style.overflowX = 'hidden';
            document.body.style.paddingRight = '0px';
        });
        
        // When modal is about to hide
        modal.addEventListener('hide.bs.modal', function() {
            // Keep horizontal scrollbar hidden
            document.body.style.overflowX = 'hidden';
            document.documentElement.style.overflowX = 'hidden';
        });
        
        // When modal is completely hidden
        modal.addEventListener('hidden.bs.modal', function() {
            // Ensure horizontal scrollbar stays hidden
            document.body.style.overflowX = 'hidden';
            document.documentElement.style.overflowX = 'hidden';
            document.body.style.paddingRight = '0px';
            
            // Remove any Bootstrap added classes that might cause issues
            document.body.classList.remove('modal-open');
            
            // Force cleanup of any remaining modal backdrop
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());
        });
    });
    
    // Override Bootstrap's modal padding adjustment
    const originalShow = bootstrap.Modal.prototype.show;
    const originalHide = bootstrap.Modal.prototype.hide;
    
    bootstrap.Modal.prototype.show = function() {
        originalShow.call(this);
        // Force no horizontal scroll and no padding adjustment
        setTimeout(() => {
            document.body.style.overflowX = 'hidden';
            document.body.style.paddingRight = '0px';
        }, 0);
    };
    
    bootstrap.Modal.prototype.hide = function() {
        originalHide.call(this);
        // Ensure cleanup
        setTimeout(() => {
            document.body.style.overflowX = 'hidden';
            document.body.style.paddingRight = '0px';
        }, 300); // Wait for modal transition
    };
});
// Date validation for check-in and check-out dates
function validateReservationDates() {
    const checkInDate = document.getElementById('check_in_date');
    const checkOutDate = document.getElementById('check_out_date');
    const dateError = document.getElementById('checkout_date_error');
    
    if (!checkInDate.value || !checkOutDate.value) {
        return true; // Don't validate if either date is empty
    }
    
    const checkIn = new Date(checkInDate.value);
    const checkOut = new Date(checkOutDate.value);
    
    // Check if check-out date is before check-in date
    if (checkOut < checkIn) {
        showDateError(checkOutDate, dateError, 'Check-out date cannot be before check-in date.');
        return false;
    } else {
        hideDateError(checkOutDate, dateError);
        return true;
    }
}

function showDateError(input, errorElement, message) {
    input.style.borderColor = '#dc3545';
    input.classList.add('is-invalid');
    
    if (!errorElement) {
        // Create error element if it doesn't exist
        const newErrorElement = document.createElement('div');
        newErrorElement.id = 'checkout_date_error';
        newErrorElement.className = 'invalid-feedback text-danger';
        newErrorElement.style.display = 'block';
        input.parentNode.appendChild(newErrorElement);
        errorElement = newErrorElement;
    }
    
    errorElement.innerHTML = `<i class="fas fa-exclamation-triangle me-1"></i>${message}`;
    errorElement.style.display = 'block';
}

function hideDateError(input, errorElement) {
    input.style.borderColor = '#28a745';
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
    
    if (errorElement) {
        errorElement.style.display = 'none';
    }
    
    // Remove valid class after 3 seconds for cleaner look
    setTimeout(() => {
        input.classList.remove('is-valid');
        input.style.borderColor = '';
    }, 3000);
}

function updateCheckOutMinDate() {
    const checkInDate = document.getElementById('check_in_date');
    const checkOutDate = document.getElementById('check_out_date');
    
    if (checkInDate.value) {
        // Set minimum check-out date to be the same as check-in date
        checkOutDate.setAttribute('min', checkInDate.value);
        
        // If current check-out date is before new check-in date, clear it
        if (checkOutDate.value && checkOutDate.value < checkInDate.value) {
            checkOutDate.value = '';
        }
    }
}

function initializeDateValidation() {
    const checkInDate = document.getElementById('check_in_date');
    const checkOutDate = document.getElementById('check_out_date');
    const today = new Date().toISOString().split('T')[0];
    
    // Set minimum date to today for both inputs
    checkInDate.setAttribute('min', today);
    checkOutDate.setAttribute('min', today);
    
    // Add event listeners
    checkInDate.addEventListener('change', function() {
        updateCheckOutMinDate();
        validateReservationDates();
        
        // Also trigger availability check if it exists
        if (typeof checkAvailability === 'function' && this.value) {
            checkAvailability(this.value);
        }
    });
    
    checkOutDate.addEventListener('change', function() {
        validateReservationDates();
    });
    
    // Add form submission validation
    const form = document.querySelector('form[action*="walkin.store"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateReservationDates()) {
                e.preventDefault();
                
                // Focus on the problematic field
                const checkOutDate = document.getElementById('check_out_date');
                checkOutDate.focus();
                
                // Show alert
                alert('Please fix the date validation errors before submitting.');
                return false;
            }
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeDateValidation();
});

// Also initialize when modal is shown (in case DOM content was loaded before modal HTML)
document.addEventListener('shown.bs.modal', function(event) {
    if (event.target.id === 'addWalkInModal') {
        initializeDateValidation();
    }
});
</script>
<!-- Error Handling for Mobile Number -->
 <script>
// Function to allow only numbers
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

// Function to validate phone number length
function validatePhoneNumber(input) {
    const phoneError = document.getElementById('phone_error');
    const value = input.value;
    
    // Remove any non-numeric characters
    input.value = value.replace(/[^0-9]/g, '');
    
    // Check if length is exactly 11
    if (input.value.length > 0 && input.value.length !== 11) {
        input.classList.add('is-invalid');
        phoneError.style.display = 'block';
        
        // Update error message based on length
        if (input.value.length < 11) {
            phoneError.innerHTML = '<i class="fas fa-exclamation-circle me-1" style="color: #dc3545;"></i>Phone number must be exactly 11 digits. Currently: ' + input.value.length + ' digits.';
        } else if (input.value.length > 11) {
            phoneError.innerHTML = '<i class="fas fa-exclamation-circle me-1" style="color: #dc3545;"></i>Phone number cannot exceed 11 digits.';
            // Trim to 11 digits
            input.value = input.value.substring(0, 11);
        }
    } else if (input.value.length === 11) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        phoneError.style.display = 'none';
    } else if (input.value.length === 0) {
        input.classList.remove('is-invalid', 'is-valid');
        phoneError.style.display = 'none';
    }
}

// Additional validation on form submit
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const phoneInput = document.getElementById('phone');
            if (phoneInput.value.length !== 11) {
                e.preventDefault();
                phoneInput.classList.add('is-invalid');
                document.getElementById('phone_error').style.display = 'block';
                document.getElementById('phone_error').innerHTML = '<i class="fas fa-exclamation-circle me-1" style="color: #dc3545;"></i>Phone number must be exactly 11 digits before submitting.';
                phoneInput.focus();
            }
        });
    }
});
</script>
</body>
</html>