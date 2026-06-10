<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminKey;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'secret_key' => 'required|string'
        ]);
        
        $secretKey = $request->input('secret_key');
        $admin = AdminKey::verifyKey($secretKey);
        
        if ($admin) {
            session(['admin_authenticated' => true, 'admin_id' => $admin->id]);
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'redirect' => route('admin.dashboard')]);
            }
            
            return redirect()->route('admin.dashboard')->with('success', 'Welcome to Admin Panel!');
        }
        
        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'error' => 'Invalid secret key'], 401);
        }
        
        return back()->with('error', 'Invalid secret key');
    }
    
    public function dashboard()
    {
        $totalUsers = \App\Models\User::count();
        $totalCars = \App\Models\Car::count();
        $totalReviews = \App\Models\Review::count();
        $totalMechanics = \App\Models\User::where('role', 'mechanic')->count();
        
        return view('admin.dashboard', compact('totalUsers', 'totalCars', 'totalReviews', 'totalMechanics'));
    }
    
    public function logout()
    {
        session()->forget(['admin_authenticated', 'admin_id']);
        return redirect()->route('admin.login');
    }
}