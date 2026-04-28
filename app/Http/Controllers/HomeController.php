<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Ad;
use App\Models\User;
use App\Models\FaultCode;

class HomeController extends Controller
{
    public function index()
    {
        $ads = Ad::active()->orderBy('sort_order')->limit(3)->get();
        $popularCars = Car::orderBy('review_count', 'desc')->limit(4)->get();
        $faultCodes = FaultCode::orderBy('severity', 'desc')->limit(4)->get();
        $mechanics = User::where('role', 'mechanic')
                         ->where('is_verified_mechanic', true)
                         ->with('mechanicDetail')
                         ->limit(3)
                         ->get();

        return view('welcome', compact('ads', 'popularCars', 'faultCodes', 'mechanics'));
    }
}
