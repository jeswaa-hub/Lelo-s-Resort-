<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Calendar</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo new.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <style>
        body {
            background: url('{{ asset('images/logosheesh.png') }}') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        #calendar {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            height: auto !important;
            min-height: 500px;
        }

        .reservation-controls {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 1.5rem;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        @media (min-width: 768px) {
            .btn-group {
                flex-direction: row;
            }
            
            .container-fluid {
                max-width: 1400px;
            }
        }

        @media (max-width: 767px) {
            .container-fluid {
                flex-direction: column;
            }
            
            .reservation-controls {
                width: 100% !important;
                margin-top: 1rem;
            }
        }

        .profile-icon {
            width: 40px;
            height: 40px;
            background: #2ecc71;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: transform 0.2s;
        }

        .profile-icon:hover {
            transform: scale(1.1);
        }

        .app-logo {
            max-width: 100px;
            height: auto;
        }

        .instructions-box, .selected-dates {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .toast {
            z-index: 1050;
        }
    </style>
</head>
<body class="font-paragraph">
    @if (session('login_success'))
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div class="toast show align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-bold">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('login_success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif
    
    @include('Alert.loginSuccessUser')

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg py-3">
        <div class="container">
            <a href="{{ route('homepage') }}" class="navbar-brand">
                <div class="">
                    <i class="color-3 fa-2x fa-circle-left fa-solid icon icon-hover"></i>
                </div>
            </a>
                <img src="{{ asset('images/logo new.png') }}" alt="App Logo" class="app-logo">
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row g-4">
            <!-- Left Panel -->
            <div class="col-lg-4">
                <div class="reservation-controls h-100 d-flex flex-column gap-4">
                    <!-- Additional Info Card -->
                    <div class="instructions-box p-4 rounded-3 shadow-sm">
                        <h6 class="text-center mb-3 text-success fw-semibold">for the recent book
                        </h6>
                    </div>

                    <!-- Reservation Type Toggle -->
                    <div class="btn-group w-100 shadow-sm" role="group">
                        <button type="button" class="btn btn-success active flex-grow-1 reservation-btn" id="stayinBtn">
                            Stay-In
                        </button>
                        <button type="button" class="btn btn-success flex-grow-1 reservation-btn" id="daytourBtn">
                            One Day Stay
                        </button>
                    </div>

                    <!-- Selected Dates Card -->
                    <div class="selected-dates p-4 rounded-3 shadow-sm" id="selectedDatesBox">
                        <h6 class="text-center mb-3 text-success fw-semibold">Chosen Dates</h6>
                        <div class="row text-center">
                            <div class="col-6">
                                <small class="text-muted d-block">Check-in</small>
                                <div id="selectedCheckIn" class="fw-bold text-dark">—</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Check-out</small>
                                <div id="selectedCheckOut" class="fw-bold text-dark">—</div>
                            </div>
                        </div>
                    </div>

                    <!-- Instructions Cards -->
                    <div id="overnightInstructions" class="instructions-box p-4 rounded-3 shadow-sm">
                        <h6 class="text-center mb-3 text-success fw-semibold">How to Book an Overnight Stay</h6>
                        <ol class="small mb-0">
                            <li>Select your Check-In Date
                                <ul class="mt-1 mb-2">
                                    <li>Check-in Time: 2 PM</li>
                                </ul>
                            </li>
                            <li>Then select your Check-out Date
                                <ul class="mt-1">
                                    <li>Check-out Time: 12 PM</li>
                                </ul>
                            </li>
                        </ol>
                    </div>

                    <div id="daytourInstructions" class="instructions-box p-4 rounded-3 shadow-sm" style="display: none;">
                        <h6 class="text-center mb-3 text-success fw-semibold">How to Book a Day Tour</h6>
                        <ol class="small mb-0">
                            <li class="mb-2">Select your preferred date</li>
                            <li class="mb-2">Note:
                                <ul class="mt-1">
                                    <li>Past dates cannot be selected</li>
                                </ul>
                            </li>
                            <li>Once selected, we'll check availability and show room options</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Calendar Column -->
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div id="calendar" class="rounded-3 shadow-lg bg-white p-3"></div>
            </div>
        </div>
    </div>

    <style>
        /* Reservation Controls */
        .reservation-controls {
            background: #ffffff;
            border-radius: 12px;
            padding: 1.5rem;
        }

        /* Professional Toggle Buttons */
        .reservation-btn {
            border: 1px solid #dee2e6;
            font-weight: 500;
            letter-spacing: .5px;
            transition: all .25s ease-in-out;
            border-radius: 8px;
        }
        .reservation-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,.08);
        }
        .reservation-btn.active {
            background-color: #198754;
            border-color: #198754;
            box-shadow: 0 0 0 3px rgba(25,135,84,.25);
        }

        /* Selected Dates Card */
        .selected-dates {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
        }

        /* Instructions Cards */
        .instructions-box {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
        }

        /* Calendar Styling */
        #calendar {
            border: 1px solid #dee2e6;
            border-radius: 12px;
            overflow: hidden;
        }
        .fc .fc-toolbar-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #212529;
        }
        .fc .fc-button {
            border-radius: 8px;
            font-weight: 500;
            text-transform: capitalize;
        }
        .fc-day-today {
            background-color: #e6f4ea !important;
        }
        .fc-day-today .fc-daygrid-day-number {
            background: #198754;
            color: #fff;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 4px;
            font-weight: 600;
        }
        .fc-event {
            border-radius: 6px;
            font-size: .75rem;
            font-weight: 500;
            padding: 2px 4px;
        }
        .past-date {
            background-color: #f5f5f5 !important;
            color: #adb5bd !important;
            cursor: not-allowed !important;
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const allEvents = @json($events);
        const today = new Date().toISOString().split('T')[0];
        const stayinBtn = document.getElementById('stayinBtn');
        const daytourBtn = document.getElementById('daytourBtn');
        let reservationType = 'stayin';
        let checkInDate = null;
        let checkOutDate = null;
        let fullyBookedDates = new Set();

        function formatDateLong(dateString) {
            const date = new Date(dateString);
            const options = { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            return date.toLocaleDateString('en-US', options);
        }

        // Toggle reservation type
        [stayinBtn, daytourBtn].forEach(btn => {
            btn.addEventListener('click', function() {
                reservationType = this.id.replace('Btn', '');
                document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                checkInDate = null;
                checkOutDate = null;
                highlightSelectedDates();
                
                // Toggle visibility of selected dates box
                const selectedDatesBox = document.getElementById('selectedDatesBox');
                const overnightInstructions = document.getElementById('overnightInstructions');
                const daytourInstructions = document.getElementById('daytourInstructions');
                
                if (reservationType === 'daytour') {
                    selectedDatesBox.style.display = 'none';
                    overnightInstructions.style.display = 'none';
                    daytourInstructions.style.display = 'block';
                } else {
                    selectedDatesBox.style.display = 'block';
                    overnightInstructions.style.display = 'block';
                    daytourInstructions.style.display = 'none';
                }
            });
        });

        // Process events data
        const eventsByDate = {};
        allEvents.forEach(event => {
            const eventDate = event.start;
            eventsByDate[eventDate] = eventsByDate[eventDate] || [];
            eventsByDate[eventDate].push(event);
        });

        const filteredEvents = [];
        Object.entries(eventsByDate).forEach(([date, events]) => {
            events.forEach(event => {
                if (event.extendedProps?.status === 'reserved' || event.extendedProps?.status === 'checked-in') {
                    filteredEvents.push({
                        title: event.title,
                        start: event.start,
                        end: event.end,
                        allDay: true,
                        color: event.extendedProps.status === 'checked-in' ? '#2ecc71' : '#97a97c',
                        extendedProps: event.extendedProps
                    });
                }
            });

            if (events.some(e => e.title === "Fully Booked")) {
                fullyBookedDates.add(date);
                filteredEvents.push({
                    title: "Fully Booked",
                    start: date,
                    allDay: true,
                    color: '#dc3545',
                    textColor: '#fff'
                });
            }
        });

        // Initialize calendar
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            events: filteredEvents,
            eventClick: function(info) {
                if (info.event.title !== "Fully Booked") {
                    const props = info.event.extendedProps;
                    document.getElementById('event-name').textContent = props.name;
                    document.getElementById('event-date').textContent = `${new Date(info.event.start).toLocaleDateString()}`;
                    document.getElementById('event-check_in').textContent = props.check_in;
                    document.getElementById('event-check_out').textContent = props.check_out;
                    document.getElementById('event-accommodations').textContent = props.accommodations;
                    document.getElementById('event-activities').textContent = props.activities;
                    
                    const modal = new bootstrap.Modal(document.getElementById('eventModal'));
                    modal.show();
                }
            },
            dateClick: handleDateClick,
            dayCellDidMount: handleDayCellMount,
            selectable: true,
            selectConstraint: {
                start: today,
                end: '2100-12-31'
            },
            validRange: {
                start: today
            },
            dayCellClassNames: function(arg) {
                if (arg.date < new Date(today)) {
                    return ['past-date'];
                }
                return [];
            }
        });

        function handleDayCellMount(info) {
            const cellDate = info.date.toISOString().split('T')[0];
            if(cellDate < today) {
                info.el.classList.add('past-date');
            }
        }

        calendar.render();

        function handleDateClick(info) {
            const selectedDate = info.dateStr;

            if(selectedDate < today) {
                Swal.fire("Past Date", "Cannot select dates in the past", "warning");
                return;
            }

            if(fullyBookedDates.has(selectedDate)) {
                Swal.fire("Booked Out", "This date is unavailable", "error");
                return;
            }

            if(reservationType === 'daytour') {
                handleDayTour(selectedDate);
            } else {
                handleStayIn(selectedDate);
            }

            highlightSelectedDates();
        }

        function handleDayTour(date) {
            checkInDate = date;
            checkOutDate = date;
            const urlParams = new URLSearchParams(window.location.search);
            const selectedRoomId = urlParams.get('roomid');
            const selectedRoomName = urlParams.get('room');
            Swal.fire({
                title: 'Check in Date Selected',
                text: `Date: ${new Date(date).toLocaleDateString()}`,
                icon: 'success'
            }).then(() => {
                window.location.href = `{{ route('selectPackage') }}?checkIn=${date}&checkOut=${date}&type=daytour&roomid=${selectedRoomId}`;
            });
        }

        function handleStayIn(date) {
            if(!checkInDate) {
                checkInDate = date;
                document.getElementById('selectedCheckIn').textContent = new Date(date).toLocaleDateString();
                document.getElementById('selectedCheckOut').textContent = '—';
                
                Swal.fire({
                    title: 'Check-in Date Selected',
                    text: 'Please select a Check-out Date',
                    html: `Check-in Date: ${new Date(date).toLocaleDateString()}<br><br>
                           <strong>Please select a Check-out Date on the calendar</strong>`,
                    icon: 'info',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#198754'
                });
            } else if(!checkOutDate && date > checkInDate) {
                checkOutDate = date;
                const urlParams = new URLSearchParams(window.location.search);
                const selectedRoomId = urlParams.get('roomid');
                const selectedRoomName = urlParams.get('room');
                document.getElementById('selectedCheckOut').textContent = new Date(date).toLocaleDateString();
                
                fetch(`/check-accommodation-availability?checkIn=${checkInDate}&checkOut=${checkOutDate}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data && data.available_accommodations && data.available_accommodations.length > 0) {
                            Swal.fire({
                                title: 'Selected Dates',
                                html: `<strong>Check-in:</strong> ${new Date(checkInDate).toLocaleDateString()}<br>
                                      <strong>Check-out:</strong> ${new Date(checkOutDate).toLocaleDateString()}`,
                                icon: 'success',
                                confirmButtonColor: '#198754'
                            }).then(() => {
                                window.location.href = `{{ route('selectPackageCustom') }}?checkIn=${checkInDate}&checkOut=${checkOutDate}&roomid=${selectedRoomId}`;
                            });
                        } else {
                            throw new Error('No accommodations available');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error',
                            text: error.message || 'Failed to check availability',
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                        checkInDate = null;
                        checkOutDate = null;
                        highlightSelectedDates();
                    });
            } else if(date <= checkInDate) {
                Swal.fire({
                    title: 'Invalid Date',
                    text: 'Check-out date must be after the Check-in date',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            } else {
                checkInDate = date;
                checkOutDate = null;
                Swal.fire({
                    title: 'New Check-in Date',
                    text: 'Please select a new Check-out Date',
                    html: `New Check-in Date: ${new Date(date).toLocaleDateString()}<br><br>
                           <strong>Please select Check-out Date on the calendar</strong>`,
                    icon: 'info',
                    confirmButtonColor: '#198754'
                });
            }
        }

        function highlightSelectedDates() {
            document.querySelectorAll('.fc-daygrid-day').forEach(day => {
                const date = day.dataset.date;
                day.style.backgroundColor = '';
                day.style.color = '';

                if(date === checkInDate) {
                    day.style.backgroundColor = '#198754';
                    day.style.color = 'white';
                } else if(date === checkOutDate) {
                    day.style.backgroundColor = '#dc3545';
                    day.style.color = 'white';
                } else if(checkInDate && checkOutDate && date > checkInDate && date < checkOutDate) {
                    day.style.backgroundColor = '#ffc107';
                }
            });
        }
    });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const stayinBtn = document.getElementById('stayinBtn');
        const daytourBtn = document.getElementById('daytourBtn');
        const overnightInstructions = document.getElementById('overnightInstructions');
        const daytourInstructions = document.getElementById('daytourInstructions');

        stayinBtn.addEventListener('click', function() {
            overnightInstructions.style.display = 'block';
            daytourInstructions.style.display = 'none';
        });

        daytourBtn.addEventListener('click', function() {
            overnightInstructions.style.display = 'none';
            daytourInstructions.style.display = 'block';
        });
    });
    </script>
    <script>
    function resetSelectedDates() {
        document.getElementById('selectedCheckIn').textContent = '—';
        document.getElementById('selectedCheckOut').textContent = '—';
    }

    [stayinBtn, daytourBtn].forEach(btn => {
        btn.addEventListener('click', function() {
            resetSelectedDates();
        });
    });
    </script>

</body>
</html>