<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query();

        if ($request->has('make')) {
            $query->where('make', $request->make);
        }
        if ($request->has('body_type')) {
            $query->where('body_type', $request->body_type);
        }
        if ($request->has('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }

        $cars = $query->orderBy('make')->orderBy('model')->paginate(12);
        $makes = Car::select('make')->distinct()->orderBy('make')->pluck('make');

        return view('cars.index', compact('cars', 'makes'));
    }

    public function show(Car $car)
    {
        $car->load(['reviews' => function ($q) {
            $q->where('is_approved', true)->latest()->limit(5);
        }, 'reviews.user', 'faultCodes']);

        $relatedCars = Car::where('make', $car->make)
                          ->where('id', '!=', $car->id)
                          ->limit(4)
                          ->get();

        return view('cars.show', compact('car', 'relatedCars'));
    }
}
