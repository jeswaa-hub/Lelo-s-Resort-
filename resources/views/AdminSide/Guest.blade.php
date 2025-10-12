<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76))>
    @include('Alert.loginSuccessUser')
    @include('Navbar.navbarAdmin')
    <div class=" container-fluid min-vh-100 d-flex p-0">
    <div class="d-flex w-100" id="mainLayout" style="min-height:100vh;">

        <!-- Main Content -->
        <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width" style="transition: all 0.3s ease;">

            <!-- HERO BANNER -->
            <div class="row">
                <div class="col-11 mx-auto">
                    <div class="hero-banner d-flex flex-column justify-content-center text-white p-3 p-sm-4 p-md-5"
                        style="background-color: white; min-height: 450px; border-radius: 15px;">

                        <div class="row g-3 g-md-4">
                            <!-- Left Side with background image -->
                            <div class="col-12 col-md-6">
                                <div class="d-flex flex-column gap-3 h-100" style="background-image: url('{{ url('images/Dashboardbg.png') }}');
                                    background-size: cover; background-position: center; 
                                    border-radius: 15px; padding: 2rem;">
                                    <!-- Greeting -->
                                    <div class="d-flex flex-column align-items-start text-start"
                                        style="padding: 0 20px;">
                                        <p class="text-white"
                                            style="font-family: 'Poppins', sans-serif; font-size: clamp(2rem, 5vw, 3rem); letter-spacing: 5px;">
                                            Hello,
                                        </p>
                                        <h1 class="text-capitalize fw-bolder"
                                            style="font-family: 'Montserrat', sans-serif; font-size: clamp(3rem, 8vw, 5rem); color:#ffffff; letter-spacing: clamp(5px, 2vw, 15px); white-space: normal; overflow-wrap: break-word; font-weight: 900; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                                            Admin
                                        </h1>
                                    </div>

                                    <!-- Registered Guests Card -->
                                    <div class="d-flex align-items-center text-dark p-3 p-md-4 p-lg-5 rounded-3 shadow-sm h-100 position-relative overflow-hidden"
                                        style="background: linear-gradient(135deg, #43cea2 0%, #385E3C 100%); border: 1px solid #ffffff;">
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <div class="d-flex align-items-baseline gap-2">
                                                <h1 class="fw-bold mb-0 text-white"
                                                    style="font-size: clamp(1.5rem, 2.5vw, 3rem);">
                                                    {{$totalGuests ?? 0}}
                                                </h1>
                                                <p class="mb-0 text-uppercase fw-semibold text-white"
                                                    style="font-size: clamp(0.8rem, 1.2vw, 1.2rem);">
                                                    Registered Guest
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-door-open text-white"
                                                    style="font-size: clamp(2.2rem, 4.5vw, 3.5rem);"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side without background image -->
                            <div class="col-12 col-md-6">
                                <div class="row row-cols-2 g-4 h-100">
                                    <!-- Checked-in Guests Card -->
                                    <div class="col d-flex align-items-stretch">
                                        <div class="d-flex align-items-center text-dark p-3 p-md-4 rounded-4 shadow-lg w-100 position-relative overflow-hidden dashboard-card"
                                            style="min-height: 130px; background: linear-gradient(135deg, #43cea2 0%, #385E3C 100%); border: none;">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <div class="d-flex flex-column">
                                                    <h2 class="fw-bold mb-0 text-white"
                                                        style="font-size: clamp(1.5rem, 2.5vw, 2.5rem);">
                                                        {{ $checkedInReservations ?? 0 }}
                                                    </h2>
                                                    <p class="mb-0 text-uppercase fw-semibold text-white"
                                                        style="font-size: clamp(0.75rem, 1vw, 1rem);">CheckIn Guest
                                                    </p>
                                                </div>
                                                <i class="fas fa-door-open text-white"
                                                    style="font-size: clamp(2rem, 3vw, 3rem);"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reserved Reservation Card -->
                                    <div class="col d-flex align-items-stretch">
                                        <div class="d-flex align-items-center text-dark p-3 p-md-4 rounded-4 shadow-lg w-100 position-relative overflow-hidden dashboard-card"
                                            style="min-height: 130px; background: linear-gradient(135deg, rgb(75, 96, 7) 0%, rgb(129, 235, 48) 100%); border: none;">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <div class="d-flex flex-column">
                                                    <h2 class="fw-bold mb-0 text-white"
                                                        style="font-size: clamp(1.5rem, 2.5vw, 2.5rem);">
                                                        {{ $reservedCount ?? 0 }}
                                                    </h2>
                                                    <p class="mb-0 text-uppercase fw-semibold text-white"
                                                        style="font-size: clamp(0.75rem, 1vw, 1rem);">Reserved
                                                        Reservation</p>
                                                </div>
                                                <i class="fas fa-calendar-check text-white"
                                                    style="font-size: clamp(2rem, 3vw, 3rem);"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cancellations/No Shows Card -->
                                    <div class="col d-flex align-items-stretch">
                                        <div class="d-flex align-items-center text-dark p-3 p-md-4 rounded-4 shadow-lg w-100 position-relative overflow-hidden dashboard-card"
                                            style="min-height: 130px; background: linear-gradient(135deg, rgb(75, 96, 7) 0%, rgb(129, 235, 48) 100%); border: none;">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <div class="d-flex flex-column">
                                                    <h2 class="fw-bold mb-0 text-white"
                                                        style="font-size: clamp(1.5rem, 2.5vw, 2.5rem);">
                                                        {{ $cancelledReservations ?? 0 }}
                                                    </h2>
                                                    <p class="mb-0 text-uppercase fw-semibold text-white"
                                                        style="font-size: clamp(0.75rem, 1vw, 1rem);">
                                                        Cancellation/No Show</p>
                                                </div>
                                                <i class="fas fa-calendar-xmark text-white"
                                                    style="font-size: clamp(2rem, 3vw, 3rem);"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Guest Feedback & Complaints Card -->
                                    <div class="col d-flex align-items-stretch">
                                        <div class="d-flex align-items-center text-dark p-3 p-md-4 rounded-4 shadow-lg w-100 position-relative overflow-hidden dashboard-card"
                                            style="min-height: 130px; background: linear-gradient(135deg, #43cea2 0%, #385E3C 100%); border: none;">
                                            <div class="d-flex align-items-center justify-content-between w-100">
                                                <div class="d-flex flex-column">
                                                    <h2 class="fw-bold mb-0 text-white"
                                                        style="font-size: clamp(1.5rem, 2.5vw, 2.5rem);">
                                                        {{ $feedbackCount ?? 0 }}
                                                    </h2>
                                                    <p class="mb-0 text-uppercase fw-semibold text-white"
                                                        style="font-size: clamp(0.75rem, 1vw, 1rem);">Guest Feedback
                                                        & Complain</p>
                                                </div>
                                                <i class="fas fa-comments text-white"
                                                    style="font-size: clamp(2rem, 3vw, 3rem);"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <i class="fas fa-comments fs-1"></i>
                                </div>
                            </div>

                        </div>
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
                                <th scope="col">Guest Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">No. of Visits</th>
                                <th scope="col">Last Visit</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->name }}</td>
                                    <td>{{ $reservation->email }}</td>
                                    <td>{{ $reservation->mobileNo }}</td>
                                    <td>{{ $reservation->visit_count ?? '-' }}</td>
                                    <td>{{ $reservation->last_visit ? date('M d, Y', strtotime($reservation->last_visit)) : '-' }}
                                    </td>
                                    <td>{{ $reservation->status }}</td>
                                    <td>
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
                                <td colspan="7" class="pt-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            @if($reservations->count() > 0)
                                                Showing {{ $reservations->firstItem() }}
                                                to
                                                {{ min($reservations->currentPage() * $reservations->perPage(), $reservations->total()) }}
                                                of {{ $reservations->total() }} Guest
                                            @else
                                                Showing 0 to 0 of 0 entries
                                            @endif
                                        </div>
                                        <div>
                                            {{ $reservations->links('pagination::bootstrap-5') }}
                                        </div>
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
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.querySelector('#search');
            const tableBody = document.querySelector('tbody');
            const reservationsData = @json($reservations->items()); // Get the actual array of items

            // Function to filter table rows based on the search input
            function filterGuests(search) {
                // Clear the current table
                tableBody.innerHTML = '';
            // Function to filter table rows based on the search input
            function filterGuests(search) {
                // Clear the current table
                tableBody.innerHTML = '';

                // Convert reservationsData to array if it's not already
                const reservationsArray = Array.isArray(reservationsData) ? reservationsData : [reservationsData];
                // Convert reservationsData to array if it's not already
                const reservationsArray = Array.isArray(reservationsData) ? reservationsData : [reservationsData];

                // Filter the reservations by guest name (case insensitive)
                const filteredGuests = reservationsArray.filter(guest => {
                    return guest && guest.name && guest.name.toLowerCase().includes(search.toLowerCase());
                });
                // Filter the reservations by guest name (case insensitive)
                const filteredGuests = reservationsArray.filter(guest => {
                    return guest && guest.name && guest.name.toLowerCase().includes(search.toLowerCase());
                });

                // If no guests match the search, show a "No results found" message
                if (filteredGuests.length === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
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
                        tableBody.appendChild(row);
                    });
                }
            }

            // Search event listener (triggered when typing or clicking search button)
            searchInput.addEventListener('input', function () {
                const search = searchInput.value.trim();
                filterGuests(search); // Filter the guest list based on the input value
            });
            // Search event listener (triggered when typing or clicking search button)
            searchInput.addEventListener('input', function () {
                const search = searchInput.value.trim();
                filterGuests(search); // Filter the guest list based on the input value
            });

            // Initial display of all records when the page loads
            filterGuests('');
        });
    </script>
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
                                            $userReservations = DB::table('reservation_details')
                                                ->where('user_id', $reservation->id)
                                                ->get()
                                                ->map(function ($res) {
                                                    // Decode the JSON string to array
                                                    $accomodationIds = json_decode($res->accomodation_id);

                                                    // Get accommodation names
                                                    $accomodationNames = DB::table('accomodations')
                                                        ->whereIn('accomodation_id', $accomodationIds)
                                                        ->pluck('accomodation_name')
                                                        ->join(', ');

                                                    $res->accomodation_name = $accomodationNames;
                                                    return $res;
                                                });
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

</body>


</html>