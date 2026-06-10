<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OtpVerificationController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Show OTP verification form
     */
    public function showForm(Request $request)
    {
        $email = session('verification_email') ?? $request->query('email');
        
        if (!$email) {
            return redirect()->route('register');
        }

        return view('auth.verify-otp', compact('email'));
    }

    /**
     * Send OTP to user's email
     */
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email address.'
            ], 422);
        }

        $email = $request->email;
        $result = $this->otpService->sendOtp($email);

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Verification code sent to your email.' : 'Failed to send code. Please try again.'
        ]);
    }

    /**
     * Verify the OTP code
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid 6-digit code.'
            ], 422);
        }

        $email = $request->email;
        $otp = $request->otp;

        $verified = $this->otpService->verifyOtp($email, $otp);

        if ($verified) {
            // Log the user in
            $user = User::where('email', $email)->first();
            Auth::login($user);
            
            return response()->json([
                'success' => true,
                'message' => 'Email verified successfully!',
                'redirect' => route('dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired verification code. Please request a new one.'
        ], 422);
    }

    /**
     * Resend OTP code
     */
    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email address.'
            ], 422);
        }

        $result = $this->otpService->resendOtp($request->email);

        return response()->json($result);
    }
}