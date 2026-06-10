<?php

namespace App\Services;

use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class OtpService
{
    public function sendOtp(string $email): bool
    {
        // Delete any existing unused OTPs for this email
        OtpVerification::where('email', $email)
            ->where('is_used', false)
            ->delete();

        // Generate new 6-digit OTP
        $otp = OtpVerification::generateOtp();
        $expiresAt = Carbon::now()->addMinutes(15);

        // Store in database
        OtpVerification::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => $expiresAt,
            'is_used' => false,
        ]);

        // Log the OTP for debugging (optional - remove in production)
        Log::info("OTP generated for {$email}: {$otp}");

        // Send email with OTP - ONLY AFTER USER IS CREATED
        try {
            Mail::send('emails.otp', ['otp' => $otp, 'email' => $email], function ($message) use ($email) {
                $message->to($email)
                        ->subject('Your FitarSelf Verification Code');
            });
            Log::info("OTP email sent successfully to: {$email}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send OTP to {$email}: " . $e->getMessage());
            return false;
        }
    }

    public function verifyOtp(string $email, string $otp): bool
    {
        $otpRecord = OtpVerification::where('email', $email)
            ->where('otp', $otp)
            ->where('is_used', false)
            ->first();

        if (!$otpRecord || !$otpRecord->isValid()) {
            return false;
        }

        // Mark OTP as used
        $otpRecord->markAsUsed();

        // Mark user as verified
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->update([
                'verified_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
            ]);
        }

        return true;
    }

    public function resendOtp(string $email): array
    {
        // Check if recent OTP was sent (prevent spam)
        $recentOtp = OtpVerification::where('email', $email)
            ->where('created_at', '>=', Carbon::now()->subMinutes(1))
            ->first();

        if ($recentOtp) {
            return [
                'success' => false,
                'message' => 'Please wait 60 seconds before requesting another code.'
            ];
        }

        $sent = $this->sendOtp($email);

        return [
            'success' => $sent,
            'message' => $sent ? 'Verification code sent to your email.' : 'Failed to send verification code. Please try again.'
        ];
    }
}