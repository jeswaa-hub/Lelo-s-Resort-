<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo new.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <title>Damage Report</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    .transition-width {
        transition: all 0.3s ease;
    }

    #mainContent.full-width {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }

    /* Pending (yellow / warning) */
    .status-pending {
        background: #ffc107;
        color: #000;
    }

    .status-inprogress {
        background: linear-gradient(180deg, #963e15, #f4773e) !important;
        color: #fff !important;
        border: none !important;
    }

    /* Resolved (green gradient na binigay mo) */
    .status-resolved {
        background: linear-gradient(180deg, #226214, #43cc25);
        color: #fff;
    }

    /* Custom Table Header Style */
    .custom-table thead th {
        background: linear-gradient(180deg, #f8f9fa, #dcdcdc);
        /* light grey gradient */
        color: #0b573d;
        /* same green tone para match sa theme */
        font-weight: 600;
        text-align: center;
        padding: 12px;
        border-radius: 6px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.15);
        border: none !important;
    }
</style>

<body
    style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76))">
    @include('Alert.loginSucess')
    @include('Navbar.sidenavbar')
    @if ($errors->any())
        <div class="
            alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container-fluid min-vh-100 d-flex p-0">
        <div class="d-flex w-100" id="mainLayout" style="min-height: 100vh;">
            <!-- Main Content -->
            <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width" style="transition: all 0.3s ease;">
                <div class="container-fluid mt-4 mb-4 rounded-4 p-5" style="background: url('{{ asset('images/staff-admin-bg.jpg') }}') no-repeat center center; 
                background-size: cover; 
                    width: 100%;
                    height: 100vh;
                    border-radius: 30px;">


                    <div class="mb-5 text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); margin-top: 13%;">
                        <h2 class="mb-0 fs-1" style="font-size: 4.5rem !important;">Hello,</h2>
                        <h1 class="display-1 fw-bold" style="font-size: 5.5rem !important;">{{$adminCredentials->username}}</h1>
                    </div>
                    <!-- Damage Reports Table -->

                    <div class="bg-white shadow-lg rounded-4 p-4 mt-5" style="max-width: 95%; margin: 0 auto;">
                        <h5 class="fw-bold text-uppercase text-color-2 mb-1" style="letter-spacing: 1px;">Damage Report
                        </h5>
                        <hr>

                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table align-middle table-hover mb-0 custom-table">
                                <thead class="table-light text-uppercase small text-secondary">
                                    <tr>
                                        <th scope="col">Room/Area</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Date Reported</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($damageReports as $report)
                                        <tr>
                                            <!-- Room/Area -->
                                            <td class="fw-semibold text-center">
                                                @if($report->damage_photos)
                                                    <a href="{{ asset('storage/' . $report->damage_photos) }}" target="_blank"
                                                        class="d-block small text-decoration-underline text-muted">
                                                        View Image
                                                    </a>
                                                @else
                                                    <span class="text-muted small">No Image</span>
                                                @endif
                                                <div>{{ $report->notes ?? 'No Room Info' }}</div>
                                            </td>

                                            <!-- Description -->
                                            <td class="text-center">{{ $report->damage_description ?? 'No description' }}</td>

                                            <!-- Date Reported -->
                                            <td class="text-center">
                                                @if($report->created_at)
                                                    {{ $report->created_at->format('M d, Y') }} <br>
                                                    <span
                                                        class="text-muted small">{{ $report->created_at->format('h:i A') }}</span>
                                                @else
                                                    <span class="text-muted">No Date</span>
                                                @endif
                                            </td>

                                            <!-- Status -->
                                            <td class="text-center">
                                                <span class="badge text-capitalize 
                                                                                            @if($report->status == 'pending') status-pending 
                                                                                            @elseif($report->status == 'in-progress') status-inprogress 
                                                                                            @elseif($report->status == 'resolved') status-resolved 
                                                                                            @endif">
                                                    {{ $report->status }}
                                                </span>
                                            </td>



                                            <!-- Actions -->
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button
                                                        class="btn btn-sm color-background5 text-white rounded-3 shadow-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editReportModal{{ $report->id }}"
                                                        style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background-color: #0b573d;">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button
                                                        class="btn btn-sm btn-danger rounded-3 shadow-sm delete-report-btn"
                                                        data-report-id="{{ $report->id }}"
                                                        style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">No Damage Report</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @foreach($damageReports as $report)
                <!-- Edit Damage Report Modal -->
                <div class="modal fade" id="editReportModal{{ $report->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4" style="border: 2px solid #0b573d;">
                            <div class="modal-header color-background5 text-white rounded-top-4"
                                style="background-color: #0b573d;">
                                <h5 class="modal-title fw-bold" style="font-family: 'Poppins', sans-serif;">Edit Damage
                                    Report</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" style="background: #f8f9fa;">
                                <form action="{{ route('editDamageReport', $report->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Room/Area</label>
                                        <input type="text" class="form-control" name="notes" value="{{ $report->notes }}"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Damage Description</label>
                                        <textarea class="form-control" name="damage_description"
                                            required>{{ $report->damage_description }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Status</label>
                                        <select class="form-select rounded-3 border-2" name="status"
                                            style="border-color: #0b573d;">
                                            <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="in-progress" {{ $report->status === 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>
                                                Resolved</option>
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
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4" style="border: 2px solid #dc3545;">
                <div class="modal-header bg-danger text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" style="font-family: 'Poppins', sans-serif;">Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-exclamation-triangle text-warning mb-3" style="font-size: 3rem;"></i>
                    <p class="mb-1 fw-semibold">Are you sure you want to delete this damage report?</p>
                    <p class="text-muted small">This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let reportIdToDelete = null;

        function deleteReport(id) {
            reportIdToDelete = id;
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            modal.show();
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-report-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const reportId = this.dataset.reportId;
                    deleteReport(reportId);
                });
            });

            document.getElementById('confirmDelete').addEventListener('click', function () {
                if (reportIdToDelete) {
                    fetch(`/damage-report/delete/${reportIdToDelete}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.reload();
                            } else {
                                alert('Hindi matagumpay ang pagtanggal ng report');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('May naganap na error sa pagtanggal ng report');
                        });
                }
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal'));
                modal.hide();
            });
        });
    </script>
</body>

</html>