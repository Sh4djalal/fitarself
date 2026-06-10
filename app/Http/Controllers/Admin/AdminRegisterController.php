<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class AdminRegisterController extends Controller
{
    /**
     * Show admin registration form
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Handle admin registration
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'admin_secret' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Check if admin secret key exists in database
        $adminKey = DB::table('admin_keys')
            ->where('secret_key', $request->admin_secret)
            ->where('is_active', 1)
            ->first();

        if (!$adminKey) {
            return back()->withErrors(['admin_secret' => 'The selected admin secret is invalid.'])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'locale' => app()->getLocale(),
            'theme_preference' => 'dark',
        ]);

        // Update last used time
        DB::table('admin_keys')
            ->where('id', $adminKey->id)
            ->update(['last_used_at' => now()]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect to admin dashboard instead of home
        return redirect()->route('admin.dashboard')->with('success', 'Welcome Admin! You are now logged in.');
    }
}