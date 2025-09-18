<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Room</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    .fancy-link {
        text-decoration: none;
        font-weight: 600;
        position: relative;
        transition: color 0.3s ease;
    }

    .fancy-link::after {
        content: "";
        position: absolute;
        width: 0;
        height: 2px;
        left: 0;
        bottom: -2px;
        background-color: #0b573d;
        transition: width 0.3s ease;
    }

    .fancy-link:hover {
        color: #0b573d;
    }

    .fancy-link:hover::after {
        width: 100%;
    }

    .fancy-link.active::after {
        width: 100% !important;
    }

    .transition-width {
        transition: all 0.3s ease;
    }

    #mainContent.full-width {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
</style>

<body
    style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76))">
    @include('Alert.loginSuccessUser')
    @include('Alert.errornotification')
    <!-- NAVBAR -->
    @include('Navbar.navbarAdmin')

    <div class="container-fluid min-vh-100 d-flex p-0">
        <div class="d-flex w-100" id="mainLayout" style="min-height: 100vh;">
            <!-- Main Content -->
            <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width" style="transition: all 0.3s ease;">
                <!-- Links -->

                <div class="container-fluid mt-4 mb-4 rounded-4 p-5" style="background: url('{{ asset('images/Dashboardbg.png') }}') no-repeat center center; 
                 background-size: cover; 
                     width: 100%;
                     height: 100vh;
                     border-radius: 30px;">

                    <div class="row h-100">
                        <!-- Left side -->
                        <div class="col-md-6 d-flex flex-column justify-content-center text-white"
                            style="margin-top: 12%;">

                            <div class="mb-5" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                                <h2 class="mb-0 fs-1" style="font-size: 4.5rem !important;">Hello,</h2>
                                <h1 class="display-1 fw-bold" style="font-size: 5.5rem !important;">Admin User!</h1>
                            </div>

                            <div class="card text-dark rounded-4 shadow p-4 mt-4"
                                style="background-color: rgba(255,255,255,0.85);">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <h2 class="fw-bold font-paragraph mb-0">{{$count ?? 0}}</h2>
                                            <h5 class="text-uppercase mb-0"
                                                style="font-family: Anton; letter-spacing: 0.1em;">
                                                Total <br> Rooms
                                            </h5>
                                        </div>
                                    </div>
                                    <i class="bi bi-building" style="font-size: 2.5rem;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Right side -->
                        <div class="col-md-6 d-flex flex-column justify-content-between text-white">
                            <!-- Clock -->
                            <div class="text-end" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                                <h1 id="clock" class="fw-bold"></h1>
                                <p id="date"></p>
                            </div>

                            <!-- Cards -->
                            <div>
                                <div class="card text-white rounded-4 shadow p-4 mb-3"
                                    style="background-color: #226214;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h2 class="fw-bold font-paragraph">{{$countAvailableRoom}}</h2>
                                            <h5 class="text-uppercase mb-1"
                                                style="font-family: Anton; letter-spacing: 0.1em;">
                                                Available <br> Rooms
                                            </h5>
                                        </div>
                                        <i class="bi bi-door-open" style="font-size: 2.5rem;"></i>
                                    </div>
                                </div>

                                <div class="card text-white rounded-4 shadow p-4 mb-3"
                                    style="background-color: #3e786d;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h2 class="fw-bold font-paragraph" style="font-size: 2.5rem;">
                                                {{$countReservedRoom ?? 0}}
                                            </h2>
                                            <h5 class="text-uppercase mb-1"
                                                style="font-family: Anton; letter-spacing: 0.1em; font-size: 1.3rem;">
                                                Reserved <br> Rooms
                                            </h5>
                                        </div>
                                        <i class="bi bi-calendar-check" style="font-size: 3.5rem;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <!-- Filterization -->
                    <!-- Table -->
                    <div class="bg-white shadow-lg rounded-4 p-4 mt-2">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <!-- Title + Filter -->
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <h1 class="text-color-2 fw-bold mt-0 mb-0"
                                    style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;">
                                    ROOM OVERVIEW
                                </h1>
                                <select class="form-select w-auto" id="roomTypeFilter" style="width: 150px !important;">
                                    <option value="all">All Rooms</option>
                                    <option value="room">Room</option>
                                    <option value="cottage">Cottage</option>
                                    <option value="cabin">Cabin</option>
                                </select>
                            </div>

                            <!-- Add Room Button -->
                            <button type="button"
                                class="d-flex align-items-center gap-2 px-3 py-2 border-0 rounded text-white fw-bold"
                                style="background-color: #004aad;" data-bs-toggle="modal"
                                data-bs-target="#addRoomModal">

                                <!-- Bed + Plus Icon (Font Awesome example) -->
                                <i class="fas fa-bed"></i>
                                <span>+ Add Rooms</span>
                            </button>
                        </div>
                        <hr>
                        <table class="table table-hover table-borderless mb-0">
                            <thead class="table-light text-uppercase text-secondary small">
                                <tr>
                                    <th scope="col">Room ID</th>
                                    <th scope="col">Room Image</th>
                                    <th scope="col">Room Name</th>
                                    <th scope="col">Room Description</th>
                                    <th scope="col">Room Type</th>
                                    <th scope="col">Room Qty</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Capacity</th>
                                    <th scope="col">Availability</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accomodations as $accomodation)
                                    <tr class="border-bottom" style="border-color: #e9e9e9 !important;">
                                        <td>{{$accomodation->room_id}}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}"
                                                alt="Accommodation Image" width="100" height="80" class="rounded">
                                        </td>
                                        <td>{{ $accomodation->accomodation_name }}</td>
                                        <td>{{ Str::limit($accomodation->accomodation_description, 100) }}</td>
                                        <td>{{ $accomodation->accomodation_type }}</td>
                                        <td>{{ $accomodation->quantity}}</td>
                                        <td>₱{{ number_format($accomodation->accomodation_price, 2) }}</td>
                                        <td>{{ $accomodation->accomodation_capacity }}</td>
                                        <td>
                                            <span
                                                class="badge rounded-pill {{ $accomodation->accomodation_status == 'available' ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                                {{ $accomodation->accomodation_status == 'available' ? 'Available' : 'Not Available' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-sm btn-outline-success me-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editRoomModal{{ $accomodation->accomodation_id }}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $accomodation->accomodation_id }}">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </div>
                                            <form id="delete-form-{{ $accomodation->accomodation_id }}"
                                                action="{{ route('deleteRoom', ['id' => $accomodation->accomodation_id]) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                            <!-- Delete Confirmation Modal -->
                                            <div class="modal fade" id="deleteModal{{ $accomodation->accomodation_id }}"
                                                tabindex="-1"
                                                aria-labelledby="deleteModalLabel{{ $accomodation->accomodation_id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content rounded-4 shadow border-0">
                                                        <div class="modal-header border-0"
                                                            style="background-color: #0b573d;">
                                                            <h5 class="modal-title text-white text-uppercase"
                                                                style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;"
                                                                id="deleteModalLabel{{ $accomodation->accomodation_id }}">
                                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                                Confirm Deletion
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-5 text-center">
                                                            <div class="mb-4">
                                                                <p class="mb-2 fs-7 font-paragraph">Are you sure you
                                                                    want to delete this room?</p>
                                                                <p class="mb-0 text-muted">
                                                                    <span class="fw-semibold"
                                                                        style="font-family:Montserrat;">Room
                                                                        Name:</span>
                                                                    {{ $accomodation->accomodation_name }}
                                                                </p>
                                                            </div>
                                                            <div class="d-flex justify-content-center gap-3">
                                                                <button type="button"
                                                                    class="btn btn-secondary btn-lg rounded-3 px-4"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="fas fa-times me-2"></i>
                                                                    Cancel
                                                                </button>
                                                                <button type="button"
                                                                    class="btn btn-lg rounded-3 text-white px-4"
                                                                    style="background-color: #0b573d;"
                                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $accomodation->accomodation_id }}').submit();">
                                                                    <i class="fas fa-trash-alt me-2"></i>
                                                                    Delete
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Edit Room Modal -->
                                    <div class="modal fade" id="editRoomModal{{ $accomodation->accomodation_id }}"
                                        tabindex="-1"
                                        aria-labelledby="editRoomModalLabel{{ $accomodation->accomodation_id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content rounded-4 shadow">
                                                <div class="modal-header border-0" style="background-color: #0b573d;">
                                                    <h5 class="modal-title text-white text-uppercase"
                                                        style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;"
                                                        id="editRoomModalLabel{{ $accomodation->accomodation_id }}">Edit
                                                        Room</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <form method="POST"
                                                        action="{{ route('updateRoom', ['id' => $accomodation->accomodation_id]) }}"
                                                        enctype="multipart/form-data" class="needs-validation" novalidate>
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" id="editRoomId" name="room_id"
                                                            value="{{ $accomodation->accomodation_id }}">

                                                        <div class="row g-4">
                                                            <!-- Room ID and Image Section -->
                                                            <div class="col-md-6">
                                                                <label for="editRoomId{{ $accomodation->accomodation_id }}"
                                                                    class="form-label fw-bold text-color-2">Room
                                                                    ID</label>
                                                                <input type="text"
                                                                    class="form-control form-control-lg border-2 rounded-3"
                                                                    id="editRoomId{{ $accomodation->accomodation_id }}"
                                                                    name="room_id" required
                                                                    value="{{ $accomodation->room_id }}">
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label
                                                                    for="editRoomImage{{ $accomodation->accomodation_id }}"
                                                                    class="form-label fw-bold text-color-2">Image</label>
                                                                <input type="file"
                                                                    class="form-control form-control-lg border-2 rounded-3"
                                                                    id="editRoomImage{{ $accomodation->accomodation_id }}"
                                                                    name="accomodation_image" accept="image/*"
                                                                    onchange="previewImage(event, 'preview{{ $accomodation->accomodation_id }}')">
                                                                <div class="mt-3 text-center">
                                                                    <img id="preview{{ $accomodation->accomodation_id }}"
                                                                        src="{{ asset('storage/' . $accomodation->accomodation_image) }}"
                                                                        alt="Preview" class="rounded-3 shadow-sm"
                                                                        style="max-width: 200px; height: auto;">
                                                                </div>
                                                            </div>

                                                            <!-- Name and Type Section -->
                                                            <div class="col-md-6">
                                                                <label
                                                                    for="editRoomName{{ $accomodation->accomodation_id }}"
                                                                    class="form-label fw-bold text-color-2">Name</label>
                                                                <input type="text"
                                                                    class="form-control form-control-lg border-2 rounded-3"
                                                                    id="editRoomName{{ $accomodation->accomodation_id }}"
                                                                    name="accomodation_name" required
                                                                    value="{{ $accomodation->accomodation_name }}">
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label
                                                                    for="editRoomType{{ $accomodation->accomodation_id }}"
                                                                    class="form-label fw-bold text-color-2">Type</label>
                                                                <select
                                                                    class="form-select form-select-lg border-2 rounded-3"
                                                                    id="editRoomType{{ $accomodation->accomodation_id }}"
                                                                    name="accomodation_type" required>
                                                                    <option value="room" {{ $accomodation->accomodation_type == 'room' ? 'selected' : '' }}>Room</option>
                                                                    <option value="cottage" {{ $accomodation->accomodation_type == 'cottage' ? 'selected' : '' }}>Cottage</option>
                                                                    <option value="cabin" {{ $accomodation->accomodation_type == 'cabin' ? 'selected' : '' }}>Cabin</option>
                                                                </select>
                                                            </div>

                                                            <!-- Description and Amenities Section -->
                                                            <div class="col-12">
                                                                <label
                                                                    for="editRoomDescription{{ $accomodation->accomodation_id }}"
                                                                    class="form-label fw-bold text-color-2">Description</label>
                                                                <textarea
                                                                    class="form-control form-control-lg border-2 rounded-3"
                                                                    id="editRoomDescription{{ $accomodation->accomodation_id }}"
                                                                    name="accomodation_description"
                                                                    rows="3">{{ $accomodation->accomodation_description }}</textarea>
                                                            </div>

                                                            <div class="col-12">
                                                                <label
                                                                    for="editRoomAmenities{{ $accomodation->accomodation_id }}"
                                                                    class="form-label fw-bold text-color-2">Amenities</label>
                                                                <textarea
                                                                    class="form-control form-control-lg border-2 rounded-3"
                                                                    id="editRoomAmenities{{ $accomodation->accomodation_id }}"
                                                                    name="amenities" rows="3"
                                                                    placeholder="Enter amenities (e.g., WiFi, TV, Air Conditioning)">{{ $accomodation->amenities }}</textarea>
                                                            </div>

                                                            <!-- Capacity, Quantity, and Price Section -->
                                                            <div class="col-md-4">
                                                                <label
                                                                    for="editRoomCapacity{{ $accomodation->accomodation_id }}"
                                                                    class="form-label fw-bold text-color-2">Capacity</label>
                                                                <input type="number"
                                                                    class="form-control form-control-lg border-2 rounded-3"
                                                                    id="editRoomCapacity{{ $accomodation->accomodation_id }}"
                                                                    name="accomodation_capacity" min="1" required
                                                                    value="{{ $accomodation->accomodation_capacity }}">
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label
                                                                    for="editRoomQuantity{{ $accomodation->accomodation_id }}"
                                                                    class="form-label fw-bold text-color-2">Quantity</label>
                                                                <input type="number"
                                                                    class="form-control form-control-lg border-2 rounded-3"
                                                                    id="editRoomQuantity{{ $accomodation->accomodation_id }}"
                                                                    name="quantity" min="1" required
                                                                    value="{{ $accomodation->quantity }}">
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label
                                                                    for="editRoomPrice{{ $accomodation->accomodation_id }}"
                                                                    class="form-label fw-bold text-color-2">Price</label>
                                                                <input type="number"
                                                                    class="form-control form-control-lg border-2 rounded-3"
                                                                    id="editRoomPrice{{ $accomodation->accomodation_id }}"
                                                                    name="accomodation_price" min="0" required
                                                                    value="{{ $accomodation->accomodation_price }}">
                                                            </div>

                                                            <!-- Status Section -->
                                                            <div class="col-12">
                                                                <label
                                                                    for="editRoomStatus{{ $accomodation->accomodation_id }}"
                                                                    class="form-label fw-bold text-color-2">Status</label>
                                                                <select
                                                                    class="form-select form-select-lg border-2 rounded-3"
                                                                    id="editRoomStatus{{ $accomodation->accomodation_id }}"
                                                                    name="accomodation_status" required>
                                                                    <option value="available" {{ $accomodation->accomodation_status == 'available' ? 'selected' : '' }}>Available</option>
                                                                    <option value="unavailable" {{ $accomodation->accomodation_status == 'unavailable' ? 'selected' : '' }}>Not Available</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Footer Buttons -->
                                                        <div class="modal-footer border-0 pt-4">
                                                            <button type="button"
                                                                class="btn btn-secondary btn-lg rounded-3 px-4"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit"
                                                                class="btn btn-lg rounded-3 px-4 text-white"
                                                                style="background-color: #0b573d;">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="11" class="pt-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="text-muted">
                                                Showing {{ $accomodations->firstItem() }} to
                                                {{ $accomodations->lastItem() }} of {{ $accomodations->total() }}
                                                rooms
                                            </div>
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination mb-0">
                                                    {{-- Previous Page Link --}}
                                                    @if ($accomodations->onFirstPage())
                                                        <li class="page-item disabled">
                                                            <span class="page-link">&laquo;</span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link"
                                                                href="{{ $accomodations->previousPageUrl() }}"
                                                                rel="prev">&laquo;</a>
                                                        </li>
                                                    @endif

                                                    {{-- Pagination Elements --}}
                                                    @foreach ($accomodations->getUrlRange(1, $accomodations->lastPage()) as $page => $url)
                                                        @if ($page == $accomodations->currentPage())
                                                            <li class="page-item active" aria-current="page">
                                                                <span class="page-link">{{ $page }}</span>
                                                            </li>
                                                        @else
                                                            <li class="page-item">
                                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach

                                                    {{-- Next Page Link --}}
                                                    @if ($accomodations->hasMorePages())
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $accomodations->nextPageUrl() }}"
                                                                rel="next">&raquo;</a>
                                                        </li>
                                                    @else
                                                        <li class="page-item disabled">
                                                            <span class="page-link">&raquo;</span>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </nav>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Add Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header border-0 bg-success text-white" style="background-color: #0b573d !important;">
                    <h5 class="modal-title text-uppercase" id="addRoomModalLabel"
                        style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;">Add Room</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="POST" action="{{ route('addRoom') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="accomodationImage" class="form-label fw-semibold">Image</label>
                                <input type="file" class="form-control border-2" id="accomodationImage"
                                    name="accomodation_image" accept="image/*" required>
                                @if ($errors->has('accomodation_image'))
                                    <span class="text-danger">{{ $errors->first('accomodation_image') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="accomodationId" class="form-label fw-semibold">Room ID</label>
                                <input type="text" class="form-control border-2" id="accomodationId" name="room_id"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="accomodationName" class="form-label fw-semibold">Name</label>
                                <input type="text" class="form-control border-2" id="accomodationName"
                                    name="accomodation_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="accomodationType" class="form-label fw-semibold">Type</label>
                                <select class="form-select border-2" id="accomodationType" name="accomodation_type"
                                    required>
                                    <option value="" selected disabled>Select Type</option>
                                    <option value="room">Room</option>
                                    <option value="cottage">Cottage</option>
                                    <option value="cabin">Cabin</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="accomodationStatus" class="form-label fw-semibold">Status</label>
                                <select class="form-select border-2" id="accomodationStatus" name="accomodation_status"
                                    required>
                                    <option value="" selected disabled>Select Status</option>
                                    <option value="available">Available</option>
                                    <option value="unavailable">Not Available</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="accomodationDescription" class="form-label fw-semibold">Description</label>
                                <textarea class="form-control border-2" id="accomodationDescription"
                                    name="accomodation_description" rows="3"></textarea>
                            </div>
                            <div class="col-12">
                                <label for="accomodationDescription" class="form-label fw-semibold">Amenities</label>
                                <textarea class="form-control border-2" id="accomodationDescription" name="amenities"
                                    rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="accomodationCapacity" class="form-label fw-semibold">Capacity</label>
                                <input type="number" class="form-control border-2" id="accomodationCapacity"
                                    name="accomodation_capacity" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label for="accomodationPrice" class="form-label fw-semibold">Price</label>
                                <input type="number" class="form-control border-2" id="accomodationPrice"
                                    name="accomodation_price" min="0" required>
                            </div>
                            <div class="col-md-6">
                                <label for="accomodationQuantity" class="form-label fw-semibold">Quantity</label>
                                <input type="number" class="form-control border-2" id="accomodationQuantity"
                                    name="quantity" min="1" value="1" required>
                            </div>
                        </div>
                        <div class="modal-footer border-0 px-0 pb-0">
                            <button type="submit" class="btn text-white px-4 py-2"
                                style="background-color: #0b573d;">Add Room</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        // Live Clock & Date
        function updateClock() {
            const now = new Date();
            const time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            const date = now.toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric' });
            document.getElementById("clock").textContent = time;
            document.getElementById("date").textContent = date;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
    <script>
        const addRoomBtn = document.querySelector('.btn-primary.w-25');
        if (addRoomBtn) {
            addRoomBtn.addEventListener('click', function () {
                var myModal = new bootstrap.Modal(document.getElementById('addRoomModal'));
                myModal.show();
            });
        }

        const closeModalBtn = document.querySelector('#addRoomModal button[data-bs-dismiss="modal"]');
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', function () {
                var myModal = bootstrap.Modal.getInstance(document.getElementById('addRoomModal'));
                myModal.hide();
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            const editButtons = document.querySelectorAll(".edit-room-btn");
            editButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const row = button.closest("tr");
                    const accomodationId = button.getAttribute("data-bs-target").replace("#editRoomModal", "");

                    // Update all form fields with current values
                    document.getElementById(`editRoomId${accomodationId}`).value = row.cells[0].textContent.trim();
                    document.getElementById(`editRoomName${accomodationId}`).value = row.cells[2].textContent.trim();
                    document.getElementById(`editRoomType${accomodationId}`).value = row.cells[3].textContent.trim().toLowerCase();
                    document.getElementById(`editRoomDescription${accomodationId}`).value = row.cells[4].textContent.trim();
                    document.getElementById(`editRoomAmenities${accomodationId}`).value = row.cells[5].textContent.trim();
                    document.getElementById(`editRoomCapacity${accomodationId}`).value = row.cells[6].textContent.trim();
                    document.getElementById(`editRoomQuantity${accomodationId}`).value = row.cells[7].textContent.trim();
                    document.getElementById(`editRoomPrice${accomodationId}`).value = row.cells[8].textContent.trim();
                    document.getElementById(`editRoomStatus${accomodationId}`).value = row.cells[9].textContent.trim().toLowerCase();
                });
            });
        });

        // Apply styling sa view selector dropdown
        const viewSelector = document.getElementById("viewSelector");
        if (viewSelector) {
            viewSelector.style.backgroundColor = '#f0f0f0';
            viewSelector.style.border = '1px solid #ddd';
            viewSelector.style.borderRadius = '4px';
            viewSelector.style.padding = '4px 8px';
            viewSelector.style.color = '#333';
        }

        // Room Type filter functionality
        const roomTypeFilter = document.getElementById("roomTypeFilter");
        if (roomTypeFilter) {
            roomTypeFilter.style.backgroundColor = '#f0f0f0';
            roomTypeFilter.style.border = '1px solid #ddd';
            roomTypeFilter.style.borderRadius = '4px';
            roomTypeFilter.style.padding = '4px 8px';
            roomTypeFilter.style.color = '#333';

            roomTypeFilter.addEventListener("change", function () {
                let filterValue = this.value.toLowerCase();
                let rows = document.querySelectorAll("tbody tr");

                rows.forEach(row => {
                    let roomType = row.children[3].textContent.toLowerCase(); // Get Room Type column
                    if (filterValue === "all" || roomType.includes(filterValue)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        }

    </script>
</body>