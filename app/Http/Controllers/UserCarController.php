<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCarController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cars = $user->cars()->get();
        
        return view('profile.cars', compact('cars'));
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Check if user already owns a car
        if ($user->cars()->count() > 0) {
            return redirect()->back()->with('error', 'You can only own one car at a time.');
        }
        
        $car = Car::findOrFail($request->car_id);
        
        // Attach the car to user
        $user->cars()->attach($car->id);
        
        // Redirect based on user role
        if ($user->role === 'mechanic') {
            return redirect()->route('mechanic.dashboard')->with('success', 'You now own a ' . $car->make . ' ' . $car->model . '!');
        } else {
            return redirect()->route('dashboard')->with('success', 'You now own a ' . $car->make . ' ' . $car->model . '!');
        }
    }
    
    public function destroy($carId)
    {
        $user = Auth::user();
        $user->cars()->detach($carId);
        
        // Redirect based on user role
        if ($user->role === 'mechanic') {
            return redirect()->route('mechanic.dashboard')->with('success', 'Car removed from your collection.');
        } else {
            return redirect()->route('dashboard')->with('success', 'Car removed from your collection.');
        }
    }
}