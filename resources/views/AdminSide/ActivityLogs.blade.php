<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Activity Logs</title>
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

    /* Custom Gradient Inputs */
    .custom-input {
        background: linear-gradient(180deg, #f9f9f9, #e3e3e3);
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 0.9rem;
        height: 38px;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .custom-input:focus {
        border-color: #0b573d;
        box-shadow: 0 0 5px rgba(11, 87, 61, 0.4);
    }

    label {
        font-size: 0.85rem;
        margin-right: 5px;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
        margin-top: 20px;
        font-family: 'Poppins', 'Montserrat', sans-serif;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #fff;
        color: #0b573d;
        border: 2px solid #0b573d;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .pagination .page-link:hover {
        background-color: #0b573d;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(11, 87, 61, 0.2);
    }

    .pagination .page-item.active .page-link {
        background-color: #0b573d;
        color: #fff;
        border-color: #0b573d;
    }

    .pagination .page-item.disabled .page-link {
        background-color: #e9ecef;
        border-color: #dee2e6;
        color: #6c757d;
        cursor: not-allowed;
        pointer-events: none;
    }

    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-size: 1.2rem;
        font-weight: bold;
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

    /* Custom Gradient Inputs */
    .custom-input {
        background: linear-gradient(180deg, #f9f9f9, #e3e3e3);
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 0.9rem;
        height: 38px;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .custom-input:focus {
        border-color: #0b573d;
        box-shadow: 0 0 5px rgba(11, 87, 61, 0.4);
    }

    label {
        font-size: 0.85rem;
        margin-right: 5px;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
        margin-top: 20px;
        font-family: 'Poppins', 'Montserrat', sans-serif;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #fff;
        color: #0b573d;
        border: 2px solid #0b573d;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .pagination .page-link:hover {
        background-color: #0b573d;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(11, 87, 61, 0.2);
    }

    .pagination .page-item.active .page-link {
        background-color: #0b573d;
        color: #fff;
        border-color: #0b573d;
    }

    .pagination .page-item.disabled .page-link {
        background-color: #e9ecef;
        border-color: #dee2e6;
        color: #6c757d;
        cursor: not-allowed;
        pointer-events: none;
    }

    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-size: 1.2rem;
        font-weight: bold;
    }
</style>

<body
    style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76))">

<body
    style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76))">
    @include('Alert.loginSucess')
    @include('Navbar.navbarAdmin')

    <div class="container-fluid min-vh-100 d-flex p-0">
        <div class="d-flex w-100" id="mainLayout" style="min-height: 100vh;">
            <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width" style="transition: all 0.3s ease;">
                <div class="container-fluid mt-4 mb-4 rounded-4 p-5" style="background: url('{{ asset('images/Dashboardbg.png') }}') no-repeat center center; 
                background-size: cover; 
                    width: 100%;
                    height: 100vh;
                    border-radius: 30px;">

                    <div class="mb-5 text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); margin-top: 10%;">
                        <h2 class="mb-0 fs-1" style="font-size: 4.5rem !important;">Hello,</h2>
                        <h1 class="display-1 fw-bold" style="font-size: 5.5rem !important;">Admin User!</h1>
                    </div>

                    <!-- Filter Card -->
                    <div class="card shadow-lg border-0 rounded-4 mb-4"
                        style="background: linear-gradient(to right, #ffffff, #f8f9fa);">
                        <div class="d-flex justify-content-between align-items-center px-4 pt-4">
                            <div class="dropdown">
                                <button
                                    class="btn btn-lg dropdown-toggle text-color-2 text-decoration-none d-flex align-items-center gap-2"
                                    type="button" id="activityLogsDropdown" data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                    style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em; background: none; border: none;">
                                    <h1 class="fs-1 text-uppercase mb-0"
                                        style="background: linear-gradient(45deg, #0b573d, #198754); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                                        Activity Logs</h1>
                                </button>
                                <ul class="dropdown-menu shadow-lg border-0 animated fadeInDown"
                                    aria-labelledby="activityLogsDropdown"
                                    style="border-radius: 12px; overflow: hidden; min-width: 380px; padding: 10px 0;">

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center py-3 px-4"
                                            href="{{ route('userAccountRoles') }}"
                                            style="font-size: 1rem; font-weight: 500;">
                                            <i class="fas fa-user-plus text-success me-3 fs-5"></i>
                                            <span>Account Creation</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>

                        </div>
                        <hr class="my-0" style="height: 2px; background: linear-gradient(to right, #0b573d, #ffffff);">
                        <div class="card-body p-4">

                            <form action="{{ route('activityLogs') }}" method="GET"
                                class="d-flex flex-wrap align-items-center gap-3 p-3 bg-white shadow-sm rounded-3">

                                <!-- Search Bar -->
                                <div class="input-group position-relative" style="width: 47%;">
                                    <input type="search" name="search"
                                        class="form-control mb-0 rounded-0 bg-light border border-secondary shadow-sm"
                                        placeholder="Search..." value="{{ request('search') }}"
                                        style="padding-right: 35px; background-color: #f8f9fa;">
                                    <div class="position-absolute"
                                        style="right: 10px; top: 50%; transform: translateY(-50%); z-index: 10;">
                                        <i class="fa-solid fa-magnifying-glass text-secondary"></i>
                                    </div>
                                </div>


                                <!-- Role Filter -->
                                <div>
                                    <select name="role" class="form-select"
                                        style="background-color: #f0f0f0; border: 1px solid #ddd; border-radius: 4px; padding: 4px 8px; color: #333; width: 150px;">
                                        <option value="">All Roles</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                                                {{ ucfirst($role) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <!-- Date Range Filter -->
                                <div class="d-flex flex-column align-items-center gap-2">
                                    <div class="d-flex align-items-center gap-4">
                                        <div class="text-center">
                                            <label class="fw-semibold text-success d-block mb-1">FROM:</label>
                                            <input type="date" name="start_date"
                                                class="form-control custom-input bg-light"
                                                value="{{ request('start_date') }}"
                                                style="border-radius: 4px; border: 1px solid #ddd;">
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="fw-bold fs-5">-</span>
                                        </div>
                                        <div class="text-center">
                                            <label class="fw-semibold text-success d-block mb-1">TO:</label>
                                            <input type="date" name="end_date"
                                                class="form-control custom-input bg-light"
                                                value="{{ request('end_date') }}"
                                                style="border-radius: 4px; border: 1px solid #ddd;">
                                        </div>
                                    </div>
                                </div>

                                <!-- Clear Filter Button -->
                                @if(request()->hasAny(['start_date', 'end_date', 'role', 'search']))
                                    <a href="{{ route('activityLogs') }}" class="btn btn-outline-secondary ms-auto">
                                        <i class="fas fa-times"></i> Clear
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>

                    <!-- Table Container -->
                    <div class="container-fluid px-0">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="py-3 text-secondary" style="width: 20%;">
                                                    <i class="fas fa-calendar-alt me-2"></i>Date & Time
                                                </th>
                                                <th class="py-3 text-secondary" style="width: 20%;">
                                                    <i class="fas fa-user me-2"></i>User
                                                </th>
                                                <th class="py-3 text-secondary" style="width: 15%;">
                                                    <i class="fas fa-user-tag me-2"></i>Role
                                                </th>
                                                <th class="py-3 text-secondary" style="width: 45%;">
                                                    <i class="fas fa-clipboard-list me-2"></i>Activity
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($activityLogs as $log)
                                                <tr class="border-bottom">
                                                    <td class="py-3" style="width: 200px;">
                                                        {{ \Carbon\Carbon::parse($log->date . ' ' . $log->time)->format('F j, Y g:i A') }}
                                                    </td>
                                                    <td class="py-3" style="width: 150px;">{{ $log->user }}</td>
                                                    <td class="py-3" style="width: 100px;">
                                                        <span
                                                            class="badge bg-success rounded-pill px-3">{{ $log->role }}</span>
                                                    </td>
                                                    <td class="py-3" style="width: 400px;">{{ $log->activity }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-end mt-4">
                                        {{ $activityLogs->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>