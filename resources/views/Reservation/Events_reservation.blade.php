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
            height: 100%; /* Make calendar fill the column height */
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


        .swal2-popup.custom-modal {
        border-radius: 20px !important;
        padding-top: 60px !important;
    }

    .swal2-popup.custom-modal {
        border-radius: 12px !important;
        padding: 20px !important;
    }

    .swal2-actions.custom-actions {
        display: flex !important;
        justify-content: flex-end !important;
        gap: 10px;
        margin-top: 20px;
    }

    .swal2-styled.custom-confirm {
        background: #0b573d !important;
        color: #fff !important;
        border-radius: 6px !important;
        padding: 8px 18px !important;
        font-size: 14px !important;
        font-weight: 500 !important;
    }

    .swal2-styled.custom-cancel {
        background: #e0e0e0 !important;
        color: #333 !important;
        border-radius: 6px !important;
        padding: 8px 18px !important;
        font-size: 14px !important;
        font-weight: 500 !important;
    }

    #calendar .fc-col-header-cell-cushion, /* Day of week headers */
    #calendar .fc-daygrid-day-number, /* Day numbers */
    #calendar .fc-button { /* Header buttons */
        color: #0b573d !important;
    }

    #calendar .fc-button-primary {
        background-color: transparent !important;
        border-color: #0b573d !important;
    }

    #calendar .fc-button-primary:hover {
        background-color: #0b573d !important;
        color: white !important;
    }

    #calendar .fc-day-today .fc-daygrid-day-number { /* Today's date */
        color: white !important;
        background-color: #0b573d;
        border-radius: 50%;
    }

    /* New styles for the enhanced "How to Reserve" guide */
    .step-guide-container {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
    }

    .step-item {
        display: flex;
        align-items: center; /* Vertically center icon with text */
        margin-bottom: 0.75rem; /* Reduced margin */
        position: relative;
    }

    .step-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 15px; /* Center of the smaller icon */
        top: 35px; /* Start below the icon */
        bottom: -0.75rem; /* End at the next icon's top */
        width: 2px;
        background-color: #dee2e6;
        z-index: 1;
    }

    .step-icon {
        flex-shrink: 0;
        width: 30px; /* Smaller icon */
        height: 30px; /* Smaller icon */
        z-index: 2;
    }

    .step-item h6 {
        font-size: 0.9rem; /* Smaller title font */
    }

    .step-item small {
        font-size: 0.8rem; /* Smaller description font */
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
    
    <div class="container" style="max-width: 75vw;">
        <div class="d-flex justify-content-between align-items-center gap-4 flex-wrap mb-3">
            <div class="flex-grow-1">
                <select id="stayType" class="form-select bg-white rounded shadow-sm border-success text-success fw-bold" style="width: 15vw; min-width: 150px; font-size: 1.25rem; height: 45px;">
                    <option value="one-day">Day Tour</option>
                    <option value="stay-in">Stay In</option>
                </select>
            </div>
            <div class="bg-white rounded p-4 shadow-sm d-flex align-items-center justify-content-center" style="width: 30vw; min-width: 280px; height: 45px;">
                <span id="calendar-title" class="fw-bold text-success text-uppercase" style="font-size: 1.5rem;"></span>
            </div>
            <div class="flex-grow-1 d-flex justify-content-end">
                <button id="helpBtn" class="btn btn-light d-flex justify-content-center align-items-center" 
                    style="width:50px; height:45px; border-radius:8px;">
                        <i class="fas fa-question text-success"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="container bg-white rounded p-4 shadow-sm" style="max-width: 75vw;">
        <div class="row">
            <div class="col-lg-8">
                <div id="calendar"></div>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="reservation-controls d-flex flex-column h-100">
                    <h4 class="text-success fw-bold">Your Selection</h4>
                    <hr>
                    <!-- Step-by-step guide -->
                    <div id="stepGuide" class="mb-4 p-3 step-guide-container">
                        <h6 class="text-success fw-bold mb-3">How to Reserve:</h6>
                        <div id="stepList" class="mt-3"></div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const stepListContainer = document.getElementById('stepList');
                            const stayTypeSelect = document.getElementById('stayType');

                            const steps = {
                                'one-day': [
                                    { icon: 'fa-calendar-day', title: 'Select a Date', description: 'Click your desired date on the calendar.' },
                                    { icon: 'fa-arrow-right', title: 'Proceed', description: 'Click the "Proceed" button to choose your rooms.' },
                                    { icon: 'fa-credit-card', title: 'Complete Payment', description: 'Finalize your booking by completing the payment.' },
                                    { icon: 'fa-receipt', title: 'Get Confirmation', description: 'Review your reservation summary and QR code.' }
                                ],
                                'stay-in': [
                                    { icon: 'fa-calendar-day', title: 'Select Check-in', description: 'Click your desired start date.' },
                                    { icon: 'fa-calendar-week', title: 'Select Check-out', description: 'Click your desired end date to form a range.' },
                                    { icon: 'fa-arrow-right', title: 'Proceed', description: 'Click "Proceed" to choose your rooms.' },
                                    { icon: 'fa-credit-card', title: 'Complete Payment', description: 'Finalize your booking by completing the payment.' }
                                ]
                            };

                            function updateSteps() {
                                const selectedType = stayTypeSelect.value;
                                const stepArray = steps[selectedType];
                                stepListContainer.innerHTML = ''; // Clear previous steps

                                stepArray.forEach(step => {
                                    const stepEl = document.createElement('div');
                                    stepEl.className = 'step-item';
                                    stepEl.innerHTML = `
                                        <div class="step-icon bg-success rounded-circle d-flex align-items-center justify-content-center me-3">
                                            <i class="fas ${step.icon} text-white fa-sm"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0">${step.title}</h6>
                                            <small class="text-muted">${step.description}</small>
                                        </div>`;
                                    stepListContainer.appendChild(stepEl);
                                });
                            }

                            stayTypeSelect.addEventListener('change', updateSteps);
                            updateSteps(); // Initial load
                        });
                    </script>

                    <div id="one-day-selection" style="display:none;">
                        <div class="mb-3">
                            <label for="selectedDate" class="form-label text-success fw-semibold">Selected Date</label>
                            <input type="text" id="selectedDate" class="form-control" readonly placeholder="Select a date from the calendar">
                        </div>
                    </div>
                    <div id="stay-in-selection">
                        <div class="mb-3">
                            <label for="checkInDate" class="form-label text-success fw-semibold">Check-in Date</label>
                            <input type="text" id="checkInDate" class="form-control" readonly placeholder="Select a start date">
                        </div>
                        <div class="mb-3">
                            <label for="checkOutDate" class="form-label text-success fw-semibold">Check-out Date</label>
                            <input type="text" id="checkOutDate" class="form-control" readonly placeholder="Select an end date">
                        </div>
                    </div>

                        <div class="mt-auto">
                            <button id="proceedBtn" class="btn btn-success w-100 fw-bold" disabled>Proceed</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
    




    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const stayTypeSelect = document.getElementById('stayType');
        const oneDaySelection = document.getElementById('one-day-selection');
        const stayInSelection = document.getElementById('stay-in-selection');
        const selectedDateInput = document.getElementById('selectedDate');
        const checkInDateInput = document.getElementById('checkInDate');
        const checkOutDateInput = document.getElementById('checkOutDate');
        const proceedBtn = document.getElementById('proceedBtn');

        let checkInDate = null;
        let checkOutDate = null;

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: '',
                right: 'dayGridMonth',
            },
            buttonText: {
                dayGridMonth: 'Month'
            },
            datesSet: function(dateInfo) {
                const titleEl = document.getElementById('calendar-title');
                if (titleEl) {
                    titleEl.innerText = dateInfo.view.title;
                }
            },
            events: @json($events),
            selectable: true,
            selectAllow: function(selectInfo) {
                // All validation is now in the `dateClick` and `select` handlers to allow for error messages.
                return true;
            },
            dateClick: function(info) {
                handleDateSelection(info.date);
            },
            select: function(info) {
                if (stayTypeSelect.value === 'stay-in') {
                    // This handles drag-selection. Single-click selection is handled by dateClick.
                    // A single click also triggers 'select', so we need to differentiate.
                    const oneDay = 24 * 60 * 60 * 1000;
                    if ((info.end.getTime() - info.start.getTime()) <= oneDay) {
                        // This is a single-day click, let dateClick handle it to allow for range selection by two clicks.
                        // We unselect to prevent the calendar from showing a selection for a single day click.
                        calendar.unselect();
                        return;
                    }

                    // This is a drag selection for a range.
                    checkInDate = info.start;
                    checkOutDate = info.end; // end is already exclusive
                    updateDateInputs();
                }
            },
            eventDidMount: function(info) {
                if (info.event.title === 'Fully Booked') {
                    info.el.style.backgroundColor = '#dc3545';
                    info.el.style.borderColor = '#dc3545';
                }
            }
        });

        calendar.render();

        function handleDateSelection(date) {
            const stayType = stayTypeSelect.value;
            const today = new Date(new Date().setHours(0, 0, 0, 0));

            // Universal check for past dates on any click.
            if (date < today) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date',
                    text: 'You cannot select a past date.',
                    confirmButtonColor: '#0b573d'
                });
                return; // Stop processing the invalid date.
            }

            if (stayType === 'one-day') {
                checkInDate = date;
                checkOutDate = date;
                updateDateInputs();
            } else { // stay-in
                if (!checkInDate) {
                    // First click: Set the check-in date.
                    checkInDate = date;
                    checkOutDate = null; // Ensure check-out is cleared.
                    updateDateInputs();
                } else {
                    // Second (or subsequent) click: Set/update the check-out date.
                    if (date < checkInDate) {
                        // The selected date is before the check-in date.
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Check-out Date',
                            text: 'Your check-out date cannot be earlier than your check-in date.',
                            confirmButtonColor: '#0b573d'
                        });
                        // Don't update dates, just show error.
                    } else {
                        // Valid date, update the check-out date.
                        checkOutDate = new Date(date.getTime() + (24 * 60 * 60 * 1000)); // Make it exclusive for backend
                        updateDateInputs();
                    }
                }
            }
        }

        function updateDateInputs() {
            const stayType = stayTypeSelect.value;
            if (stayType === 'one-day') {
                selectedDateInput.value = checkInDate ? checkInDate.toLocaleDateString() : '';
                proceedBtn.disabled = !checkInDate;
                if (checkInDate) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: `Date selected: ${checkInDate.toLocaleDateString()}`,
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true
                    });
                }
            } else {
                checkInDateInput.value = checkInDate ? checkInDate.toLocaleDateString() : '';
                // For display, if checkout was selected, show the actual day, not the exclusive one.
                const displayCheckOutDate = checkOutDate ? new Date(checkOutDate.getTime() - (24 * 60 * 60 * 1000)) : null;
                checkOutDateInput.value = displayCheckOutDate ? displayCheckOutDate.toLocaleDateString() : '';
                proceedBtn.disabled = !(checkInDate && checkOutDate);

                if (checkInDate && !checkOutDate) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'info',
                        title: `Check-in selected: ${checkInDate.toLocaleDateString()}. Now select a check-out date.`,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                } else if (checkInDate && checkOutDate) {
                    const displayCheckOut = new Date(checkOutDate.getTime() - (24 * 60 * 60 * 1000));
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: `Date range selected: ${checkInDate.toLocaleDateString()} to ${displayCheckOut.toLocaleDateString()}`,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            }
        }

        function toggleStayTypeView() {
            const stayType = stayTypeSelect.value;
            if (stayType === 'one-day') {
                oneDaySelection.style.display = 'block';
                stayInSelection.style.display = 'none';
            } else {
                oneDaySelection.style.display = 'none';
                stayInSelection.style.display = 'block';
            }
            // Reset dates on type change
            checkInDate = null;
            checkOutDate = null;
            updateDateInputs();
        }

        stayTypeSelect.addEventListener('change', toggleStayTypeView);

        checkInDateInput.addEventListener('click', () => {
            if (stayTypeSelect.value === 'stay-in') {
                // Clicking the input field resets the entire selection
                checkInDate = null;
                checkOutDate = null;
                updateDateInputs();
            }
        });

        checkOutDateInput.addEventListener('click', () => {
            if (stayTypeSelect.value === 'stay-in' && checkInDate) {
                // Clicking the check-out input field clears it to allow re-selection
                checkOutDate = null;
                updateDateInputs();
            }
        });

        proceedBtn.addEventListener('click', function() {
            const stayType = stayTypeSelect.value;
            let url;
            if (stayType === 'one-day' && checkInDate) {
                const dateStr = checkInDate.toISOString().split('T')[0];
                url = `{{ route('selectPackage') }}?checkIn=${dateStr}&checkOut=${dateStr}`;
            } else if (stayType === 'stay-in' && checkInDate && checkOutDate) {
                const checkInStr = checkInDate.toISOString().split('T')[0];
                const checkOutStr = checkOutDate.toISOString().split('T')[0];
                url = `{{ route('selectPackageCustom') }}?checkIn=${checkInStr}&checkOut=${checkOutStr}`;
            }

            if (url) {
                window.location.href = url;
            }
        });

        // Initial setup
        toggleStayTypeView();
    });
    </script>
<script>
    document.getElementById("helpBtn").addEventListener("click", function () {
    const stayType = document.getElementById("stayType").value;

    let title, htmlContent;
    const listStyle = `
        list-style: none; 
        padding-left: 0; 
        text-align: left; 
        font-size: 1rem;
    `;
    const listItemStyle = `
        display: flex; 
        align-items: center; 
        margin-bottom: 15px;
    `;
    const iconStyle = `
        color: #198754; 
        font-size: 1.5rem; 
        margin-right: 15px; 
        width: 30px; 
        text-align: center;
    `;

    if (stayType === "stay-in") {
        title = 'Booking a Stay-In Reservation';
        htmlContent = `
            <ul style="${listStyle}">
                <li style="${listItemStyle}"><i class="fas fa-calendar-day" style="${iconStyle}"></i><div><strong>Select Check-in:</strong> Click on your desired start date.</div></li>
                <li style="${listItemStyle}"><i class="fas fa-calendar-week" style="${iconStyle}"></i><div><strong>Select Check-out:</strong> Click and drag to your desired end date.</div></li>
                <li style="${listItemStyle}"><i class="fas fa-arrow-right" style="${iconStyle}"></i><div><strong>Proceed:</strong> Click the "Proceed" button to continue.</div></li>
            </ul>
        `;
    } else if (stayType === "one-day") {
        title = 'Booking a Day Tour';
        htmlContent = `
            <ul style="${listStyle}">
                <li style="${listItemStyle}"><i class="fas fa-calendar-day" style="${iconStyle}"></i><div><strong>Select Date:</strong> Click on your desired date on the calendar.</div></li>
                <li style="${listItemStyle}"><i class="fas fa-arrow-right" style="${iconStyle}"></i><div><strong>Proceed:</strong> Click the "Proceed" button to continue.</div></li>
            </ul>
        `;
    }

    Swal.fire({
        icon: 'info',
        iconColor: '#0b573d',
        title: title,
        html: htmlContent,
        confirmButtonText: 'Got it!',
        confirmButtonColor: '#0b573d'
    });
});

</script>
</body>
</html>