<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Remove or fix the Vite reference if not needed -->
  <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
</head>

<style>
  * {
    font-family: 'Montserrat';
  }

  /* Default navbar link style */
  .navbar-nav .nav-link {
    position: relative;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .navbar-nav .nav-link::after {
    content: '';
    position: absolute;
    left: 50%;
    bottom: 0;
    transform: translateX(-50%) scaleX(0);
    transform-origin: center;
    width: 60%;
    height: 2px;
    background-color: #000;
    transition: transform 0.3s ease;
  }

  .navbar-nav .nav-link:hover::after {
    transform: translateX(-50%) scaleX(1);
  }

  /* Logout special */
  .navbar-nav .nav-item:last-child .nav-link {
    color: black !important;
    border-radius: 6px;
    padding: 8px 18px !important;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  .navbar-nav .nav-item:last-child .nav-link::after {
    display: none;
  }

  .navbar-nav .nav-item:last-child .nav-link:hover {
    color: #b02a37 !important;
  }
  
  /* Fix dropdown menu positioning */
  .dropdown-menu {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
  }
  
  /* Ensure dropdown is visible */
  .dropdown:hover .dropdown-menu {
    display: block;
  }
</style>

<body>
  <nav class="navbar navbar-expand-lg p-2">
    <div class="container-fluid">

      <!-- Logo always visible -->
      <a class="navbar-brand d-flex align-items-center ms-3" href="#">
        <img src="{{ asset('images/logo2.png') }}" alt="Logo" width="100" height="100" class="rounded-circle">
      </a>

      <!-- Burger toggler (opens offcanvas) -->
      <button class="navbar-toggler me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav"
        aria-controls="offcanvasNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Offcanvas menu (slides in from right) -->
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNav" aria-labelledby="offcanvasNavLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavLabel">Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav ms-auto gap-1">
            <li class="nav-item">
              <a class="nav-link text-black px-3 py-2 {{ Request::routeIs('staff.dashboard') ? 'active bg-white bg-opacity-10' : '' }}"
                href="{{ route('staff.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
              </a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-black px-3 py-2" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fas fa-calendar-alt"></i> Reservations
              </a>
              <ul class="dropdown-menu p-1">
                <li><a class="dropdown-item text-black rounded py-1" href="{{ route('staff.reservation') }}">Online
                    Reservations</a></li>
                <li><a class="dropdown-item text-black rounded py-1" href="{{ route('staff.walkIn') }}">Walk In
                    Reservations</a></li>
                <li><a class="dropdown-item text-black rounded py-1" href="{{ route('staff.accomodations') }}">Room
                    Availability</a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a class="nav-link text-black px-3 py-2 {{ Request::routeIs('staff.guests') ? 'active bg-white bg-opacity-10' : '' }}"
                href="{{ route('staff.guests') }}">
                <i class="fas fa-users"></i> Guests
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link text-black px-3 py-2 {{ Request::routeIs('staff.damageReport') ? 'active bg-white bg-opacity-10' : '' }}"
                href="{{ route('staff.damageReport') }}">
                <i class="fas fa-clipboard-list"></i> Damage Report
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link text-black px-5 py-2" href="{{ route('staff.logout')}}"
                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Log out">
                <i class="fas fa-sign-out-alt"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>

    </div>
  </nav>
  
  <!-- Initialize tooltips -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })
    })
  </script>
</body>
</html>