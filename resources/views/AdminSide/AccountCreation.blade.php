<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <title>User Accounts and Roles</title>
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

    .status-active {
        background: linear-gradient(180deg, #226214, #43cc25);
        color: #fff;
        border: none !important;
    }

    .status-inactive {
        background: linear-gradient(180deg, #963e15, #f4773e) !important;
        color: #fff !important;
        border: none !important;
    }

    /* Custom Table Header Style */
    .custom-table thead th {
        background: linear-gradient(180deg, #f8f9fa, #dcdcdc);
        color: #0b573d;
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
    @include('Navbar.navbarAdmin')
    <div class="container-fluid min-vh-100 d-flex p-0">
        <div class="d-flex w-100" id="mainLayout" style="min-height: 100vh;">
            <!-- Main Content -->
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
                    <!-- Add User Button -->
                    <div class="d-flex justify-content-end mb-5">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addUserModal"
                            style="background-color: #ffffff; color: #333; border-radius: 4px; padding: 6px 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <i class="fas fa-plus me-2"></i>Add User
                        </button>
                    </div>

                    <!-- Filter Card -->
                    <div class="card shadow-sm border-0 rounded-4 mb-4"
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
                                        Account Creation</h1>
                                </button>
                                <ul class="dropdown-menu shadow-lg border-0 animated fadeInDown"
                                    aria-labelledby="activityLogsDropdown"
                                    style="border-radius: 10px; overflow: hidden;">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center py-2"
                                            href="{{ route('activityLogs') }}">
                                            <i class="fas fa-list-alt text-success me-2"></i>
                                            <span>Activity Logs</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <div class="card-body p-4">

                            <!-- Table Container -->
                            <div class="container-fluid px-0">
                                <div class="card shadow-sm border-0 rounded-4">
                                    <div class="card-body p-4">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle custom-table">
                                                <thead class="table-light text-uppercase small text-secondary">
                                                    <tr>
                                                        <th class="py-3 text-secondary">
                                                            <i class="fas fa-id-card me-2"></i>ID
                                                        </th>
                                                        <th class="py-3 text-secondary">
                                                            <i class="fas fa-user me-2"></i>Username
                                                        </th>
                                                        <th class="py-3 text-secondary">
                                                            <i class="fas fa-key me-2"></i>Password
                                                        </th>
                                                        <th class="py-3 text-secondary">
                                                            <i class="fas fa-toggle-on me-2"></i>Status
                                                        </th>
                                                        <th class="py-3 text-secondary">
                                                            <i class="fas fa-cogs me-2"></i>Actions
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($staffAccounts as $user)
                                                        <tr class="border-bottom">
                                                            <td class="py-3">{{ $user->id }}</td>
                                                            <td class="py-3">{{ $user->username }}</td>
                                                            <td class="py-3">{{ $user->password }}</td>
                                                            <td class="py-3">
                                                                <span
                                                                    class="badge px-3 {{ $user->status === 'active' ? 'status-active' : 'status-inactive' }}">
                                                                    {{ ucfirst($user->status) }}
                                                                </span>
                                                            </td>
                                                            <td class="py-3 d-flex gap-2">
                                                                <button
                                                                    class="btn btn-sm color-background5 text-white rounded-3 shadow-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editUser{{ $user->id }}"
                                                                    style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background-color: #0b573d;">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-danger rounded-3 shadow-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deleteUser{{ $user->id }}"
                                                                    style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>

                                                        <!-- Edit User Modal -->
                                                        <div class="modal fade" id="editUser{{ $user->id }}" tabindex="-1"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-success text-white">
                                                                        <h5 class="modal-title">Edit User</h5>
                                                                        <button type="button"
                                                                            class="btn-close btn-close-white"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="{{ route('updateUser', $user->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label
                                                                                    class="form-label text-success fw-bold">Username</label>
                                                                                <input type="text"
                                                                                    class="form-control border-success"
                                                                                    name="username"
                                                                                    value="{{ $user->username }}" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label
                                                                                    class="form-label text-success fw-bold">Password</label>
                                                                                <div class="input-group">
                                                                                    <input type="password"
                                                                                        class="form-control border-success"
                                                                                        name="password"
                                                                                        id="password{{ $user->id }}"
                                                                                        placeholder="Enter new password">
                                                                                    <button class="btn btn-outline-success"
                                                                                        type="button"
                                                                                        onclick="togglePassword('password{{ $user->id }}')"
                                                                                        style="height: 50px;">
                                                                                        <i class="fas fa-eye"
                                                                                            id="eye{{ $user->id }}"></i>
                                                                                    </button>
                                                                                </div>
                                                                                <small class="text-muted">Leave blank to
                                                                                    keep current
                                                                                    password</small>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label
                                                                                    class="form-label text-success fw-bold">Status</label>
                                                                                <select class="form-select border-success"
                                                                                    name="status" required>
                                                                                    <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                                                                                    <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-outline-success"
                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit"
                                                                                class="btn btn-success">Save
                                                                                Changes</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <script>
                                                            function togglePassword(inputId) {
                                                                const passwordInput = document.getElementById(inputId);
                                                                const eyeIcon = document.getElementById('eye' + inputId.replace('password', ''));

                                                                if (passwordInput.type === 'password') {
                                                                    passwordInput.type = 'text';
                                                                    eyeIcon.classList.remove('fa-eye');
                                                                    eyeIcon.classList.add('fa-eye-slash');
                                                                } else {
                                                                    passwordInput.type = 'password';
                                                                    eyeIcon.classList.remove('fa-eye-slash');
                                                                    eyeIcon.classList.add('fa-eye');
                                                                }
                                                            }
                                                        </script>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
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