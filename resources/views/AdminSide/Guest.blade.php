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
    <title>Guest</title>
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

    /* Custom Pagination Styles */
    .pagination .page-link {
        border-radius: 50% !important;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 3px;
        border: 2px solid #0b573d;
        color: #0b573d;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .pagination .page-link:hover {
        background-color: #0b573d;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .pagination .page-item.active .page-link {
        background-color: #0b573d;
        border-color: #0b573d;
        color: white;
    }

    .pagination .page-item.disabled .page-link {
        background-color: #e9ecef;
        border-color: #dee2e6;
        color: #6c757d;
    }
</style>

<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76))">
    @include('Alert.loginSuccessUser')
    @include('Navbar.sidenavbar')
    <div class="container-fluid min-vh-100 d-flex p-0">
    
    <div class="d-flex w-100" id="mainLayout" style="min-height:100vh;">

        <!-- Main Content -->
        <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width" style="transition: all 0.3s ease;">
            <div class="container-fluid mt-4 mb-4 rounded-4 p-5" style="background: url('{{ asset('images/staff-admin-bg.jpg') }}') no-repeat center center; 
            background-size: cover; 
                width: 100%;
                height: 100vh;
                border-radius: 30px;">
                <!-- Cards -->

                <div class="row g-4 mt-2">
                    <!-- Registered Guests Card -->
                    <div class="col-md-6">
                        <div class="card border-0 rounded-4 shadow"
                            style="background: linear-gradient(180deg, #226214, #43cc25);">
                            <div class="card-body text-white p-5">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="display-4 fw-bold">{{$totalGuests ?? 0}}</h3>
                                        <p class="mb-0 font-paragraph fw-bold">Registered Guest</p>
                                    </div>
                                    <i class="fas fa-door-open fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Checked-in Guests Card -->
                    <div class="col-md-6">
                        <div class="card border-0 rounded-4 shadow"
                            style="background: linear-gradient(180deg, #226214, #43cc25);">
                            <div class="card-body text-white p-5">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="display-4 fw-bold">{{$checkedInReservations ?? 0}}</h3>
                                        <p class="mb-0 font-paragraph fw-bold">CheckIn Guest</p>
                                    </div>
                                    <i class="fas fa-door-open fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mt-4">
                    <!-- Reserved Reservation Card -->
                    <div class="col-md-4">
                        <div class="card border-0 rounded-4 shadow"
                            style="background: linear-gradient(180deg, #3e786d, #9bd7e7);">
                            <div class="card-body text-white p-5">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="display-4 fw-bold">{{$reservedCount ?? 0}}</h3>
                                        <p class="mb-0 font-paragraph fw-bold">Reserved Reservation</p>
                                    </div>
                                    <i class="fas fa-calendar-check fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cancellations/No Shows Card -->
                    <div class="col-md-4">
                        <div class="card border-0 rounded-4 shadow"
                            style="background: linear-gradient(180deg, #226214, #43cc25);">
                            <div class="card-body text-white p-5">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="display-4 fw-bold">{{$cancelledReservations ?? 0}}</h3>
                                        <p class="mb-0 font-paragraph fw-bold">Cancellation/No Show</p>
                                    </div>
                                    <i class="fas fa-calendar-xmark fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Guest Feedback & Complaints Card -->
                    <div class="col-md-4">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#feedbackModal"
                           class="text-decoration-none">
                            <div class="card border-0 rounded-4 shadow h-100"
                                 style="background: linear-gradient(180deg, #3e786d, #9bd7e7); transition: transform 0.2s ease-in-out;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                            <div class="card-body text-white p-5">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="display-4 fw-bold">{{ $feedbackCount ?? 0}}</h3>
                                        <p class="mb-0 font-paragraph fw-bold">Guest Feedback & Complain</p>
                                    </div>
                                    <i class="fas fa-comments fs-1"></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Guest List -->
            <div class="mt-5">
                <!-- Table -->
                <div class="bg-white shadow-lg rounded-4 p-4 mt-1">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Title -->
                            <h2 class="mb-0 me-3" style="color: #0b573d; font-weight: bold; white-space: nowrap;">
                                Guest Information
                            </h2>

                            <!-- Search box -->
                            <div class="flex-grow-1">
                                <input type="search" id="search" class="form-control" placeholder="Search Guest Name"
                                    aria-label="Search">
                            </div>
                        </div>
                        <hr class="mt-2 mb-0">
                    </div>



                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="py-3 px-4">Guest Name</th>
                                <th scope="col" class="py-3 px-4">Email</th>
                                <th scope="col" class="py-3 px-4">Phone Number</th>
                                <th scope="col" class="py-3 px-4">No. of Visits</th>
                                <th scope="col" class="py-3 px-4">Last Visit</th>
                                <th scope="col" class="py-3 px-4">Status</th>
                                <th scope="col" class="py-3 px-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                <tr>
                                    <td class="py-3 px-4">{{ $reservation->name }}</td>
                                    <td class="py-3 px-4">{{ $reservation->email }}</td>
                                    <td class="py-3 px-4 text-center">{{ $reservation->mobileNo }}</td>
                                    <td class="py-3 px-4 text-center">{{ $reservation->visit_count ?? '-' }}</td>
                                    <td class="py-3 px-4 text-center">{{ $reservation->last_visit ? date('M d, Y', strtotime($reservation->last_visit)) : '-' }}
                                    </td>
                                    <td class="py-3 px-4 text-center">{{ $reservation->status }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm text-white" style="background-color: #0b573d;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewGuestModal{{ $reservation->id }}" title="View Guest">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#banGuestModal{{ $reservation->id }}" title="Ban Guest">
                                                <i class="fas fa-ban"></i> Ban
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" class="pt-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted small">
                                            @if($reservations->count() > 0)
                                                Showing {{ $reservations->firstItem() }}
                                                to
                                                {{ $reservations->lastItem() }}
                                                of {{ $reservations->total() }} guests
                                            @else
                                                Showing 0 to 0 of 0 entries
                                            @endif
                                        </div> 
                                        {{ $reservations->links('pagination.custom') }}
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

    <!-- Scripts -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.querySelector('#search');
            const tableBody = document.querySelector('tbody');
            const reservationsData = @json($reservations->items()); // Get the actual array of items

            // Function to filter table rows based on the search input
            function filterGuests(search) {
                // Clear the current table
                tableBody.innerHTML = '';

                // Convert reservationsData to array if it's not already
                const reservationsArray = Array.isArray(reservationsData) ? reservationsData : [reservationsData];

                // Filter the reservations by guest name (case insensitive)
                const filteredGuests = reservationsArray.filter(guest => {
                    return guest && guest.name && guest.name.toLowerCase().includes(search.toLowerCase());
                });

                // If no guests match the search, show a "No results found" message
                if (filteredGuests.length === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                    <td colspan="6" class="text-center py-3 px-4">
                        <div class="d-flex justify-content-center align-items-center">
                            No results found
                        </div>
                    </td>`;
                    tableBody.appendChild(row);
                } else {
                    // Append the filtered guests to the table
                    filteredGuests.forEach(guest => {
                        const row = document.createElement('tr');
                        row.className = '';
                        row.innerHTML = `
                        <td class="">
                            <div>
                                ${guest.name}
                            </div>
                        </td>
                        <td >
                            <div>
                                ${guest.email}
                            </div>
                        </td>
                        <td >
                            <div>
                                ${guest.mobileNo || '-'}
                            </div>
                        </td>
                        <td>
                            <div>
                                ${guest.visit_count || '-'}
                            </div>
                        </td>
                        <td>
                            <div>
                                ${guest.last_visit ? new Date(guest.last_visit).toLocaleString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) : '-'}
                            </div>
                        </td>
                        <td>
                            <div>
                                ${guest.status || '-'}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm text-white" style="background-color: #0b573d;" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewGuestModal${guest.id}" 
                                        title="View Guest">
                                    <i class="fas fa-eye me-1"></i> View
                                </button>
                                <button class="btn btn-sm btn-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#banGuestModal${guest.id}" 
                                        title="Ban Guest">
                                    <i class="fas fa-ban me-1"></i> Ban
                                </button>
                            </div>
                        </td>
                    `;
                        tableBody.appendChild(row);
                    });
                }
            }

            // Search event listener (triggered when typing or clicking search button)
            searchInput.addEventListener('input', function () {
                const search = searchInput.value.trim();
                filterGuests(search); // Filter the guest list based on the input value
            });

            // Initial display of all records when the page loads
            filterGuests('');
        });
    </script>

    <!-- Add these modals at the end of the body tag -->
    @foreach($reservations as $reservation)
        <!-- View Guest Modal -->
        <div class="modal fade" id="viewGuestModal{{ $reservation->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #0b573d; color: white;">
                        <h5 class="modal-title">Guest Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Guest Information -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Personal Information</h6>
                            <div class="mb-2">
                                <strong>Name:</strong> {{ $reservation->name }}
                            </div>
                            <div class="mb-2">
                                <strong>Email:</strong> {{ $reservation->email }}
                            </div>
                            <div class="mb-2">
                                <strong>Phone:</strong> {{ $reservation->mobileNo }}
                            </div>
                            <div class="mb-2">
                                <strong>Total Visits:</strong> {{ $reservation->visit_count ?? '0' }}
                            </div>
                            <div class="mb-2">
                                <strong>Last Visit:</strong>
                                {{ $reservation->last_visit ? date('M d, Y', strtotime($reservation->last_visit)) : 'No visits yet' }}
                            </div>
                        </div>

                        <!-- Reservations History -->
                        <div>
                            <h6 class="fw-bold mb-3">Reservation History</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>No. of Guest</th>
                                            <th>Room</th>
                                            <th>Reservation Status</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        // Fetch paginated reservations for the user
                                        $userReservations = DB::table('reservation_details')
                                            ->where('user_id', $reservation->id)
                                            ->orderBy('reservation_check_in_date', 'desc')
                                            ->paginate(3, ['*'], 'reservationsPage' . $reservation->id); // Use a unique page name

                                        // Get accommodation names for the current page of reservations
                                        foreach ($userReservations as $res) {
                                            $accomodationIds = json_decode($res->accomodation_id, true) ?: [];
                                            if (!is_array($accomodationIds)) {
                                                $accomodationIds = explode(',', $res->accomodation_id);
                                            }
                                            $res->accomodation_name = DB::table('accomodations')
                                                ->whereIn('accomodation_id', $accomodationIds)
                                                ->pluck('accomodation_name')->join(', ');
                                        }
                                        @endphp

                                        @forelse($userReservations as $res)
                                            <tr>
                                                <td>{{ date('M d, Y', strtotime($res->reservation_check_in_date)) }}</td>
                                                <td>{{ $res->number_of_adults + $res->number_of_children }}
                                                    ({{ $res->number_of_adults }} Adults, {{ $res->number_of_children }}
                                                    Children)</td>
                                                <td>{{ $res->accomodation_name }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $res->reservation_status == 'cancelled' || $res->reservation_status == 'checked-out' ? 'bg-danger' : ($res->reservation_status == 'checked-in' ? 'bg-success' : 'bg-warning') }}">
                                                        {{ ucfirst($res->reservation_status) }}
                                                    </span>
                                                </td>
                                                <td>₱{{ number_format($res->amount, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No reservations found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination for Reservation History -->
                            <div class="d-flex justify-content-end mt-3">
                                {{ $userReservations->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ban Guest Modal -->
        <div class="modal fade" id="banGuestModal{{ $reservation->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Ban Guest</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to ban {{ $reservation->name }}?</p>
                        <p class="text-muted">This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('ban.guest', $reservation->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger">Ban Guest</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #3e786d, #5ca9bf);">
                    <h5 class="modal-title fw-bold" id="feedbackModalLabel">
                        <i class="fas fa-comments me-2"></i>All Guest Feedback & Complaints
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="background-color: #f8f9fa;">
                    @if($allFeedback->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Feedback Yet</h5>
                            <p class="text-secondary">There are currently no feedback entries from guests.</p>
                        </div>
                    @else
                        @foreach($allFeedback as $feedback)
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <img src="{{ $feedback->user_image ? asset('storage/' . $feedback->user_image) : asset('images/default-profile.jpg') }}" 
                                             alt="User" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="fw-bold mb-0">{{ $feedback->user_name }}</h6>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($feedback->created_at)->diffForHumans() }}</small>
                                            </div>
                                            <div class="d-flex align-items-center my-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $feedback->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                                @endfor
                                                <span class="ms-2 text-muted">({{ $feedback->rating }}/5)</span>
                                            </div>
                                            <p class="mb-0 text-secondary">{{ $feedback->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="modal-footer border-0" style="background-color: #f1f3f5;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</body>

</html>