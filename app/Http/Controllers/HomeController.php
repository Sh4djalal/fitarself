<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\FaultCode;
use App\Models\User;
use App\Models\Part;
use App\Models\Ad;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get popular cars (for the homepage)
        $popularCars = Car::orderBy('review_count', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
        
        // Get common fault codes
        $faultCodes = FaultCode::orderBy('severity', 'desc')
            ->limit(8)
            ->get();
        
        // Get featured/verified mechanics
        $mechanics = User::where('role', 'mechanic')
            ->where('is_verified_mechanic', true)
            ->with('reviews')
            ->limit(6)
            ->get();
        
        // Get ads for carousel
        $ads = Ad::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Pass all variables to welcome.blade.php
        return view('welcome', compact('popularCars', 'faultCodes', 'mechanics', 'ads'));
    }
}