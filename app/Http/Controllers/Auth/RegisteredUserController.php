<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MechanicDetail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function createMechanic()
    {
        return view('auth.register-mechanic');
    }

    public function store(Request $request)
    {
        if ($request->role === 'mechanic') {
            $request->validate([
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'username' => 'required|string|max:50|unique:users',
                'phone' => 'required|string|max:20',
                'city' => 'required|string|max:100',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        } else {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        }

        $user = User::create([
            'is_verified_mechanic' => $request->role === 'mechanic',
            'name' => $request->role === 'mechanic' 
                ? $request->first_name . ' ' . $request->last_name 
                : $request->name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user',
            'phone' => $request->phone,
            'city' => $request->city,
        ]);

        if ($request->role === 'mechanic') {
            MechanicDetail::create([
                'user_id' => $user->id,
                'specialization_en' => implode(', ', array_map(function($tag) { return ucwords(str_replace('-', ' ', $tag)); }, $request->specialties ?? [])),
                'specialization_ku' => 'چەندین شارەزایی',
                'workshop_city' => $request->city,
                'workshop_phone' => $request->phone,
                'specialty_tags' => $request->specialties ?? [],
            ]);
        }

        event(new Registered($user));
        Auth::login($user);
        return redirect('/dashboard');
    }
}