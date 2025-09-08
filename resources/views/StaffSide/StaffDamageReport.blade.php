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
        <div class="row">
    <div class="col-11 mx-auto">
        <div class="hero-banner" 
             style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(34, 34, 34, 0.5)), url('{{ asset('images/staff-admin-bg.jpg') }}'); 
                    background-size: cover; 
                    background-position: center; 
                    height: 450px; 
                    border-radius: 15px;">
            <div class="d-flex justify-content-start align-items-center h-100">
                <div class="ms-5">
                    <p class="text-white mb-0" style="font-size: 2.5rem; font-family: 'Poppins', sans-serif; margin-left: 5rem;">Hello,</p>
                    <h1 class="text-white fw-bold" style="font-size: 4.5rem; font-family: 'Poppins', sans-serif; margin-left: 5rem;">
                        Staff002!
                    </h1>
                </div>
            </div>
        </div>
    </div>
</div>




     <!-- TABLE SECTION -->
<div class="position-relative w-100" style="margin-top: -125px; margin-bottom: 50px;">
    <div class="d-flex justify-content-center">
        <div class="w-75">
            <div class="card border-2 shadow-lg" style="background-color: rgba(255, 255, 255, 0.95);">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h2 class="font-heading mb-0 fs-3 fw-bold" style="color: #0b573d;">DAMAGE REPORT</h2>
                    <button class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addDamageReportModal" style="background-color: #0b573d; border: none; padding: 12px 24px; border-radius: 12px; transition: all 0.3s ease; font-size: 1.1rem; font-weight: 600; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        <i class="fas fa-plus"></i>
                        <span>Add Report</span>
                    </button>
                </div>

                <div style="height: 400px; overflow-y: auto;">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead style="background-color: #f5f5f5;">
                                    <tr>
                                        <th style="color: #0b573d; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); background-color: #f8f9fa; border-radius: 4px;">Room/Area</th>
                                        <th style="color: #0b573d; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); background-color: #f8f9fa; border-radius: 4px;">Damage Description</th>
                                        <th style="color: #0b573d; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); background-color: #f8f9fa; border-radius: 4px;">Date Reported</th>
                                        <th style="color: #0b573d; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); background-color: #f8f9fa; border-radius: 4px;">Status</th>
                                        <th style="color: #0b573d; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); background-color: #f8f9fa; border-radius: 4px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($damageReports as $report)
                                    <tr>
                                        <td>
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

                                            <!-- Image Modal -->
                                            <div class="modal fade" id="imageModal{{ $report->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $report->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="imageModalLabel{{ $report->id }}">Damage Photo</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('storage/' . $report->damage_photos) }}" 
                                                                alt="Damage Photo Full Size" 
                                                                style="max-width: 100%; max-height: 80vh; object-fit: contain;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td><strong>{{ $report->damage_description }}</strong></td>
                                        <td><strong>{{ $report->created_at->format('M d, Y') }}<br>{{ $report->created_at->format('h:i A') }}</strong></td>
                                        <td>
                                            <span class="badge fs-6 px-3 py-2 {{ $report->status == 'pending' ? 'bg-warning' : ($report->status == 'in progress' ? 'bg-info' : 'bg-success') }}" style="font-size: 1rem;">
                                                {{ strtoupper($report->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-primary rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#editReportModal{{ $report->id }}" style="background-color: #0b573d; border: none; transition: background 0.2s; width: 32px; height: 32px; padding: 0;">
                                                    <i class="fas fa-edit" style="font-size: 14px;"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $report->id }}" style="background-color: #d9534f; border: none; transition: background 0.2s; width: 32px; height: 32px; padding: 0;">
                                                    <i class="fas fa-trash" style="font-size: 14px;"></i>
                                                </button>

                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteModal{{ $report->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content rounded-4" style="border: 2px solid #d9534f;">
                                                            <div class="modal-header bg-danger text-white rounded-top-4">
                                                                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
<!-- Added spacing below table -->



            <!-- Add Damage Report Modal -->
            <div class="modal fade" id="addDamageReportModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4" style="border: 2px solid #0b573d;">
                        <div class="modal-header color-background5 text-white rounded-top-4" style="background-color: #0b573d;">
                            <h5 class="modal-title fw-bold" style="font-family: 'Poppins', sans-serif;">Add Damage Report</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" style="background: #f8f9fa;">
                            <form action="{{ route('staff.storeDamageReport') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #0b573d; font-family: 'Poppins', sans-serif;">Room/Area</label>
                                    <input type="text" class="form-control rounded-3 border-2" name="notes" required style="border-color: #0b573d;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #0b573d; font-family: 'Poppins', sans-serif;">Damage Description</label>
                                    <textarea class="form-control rounded-3 border-2" name="damage_description" rows="3" required style="border-color: #0b573d;"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #0b573d; font-family: 'Poppins', sans-serif;">Status</label>
                                    <select class="form-select rounded-3 border-2" name="status" style="border-color: #0b573d;">
                                        <option value="Pending">Pending</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Resolved">Resolved</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #0b573d; font-family: 'Poppins', sans-serif;">Upload Image</label>
                                    <input type="file" class="form-control rounded-3 border-2" name="damage_photos" accept="image/*" style="border-color: #0b573d;">
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success rounded-3 fw-semibold" style="background-color: #0b573d; border: none; padding: 10px; font-family: 'Poppins', sans-serif; letter-spacing: 1px; transition: all 0.3s;">
                                        Submit Report
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @foreach($damageReports as $report)
        <!-- Edit Damage Report Modal -->
        <div class="modal fade" id="editReportModal{{ $report->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4" style="border: 2px solid #0b573d;">
                    <div class="modal-header color-background5 text-white rounded-top-4" style="background-color: #0b573d;">
                        <h5 class="modal-title fw-bold" style="font-family: 'Poppins', sans-serif;">Edit Damage Report</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="background: #f8f9fa;">
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
                                <select class="form-select rounded-3 border-2" name="status" style="border-color: #0b573d;">
                                    <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in-progress" {{ $report->status === 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Update Report</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    </div>
    </div>
</body>
</html>