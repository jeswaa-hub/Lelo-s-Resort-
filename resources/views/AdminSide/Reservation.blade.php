<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Reservation</title>
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

#calendar-container {
    max-width: 100%; /* Reduce width */
    
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.fc-view-container {
    height: 300px !important; /* Ensure height applies */
}
.fc .fc-toolbar-title{
    font-size: 3rem !important;
    text-transform: uppercase;
    font-family: 'Anton';
    letter-spacing: 0.1em;
    color: #0b573d;
}
.fc-daygrid-day-number {
    font-size: 0.75rem !important; 
    color: #0b573d;
}
.fc .fc-col-header-cell-cushion{
    font-size: 1rem !important; 
    color: #0b573d;
    text-decoration: none !important;
    
}
.fc-direction-ltr .fc-button-group{
    color: #0b573d;
}
.fc-daygrid-event {
    font-size: 0.7rem !important; /* Smaller event text */
    padding: 2px;
    border-radius: 3px;
}
.fc-button {
    background-color: #0b573d !important;
    font-family: 'Anton', sans-serif !important;
    color: white !important;
    text-transform: capitalize !important;
    
    border: none !important;
    border-radius: 8px !important;
    padding: 6px 12px !important;
    transition: background-color 0.3s ease;
}

/* Style for the active button (selected view) */
.fc-button.fc-button-active {
    background-color: #094a34 !important;
}

/* Hover effect */
.fc-button:hover {
    background-color: #127656 !important;
}
.transition-width {
    transition: all 0.3s ease;
}
#mainContent.full-width {
    width: 100% !important;
    flex: 0 0 100% !important;
    max-width: 100% !important;
}

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
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
@media (max-width: 350px) {
    /* Greeting and Username */
    .hero-banner p {
        font-size: 0.9rem !important;
    }
    .hero-banner h1 {
        font-size: 1.8rem !important;
    }

    /* Force scroll on small devices */
    .reservation-table {
        min-width: 650px !important;
        font-size: 0.75rem;
    }

    .calendar-table {
        min-width: 500px !important;
    }

    /* Hide time/date */
    #live-time, #live-date {
        display: none !important;
    }
}


</style>
<x-loading-screen/>
<body style="margin: 0; padding: 0; height: 100vh; background-color: white; overflow-x: hidden;">
     @include('Alert.loginSucess')

    <!-- NAVBAR -->
    @include('Navbar.sidenavbar')
    <div id="mainContent" class="flex-grow-1 pt-4 px-4">
        <div class="row">
            <div class="col-12 col-lg-11 mx-auto mt-4">
                <div  class="hero-banner d-flex align-items-center"
                        style="background-image: url('{{ asset('images/staff-admin-bg.jpg') }}'); 
                        background-size: cover; 
                        background-position: center; 
                        min-height: 450px; 
                        border-radius: 15px; 
                        padding: 40px;">
                    
                    <div class="container-fluid">
                        <div class="row g-4">
                            <div class="col-12 col-lg-7 d-flex flex-column">
                                <!-- Greeting -->
                                <p class="text-white mb-1"
                                    style="font-family: 'Poppins', sans-serif; font-size: clamp(1.3rem, 3.5vw, 2.2rem); letter-spacing: 2px;">
                                    Hello,
                                </p>
                                <h1 class="fw-bolder mb-4 text-white text-capitalize"
                                    style="font-family: 'Montserrat', sans-serif; font-size: clamp(3.5rem, 9vw, 6.2rem); font-weight: 900;">
                                    {{ $adminCredentials->username }}
                                </h1>
                            </div>

                            <!-- Date & Time (hidden on smaller screens) -->
                            <div class="col-12 col-lg-5 d-flex justify-content-lg-end align-items-center d-none d-lg-flex">
                                <div class="text-white text-lg-end">
                                    <h2 id="live-time" class="fw-bolder"
                                        style="font-family: 'Montserrat', sans-serif; font-size: 3.2rem;"></h2>
                                    <p id="live-date" style="font-family: 'Poppins', sans-serif; font-size: 1.3rem;"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid min-vh-100 d-flex p-0" style="margin-top: -150px;">
    <div class="d-flex w-100 mx-auto" id="mainLayout" style="min-height: 100vh; max-width: 90%;">
        <div class="flex-grow-1 py-4 px-3 px-md-4 transition-width" style="transition: all 0.3s ease;">
            
            <!-- Records -->
            <div class="card shadow-lg rounded-4 border-0 p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center mt-3 mb-3 flex-wrap">
                    <!-- Title -->
                    <h1 class="text-color-2 mb-2 mb-md-0" style="font-family: 'Anton', sans-serif;">
                        Guest Reservation Records
                    </h1>

                    <!-- Search Function -->
                    <form class="d-flex justify-content-center align-items-center mt-2 mt-md-0 w-100 w-md-auto"
                        role="search" action="{{ route('reservations') }}" method="GET" style="max-width: 500px; flex: 1;">
                        <select name="type" class="form-select me-2 rounded-5 bg-light border border-secondary" onchange="this.form.submit()">
                            <option value="">All Types</option>
                            <option value="online" {{ request('type') == 'online' ? 'selected' : '' }}>Online</option>
                            <option value="walkin" {{ request('type') == 'walkin' ? 'selected' : '' }}>Walk-in</option>
                        </select>
                        <div class="input-group">
                            <input type="text" 
                                name="search"
                                class="form-control mb-0 rounded-start-5 bg-light border border-secondary" 
                                placeholder="Search Guest Name" aria-label="Search" 
                                value="{{ request('search') }}">
                            <button class="btn btn-outline-success rounded-end-5"
                                    type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Responsive Table -->
                <div class="mt-2" style="overflow-x: auto;">
                    <table class="table table-hover table-striped table-sm align-middle reservation-table">
                        <thead class="table-light text-uppercase text-secondary small">
                            <tr>
                                <th>Guest Name</th>
                                <th>Dates(In-Out)</th>
                                <th>Time(In-Out)</th>
                                <th>Room Type</th>
                                <th>Room Qty</th>
                                <th>Mobile Number</th>
                                <th>Reference Number</th>
                                <th>Payment Status</th>
                                <th>Res. Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="reservationTable">
                            @foreach ($reservations as $reservation)
                                <tr>
                                    <td class="fw-semibold">{{ $reservation->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('M j, Y') }}-{{ \Carbon\Carbon::parse($reservation->reservation_check_out_date)->format('M j, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->reservation_check_in)->format('h:i A') }}-{{ \Carbon\Carbon::parse($reservation->reservation_check_out)->format('h:i A') }}</td>
                                    <td>
                                        @if(!empty($reservation->accomodation_names))
                                            {{ implode(', ', $reservation->accomodation_names) }}
                                        @else
                                            <span class="text-muted">No Accommodation</span>
                                        @endif
                                    </td>
                                    <td>{{ $reservation->quantity}}</td>
                                    <td>{{$reservation->mobileNo}}</td>
                                    <td>{{ $reservation->reference_num}}</td>
                                    <td>
                                        <span class="badge 
                                            @if($reservation->payment_status == 'paid') bg-success
                                            @elseif($reservation->payment_status == 'pending') bg-warning text-dark
                                            @elseif($reservation->payment_status == 'booked') bg-primary
                                            @else bg-danger
                                            @endif
                                            px-3 py-2 rounded-pill text-uppercase fw-medium">
                                            {{ ucfirst($reservation->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($reservation->reservation_status == 'pending')
                                                bg-warning text-dark
                                            @elseif($reservation->reservation_status == 'reserved')
                                                bg-primary
                                            @elseif($reservation->reservation_status == 'checked-in' || $reservation->reservation_status == 'confirmed')
                                                bg-success
                                            @elseif($reservation->reservation_status == 'checked-out' || $reservation->reservation_status == 'early-checked-out' || $reservation->reservation_status == 'cancelled')
                                                bg-danger
                                            @else
                                                bg-secondary
                                            @endif
                                            px-3 py-2 rounded-pill text-uppercase fw-medium">
                                            {{ ucfirst(str_replace('-', ' ', $reservation->reservation_status)) }}
                                        </span>
                                    </td>
                                    <td>₱{{ number_format($reservation->amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="10" class="pt-4">
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                                        <div class="text-muted small">
                                            Showing {{ $reservations->firstItem() }} to {{ $reservations->lastItem() }} of {{ $reservations->total() }} reservations
                                        </div>
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination mb-0">
                                                {{-- Previous Page Link --}}
                                                @if ($reservations->onFirstPage())
                                                    <li class="page-item disabled">
                                                        <span class="page-link">&laquo;</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $reservations->previousPageUrl() }}" rel="prev">&laquo;</a>
                                                    </li>
                                                @endif

                                                {{-- Pagination Elements --}}
                                                @foreach ($reservations->getUrlRange(1, $reservations->lastPage()) as $page => $url) 
                                                    @if ($page == $reservations->currentPage())
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
                                                @if ($reservations->hasMorePages())
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $reservations->nextPageUrl() }}" rel="next">&raquo;</a>
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

            <!-- Calendar -->
            <div class="mt-5">
                <div id="calendar-container" 
                    class="shadow-lg rounded-4 p-3 bg-white floating-effect" 
                    style="overflow-x: auto;">
                    <div id="calendar" class="mb-5 calendar-table"></div>
                </div>
            </div>

        </div>
    </div>
</div>

    

<!-- Showing Calendar -->
<script>
    function renderCalendar() {
        var calendarEl = document.getElementById('calendar');

        // Get the selected reservation type from the dropdown
        var selectedType = '{{ request('type', 'all') }}';
        if (selectedType === '') selectedType = 'all';

        // Filter events based on the selected type
        var events = @json($events);
        var filteredEvents = events;

        if (selectedType !== 'all') {
            filteredEvents = events.filter(function(event) {
                return event.extendedProps.reservation_type === selectedType;
            });
        }

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 'auto',
            contentHeight: 600,
            events: filteredEvents,
            eventColor: '#0b573d',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            eventClick: function(info) {
                // Enhanced event details display
                const event = info.event;
                const startDateFmt = moment(event.start).format('MMMM D, YYYY');
                const endDateFmt = event.end ? moment(event.end).subtract(1, 'days').format('MMMM D, YYYY') : startDateFmt;
                const guestName = event.extendedProps.name;
                const quantity = event.extendedProps.quantity;
                
                // Get original dates from extendedProps
                const checkInDate = event.extendedProps.check_in_date;
                const checkOutDate = event.extendedProps.check_out_date;
                const reservationType = event.extendedProps.reservation_type;

                // Determine stay type
                const stayType = (checkInDate === checkOutDate) ? 'One-Day Stay' : 'Staycation';
                
                // Split the description into reserved and available rooms
                const description = event.extendedProps.description;
                const [reservedRooms, availableRooms] = description.split('\n');
                
                const detailsHtml = `
                    <div class="p-4">
                        <h5 class="text-center mb-4" style="font-family: 'Anton', sans-serif; color: #0b573d; letter-spacing: 0.1em;">RESERVATION DETAILS</h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body" style="background-color: #f8f9fa; border-radius: 10px;">
                                        <h6 class="card-subtitle mb-2" style="color: #0b573d; font-family: 'Poppins', sans-serif;">Guest Name</h6>
                                        <p class="card-text fw-semibold">${guestName}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body" style="background-color: #f8f9fa; border-radius: 10px;">
                                        <h6 class="card-subtitle mb-2" style="color: #0b573d; font-family: 'Poppins', sans-serif;">Reservation Dates & Type</h6>
                                        <p class="card-text fw-semibold">
                                            ${startDateFmt}${startDateFmt !== endDateFmt ? ' - ' + endDateFmt : ''}
                                            <span class="badge bg-success ms-2">${stayType}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body" style="background-color: #f8f9fa; border-radius: 10px;">
                                        <h6 class="card-subtitle mb-2" style="color: #0b573d; font-family: 'Poppins', sans-serif;">Reservation Type</h6>
                                        <p class="card-text fw-semibold text-capitalize">${reservationType} Reservation</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body" style="background-color: #0b573d; border-radius: 10px;">
                                        <h6 class="card-subtitle mb-2 text-white" style="font-family: 'Poppins', sans-serif;">Reserved Rooms</h6>
                                        <p class="card-text text-white fw-semibold">${reservedRooms.replace('Reserved Rooms: ', '')}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body" style="background-color: #127656; border-radius: 10px;">
                                        <h6 class="card-subtitle mb-2 text-white" style="font-family: 'Poppins', sans-serif;">Available Rooms</h6>
                                        <p class="card-text text-white fw-semibold">${availableRooms.replace('Available Rooms: ', '')}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            
                Swal.fire({
                    title: '',
                    html: detailsHtml,
                    showCloseButton: true,
                    showConfirmButton: false,
                    width: '32rem',
                    padding: '0',
                    background: '#ffffff',
                    customClass: {
                        popup: 'rounded-4 shadow-lg',
                        closeButton: 'btn btn-lg btn-outline-secondary rounded-circle p-2 position-absolute end-0 top-0 m-3'
                    }
                });
            },
            dayMaxEvents: true,
            eventTimeFormat: {
                hour: 'numeric',
                minute: '2-digit',
                meridiem: 'short'
            }
        });

        calendar.render();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const calendarContainer = document.getElementById('calendar-container');

        const observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) {
                renderCalendar();
                observer.disconnect();
            }
        }, {
            root: null,
            threshold: 0.1
        });

        observer.observe(calendarContainer);
    });
</script>

<!-- Something Function -->
<script>
    document.getElementById('user_id').addEventListener('change', function() {
        let userId = this.value;
        let reservationTable = document.getElementById('reservationTable');

        // Clear table content
        reservationTable.innerHTML = '';

        // Fetch filtered reservations
        fetch("{{ route('reservations') }}?user_id=" + userId)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    data.forEach(reservation => {
                        let row = `
                            <tr>
                                <td>${reservation.id}</td>
                                <td>${reservation.reservation_check_in_date}</td>
                                <td>example</td>
                                <td>${reservation.name}</td>
                                <td>${reservation.reservation_check_in}</td>
                                <td>${reservation.reservation_check_out}</td>
                                <td>${reservation.payment_status}</td>
                                <td>${reservation.amount}</td>
                                <td>
                                    <a href="#" class="text-success"><i class="fa-solid fa-eye"></i></a>
                                    <a href="#" class="text-warning mx-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="#" method="POST" style="display:inline;">
                                        <button type="submit" class="text-danger border-0 bg-transparent"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>
                        `;
                        reservationTable.innerHTML += row;
                    });
                } else {
                    reservationTable.innerHTML = `<tr><td colspan="9" class="text-center mt-3">No Reservations Found</td></tr>`;
                }
            });
    });
</script>
<!-- Live Time and Date -->
<script>
    function updateTime() {
        const timeElement = document.getElementById('live-time');
        const dateElement = document.getElementById('live-date');
        
        const now = new Date();
        
        const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const dateString = now.toLocaleDateString([], { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        
        timeElement.textContent = timeString;
        dateElement.textContent = dateString;
    }
    
    setInterval(updateTime, 1000);
    updateTime(); // Initial call
</script>
</body>
</html>