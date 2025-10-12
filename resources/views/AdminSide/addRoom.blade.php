<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo new.png') }}">
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
    @include('Alert.errorLogin')
    <!-- NAVBAR -->
    @include('Navbar.sidenavbar')

    <div class="container-fluid min-vh-100 d-flex p-0">
        <div class="d-flex w-100" id="mainLayout" style="min-height: 100vh;">
            <!-- Main Content -->
            <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width" style="transition: all 0.3s ease;">
                <!-- Links -->

                <div class="container-fluid mt-4 mb-4 rounded-4 p-5" style="background: url('{{ asset('images/staff-admin-bg.jpg') }}') no-repeat center center; 
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
                                <h1 class="display-1 fw-bold text-capitalize" style="font-size: 5.5rem !important;">{{ $adminCredentials->username }}!</h1>
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
                                    style="background: linear-gradient(180deg, #226214, #43cc25);">
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
                                    <th scope="col" class="py-3 px-4">Room Image</th>
                                    <th scope="col" class="py-3 px-4">Room Name</th>
                                    <th scope="col" class="py-3 px-4">Room Description</th>
                                    <th scope="col" class="py-3 px-4">Room Type</th>
                                    <th scope="col" class="py-3 px-4">Room Qty</th>
                                    <th scope="col" class="py-3 px-4">Price</th>
                                    <th scope="col" class="py-3 px-4">Capacity</th>
                                    <th scope="col" class="py-3 px-4">Availability</th>
                                    <th scope="col" class="py-3 px-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accomodations as $accomodation)
                                    <tr class="border-bottom" style="border-color: #e9e9e9 !important;">
                                        <td class="py-3 px-4">
                                            <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}"
                                                alt="Accommodation Image" width="100" height="80" class="rounded">
                                        </td>
                                        <td class="py-3 px-4">{{ $accomodation->accomodation_name }}</td>
                                        <td class="py-3 px-4">{{ Str::limit($accomodation->accomodation_description, 100) }}</td>
                                        <td class="py-3 px-4">{{ $accomodation->accomodation_type }}</td>
                                        <td class="py-3 px-4">{{ $accomodation->quantity}}</td>
                                        <td class="py-3 px-4">₱{{ number_format($accomodation->accomodation_price, 2) }}</td>
                                        <td class="py-3 px-4">{{ $accomodation->accomodation_capacity }}</td>
                                        <td class="py-3 px-4">
                                            <span
                                                class="badge rounded-pill {{ $accomodation->accomodation_status == 'available' ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                                {{ $accomodation->accomodation_status == 'available' ? 'Available' : 'Not Available' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">
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
                                                <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
                                                    <div class="modal-content rounded-4 shadow-lg border-0">
                                                        <div class="modal-body p-4 text-center">
                                                            <div class="mb-3">
                                                                <i class="fas fa-exclamation-triangle fa-4x text-warning"></i>
                                                            </div>
                                                            <h4 class="fw-bold mb-2">Confirm Deletion</h4>
                                                            <p class="text-muted mb-4">
                                                                Are you sure you want to delete the room <strong class="text-dark">{{ $accomodation->accomodation_name }}</strong>? This action cannot be undone.
                                                            </p>
                                                            <div class="d-flex justify-content-center gap-3">
                                                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                                                                    Cancel
                                                                </button>
                                                                <button type="button" class="btn btn-danger rounded-pill px-4" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $accomodation->accomodation_id }}').submit();">
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
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content rounded-4 shadow-lg border-0">
                                                <div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #0b573d, #198754);">
                                                    <h5 class="modal-title fw-bold" id="editRoomModalLabel{{ $accomodation->accomodation_id }}">
                                                        <i class="fas fa-edit me-2"></i>Edit Room Details
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4" style="background-color: #f8f9fa;">
                                                    <form method="POST" action="{{ route('updateRoom', ['id' => $accomodation->accomodation_id]) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="row g-4">
                                                            <!-- Left Column -->
                                                            <div class="col-md-7">
                                                                <div class="row g-3">
                                                                    <div class="col-12">
                                                                        <label class="form-label fw-semibold"><i class="fas fa-tag me-2 text-success"></i>Room Name</label>
                                                                        <input type="text" class="form-control" name="accomodation_name" required value="{{ $accomodation->accomodation_name }}">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label fw-semibold"><i class="fas fa-home me-2 text-success"></i>Type</label>
                                                                        <select class="form-select" name="accomodation_type" required>
                                                                            <option value="room" {{ $accomodation->accomodation_type == 'room' ? 'selected' : '' }}>Room</option>
                                                                            <option value="cottage" {{ $accomodation->accomodation_type == 'cottage' ? 'selected' : '' }}>Cottage</option>
                                                                            <option value="cabin" {{ $accomodation->accomodation_type == 'cabin' ? 'selected' : '' }}>Cabin</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label fw-semibold"><i class="fas fa-check-circle me-2 text-success"></i>Status</label>
                                                                        <select class="form-select" name="accomodation_status" required>
                                                                            <option value="available" {{ $accomodation->accomodation_status == 'available' ? 'selected' : '' }}>Available</option>
                                                                            <option value="unavailable" {{ $accomodation->accomodation_status == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label class="form-label fw-semibold"><i class="fas fa-align-left me-2 text-success"></i>Description</label>
                                                                        <textarea class="form-control" name="accomodation_description" rows="3">{{ $accomodation->accomodation_description }}</textarea>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label class="form-label fw-semibold"><i class="fas fa-wifi me-2 text-success"></i>Amenities</label>
                                                                        <textarea class="form-control" name="amenities" rows="3">{{ $accomodation->amenities }}</textarea>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label class="form-label fw-semibold"><i class="fas fa-users me-2 text-success"></i>Capacity</label>
                                                                        <input type="number" class="form-control" name="accomodation_capacity" min="1" required value="{{ $accomodation->accomodation_capacity }}">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label class="form-label fw-semibold"><i class="fas fa-hashtag me-2 text-success"></i>Quantity</label>
                                                                        <input type="number" class="form-control" name="quantity" min="1" required value="{{ $accomodation->quantity }}">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label class="form-label fw-semibold"><i class="fas fa-dollar-sign me-2 text-success"></i>Price</label>
                                                                        <input type="number" class="form-control" name="accomodation_price" min="0" required value="{{ $accomodation->accomodation_price }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Right Column -->
                                                            <div class="col-md-5">
                                                                <div class="d-flex flex-column h-100 mt-4">
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold"><i class="fas fa-image me-2 text-success"></i>Main Image</label>
                                                                        <input type="file" class="form-control" name="accomodation_image" accept="image/*" onchange="previewImage(event, 'preview{{ $accomodation->accomodation_id }}')">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold"><i class="fas fa-images me-2 text-success"></i>Extra Images</label>
                                                                        <input type="file" class="form-control" name="extra_images[]" multiple accept="image/*">
                                                                        @if($accomodation->extra_images)
                                                                            <div class="mt-2 d-flex flex-wrap gap-2">
                                                                                @foreach(explode(',', $accomodation->extra_images) as $extra)
                                                                                    <img src="{{ asset('storage/'.$extra) }}" class="rounded shadow-sm" style="width:70px; height:70px; object-fit:cover;">
                                                                                @endforeach
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                    <div class="mt-2 text-center flex-grow-1">
                                                                        <img id="preview{{ $accomodation->accomodation_id }}" 
                                                                            src="{{ asset('storage/' . $accomodation->accomodation_image) }}" 
                                                                            alt="Image Preview" 
                                                                            class="img-fluid rounded-3 shadow-sm" 
                                                                            style="max-height: 250px; border: 3px solid #dee2e6; padding: 3px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer border-0 pt-4 pb-0">
                                                            <button type="button" class="btn btn-light border shadow-sm rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn text-white rounded-pill px-4 shadow-sm" style="background-color: #0b573d;">
                                                                <i class="fas fa-save me-2"></i>Save Changes
                                                            </button>
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
                                    <td colspan="9" class="pt-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="text-muted">
                                                Showing {{ $accomodations->firstItem() }} to
                                                {{ $accomodations->lastItem() }} of {{ $accomodations->total() }}
                                                rooms
                                            </div>
                                            {{ $accomodations->links('pagination.custom') }}
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
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-lg border-0">
                <div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #0b573d, #198754);">
                    <h5 class="modal-title fw-bold" id="addRoomModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Add New Room
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="background-color: #f8f9fa;">
                    <form method="POST" action="{{ route('addRoom') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class="row g-4">
                            <!-- Left Column: Form Fields -->
                            <div class="col-md-7">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="addRoomName" class="form-label fw-semibold"><i class="fas fa-tag me-2 text-success"></i>Room Name</label>
                                        <input type="text" class="form-control @error('accomodation_name') is-invalid @enderror" id="addRoomName" name="accomodation_name" value="{{ old('accomodation_name') }}" required>
                                        @error('accomodation_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="addRoomType" class="form-label fw-semibold"><i class="fas fa-home me-2 text-success"></i>Type</label>
                                        <select class="form-select @error('accomodation_type') is-invalid @enderror" id="addRoomType" name="accomodation_type" required>
                                            <option value="" selected disabled>Select Type</option>
                                            <option value="room" {{ old('accomodation_type') == 'room' ? 'selected' : '' }}>Room</option>
                                            <option value="cottage" {{ old('accomodation_type') == 'cottage' ? 'selected' : '' }}>Cottage</option>
                                            <option value="cabin" {{ old('accomodation_type') == 'cabin' ? 'selected' : '' }}>Cabin</option>
                                        </select>
                                        @error('accomodation_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="addRoomStatus" class="form-label fw-semibold"><i class="fas fa-check-circle me-2 text-success"></i>Status</label>
                                        <select class="form-select @error('accomodation_status') is-invalid @enderror" id="addRoomStatus" name="accomodation_status" required>
                                            <option value="" selected disabled>Select Status</option>
                                            <option value="available" {{ old('accomodation_status') == 'available' ? 'selected' : '' }}>Available</option>
                                            <option value="unavailable" {{ old('accomodation_status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                                        </select>
                                        @error('accomodation_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="addRoomDescription" class="form-label fw-semibold"><i class="fas fa-align-left me-2 text-success"></i>Description</label>
                                        <textarea class="form-control" id="addRoomDescription" name="accomodation_description" rows="3">{{ old('accomodation_description') }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label for="addRoomAmenities" class="form-label fw-semibold"><i class="fas fa-wifi me-2 text-success"></i>Amenities</label>
                                        <textarea class="form-control" id="addRoomAmenities" name="amenities" rows="3" placeholder="e.g., WiFi, TV, Air Conditioning">{{ old('amenities') }}</textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="addRoomCapacity" class="form-label fw-semibold"><i class="fas fa-users me-2 text-success"></i>Capacity</label>
                                        <input type="number" class="form-control @error('accomodation_capacity') is-invalid @enderror" id="addRoomCapacity" name="accomodation_capacity" min="1" value="{{ old('accomodation_capacity') }}" required>
                                        @error('accomodation_capacity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="addRoomQuantity" class="form-label fw-semibold"><i class="fas fa-hashtag me-2 text-success"></i>Quantity</label>
                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="addRoomQuantity" name="quantity" min="1" value="{{ old('quantity', 1) }}" required>
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="addRoomPrice" class="form-label fw-semibold"><i class="fas fa-dollar-sign me-2 text-success"></i>Price</label>
                                        <input type="number" class="form-control @error('accomodation_price') is-invalid @enderror" id="addRoomPrice" name="accomodation_price" min="0" value="{{ old('accomodation_price') }}" required>
                                        @error('accomodation_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Right Column: Image & ID -->
                            <div class="col-md-5">
                                <div class="d-flex flex-column h-100">
                                    <div class="mb-3">
                                        <label for="addRoomImage" class="form-label fw-semibold"><i class="fas fa-image me-2 text-success"></i>Upload Image</label>
                                        <input type="file" class="form-control @error('accomodation_image') is-invalid @enderror" id="addRoomImage" name="accomodation_image" accept="image/*" required onchange="previewImage(event, 'addPreview')">
                                        @error('accomodation_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mt-2 text-center flex-grow-1">
                                        <img id="addPreview" src="{{ asset('images/placeholder.png') }}" alt="Image Preview" class="img-fluid rounded-3 shadow-sm" style="max-height: 250px; border: 3px solid #dee2e6; padding: 3px;">
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="addExtraImages" class="form-label fw-semibold">
                                            <i class="fas fa-images me-2 text-success"></i>Upload Additional Images
                                        </label>
                                        <input type="file" class="form-control @error('extra_images.*') is-invalid @enderror" id="addExtraImages" name="extra_images[]" multiple accept="image/*">
                                        @error('extra_images.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">You can select multiple images.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Footer Buttons -->
                        <div class="modal-footer border-0 pt-4 pb-0">
                            <button type="button" class="btn btn-light border shadow-sm rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn text-white rounded-pill px-4 shadow-sm" style="background-color: #0b573d;">
                                <i class="fas fa-plus me-2"></i>Add Room
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        function previewImage(event, previewId) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById(previewId);
                output.src = reader.result;
            };
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }

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

        // Automatically open the 'Add Room' modal if there are validation errors
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                var addRoomModal = new bootstrap.Modal(document.getElementById('addRoomModal'));
                addRoomModal.show();
            });
        @endif
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