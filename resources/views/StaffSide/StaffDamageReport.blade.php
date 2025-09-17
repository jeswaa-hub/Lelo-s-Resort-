<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <title>Damage Report</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
</style>
<body style="margin: 0; padding: 0; height: 100vh; background-color: white; overflow-x: hidden;">
    @include('Alert.loginSucess')
    @include('Alert.notification')
    <!-- NAVBAR -->
     @include('Navbar.sidenavbarStaff')
        <!-- Main Content -->
 <!-- HERO BANNER -->
 <div class="row">
        <div class="col-11 mx-auto">
            <div class="hero-banner" style="
                background-image: url('{{ asset('images/staff-admin-bg.jpg') }}');
                background-size: cover;
                background-position: center;
                height: min(450px, 50vw);
                border-radius: 15px;
                max-width: 100%;
                margin: 0 auto;
                position: relative;">
                
                <!-- Welcome Text Overlay -->
                <div class="position-absolute top-50 start-50 translate-middle text-start" style="width: 90%;">
                    <p class="text-white mb-4" style="
                        font-family: 'Poppins', sans-serif;
                        font-size: clamp(2rem, 4vw, 3.5rem);
                        letter-spacing: 3px;
                        margin-top: 2rem;
                        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                        Hello,
                    </p>
                    <h1 class="text-capitalize fw-bolder" style="
                        font-family: 'Montserrat', sans-serif;
                        font-size: clamp(3.5rem, 8vw, 5.5rem);
                        color: #ffffff;
                        letter-spacing: clamp(3px, 2vw, 12px);
                        white-space: normal;
                        overflow-wrap: break-word;
                        font-weight: 900;
                        text-shadow: 3px 3px 6px rgba(0,0,0,0.6);
                        margin-top: 1rem;">
                        {{ $staffCredentials->username }}!
                    </h1>
                </div>
            </div>
        </div>
    </div>  
</div>


<!-- DAMAGE REPORT CARD -->
<div class="card border-0 shadow-lg mx-auto" style="
            max-width: 80%;
            margin-top: -50px;
            background-color: rgba(255, 255, 255, 0.98);
            border-radius: 15px;">
            
    <!-- Card Header -->
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h2 class="font-heading mb-0 fs-3 fw-bold" style="color: #0b573d;">DAMAGE REPORT</h2>
        
        <button class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addDamageReportModal" 
                style="background-color: #0b573d;
                       border: none;
                       padding: 12px 24px;
                       border-radius: 12px;
                       transition: all 0.3s ease;
                       font-size: 1.1rem;
                       font-weight: 600;
                       box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <i class="fas fa-plus"></i>
            <span>Add Report</span>
        </button>
    </div>

    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
        <!-- Desktop View -->
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="py-3">Room/Area</th>
                        <th class="py-3">Damage Description</th>
                        <th class="py-3">Date Reported</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($damageReports as $report)
                    <tr>
                        <td class="py-3">
                            @if($report->damage_photos)
                            <div>
                                <strong>{{ $report->notes }}</strong>
                                <br>
                                <a href="#" 
                                class="text-primary text-decoration-none"
                                data-bs-toggle="modal" 
                                data-bs-target="#imageModal{{ $report->id }}">
                                    View Image
                                </a>
                            </div>
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td class="py-3"><strong>{{ $report->damage_description }}</strong></td>
                        <td class="py-3">
                            <strong>{{ $report->created_at->format('M d, Y') }}</strong>
                            <div class="text-muted small">{{ $report->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="py-3">
                            <span class="badge rounded-pill text-capitalize px-3 py-2 
                                {{ $report->status == 'pending' ? 'bg-warning' : ($report->status == 'in progress' ? 'bg-info' : 'bg-success') }}">
                                {{ strtoupper($report->status) }}
                            </span>
                        </td>
                        <td class="py-3">
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-primary rounded-3" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editReportModal{{ $report->id }}" 
                                        style="background-color: #0b573d; 
                                               border: none; 
                                               transition: all 0.3s ease;
                                               width: 32px; 
                                               height: 32px; 
                                               padding: 0;
                                               display: flex;
                                               align-items: center;
                                               justify-content: center;">
                                    <i class="fas fa-edit" style="font-size: 14px;"></i>
                                </button>
                                <button class="btn btn-sm btn-danger rounded-3" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $report->id }}" 
                                        style="background-color: #d9534f; 
                                               border: none; 
                                               transition: all 0.3s ease;
                                               width: 32px; 
                                               height: 32px; 
                                               padding: 0;
                                               display: flex;
                                               align-items: center;
                                               justify-content: center;">
                                    <i class="fas fa-trash" style="font-size: 14px;"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile View -->
        <div class="d-md-none">
            @foreach($damageReports as $report)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold">{{ $report->notes }}</h5>
                    <p class="card-text text-muted mb-2">{{ $report->damage_description }}</p>
                    <div class="d-flex flex-column gap-2">
                        <div>
                            <small class="text-muted">Date Reported:</small>
                            <div class="fw-semibold">{{ $report->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                        <div>
                            <small class="text-muted">Status:</small>
                            <div>
                                <span class="badge rounded-pill text-capitalize px-3 py-2 
                                    {{ $report->status == 'pending' ? 'bg-warning' : ($report->status == 'in progress' ? 'bg-info' : 'bg-success') }}">
                                    {{ strtoupper($report->status) }}
                                </span>
                            </div>
                        </div>
                        @if($report->damage_photos)
                        <div>
                            <a href="#" 
                               class="text-primary text-decoration-none"
                               data-bs-toggle="modal" 
                               data-bs-target="#imageModal{{ $report->id }}">
                                View Damage Image
                            </a>
                        </div>
                        @endif
                        <div class="d-flex gap-2 mt-2">
                            <button class="btn btn-sm btn-primary rounded-3" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editReportModal{{ $report->id }}" 
                                    style="background-color: #0b573d; border: none;">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger rounded-3" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal{{ $report->id }}" 
                                    style="background-color: #d9534f; border: none;">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($damageReports->isEmpty())
        <div class="text-center py-4">
            <p class="mb-0">No damage reports found.</p>
        </div>
        @endif

        <!-- Image Modals -->
        @foreach($damageReports as $report)
        @if($report->damage_photos)
        <div class="modal fade" id="imageModal{{ $report->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $report->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-white" style="background: linear-gradient(to right, #0b573d, #43cea2);">
                        <h5 class="modal-title" id="imageModalLabel{{ $report->id }}">Damage Photo - {{ $report->notes }}</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('storage/' . $report->damage_photos) }}" 
                            alt="Damage Photo Full Size" 
                            style="max-width: 100%; max-height: 70vh; object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach

        <!-- Delete Confirmation Modals -->
        @foreach($damageReports as $report)
        <div class="modal fade" id="deleteModal{{ $report->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-white" style="background: linear-gradient(to right, #d9534f, #ff6b6b);">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this damage report?</p>
                        <p class="text-muted small">This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="deleteReport({{ $report->id }})">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @if($damageReports->isNotEmpty())
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4">
            <div class="text-muted mb-3 mb-md-0">
                Showing {{ $damageReports->firstItem() ?? 0 }} to {{ $damageReports->lastItem() ?? 0 }} of {{ $damageReports->total() }} entries
            </div>
            <div class="pagination-container">
                {{ $damageReports->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @endif
    </div>
</div>
<div class="mb-4"></div>

<!-- Add Damage Report Modal -->
<div class="modal fade" id="addDamageReportModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: linear-gradient(to right, #0b573d, #43cea2);">
                <h5 class="modal-title fw-bold">Add Damage Report</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('staff.storeDamageReport') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Room/Area</label>
                        <input type="text" class="form-control" name="notes" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Damage Description</label>
                        <textarea class="form-control" name="damage_description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" name="status">
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Resolved">Resolved</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload Image</label>
                        <input type="file" class="form-control" name="damage_photos" accept="image/*">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" style="background-color: #0b573d; border: none;">
                            Submit Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Damage Report Modals -->
@foreach($damageReports as $report)
<div class="modal fade" id="editReportModal{{ $report->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: linear-gradient(to right, #0b573d, #43cea2);">
                <h5 class="modal-title fw-bold">Edit Damage Report</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('staff.editDamageReport', $report->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Room/Area</label>
                        <input type="text" class="form-control" name="notes" value="{{ $report->notes }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Damage Description</label>
                        <textarea class="form-control" name="damage_description" required>{{ $report->damage_description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select class="form-select" name="status">
                            <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in-progress" {{ $report->status === 'in-progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="background-color: #0b573d; border: none;">Update Report</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach


</body>
</html>