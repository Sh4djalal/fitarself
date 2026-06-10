<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MechanicDetail;
use App\Services\OtpService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // Check if it's a mechanic registration
        if ($request->role === 'mechanic') {
            $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:' . User::class, 'regex:/^[a-zA-Z0-9_]+$/'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'phone' => ['required', 'string', 'max:20'],
                'city' => ['required', 'string', 'max:100'],
                'years_experience' => ['required', 'integer', 'min:0', 'max:50'],
                'specialties' => ['nullable', 'array'],
            ]);

            $fullName = $request->first_name . ' ' . $request->last_name;

            $user = User::create([
                'name' => $fullName,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'mechanic',
                'phone' => $request->phone,
                'city' => $request->city,
                'locale' => app()->getLocale(),
                'theme_preference' => 'dark',
            ]);

            MechanicDetail::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'specialization_en' => $request->specialties ? implode(', ', $request->specialties) : null,
                    'specialization_ku' => $request->specialties ? implode(', ', $request->specialties) : null,
                    'experience_years' => $request->years_experience,
                    'specialty_tags' => $request->specialties ? json_encode($request->specialties) : null,
                    'workshop_city' => $request->city,
                    'workshop_phone' => $request->phone,
                ]
            );

        } else {
            // Regular user registration
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:' . User::class, 'regex:/^[a-zA-Z0-9_]+$/'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
                'locale' => app()->getLocale(),
                'theme_preference' => 'dark',
            ]);
        }

        event(new Registered($user));

        $this->otpService->sendOtp($user->email);

        session(['verification_email' => $user->email]);

        return redirect()->route('verification.otp.form', ['email' => $user->email])
            ->with('success', 'Verification code sent to your email!');
    }
}