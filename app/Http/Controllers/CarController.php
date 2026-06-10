<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query();

        if ($request->filled('make')) {
            $query->where('make', $request->get('make'));
            $cars = $query->orderBy('make')->orderBy('model')->get();
        } else {
            $cars = $query->orderBy('make')->orderBy('model')->paginate(12);
        }
        
        $makes = Car::select('make')->distinct()->orderBy('make')->pluck('make');

        return view('cars.index', compact('cars', 'makes'));
    }

    public function show($id)
    {
        $car = Car::findOrFail($id);
        

        $relatedCars = Car::where('make', $car->make)
                          ->where('id', '!=', $car->id)
                          ->limit(4)
                          ->get();

        return view('cars.show', compact('car', 'relatedCars'));
    }

    public function model($make, $model)
{
    $model = urldecode($model);
    $cars = Car::where('make', $make)
               ->where('model', $model)
               ->orderBy('year', 'desc')
               ->get();
               
    $regions = $cars->pluck('region')->unique()->filter();
    
    return view('cars.model', compact('cars', 'make', 'model', 'regions'));
}
}