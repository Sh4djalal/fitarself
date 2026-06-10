<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OtpVerification;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function edit()
    {
        $canChangeUsername = Auth::user()->canChangeUsername();
        $daysRemaining = Auth::user()->getDaysUntilUsernameChange();
        return view('profile.edit', compact('canChangeUsername', 'daysRemaining'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $rules = [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'bio' => 'nullable|string',
            'profile_photo_cropped' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ];
        
        // Check if username is being changed
        if ($request->has('username') && $request->username !== $user->username) {
            $rules['username'] = [
                'required',
                'string',
                'max:255',
                'unique:users,username',
                'regex:/^[a-zA-Z0-9_]+$/',
                function ($attribute, $value, $fail) use ($user) {
                    if (!$user->canChangeUsername()) {
                        $days = $user->getDaysUntilUsernameChange();
                        $fail("You can only change your username once per week. Please wait {$days} more days.");
                    }
                },
            ];
        }
        
        $request->validate($rules);
        
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->city = $request->city;
        $user->bio_en = $request->bio;
        
        // Update username if changed
        if ($request->has('username') && $request->username !== $user->username) {
            $user->username = $request->username;
            $user->username_changed_at = now();
        }
        
        if ($request->hasFile('profile_photo_cropped')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $path = $request->file('profile_photo_cropped')->store('profile_photos', 'public');
            $user->profile_photo_path = $path;
        }
        
        $user->save();
        
        if ($user->role === 'mechanic') {
            $mechanicDetail = $user->mechanicDetail ?: new \App\Models\MechanicDetail();
            $mechanicDetail->user_id = $user->id;
            $mechanicDetail->experience_years = $request->experience_years;
            
            $specialties = $request->input('specialties', []);
            if (empty($specialties)) {
                $mechanicDetail->specialty_tags = null;
            } else {
                $mechanicDetail->specialty_tags = json_encode($specialties);
            }
            
            $mechanicDetail->workshop_name = $request->workshop_name;
            $mechanicDetail->workshop_address = $request->workshop_address;
            $mechanicDetail->save();
        }
        
        // Redirect based on user role
        if ($user->role === 'mechanic') {
            return redirect()->route('mechanic.dashboard')->with('success', '✅ Your profile has been updated successfully!');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', '✅ Your profile has been updated successfully!');
        } else {
            return redirect()->route('dashboard')->with('success', '✅ Your profile has been updated successfully!');
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('profile.show', compact('user'));
    }

    public function showEmailChangeForm()
    {
        return view('profile.change-email');
    }

    public function sendEmailOtp(Request $request)
    {
        $request->validate([
            'new_email' => 'required|email|unique:users,email',
        ]);

        $newEmail = $request->new_email;
        
        session(['pending_email_change' => $newEmail]);
        
        $this->otpService->sendOtp($newEmail);
        
        return redirect()->route('profile.verify-email')->with('success', 'Verification code sent to ' . $newEmail);
    }

    public function showVerifyEmailChange()
    {
        $newEmail = session('pending_email_change');
        if (!$newEmail) {
            return redirect()->route('profile.edit')->with('error', 'No email change request found.');
        }
        
        return view('profile.verify-email', compact('newEmail'));
    }

    public function verifyEmailChange(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $newEmail = session('pending_email_change');
        if (!$newEmail) {
            return redirect()->route('profile.edit')->with('error', 'No email change request found.');
        }

        $user = Auth::user();
        
        $otpRecord = OtpVerification::where('email', $newEmail)
            ->where('otp', $request->otp)
            ->where('is_used', false)
            ->first();

        if (!$otpRecord || $otpRecord->expires_at->isPast()) {
            return back()->withErrors(['otp' => 'Invalid or expired verification code.']);
        }

        $otpRecord->update(['is_used' => true]);

        $user->email = $newEmail;
        $user->email_verified_at = now();
        $user->save();

        session()->forget('pending_email_change');

        return redirect()->route('profile.edit')->with('success', 'Email changed successfully to: ' . $newEmail);
    }
}