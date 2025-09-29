<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Lelo's Resort</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo new.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js?render=reCAPTCHA_site_key"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: url("{{ asset('images/logosheesh.png') }}") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            position: relative;
        }
        
        body::after {
            content: "";
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30vh;
            background: linear-gradient(to top, rgba(0, 93, 59, 0.8), transparent);
            pointer-events: none;
            z-index: -1;
        }

        .login-form {
            width: 100vw;
            height: 80vh;
        }
        .login-center {
            margin: 0 auto;
        }
        .login-img {
            height: 95vh;
            object-position: center;
        }
        .text-hover-effect {
            background: linear-gradient(to right, currentColor 100%, transparent 100%);
            margin-top: 10px;
            background-size: 0% 2px;
            background-repeat: no-repeat;
            background-position: 0% 100%;
            transition: background-size 0.4s ease-in-out;
            &:hover {
                background-size: 100% 2px;
            }
        }
        .google:hover {
           background-color: #4a4a4a;
           color: #fff;
           transition: all 0.3s ease-in-out;
        }
        .login:hover{
            color: #718355;
            background-color: #e5f9db;
            transition: all 0.3s ease-in-out;
        }
        .icon:hover {
            color: #4a4a4a;
            transition: all 0.3s ease-in-out;
        }

        .login-button {
            background-color: #0B5D3B;
            color: white;
            font-weight: bold;
            font-size: 0.8rem;
            padding: 5px 15px;
            border: none;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 200px; /* Increased width to accommodate loading text */
            cursor: pointer;
            margin: 0 auto;
            height: 40px;
            transition: all 0.3s ease;
        }

        .login-button .loading-text {
            display: none;
            align-items: center;
            gap: 8px;
        }

        .login-button .loading-text i {
            color: white;
            font-size: 1rem;
        }

        .login-button .arrow {
            background-color: white;
            color: #0B5D3B;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 5px;
            font-size: .7rem;
        }
        .flip-horizontal {
        display: inline-block;
        transform: scaleX(-1);
        filter: FlipH;
        -ms-filter: "FlipH";
    }
    #passwordFields {
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }
        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }
    .color-background8{
        background-color: #0B5D3B;
    }

    .g-recaptcha-wrapper {
        transform: scale(0.85);
        transform-origin: 0 0;
    }

    @media (max-width: 400px) {
        .g-recaptcha-wrapper {
            transform: scale(0.77);
        }
    }
    </style>
</head>
<body>
    <x-loading-screen/>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>

    <!-- Header with Back Button and Logo -->
    <div class="w-100 d-flex justify-content-center justify-content-sm-between align-items-center px-5 py-3">
        <!-- Back Button -->
        <a href="{{ url('/') }}" class="d-none d-sm-flex align-items-center justify-content-center rounded-circle shadow ms-3"
           style="width: 50px; height: 50px; background-color: #0B5D3B; text-decoration: none;">
            <i class="fa-solid fa-arrow-left text-white"></i>
        </a>

        <!-- Logo -->
        <a class="text-decoration-none">
            <img src="{{ asset('images/logo new.png') }}" alt="Lelo's Resort Logo" class="rounded-pill" style="width: 100px; height: auto;">
        </a>
    </div>

    <!-- Main Content Container -->
    <div class="d-flex justify-content-center align-items-center px-3">
    <div class="container p-4 shadow-lg rounded-4 bg-white" style="max-width: 1000px;">
        <div class="row align-items-center">
            
            <!-- Left Side: Login Form -->
            <div class="col-md-6">
                <div class="d-flex align-items-center w-100 mb-3">
                    <h1 class="text-success font-paragraph mx-auto fs-4 text-center fw-bold">Welcome to Lelo's Resort</h1>
                </div>

                <form id="login-form" action="{{ route('login.authenticate') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <input id="userCredential" type="text" class="form-control @error('credential') is-invalid @enderror p-3" 
                            name="credential" placeholder="Email or Username" required value="{{ old('credential') }}">
                    </div>

                    <div class="mb-4 position-relative">
                        <input type="password" 
                            class="form-control @error('password') is-invalid @enderror p-3" 
                            name="password" 
                            id="passwordField"
                            placeholder="Password" 
                            required>
                        
                        <!-- Show/Hide Password Toggle -->
                        <span class="position-absolute end-0 top-50 translate-middle-y me-3" 
                            style="cursor: pointer;"
                            onclick="togglePasswordVisibility('passwordField', 'toggleIcon')">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </span>
                    </div>

                    <div class="text-start mb-3">
                        <a data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" 
                           class="text-decoration-none text-color-1 font-paragraph text-underline-left-to-right"
                           style="cursor: pointer; font-size: 0.85rem;">Forgot Password?</a>
                    </div>

                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-md-6 col-lg-4">
                                <div class="g-recaptcha-wrapper">
                                    <div class="g-recaptcha" data-sitekey="6LeAQAgrAAAAAEIzUoydZx4MiA3sE6v0eE22Yr0l"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-check text-start mt-2 mb-2">
                        <input class="form-check-input" type="checkbox" id="agreeTerms">
                        <label class="form-check-label text-color-1 font-paragraph" for="agreeTerms" style="font-size: 0.9rem;">
                            I agree to the  
                            <a href="#" data-bs-toggle="modal" data-bs-target="#privacyPolicyModal" class="font-paragraph text-decoration-none text-color-1 fw-semibold text-underline-left-to-right">Terms and Conditions</a>
                        </label>
                    </div>

                    <button id="loginButton" type="submit" class="login-button">
                        <span id="loginText" class="fw-bold">LOG IN</span>
                    </button>

                    <p class="text-center mt-2 text-color-1 font-paragraph" style="font-size: 0.85rem;">
                        Don't have an account? 
                        <a href="{{ route('signup') }}" class="text-color-1 ms-1 text-decoration-none text-hover-effect">Sign Up</a>
                    </p>

                    <a href="{{ route('google.redirect') }}" class="text-white font-paragraph text-decoration-none fw-bold">
                        <div class="d-flex justify-content-center align-items-center bg-success p-3 rounded-4 google"
                             style="font-size: 0.9rem;">
                            <img src="{{ asset('images/google.png') }}" alt="" width="16" height="16" class="me-2"> 
                            Sign In using Google
                        </div>
                    </a>
                </form>
            </div>

            <!-- Right Side: Image -->
            <div class="col-md-6 d-none d-md-block">
                <img src="{{ asset('images/labasneto.JPG') }}" alt="Login Image" class="img-fluid rounded-4" style="height: 65vh;">
            </div>
        </div>
    </div>
</div>

<!-- Privacy Policy Modal -->
<div class="modal fade" id="privacyPolicyModal" tabindex="-1" aria-labelledby="privacyPolicyLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="margin-top: 8vh;">
        <div class="modal-content rounded-4 border-0" style="background-color: #f9f9f9;">
            <div class="modal-header bg-success text-white rounded-top-4 py-3">
                <h5 class="modal-title fw-bold" id="privacyPolicyLabel">Terms and Conditions</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column px-4 py-3" style="max-height: 70vh; overflow-y: auto;">
                <div class="text-start">
                    <h5 class="fw-bold text-success mb-4">Terms and Conditions & Data Privacy Notice</h5>
                    <div class="mb-4">
                        <p class="fw-bold mb-2">Data Privacy Act Compliance</p>
                        <p>In accordance with Republic Act 10173 (Data Privacy Act of 2012), Lelo's Resort is committed to protecting your personal information. By using our services:</p>
                        <ul class="list-unstyled ps-3">
                            <li>• You consent to the collection and processing of your personal data for reservation purposes</li>
                            <li>• Your information will be:</li>
                            <ul class="ps-4">
                                <li>- Securely stored and protected</li>
                                <li>- Used only for legitimate business purposes</li>
                                <li>- Retained only for the duration required by law</li>
                                <li>- Never shared with third parties without consent</li>
                            </ul>
                            <li>• You have the right to:</li>
                            <ul class="ps-4">
                                <li>- Access your personal data</li>
                                <li>- Request corrections or deletions</li>
                                <li>- Object to processing</li>
                                <li>- File a complaint</li>
                            </ul>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <p class="fw-bold mb-2">Reservation Agreement</p>
                        <p>By confirming a reservation, guests acknowledge and agree to all terms and conditions set by Lelo's Resort management.</p>
                    </div>
                    <div class="mb-4">
                        <p class="fw-bold mb-2">Payment Policy</p>
                        <ul class="list-unstyled ps-3">
                            <li>• Full payment is required in advance to secure the reservation.</li>
                            <li>• All payments are strictly non-refundable, regardless of:</li>
                            <ul class="ps-4">
                                <li>- Cancellations</li>
                                <li>- Date changes</li>
                                <li>- Late arrivals</li>
                                <li>- Early departures</li>
                                <li>- No-shows</li>
                                <li>- Weather disturbances</li>
                                <li>- Any other unforeseen events</li>
                            </ul>
                        </ul>
                        <p class="mt-2">Guests are strongly advised to finalize their plans before confirming a reservation.</p>
                    </div>
                    <div class="mb-4">
                        <p class="fw-bold mb-2">Security Deposit</p>
                        <ul class="list-unstyled ps-3">
                            <li>• A security deposit equivalent to 50% of the total booking amount must be provided upon check-in.</li>
                            <li>• This deposit covers:</li>
                            <ul class="ps-4">
                                <li>- Potential damages to resort property</li>
                                <li>- Loss of items</li>
                                <li>- Violations of resort rules</li>
                            </ul>
                            <li>• The deposit is fully refundable upon check-out if no issues are found after inspection.</li>
                            <li>• Deductions will be made for any damages or violations, and excess charges will be billed to the guest.</li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <p class="fw-bold mb-2">Check-in/Check-out Policy</p>
                        <ul class="list-unstyled ps-3">
                            <li>• Guests must follow scheduled check-in and check-out times.</li>
                            <li>• Early check-in or late check-out is subject to availability and may incur additional charges.</li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <p class="fw-bold mb-2">Guest Conduct</p>
                        <ul class="list-unstyled ps-3">
                            <li>• Guests must behave responsibly and follow all resort guidelines.</li>
                            <li>• Respect towards other guests and staff is expected at all times.</li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <p class="fw-bold mb-2">Right to Refuse Service</p>
                        <ul class="list-unstyled ps-3">
                            <li>• Lelo's Resort reserves the right to refuse service or evict any guest who:</li>
                            <ul class="ps-4">
                                <li>- Violates the terms and conditions</li>
                                <li>- Engages in disruptive or inappropriate behavior</li>
                            </ul>
                            <li>• No refund will be given in such cases.</li>
                        </ul>
                    </div>
                    <div class="text-center mt-4">
                        <p class="fw-bold mb-1">Contact Information</p>
                        <p>For more details or data privacy concerns, contact us at <a href="mailto:lelosresort@gmail.com" class="text-decoration-none fw-bold text-success">lelosresort@gmail.com</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- OTP Verification Modal -->
<div class="modal fade" id="otpVerificationModal" tabindex="-1" aria-labelledby="otpVerificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="otpVerificationModalLabel">OTP Verification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <p>Please enter the OTP code sent to your email</p>
                    <p class="text-muted" id="otpEmail"></p>
                </div>
                <form id="otpVerificationForm" method="POST" action="{{ route('verify-login-otp') }}">
                    @csrf
                    <input type="hidden" name="email" id="otpEmailInput">
                    <div class="mb-3">
                        <div class="d-flex justify-content-center">
                            <input type="text" class="form-control text-center" maxlength="6" name="otp" style="width: 200px;" placeholder="Enter 6-digit OTP">
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">Verify OTP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content rounded-4 border-0" style="background-color: #f8f9fa;">
            <div class="modal-header bg-success text-white py-3 rounded-top-4">
                <h5 class="modal-title fw-bold" id="forgotPasswordModalLabel">Forgot Password</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('forgot.reset') }}" method="POST" id="passwordResetForm">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold text-success">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="otp" class="form-label fw-bold text-success">OTP Code</label>
                        <div class="d-flex">
                            <div class="position-relative w-100">
                                <input type="number" class="form-control me-2" name="otp" id="otp" placeholder="Enter OTP" required maxlength="6">
                            </div>
                            <button type="button" id="sendOTPBtn" class="btn btn-success text-center mx-auto d-block ms-2" style="font-size: 10px; height: 50px;">Send OTP</button>
                        </div>
                    </div>
                    <div id="passwordFields" style="display: none; opacity: 0; transition: opacity 0.3s ease-in-out;">
                        <div class="mb-3">
                            <label for="newPassword" class="form-label fw-bold text-success">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="newPassword" placeholder="Enter new password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('newPassword', 'newPasswordIcon')" style="height: 50px;">
                                    <i class="fas fa-eye" id="newPasswordIcon"></i>
                                </button>
                            </div>
                            <div class="password-strength mt-2">
                                <div class="progress" style="height: 5px;">
                                    <div id="passwordStrength" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small id="passwordHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-bold text-success">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password_confirmation" id="confirmPassword" placeholder="Confirm your password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('confirmPassword', 'confirmPasswordIcon')" style="height: 50px;">
                                    <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                                </button>
                            </div>
                            <div id="passwordMatch" class="mt-2"></div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success w-100 fw-bold py-2" id="submitBtn" disabled>
                            Reset Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Google Auth OTP Modal -->
@if(session('show_otp_modal'))
<div class="modal fade" id="googleOtpModal" tabindex="-1" aria-labelledby="googleOtpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="googleOtpModalLabel">OTP Verification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <p>Please enter the OTP code sent to your email</p>
                    <p class="text-muted"><strong>{{ session('otp_email') }}</strong></p>
                </div>
                <form action="{{ route('verifyOTP') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ session('otp_user_id') }}">
                    <div class="mb-3">
                        <div class="d-flex justify-content-center">
                            <input type="text" class="form-control text-center" id="google_otp" name="otp" required autofocus maxlength="6" style="width: 200px;" placeholder="Enter 6-digit OTP">
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">Verify OTP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // --- BOOTSTRAP TOAST HELPER ---
    @if(session('show_otp_modal'))
        var googleOtpModal = new bootstrap.Modal(document.getElementById('googleOtpModal'));
        googleOtpModal.show();
    @endif

    function showBootstrapToast(message, type = 'success') {
        const toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) return;

        let iconClass = '';
        let bgColor = '';
        let fontWeightClass = '';
        let closeButtonHTML = '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>';

        if (type === 'success') {
            iconClass = 'fa-check-circle';
            bgColor = 'bg-success';
            fontWeightClass = 'fw-bold';
            closeButtonHTML = ''; // No close button for success
        } else if (type === 'error') {
            iconClass = 'fa-exclamation-circle';
            bgColor = 'bg-danger';
        } else if (type === 'warning') {
            iconClass = 'fa-exclamation-circle';
            bgColor = 'bg-warning';
        }

        const toastEl = document.createElement('div');
        toastEl.classList.add('toast', 'align-items-center', 'text-white', bgColor, 'border-0');
        toastEl.setAttribute('role', 'alert');
        toastEl.setAttribute('aria-live', 'assertive');
        toastEl.setAttribute('aria-atomic', 'true');

        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body ${fontWeightClass}">
                    <i class="fas ${iconClass} me-2"></i>
                    ${message}
                </div>
                ${closeButtonHTML}
            </div>
        `;

        toastContainer.appendChild(toastEl);

        const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
        toast.show();

        toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
    }

    // --- HANDLE SESSION MESSAGES ON PAGE LOAD ---
    @if(session('success'))
        showBootstrapToast("{{ session('success') }}", 'success');
    @endif

    @if(session('error'))
        showBootstrapToast("{{ session('error') }}", 'error');
    @endif

    @if($errors->any())
        @foreach ($errors->all() as $error)
            showBootstrapToast("{{ $error }}", 'error');
        @endforeach
    @endif

    // --- GENERAL UTILITY FUNCTIONS ---
    window.togglePasswordVisibility = function(fieldId, iconId) {
        const passwordField = document.getElementById(fieldId);
        const toggleIcon = document.getElementById(iconId);
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    // --- LOGIN FORM LOGIC ---
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            // Prevent submission to handle logic first
            e.preventDefault(); 

            const loginButton = document.getElementById('loginButton');
            const userCredential = document.getElementById('userCredential').value;
            const password = document.getElementById('passwordField').value;
            const agreeTerms = document.getElementById('agreeTerms').checked;
            const isEmail = userCredential.includes('@');

            if (!userCredential || !password) {
                showBootstrapToast('Please fill out all fields.', 'warning');
                return;
            }
            
            if (!agreeTerms) {
                showBootstrapToast('You must agree to the terms and conditions.', 'warning');
                return;
            }

            loginButton.disabled = true;

            if (isEmail) {
                // Handle email login with OTP
                loginButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending OTP...`;
                try {
                    const response = await fetch('{{ route("send-login-otp") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: `email=${encodeURIComponent(userCredential)}&password=${encodeURIComponent(password)}`
                    });

                    const data = await response.json();

                    if (data.success) {
                        const otpModal = new bootstrap.Modal(document.getElementById('otpVerificationModal'));
                        document.getElementById('otpEmail').textContent = userCredential;
                        document.getElementById('otpEmailInput').value = userCredential;
                        otpModal.show();
                    } else {
                        showBootstrapToast(data.message || 'Failed to send OTP. Please try again.', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showBootstrapToast('An error occurred. Please try again later.', 'error');
                } finally {
                    loginButton.disabled = false;
                    loginButton.innerHTML = `<span id="loginText" class="fw-bold">LOG IN</span>`;
                }
            } else {
                // Handle username login
                loginButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please wait...`;
                this.submit(); // Submit the form for username authentication
            }
        });
    }

    // --- FORGOT PASSWORD LOGIC ---
    const forgotPasswordModal = document.getElementById('forgotPasswordModal');
    if(forgotPasswordModal) {
        const sendOTPBtn = document.getElementById('sendOTPBtn');
        sendOTPBtn.addEventListener('click', async function() {
            const email = forgotPasswordModal.querySelector('#email').value;
            if (!email) {
                showBootstrapToast('Please enter your email first.', 'warning');
                return;
            }

            this.disabled = true;
            this.textContent = "Sending...";

            try {
                const response = await fetch("{{ route('forgot.sendOTP') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: JSON.stringify({ email: email })
                });
                const data = await response.json();
                showBootstrapToast(data.message, data.success ? 'success' : 'error');

            } catch (error) {
                console.error("Error sending OTP:", error);
                showBootstrapToast('Failed to send OTP. Please try again.', 'error');
            } finally {
                this.disabled = false;
                this.textContent = "Send OTP";
            }
        });

        const passwordResetForm = document.getElementById('passwordResetForm');
        passwordResetForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const resetBtn = this.querySelector('button[type="submit"]');
            resetBtn.disabled = true;
            resetBtn.textContent = "Resetting...";

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch("{{ route('forgot.reset') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: JSON.stringify(data)
                });
                const result = await response.json();
                showBootstrapToast(result.message, result.success ? 'success' : 'error');

                if (result.success) {
                    setTimeout(() => {
                        window.location.href = "/login";
                    }, 2000);
                }
            } catch (error) {
                console.error("Error resetting password:", error);
                showBootstrapToast('Failed to reset password. Please try again.', 'error');
            } finally {
                resetBtn.disabled = false;
                resetBtn.textContent = "Reset Password";
            }
        });
        
        const otpInput = forgotPasswordModal.querySelector('#otp');
        const passwordFields = forgotPasswordModal.querySelector('#passwordFields');

        otpInput.addEventListener('input', function() {
            if (this.value.length === 6) {
                passwordFields.style.display = 'block';
                setTimeout(() => {
                    passwordFields.style.opacity = '1';
                }, 10);
            } else {
                passwordFields.style.opacity = '0';
                setTimeout(() => {
                    passwordFields.style.display = 'none';
                }, 300);
            }
        });

        const newPasswordInput = forgotPasswordModal.querySelector('#newPassword');
        const confirmPasswordInput = forgotPasswordModal.querySelector('#confirmPassword');
        const passwordMatchElement = forgotPasswordModal.querySelector('#passwordMatch');
        const passwordStrengthBar = forgotPasswordModal.querySelector('#passwordStrength');
        const passwordHelpText = forgotPasswordModal.querySelector('#passwordHelp');
        const submitResetBtn = forgotPasswordModal.querySelector('#submitBtn');

        function calculatePasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength += 30;
            if (/[A-Z]/.test(password)) strength += 20;
            if (/[a-z]/.test(password)) strength += 20;
            if (/[0-9]/.test(password)) strength += 20;
            if (/[^A-Za-z0-9]/.test(password)) strength += 10;
            return Math.min(strength, 100);
        }

        function checkPasswordStrength() {
            const percentage = calculatePasswordStrength(newPasswordInput.value);
            passwordStrengthBar.style.width = percentage + '%';

            if (percentage < 40) {
                passwordStrengthBar.className = 'progress-bar bg-danger';
                passwordHelpText.textContent = 'Weak';
            } else if (percentage < 70) {
                passwordStrengthBar.className = 'progress-bar bg-warning';
                passwordHelpText.textContent = 'Moderate';
            } else {
                passwordStrengthBar.className = 'progress-bar bg-success';
                passwordHelpText.textContent = 'Strong';
            }
        }

        function checkPasswordMatch() {
            const passwordsMatch = newPasswordInput.value && newPasswordInput.value === confirmPasswordInput.value;
            if (newPasswordInput.value && confirmPasswordInput.value) {
                if (passwordsMatch) {
                    passwordMatchElement.innerHTML = '<small class="text-success">Passwords match!</small>';
                } else {
                    passwordMatchElement.innerHTML = '<small class="text-danger">Passwords do not match!</small>';
                }
            } else {
                passwordMatchElement.innerHTML = '';
            }
            submitResetBtn.disabled = !passwordsMatch;
        }

        newPasswordInput.addEventListener('input', () => {
            checkPasswordStrength();
            checkPasswordMatch();
        });

        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
    }

    // --- OTP VERIFICATION MODAL LOGIC ---
    const otpVerificationForm = document.getElementById('otpVerificationForm');
    if(otpVerificationForm) {
        otpVerificationForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const verifyBtn = this.querySelector('button[type="submit"]');
            verifyBtn.disabled = true;
            verifyBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Verifying...`;

            const formData = new FormData(this);

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                const data = await response.json();
                if (data.success) {
                    showBootstrapToast('OTP verified! Redirecting...', 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect || '/dashboard';
                    }, 1500);
                } else {
                    showBootstrapToast(data.message || 'Invalid OTP. Please try again.', 'error');
                    verifyBtn.disabled = false;
                    verifyBtn.textContent = 'Verify OTP';
                }
            } catch (error) {
                console.error('Error verifying OTP:', error);
                showBootstrapToast('An error occurred during verification.', 'error');
                verifyBtn.disabled = false;
                verifyBtn.textContent = 'Verify OTP';
            }
        });
    }

    // Google login success callback
    function handleGoogleLogin(response) {
        fetch('/auth/google/callback', {
            method: 'GET',
            headers: {
            'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.otp_required) {
            // Ipakita ang modal
            const modal = new bootstrap.Modal(document.getElementById('otpModal'));
            document.getElementById('userEmail').textContent = data.email;
            document.getElementById('userId').value = data.user_id;
            modal.show();
            } else {
            window.location.href = '/calendar'; // Redirect kung walang OTP
            }
        });
    }
});
</script>

</body>
</html>