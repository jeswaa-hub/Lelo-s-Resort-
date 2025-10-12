<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Activities</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
    <!-- NAVBAR -->
    @include('Navbar.sidenavbar')
    <div class="container-fluid min-vh-100 d-flex p-0">
        <div class="d-flex w-100" id="mainLayout" style="min-height: 100vh;">

            <!--  Main Content -->
            <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width" style="transition: all 0.3s ease;">

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
                                <h1 class="display-1 fw-bold" style="font-size: 5.5rem !important;">{{$adminCredentials->username}}</h1>
                            </div>

                            <div class="card text-dark rounded-4 shadow p-4 mt-4"
                                style="background-color: rgba(255,255,255,0.85);">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <h2 class="fw-bold font-paragraph mb-0">{{$activityCount ?? 0}}</h2>
                                            <h5 class="text-uppercase mb-0"
                                                style="font-family: Anton; letter-spacing: 0.1em;">
                                                Total <br> Activities
                                            </h5>
                                        </div>
                                    </div>
                                    <i class="bi bi-calendar-event" style="font-size: 2.5rem;"></i>
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

                            <div>
                                <div class="card text-white rounded-4 shadow p-4 mb-3"
                                    style="background: linear-gradient(180deg, #226214, #43cc25);">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h2 class="fw-bold font-paragraph">13</h2>
                                            <h5 class="text-uppercase mb-1"
                                                style="font-family: Anton; letter-spacing: 0.1em;">
                                                Available <br> Activities
                                            </h5>
                                        </div>
                                        <i class="bi bi-door-open" style="font-size: 2.5rem;"></i>
                                    </div>
                                </div>

                                <div class="card text-white rounded-4 shadow p-4 mb-3"
                                    style="background-color: #3e786d;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h2 class="fw-bold font-paragraph">5</h2>
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

                    <!-- Add Activity Modal -->
                    <div class="modal fade" id="addActivityModal" tabindex="-1" aria-labelledby="addActivityModalLabel"
                         aria-hidden="true">
                         <div class="modal-dialog modal-lg modal-dialog-centered">
                             <div class="modal-content rounded-4 shadow-lg border-0">
                                 <div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #0b573d, #198754);">
                                     <h5 class="modal-title fw-bold" id="addActivityModalLabel">
                                         <i class="fas fa-plus-circle me-2"></i>Add New Activity
                                     </h5>
                                     <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                 </div>
                                 <div class="modal-body p-4" style="background-color: #f8f9fa;">
                                     <form action="{{ route('storeActivity') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                        @csrf
                                         <div class="row g-4">
                                             <div class="col-md-6">
                                                 <div class="mb-3">
                                                     <label for="activity_name" class="form-label fw-semibold"><i class="fas fa-swimmer me-2 text-success"></i>Activity Name</label>
                                                     <input type="text" class="form-control" id="activity_name" name="activity_name" required>
                                                 </div>
                                                 <div class="mb-3">
                                                     <label for="activity_status" class="form-label fw-semibold"><i class="fas fa-check-circle me-2 text-success"></i>Activity Status</label>
                                                     <select class="form-select" id="activity_status" name="activity_status" required>
                                                         <option value="Available">Available</option>
                                                         <option value="Unavailable">Unavailable</option>
                                                     </select>
                                                 </div>
                                                 <div class="mb-3">
                                                     <label for="activity_image" class="form-label fw-semibold"><i class="fas fa-image me-2 text-success"></i>Activity Image</label>
                                                     <input type="file" class="form-control" id="activity_image" name="activity_image" onchange="previewImage(event, 'addActivityPreview')" required>
                                                 </div>
                                                 <div class="mb-3">
                                                     <label for="activity_description" class="form-label fw-semibold"><i class="fas fa-align-left me-2 text-success"></i>Description</label>
                                                     <textarea class="form-control" id="activity_description" name="activity_description" rows="3"></textarea>
                                                 </div>
                                             </div>
                                             <div class="col-md-6 d-flex align-items-center justify-content-center">
                                                 <img id="addActivityPreview" src="{{ asset('images/placeholder.png') }}" alt="Image Preview" class="img-fluid rounded-3 shadow-sm" style="max-height: 250px; border: 3px solid #dee2e6; padding: 3px;">
                                             </div>
                                         </div>
                                         <div class="modal-footer border-0 pt-4 pb-0">
                                             <button type="button" class="btn btn-light border shadow-sm rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                             <button type="submit" class="btn text-white rounded-pill px-4 shadow-sm" style="background-color: #0b573d;">
                                                 <i class="fas fa-plus me-2"></i>Add Activity
                                             </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="container-fluid mt-4 mb-4">
                        <div class="bg-white shadow-lg rounded-4 p-4">
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <h1 class="text-color-2 fw-bold mt-0 mb-0"
                                    style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;">
                                    ACTIVITY OVERVIEW
                                </h1>
                                <div
                                    class="d-flex align-items-center gap-2 px-3 py-2 border-0 rounded text-white fw-bold ms-auto">
                                    <button type="button"
                                        class="d-flex align-items-center gap-2 px-3 py-2 border-0 rounded text-white fw-bold"
                                        style="background-color: #004aad;" data-bs-toggle="modal"
                                        data-bs-target="#addActivityModal">
                                        <i class="bi bi-clock-fill"></i><i class="bi bi-plus-lg"></i>
                                        Add Activity
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <table class="table table-hover table-borderless mb-0">
                                <thead class="table-light text-uppercase text-secondary small">
                                    <tr>
                                        <th scope="col">Activity Image</th>
                                        <th scope="col">Activity Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Availability</th>
                                        <th scope="col" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activities as $activity)
                                        <tr class="border-bottom" style="border-color: #e9e9e9 !important;">
                                            <td>
                                                <img src="{{ asset('storage/' . $activity->activity_image) }}"
                                                    alt="Activity Image" width="100" height="80" class="rounded">
                                            </td>
                                            <td>{{ $activity->activity_name }}</td>
                                            <td>{{$activity->activity_description}}</td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill {{ $activity->activity_status == 'Available' ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                                    {{ $activity->activity_status == 'Available' ? 'Available' : 'Unavailable' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <a href="#" class="btn btn-sm btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#editActivityModal{{ $activity->id }}">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteActivityModal{{ $activity->id }}">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit Activity Modal -->
                                        <div class="modal fade" id="editActivityModal{{ $activity->id }}" tabindex="-1"
                                             aria-labelledby="editActivityModalLabel{{ $activity->id }}" aria-hidden="true">
                                             <div class="modal-dialog modal-lg modal-dialog-centered">
                                                 <div class="modal-content rounded-4 shadow-lg border-0">
                                                     <div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #0b573d, #198754);">
                                                         <h5 class="modal-title fw-bold" id="editActivityModalLabel{{ $activity->id }}">
                                                             <i class="fas fa-edit me-2"></i>Edit Activity
                                                         </h5>
                                                         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                     </div>
                                                     <div class="modal-body p-4" style="background-color: #f8f9fa;">
                                                         <form action="{{ route('updateActivity', $activity->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                             <div class="row g-4">
                                                                 <div class="col-md-6">
                                                                     <div class="mb-3">
                                                                         <label for="activity_name" class="form-label fw-semibold"><i class="fas fa-swimmer me-2 text-success"></i>Activity Name</label>
                                                                         <input type="text" class="form-control" name="activity_name" value="{{ $activity->activity_name }}" required>
                                                                     </div>
                                                                     <div class="mb-3">
                                                                         <label for="activity_status" class="form-label fw-semibold"><i class="fas fa-check-circle me-2 text-success"></i>Activity Status</label>
                                                                         <select class="form-select" name="activity_status" required>
                                                                             <option value="Available" @if ($activity->activity_status == 'Available') selected @endif>Available</option>
                                                                             <option value="Unavailable" @if ($activity->activity_status == 'Unavailable') selected @endif>Unavailable</option>
                                                                         </select>
                                                                     </div>
                                                                     <div class="mb-3">
                                                                         <label for="activity_image" class="form-label fw-semibold"><i class="fas fa-image me-2 text-success"></i>Change Image</label>
                                                                         <input type="file" class="form-control" name="activity_image" onchange="previewImage(event, 'editActivityPreview{{ $activity->id }}')">
                                                                     </div>
                                                                     <div class="mb-3">
                                                                         <label for="activity_description" class="form-label fw-semibold"><i class="fas fa-align-left me-2 text-success"></i>Description</label>
                                                                         <textarea class="form-control" name="activity_description" rows="3">{{ $activity->activity_description }}</textarea>
                                                                     </div>
                                                                 </div>
                                                                 <div class="col-md-6 d-flex align-items-center justify-content-center">
                                                                     <img id="editActivityPreview{{ $activity->id }}" src="{{ asset('storage/' . $activity->activity_image) }}" alt="Image Preview" class="img-fluid rounded-3 shadow-sm" style="max-height: 250px; border: 3px solid #dee2e6; padding: 3px;">
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

                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal fade" id="deleteActivityModal{{ $activity->id }}" tabindex="-1" aria-labelledby="deleteActivityModalLabel{{ $activity->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
                                                <div class="modal-content rounded-4 shadow-lg border-0">
                                                    <div class="modal-body p-4 text-center">
                                                        <div class="mb-3">
                                                            <i class="fas fa-exclamation-triangle fa-4x text-warning"></i>
                                                        </div>
                                                        <h4 class="fw-bold mb-2">Confirm Deletion</h4>
                                                        <p class="text-muted mb-4">
                                                            Are you sure you want to delete the activity <strong class="text-dark">{{ $activity->activity_name }}</strong>? This action cannot be undone.
                                                        </p>
                                                        <div class="d-flex justify-content-center gap-3">
                                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('deleteActivity', $activity->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger rounded-pill px-4">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>

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
</script>
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