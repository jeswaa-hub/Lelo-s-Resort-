<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lelo's Resort</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo new.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    .animate-button {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(0, 87, 61, 0.5);
    }

    .animate-button.icon-move>span>i {
        animation: move-icon 0.5s ease-in-out infinite alternate;
    }

    @keyframes move-icon {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(10px);
        }
    }

    .room-card {
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }

    .room-card:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 24px rgba(11, 87, 61, 0.15);
    }

    .room-card,
    .room-card * {
        user-select: none;
    }

    /* Hover for small screens */
</style>

<body>
    <x-loading-screen />
    @include('Alert.loginSuccessUser')
    <div class="d-none d-md-block"
        style="position: absolute; top: 0; right: 0; width: 45%; height: 100vh; background-color: rgba(0, 0, 0, 0.5); z-index: 1; border-radius: 550px 0 0 600px;">
    </div>

    <style>
        @media (max-width: 1200px) {
            .d-none {
                display: none !important;
            }
        }
    </style>
    <!-- Logo -->
    <div class="position-absolute top-0 end-0 m-4 d-none d-md-block mb-5 mt-0" style="z-index: 3;">
        <img src="{{ asset('images/logo new.png') }}" alt="Lelo's Resort Logo" style="width: 150px; height: auto;">
    </div>
    <nav class="navbar position-absolute w-100 mt-5" style="z-index: 10;">
        <div class="container d-flex justify-content-between align-items-center">

            <!-- Profile and hamburger moved to left side -->
            <div class="d-flex align-items-center gap-3 order-lg-1">

                <!-- Hamburger Menu -->
                <!-- Hamburger Menu -->
                <button class="navbar-toggler p-2 rounded-3 border-2 border-white shadow-sm hover:shadow-lg d-md-none"
                    type="button" data-bs-toggle="offcanvas" data-bs-target="#sideNavbar" aria-controls="sideNavbar"
                    aria-expanded="false" aria-label="Toggle navigation" style="transition: all 0.3s ease;">
                    <i class="bi bi-list fw-bold fs-2 fw-bolder" style="color: #ffffff;"></i>
                </button>

                <!-- Profile Icon -->
                <div class="d-flex align-items-center">
                    <a href="{{ route('profile') }}" class="text-decoration-none d-flex align-items-center">
                        <div class="profile-icon d-flex align-items-center justify-content-center me-2" style="width: 45px; height: 45px; background-color: #0b573d; border-radius: 50%;
                                    transition: all 0.3s ease; box-shadow: 0 2px 5px rgba(0,0,0,0.2);"
                            onmouseover="this.style.transform='scale(1.1)';"
                            onmouseout="this.style.transform='scale(1)';">
                            <i class="fa-solid fa-user fa-lg" style="color: #ffffff;"></i>
                        </div>
                        <span class="me-3 mt-2 fw-semibold"
style="color:rgb(255, 255, 255); font-size: clamp(0.8rem, 2vw, 1.3rem); letter-spacing: 0.1rem; font-family:'Montserrat'">{{ implode(' ', array_slice(explode(' ', trim(Auth::user()->name ?? 'Guest')), 0, 2)) }}</span>
                    </a>
                </div>
            </div>

            <!-- Desktop Navigation (centered) -->
            <div class="collapse navbar-collapse justify-content-center order-lg-3" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0 d-none d-lg-flex">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase text-decoration-none text-white"
                            style="font-family: 'Josefin Sans', sans-serif;" href="#rooms">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase text-decoration-none text-white"
                            style="font-family: 'Josefin Sans', sans-serif;" href="#activities">Activities</a>
                    </li>
                </ul>
            </div>

            <!-- Offcanvas Menu (same as before) -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="sideNavbar" aria-labelledby="sideNavbarLabel"
                style="width: 300px;">
                <div class="offcanvas-header" style="background-color: #0b573d; padding: 1.5rem;">
                    <div class="d-flex align-items-center w-100 justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('images/logo new.png') }}" alt="Lelo's Resort Logo" class="me-3"
                                style="width: 60px; height: auto;">
                            <h5 class="offcanvas-title text-white mb-0" id="sideNavbarLabel"
                                style="font-size: 1.5rem; font-weight: 700;">
                                LELO'S RESORT
                            </h5>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                </div>
                <div class="offcanvas-body" style="background-color: #f8fff4;">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-3 py-3 px-4 border-bottom" href="#rooms">
                                <i class="fas fa-bed" style="color: #0b573d; font-size: 1.2rem;"></i>
                                <span class="fw-semibold text-uppercase"
                                    style="color: #0b573d; letter-spacing: 2px; font-size: 1.1rem;">
                                    Rooms
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-3 py-3 px-4 border-bottom"
                                href="#activities">
                                <i class="fas fa-swimming-pool" style="color: #0b573d; font-size: 1.2rem;"></i>
                                <span class="fw-semibold text-uppercase"
                                    style="color: #0b573d; letter-spacing: 2px; font-size: 1.1rem;">
                                    Activities
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- First Page -->
    <section id="home">
        <div class="smoke"></div>
        <!-- Hero Section with Background -->
        <div class="hero vh-100 d-flex flex-column justify-content-center align-items-center text-center text-light position-relative"
            style="background: url('{{ asset('images/background.png') }}') no-repeat center; background-size: cover; overflow: hidden">

            <!-- Hero Content -->
            <div id="hero" class="container" style="z-index: 2;">
                <div class="row align-items-center">
                    <!-- Right Column -->
                    <div class="col-lg-8 col-md-12">
                        <!-- Empty column -->
                    </div>
                    <!-- Left Column (moved to right) -->
                    <div class="col-lg-4 col-md-12 text-center">
                        <div class="d-flex justify-content-center align-items-center">
                            <h1 class="text-white" style="font-size: clamp(24px, 2vw, 32px); letter-spacing: 5px;">
                                WELCOME TO</h1>
                        </div>
                        <p class="fw-bold"
                            style="color:#e9ffcc; font-size: clamp(48px, 7vw, 84px); font-weight: 900; line-height: .8;">
                            LELO'S</p>
                        <p class="fw-bold"
                            style="color:#e9ffcc; font-size: clamp(64px, 10vw, 120px); font-weight: 900; line-height: .8;">
                            RESORT</p>
                        <h1 class="text-white" style="font-size: clamp(18px, 1.5vw, 24px); letter-spacing: 5px">DIGITAL
                            BOOKING COMPANION</h1>
                        <!-- Responsive Button -->
                        <div class="d-flex justify-content-center mt-4">
                            <a href="{{ route('calendar') }}"
                                class="btn btn-success d-flex align-items-center gap-2 px-4 py-2 fw-bold text-white"
                                style="background-color: #0b573d; font-style: italic; transition: all 0.3s ease-in-out; font-size: clamp(16px, 1.2vw, 20px);"
                                onmouseover="this.classList.add('animate-button'); this.classList.add('icon-move');"
                                onmouseout="this.classList.remove('animate-button'); this.classList.remove('icon-move');">
                                BOOK YOUR STAY
                                <span class="d-flex align-items-center justify-content-center bg-white rounded-circle"
                                    style="width: clamp(1.5rem, 1.8vw, 1.8rem); height: clamp(1.5rem, 1.8vw, 1.8rem); transition: all 0.3s ease-in-out;">
                                    <i class="fas fa-chevron-right"
                                        style="color: #0b573d; transform: translateX(0);"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
    <!-- Accommodations Section -->
    <section id="rooms">
        <div class="container text-center my-5">
            <div class="py-5">
                <div class="position-relative">
                    <!-- Main heading with enhanced styling -->
                    <div class="position-relative px-4 py-3 w-100"
                        style="background-color: #eaffcc; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <h1 class="fw-bolder text-success display-5"
                            style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1); font-weight: 900;">
                            ROOMS
                        </h1>
                    </div>
                </div>
            </div>

            <!-- Subtitle with enhanced styling -->
            <p class="fst-italic text-success mb-4" style="font-size: 1.2rem; letter-spacing: 0.5px;">
                Discover your perfect stay - choose from our selection of rooms
            </p>

            <!-- Decorative line -->
            <div class="d-flex justify-content-center align-items-center gap-3 mb-4">
                <div style="height: 2px; width: 50px; background-color: #0b573d;"></div>
                <i class="bi bi-star-fill text-success"></i>
                <div style="height: 2px; width: 50px; background-color: #0b573d;"></div>
            </div>

            <!-- Display all accommodation types in a single view -->
            <div class="row g-4 justify-content-center">
                @php
                    $displayedTypes = ['room' => false, 'cottage' => false, 'cabin' => false];
                @endphp

                @foreach($accommodations as $accommodation)
                    @if(!$displayedTypes[$accommodation->accomodation_type])
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 room-card"
                                style="border-radius: 20px; overflow: hidden;"
                                data-bs-toggle="modal" data-bs-target="#roomDetailsModal"
                                data-room="{{ $accommodation->accomodation_name }}"
                                data-roomid="{{ $accommodation->accomodation_id }}"
                                data-roomimg="{{ asset('storage/' . $accommodation->accomodation_image) }}"
                                data-roomprice="{{ number_format($accommodation->accomodation_price, 2) }}"
                                data-description="{{ $accommodation->accomodation_description }}"
                                data-amenities="{{ $accommodation->amenities }}"
                                data-capacity="{{ $accommodation->accomodation_capacity }}">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $accommodation->accomodation_image) }}" class="card-img-top"
                                        alt="{{ $accommodation->accomodation_name }}"
                                        style="border-radius: 20px 20px 0 0; height: 250px; object-fit: cover;">
                                    <div class="position-absolute bottom-0 end-0 m-2 px-3 py-1 bg-success text-white fw-bold"
                                        style="border-radius: 8px; font-style: italic; font-size: 1.2rem;">
                                        Price: ₱ {{ number_format($accommodation->accomodation_price, 2) }}
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <h5 class="card-title mb-0" style="font-style: italic; color: #0b573d; font-size: 1.5rem;">
                                        {{ $accommodation->accomodation_name }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                        @php
                            $displayedTypes[$accommodation->accomodation_type] = true;
                        @endphp
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- Room Details Modal -->
    <div class="modal fade" id="roomDetailsModal" tabindex="-1" aria-labelledby="roomDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
                <div class="modal-header"
                    style="background-color: #0b573d; color: white; border-bottom: 3px solid #E6F4E6;">
                    <h5 class="modal-title fw-bold" id="roomDetailsModalLabel" style="font-size: 1.5rem;">
                        <i class="bi bi-house-heart-fill me-2"></i>Room Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: #f8f9fa;">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="position-relative">
                                <img id="modalRoomImage" src="" class="img-fluid rounded shadow"
                                    alt="Room Image"
                                    style="max-height: 300px; width: 100%; object-fit: cover;">
                                <div
                                    class="position-absolute bottom-0 start-0 m-3 px-3 py-2 bg-success bg-opacity-75 rounded-pill">
                                    <h4 class="text-white mb-0">₱<span id="modalRoomPrice"
                                            class="fw-bold"></span></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3 id="modalRoomName" class="fw-bold mb-4"
                                style="color: #0b573d; font-size: 2rem;"></h3>

                            <div class="info-section mb-4 text-start">
                                <h5 class="d-flex align-items-start" style="color: #0b573d;">
                                    <i class="bi bi-card-text me-2"></i>Description
                                </h5>
                                <p id="modalRoomDescription" class="ms-4 text-muted"></p>
                            </div>

                            <div class="info-section mb-4 text-start">
                                <h5 class="d-flex align-items-start" style="color: #0b573d;">
                                    <i class="bi bi-stars me-2"></i>Amenities
                                </h5>
                                <p id="modalRoomAmenities" class="ms-4 text-muted"></p>
                            </div>

                            <div class="info-section text-start">
                                <h5 class="d-flex align-items-start" style="color: #0b573d;">
                                    <i class="bi bi-people-fill me-2"></i>Capacity
                                </h5>
                                <p id="modalRoomCapacity" class="ms-4 text-muted"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roomCards = document.querySelectorAll('.room-card');

            roomCards.forEach(card => {
                card.addEventListener('click', function () {
                    // Get data from clicked card
                    const roomName = this.dataset.room;
                    const roomImg = this.dataset.roomimg;
                    const roomPrice = this.dataset.roomprice;
                    const description = this.dataset.description;
                    const amenities = this.dataset.amenities;
                    const capacity = this.dataset.capacity;

                    // Update modal content
                    document.getElementById('modalRoomName').textContent = roomName;
                    document.getElementById('modalRoomImage').src = roomImg;
                    document.getElementById('modalRoomPrice').textContent = roomPrice;
                    document.getElementById('modalRoomDescription').textContent = description;
                    document.getElementById('modalRoomAmenities').textContent = amenities;
                    document.getElementById('modalRoomCapacity').textContent = `Good for ${capacity} persons`;
                });
            });
        });
    </script>
    <!-- Reservation Modal -->
    <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content" style="border-radius: 24px; border: 3px solid #0b573d;">
                <div class="modal-header"
                    style="border-top-left-radius: 24px; border-top-right-radius: 24px; background-color: #0b573d;">
                    <h5 class="modal-title fw-bold text-white" id="reservationModalLabel" style="font-size: 2rem;">
                        Reservation Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Add Error Message Alert -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Add Success Message Alert -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <!--activity section -->
    <section id="activities">
        <div class="container text-center my-5">
            <div class="py-5">
                <div class="position-relative">
                    <!-- Main heading with enhanced styling -->
                    <div class="position-relative px-4 py-3"
                        style="background-color: #eaffcc; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <h1 class="fw-bolder text-success display-5"
                            style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1); font-weight: 900;">
                            ACTIVITIES
                        </h1>
                    </div>
                </div>
            </div>

            <!-- Subtitle with enhanced styling -->
            <p class="fst-italic text-success mb-4" style="font-size: 1.2rem; letter-spacing: 0.5px;">
                Explore fun, engaging activities for all ages—whether you're into adventure or relaxation!
            </p>

            <!-- Decorative line -->
            <div class="d-flex justify-content-center align-items-center gap-3 mb-4">
                <div style="height: 2px; width: 50px; background-color: #0b573d;"></div>
                <i class="bi bi-star-fill text-success"></i>
                <div style="height: 2px; width: 50px; background-color: #0b573d;"></div>
            </div>

            <div class="row g-4">
                @foreach($activities->chunk(3) as $chunk)
                    <div class="row g-4 mb-4">
                        @foreach($chunk as $activity)
                            <div class="col-md-4">
                                <div class="card h-100 shadow-sm border-0" style="border-radius: 20px; overflow: hidden; cursor: pointer;"
                                     data-bs-toggle="modal" data-bs-target="#activityModal"
                                     data-activity="{{ $activity->activity_name }}" data-description="{{ $activity->activity_description ?? 'No description available.' }}"
                                     data-image="{{ asset('storage/' . $activity->activity_image) }}">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $activity->activity_image) }}" class="card-img-top"
                                            alt="{{ $activity->activity_name }}"
                                            style="border-radius: 20px 20px 0 0; height: 180px; object-fit: cover;">
                                    </div>
                                    <div class="card-body p-2">
                                        <h5 class="card-title mb-0" style="font-style: italic; color: #0b573d;">
                                            {{ $activity->activity_name }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Activity Details Modal -->
        <div class="modal fade" id="activityModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
                    <div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #0b573d, #198754);">
                        <h5 class="modal-title fw-bold" id="activityModalLabel">
                            <i class="bi bi-activity me-2"></i>Activity Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4" style="background-color: #f8f9fa;">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <img id="modalActivityImage" src="" class="img-fluid rounded shadow-sm" alt="Activity Image" style="height: 100%; max-height: 300px; width: 100%; object-fit: cover;">
                            </div>
                            <div class="col-md-6 d-flex flex-column">
                                <h3 id="modalActivityName" class="fw-bold mb-3" style="color: #0b573d;"></h3>
                                <p id="modalActivityDescription" class="text-muted mb-4 flex-grow-1"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const activityModal = document.getElementById('activityModal');
                activityModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const activityName = button.getAttribute('data-activity');
                    const activityImage = button.getAttribute('data-image');
                    const activityDescription = button.getAttribute('data-description');
                    
                    document.getElementById('modalActivityName').textContent = activityName;
                    document.getElementById('modalActivityImage').src = activityImage;
                    document.getElementById('modalActivityDescription').textContent = activityDescription;
                });
            });
        </script>
    </section>
    <!-- footer section -->
    <footer style="background-color: #0b573d; color: white;font-size: 10px;">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left: Logo -->
                <div class="col-md-4 mb-2 text-md-start text-center">
                    <img src="{{ asset('images/logo2.png') }}" alt="Lelo's Resort Logo" class="img-fluid"
                        style="max-width: 110px;">
                </div>
                <!-- Center: Contact Info -->
                <div class="col-md-4 mb-2 text-center">
                    <div class="d-flex flex-column gap-2 justify-content-center h-100">
                        <div>
                            <i class="bi bi-telephone-fill me-2"></i>
                            <span style="font-size: 14px; letter-spacing: 1px;">0917-100-4555
                            </span>
                        </div>
                        <div>
                            <i class="bi bi-envelope-fill me-2"></i>
                            <span style="font-size: 14px; letter-spacing: 1px;">lelosresort@gmail.com</span>
                        </div>
                        <div>
                            <a href="https://facebook.com/lelosmountainresort"
                                style="color: white; font-size: 14px; letter-spacing: 1px; text-decoration: none;">
                                <i class="bi bi-facebook me-2"></i>
                                facebook.com/lelosmountainresort
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right: Terms and Privacy -->
                <!-- Right: Terms of Service and Privacy Policy -->
                <div class="col-md-4 mb-3">
                    <div class="col text-center">
                        <div class="d-flex flex-column align-items-center">
                            <div class="d-flex flex-wrap justify-content-center">
                                <a href="#" class="text-white text-decoration-none" style="font-size: 14px;"
                                    data-bs-toggle="modal" data-bs-target="#termsModal">TERMS AND CONDITIONS</a>
                                <span class="text-white mx-2" style="font-size: 14px;">|</span>
                                <a href="#" class="text-white text-decoration-none" style="font-size: 14px;"
                                    data-bs-toggle="modal" data-bs-target="#privacyModal">PRIVACY POLICY</a>
                            </div>
                            <div class="mt-3">
                                <span class="text-white" style="font-size: 14px;">© 2025 Lelo's Resort. All rights
                                    reserved.</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- TERMS AND CONDITIONS MODAL -->
                    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">

                                <!-- Header -->
                                <div class="modal-header bg-success text-white py-2">
                                    <h5 class="modal-title fw-bold" id="termsModalLabel" style="font-size: 1.2rem;">
                                        Terms and Conditions
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <!-- Body -->
                                <div class="modal-body px-4 py-3"
                                    style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; color: #333;">

                                    <!-- Section Title -->
                                    <p class="fw-bold text-success mb-1" style="font-size: 1rem;">Reservation Agreement
                                    </p>
                                    <p class="mb-4">
                                        By confirming a reservation, guests acknowledge and agree to all terms and
                                        conditions set by Lelo's Resort management.
                                    </p>

                                    <!-- Payment Policy -->
                                    <p class="fw-bold text-success mb-1" style="font-size: 1rem;">Payment Policy</p>
                                    <ul class="ps-4 mb-4">
                                        <li>Full payment is required in advance to secure the reservation.</li>
                                        <li>All payments are strictly non-refundable, regardless of:</li>
                                        <ul class="ps-4">
                                            <li>Cancellations</li>
                                            <li>Date changes</li>
                                            <li>Late arrivals</li>
                                            <li>Early departures</li>
                                            <li>No-shows</li>
                                            <li>Weather disturbances</li>
                                        </ul>
                                    </ul>

                                    <!-- Security Deposit -->
                                    <p class="fw-bold text-success mb-1" style="font-size: 1rem;">Security Deposit</p>
                                    <ul class="ps-4 mb-4">
                                        <li>A security deposit of 50% of the total booking amount is required at
                                            check-in.</li>
                                        <li>The deposit covers potential damages, losses, and rule violations.</li>
                                        <li>Fully refundable upon inspection at check-out if no issues are found.</li>
                                    </ul>

                                    <!-- Check-in/Check-out -->
                                    <p class="fw-bold text-success mb-1" style="font-size: 1rem;">Check-in / Check-out
                                        Policy</p>
                                    <ul class="ps-4 mb-4">
                                        <li>Check-in: 2:00 PM</li>
                                        <li>Check-out: 12:00 PM</li>
                                        <li>Early check-in/late check-out subject to availability and fees.</li>
                                    </ul>

                                    <!-- Resort Rules -->
                                    <p class="fw-bold text-success mb-1" style="font-size: 1rem;">Resort Rules</p>
                                    <ul class="ps-4">
                                        <li>Quiet hours: 10:00 PM - 6:00 AM</li>
                                        <li>No smoking in rooms</li>
                                        <li>No pets allowed</li>
                                        <li>Guests liable for damages</li>
                                    </ul>

                                </div>

                                <!-- Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Privacy Policy Modal -->
                    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">

                                <!-- Header -->
                                <div class="modal-header bg-success text-white py-2">
                                    <h5 class="modal-title fw-bold" id="privacyModalLabel" style="font-size: 1.2rem;">
                                        Data Privacy Notice
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <!-- Body -->
                                <div class="modal-body px-4 py-3"
                                    style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; color: #333;">

                                    <!-- Data Privacy Act Compliance -->
                                    <p class="fw-bold text-success mb-1" style="font-size: 1rem;">Data Privacy Act
                                        Compliance</p>
                                    <p>
                                        In accordance with Republic Act 10173 (Data Privacy Act of 2012), Lelo's Resort
                                        is committed
                                        to protecting your personal information. By using our services:
                                    </p>
                                    <ul class="ps-4 mb-4">
                                        <li>You consent to the collection and processing of your personal data</li>
                                        <li>Your information will be:</li>
                                        <ul class="ps-4">
                                            <li>Securely stored and protected</li>
                                            <li>Used only for legitimate business purposes</li>
                                            <li>Retained only for the duration required by law</li>
                                            <li>Never shared with third parties without consent</li>
                                        </ul>
                                    </ul>

                                    <!-- Your Rights -->
                                    <p class="fw-bold text-success mb-1" style="font-size: 1rem;">Your Rights</p>
                                    <ul class="ps-4 mb-4">
                                        <li>Access your personal data</li>
                                        <li>Request corrections or deletions</li>
                                        <li>Object to processing</li>
                                        <li>File a complaint</li>
                                    </ul>

                                    <!-- Contact -->
                                    <div class="text-center mt-4">
                                        <p>For privacy concerns, contact us at:</p>
                                        <p>
                                            <a href="mailto:lelosresort@gmail.com"
                                                class="text-decoration-none fw-bold text-success">
                                                lelosresort@gmail.com
                                            </a>
                                        </p>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const offcanvasElement = document.getElementById('sideNavbar');
            const closeButton = offcanvasElement.querySelector('.btn-close');
            let isProgrammaticClose = false;
            let scrollPosition = 0;

            // Disable backdrop click
            offcanvasElement.setAttribute('data-bs-backdrop', 'static');

            offcanvasElement.addEventListener('show.bs.offcanvas', function () {
                scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
                offcanvasElement.dataset.previousScroll = scrollPosition;
                document.body.style.top = `-${scrollPosition}px`;
            });

            function customClose(e) {
                if (e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                isProgrammaticClose = true;
                const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                if (bsOffcanvas) {
                    bsOffcanvas.hide();
                }
            }

            // X button
            closeButton.addEventListener('click', function (e) {
                // Save current scroll position before closing
                const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
                offcanvasElement.dataset.previousScroll = currentScroll;
                customClose(e);
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && offcanvasElement.classList.contains('show')) {
                    customClose(e);
                }
            });

            offcanvasElement.addEventListener('hidden.bs.offcanvas', function () {
                document.body.style.position = '';
                document.body.style.width = '';
                document.body.style.top = '';
                // Restore to the saved scroll position
                window.scrollTo(0, parseInt(offcanvasElement.dataset.previousScroll || '0'));
                isProgrammaticClose = false;
            });

            // Override the hide method to prevent closing on outside click
            const originalHide = bootstrap.Offcanvas.prototype.hide;
            bootstrap.Offcanvas.prototype.hide = function () {
                if (!isProgrammaticClose) {
                    return this; // Prevent closing
                }
                originalHide.call(this);
                return this;
            };
        });
    </script>

    <script>
        let roomCapacity = 0;

        document.addEventListener('DOMContentLoaded', function () {
            // Reservation Modal Event Handler
            $('#reservationModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var roomName = button.data('room');
                var roomId = button.data('roomid');
                var roomImg = button.data('roomimg');
                var roomPrice = button.data('roomprice');
                roomCapacity = button.data('roomcapacity');

                // Update modal content
                var modal = $(this);
                modal.find('#modalRoomName').text(roomName);
                modal.find('#modalRoomId').val(roomId);
                modal.find('#modalRoomImg').attr('src', roomImg);
                modal.find('#modalRoomPrice').text('₱ ' + roomPrice);

                // Reset form values
                modal.find('#modalRoomQty').val(1);
                modal.find('#numAdults').val(1);
                modal.find('#numChildren').val(0);
                updateTotalGuests();
            });

            // Function para sa pag-update ng total guests
            function updateTotalGuests() {
                var adults = parseInt($('#numAdults').val()) || 0;
                var children = parseInt($('#numChildren').val()) || 0;
                var quantity = parseInt($('#modalRoomQty').val()) || 1;
                var totalCapacity = roomCapacity * quantity;
                var totalGuests = adults + children;

                $('#totalGuest').val(totalGuests);

                var errorDiv = $('#capacityError');
                if (!errorDiv.length) {
                    $('#totalGuest').after('<div id="capacityError" class="text-danger mt-2"></div>');
                    errorDiv = $('#capacityError');
                }

                if (totalGuests > totalCapacity) {
                    errorDiv.text(`Exceeded maximum capacity of ${totalCapacity} guests!`);
                    $('#reserveButton').prop('disabled', true);
                } else {
                    errorDiv.text('');
                    $('#reserveButton').prop('disabled', false);
                }
            }

            // Event listeners para sa pag-update ng total guests
            $('#numAdults, #numChildren, #modalRoomQty').on('change', updateTotalGuests);
        });

        // Functions para sa quantity buttons
        function incrementQuantity() {
            var input = document.getElementById('modalRoomQty');
            input.value = parseInt(input.value) + 1;
            input.dispatchEvent(new Event('change'));
        }

        function decrementQuantity() {
            var input = document.getElementById('modalRoomQty');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                input.dispatchEvent(new Event('change'));
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const reservationType = document.getElementById('reservationType');
            const checkInDate = document.getElementById('checkInDate');
            const checkOutDate = document.getElementById('checkOutDate');
            const checkOutDateGroup = document.getElementById('checkOutDateGroup');
            const checkInTime = document.getElementById('checkInTime');
            const checkOutTime = document.getElementById('checkOutTime');

            function addOptionIfMissing(selectElement, value, label) {
                const exists = Array.from(selectElement.options).some(opt => opt.value === value);
                if (!exists) {
                    const newOption = document.createElement('option');
                    newOption.value = value;
                    newOption.textContent = label;
                    selectElement.appendChild(newOption);
                }
                selectElement.value = value;
            }

            function handleReservationTypeChange() {
                if (reservationType.value === 'one_day') {
                    checkOutDateGroup.style.display = 'none';
                    checkOutDate.value = checkInDate.value;
                } else if (reservationType.value === 'overnight') {
                    checkOutDateGroup.style.display = 'block';

                    // Add/check 2:00 PM and 12:00 PM options
                    addOptionIfMissing(checkInTime, '14:00:00', '02:00 PM');
                    addOptionIfMissing(checkOutTime, '12:00:00', '12:00 PM');
                } else {
                    checkOutDateGroup.style.display = 'block';
                }
            }

            reservationType.addEventListener('change', handleReservationTypeChange);

            checkInDate.addEventListener('change', function () {
                if (reservationType.value === 'one_day') {
                    checkOutDate.value = this.value;
                }
            });

            handleReservationTypeChange(); // On load
        });
    </script>

    <script>
        function calculateTotalAmount() {
            const quantity = parseInt(document.getElementById('modalRoomQty').value) || 1;
            const priceText = document.getElementById('modalRoomPrice').textContent;
            const price = parseFloat(priceText.replace(/[^0-9.]/g, ''));
            const checkInDateValue = document.getElementById('checkInDate').value;
            const checkOutDateValue = document.getElementById('checkOutDate').value;
            const reservationType = document.getElementById('reservationType').value;

            const checkInDate = new Date(checkInDateValue);
            const checkOutDate = new Date(checkOutDateValue);

            if (!isNaN(price) && !isNaN(quantity)) {
                let totalAmount = quantity * price;

                if (reservationType === 'overnight') {
                    if (checkInDateValue && checkOutDateValue && !isNaN(checkInDate) && !isNaN(checkOutDate)) {
                        const timeDiff = checkOutDate - checkInDate;
                        const stayDuration = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
                        const validDuration = stayDuration > 0 ? stayDuration : 1;
                        totalAmount = quantity * price * validDuration;
                    } else {
                        totalAmount = quantity * price * 1;
                    }
                }

                document.getElementById('totalAmount').textContent = totalAmount.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            } else {
                document.getElementById('totalAmount').textContent = '0.00';
            }
        }

        function updateDateFields() {
            const reservationType = document.getElementById('reservationType').value;
            const checkInDateInput = document.getElementById('checkInDate');
            const checkOutDateInput = document.getElementById('checkOutDate');

            if (reservationType === 'overnight') {
                const now = new Date();

                // Set check-in: today 2:00 PM
                const checkInDate = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 14, 0);
                checkInDateInput.value = checkInDate.toISOString().slice(0, 16);

                // Set check-out: tomorrow 12:00 PM
                const checkOutDate = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, 12, 0);
                checkOutDateInput.value = checkOutDate.toISOString().slice(0, 16);
            }
        }

        function incrementQuantity() {
            const quantityInput = document.getElementById('modalRoomQty');
            quantityInput.value = parseInt(quantityInput.value) + 1;
            calculateTotalAmount();
        }

        function decrementQuantity() {
            const quantityInput = document.getElementById('modalRoomQty');
            if (quantityInput.value > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                calculateTotalAmount();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const quantityInput = document.getElementById('modalRoomQty');
            const checkInDateInput = document.getElementById('checkInDate');
            const checkOutDateInput = document.getElementById('checkOutDate');
            const reservationTypeInput = document.getElementById('reservationType');

            quantityInput.addEventListener('change', calculateTotalAmount);
            quantityInput.addEventListener('input', calculateTotalAmount);
            checkInDateInput.addEventListener('change', calculateTotalAmount);
            checkOutDateInput.addEventListener('change', calculateTotalAmount);
            reservationTypeInput.addEventListener('change', function () {
                updateDateFields(); // auto-fill, not disable
                calculateTotalAmount();
            });

            $('#reservationModal').on('show.bs.modal', function () {
                updateDateFields();
                calculateTotalAmount();
            });
        });
    </script>
</body>

</html>