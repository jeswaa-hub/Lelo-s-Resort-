<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Mail\SendOTP;

class SignUpController extends Controller
{
    public function signup()
    {
        return view('FrontEnd.signuppage');
    }

    public function sendOTP(Request $request)
    {
        try {
            // First validate the basic input fields
            $request->validate([
                'name' => 'required|string|max:255',
                'mobileNo' => 'required|string|max:11', 
                'email' => 'required|email',
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Check if email already exists in users table
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                return response()->json(['success' => false, 'message' => 'This email address is already registered. Please use a different email or try logging in.'], 409); // 409 Conflict
            }

            // Check if OTP was recently sent for this email
            $lastOTPTime = Cache::get('otp_time_' . $request->email);
            if ($lastOTPTime && now()->diffInSeconds($lastOTPTime) < 60) {
                return response()->json(['success' => false, 'message' => 'Please wait 60 seconds before requesting a new OTP.'], 429); // 429 Too Many Requests
            }

            // Generate OTP
            $otp = rand(100000, 999999);

            // Store OTP data in cache
            Cache::put('otp_' . $request->email, [
                'otp' => $otp,
                'name' => $request->name,
                'mobileNo' => $request->mobileNo,
                'password' => Hash::make($request->password)
            ], now()->addMinutes(5));

            // Store the time when OTP was sent
            Cache::put('otp_time_' . $request->email, now(), now()->addMinutes(5));

            // Send OTP via email
            Mail::to($request->email)->send(new SendOTP($otp));

            return response()->json(['success' => true, 'message' => 'OTP sent successfully! Please check your email and enter the verification code.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors as JSON
            return response()->json(['success' => false, 'errors' => $e->errors()], 422); // 422 Unprocessable Entity
        } catch (\Exception $e) {
            Log::error('OTP Send Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send OTP. Please try again later.'], 500); // 500 Internal Server Error
        }
    }

    public function verifyOTP(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'otp' => 'required|digits:6'
            ]);

            $otpData = Cache::get('otp_' . $request->email);

            if (!$otpData || $otpData['otp'] != $request->otp) {
                return response()->json(['success' => false, 'message' => 'Invalid or expired OTP.'], 400); // 400 Bad Request
            }

            // Clear OTP from cache
            Cache::forget('otp_' . $request->email);
            Cache::forget('otp_time_' . $request->email);

            // Create new user
            User::create([
                'name' => $otpData['name'],
                'mobileNo' => $otpData['mobileNo'],
                'email' => $request->email,
                'password' => $otpData['password'], // Password is already hashed
            ]);        
            
            return response()->json(['success' => true, 'message' => 'Account created successfully! You can now log in.', 'redirect' => route('login')]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors as JSON
            return response()->json(['success' => false, 'errors' => $e->errors()], 422); // 422 Unprocessable Entity
        } catch (\Exception $e) {
            Log::error('OTP Verification Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'OTP verification failed. Please try again.'], 500); // 500 Internal Server Error
        }
    }
    public function checkEmail(Request $request)
    {
        // Validate that an email was provided and it's in a valid format.
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        // If validation fails, return an error response.
        if ($validator->fails()) {
            // 422 Unprocessable Entity is a standard response for validation errors.
            return response('Please provide a valid email address.', 422);
        }

        // Check if the email exists in the users table.
        $exists = User::where('email', $request->email)->exists();

        // Return a 409 Conflict status if the email is taken, or a 200 OK if it's available.
        // This allows the frontend to check the status code instead of parsing a JSON body.
        return $exists ? response('Email is already taken.', 409) : response('Email is available.', 200);
    }
}