<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCarController extends Controller
{
    public function index()
    {
        $ownedCars = Auth::user()->ownedCars;
        return view('profile.cars', compact('ownedCars'));
    }

    public function store(Request $request)
    {
        $request->validate(['car_id' => 'required|exists:cars,id']);
        Auth::user()->ownedCars()->syncWithoutDetaching([$request->car_id]);
        return back()->with('success', 'Car added to your garage!');
    }

    public function destroy(Car $car)
    {
        Auth::user()->ownedCars()->detach($car->id);
        return back()->with('success', 'Car removed from garage.');
    }
}