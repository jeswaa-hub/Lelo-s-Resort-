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
        background: #2e7d32 !important;
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
    
    <div class="d-flex justify-content-center align-items-center gap-4 flex-wrap mb-3">
        <select id="stayType" class="form-select bg-white rounded shadow-sm border-success text-success fw-bold" style="width: 15vw; min-width: 150px; font-size: 1.25rem; height: 45px;">
            <option value="one-day">One Day Stay</option>
            <option value="stay-in">Stay In</option>
        </select>
        
        <div class="bg-white rounded p-4 shadow-sm d-flex align-items-center justify-content-center" style="width: 30vw; min-width: 280px; height: 45px;">
            <span class="fw-bold text-success text-uppercase" style="font-size: 1.5rem;">{{ now()->format('F Y') }}</span>
        </div>
        
        <button id="helpBtn" class="btn btn-light d-flex justify-content-center align-items-center" 
            style="width:50px; height:45px; border-radius:8px;">
                <i class="fas fa-question text-success"></i>
        </button>
    </div>

    <div class="container bg-white rounded p-4 shadow-sm" style="height: 70vh; max-width: 75vw;">
        <!-- Content goes here -->
    </div>
    
























    <script>
    document.getElementById("helpBtn").addEventListener("click", function () {
    const stayType = document.getElementById("stayType").value;

    let title, htmlContent;

    if (stayType === "stay-in") {
        title = '<h4 style="color:#2e7d32; margin-bottom:10px;">How to Book a Stay-In Reservation?</h4>';
        htmlContent = `
            <ol style="text-align:left; font-size:15px; color:#333; padding-left:20px;">
                <li>Select your check-in date.</li>
                <li>Choose your preferred check-out date.</li>
                <li>Confirm your reservation by reviewing the selected dates.</li>
            </ol>
        `;
    } else if (stayType === "one-day") {
        title = '<h4 style="color:#2e7d32; margin-bottom:10px;">How to Book a One-Day Stay?</h4>';
        htmlContent = `
            <ol style="text-align:left; font-size:15px; color:#333; padding-left:20px;">
                <li>Select your preferred date.</li>
                <li>Confirm your reservation by reviewing the selected date.</li>
            </ol>
        `;
    } else {
        title = '<h4 style="color:#2e7d32; margin-bottom:10px;">How to Book an Overnight Stay?</h4>';
        htmlContent = `
            <ol style="text-align:left; font-size:15px; color:#333; padding-left:20px;">
                <li>Select your check-in date.</li>
                <li>Choose your preferred check-out date.</li>
                <li>Confirm your reservation by reviewing the selected dates.</li>
            </ol>
        `;
    }

    Swal.fire({
        title: title,
        html: htmlContent,
        background: '#fff', /* clean white background */
        showCancelButton: true,
        confirmButtonText: 'Got It',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#2e7d32',
        cancelButtonColor: '#aaa',
        customClass: {
            popup: 'custom-modal',
            confirmButton: 'custom-confirm',
            cancelButton: 'custom-cancel',
            actions: 'custom-actions'
        }
    });
});
</script>
</body>
</html>
