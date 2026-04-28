<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\FaultCode;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return view('search.index', ['cars' => [], 'faultCodes' => [], 'mechanics' => [], 'query' => '']);
        }

        $cars = Car::where('make', 'like', "%{$query}%")
                   ->orWhere('model', 'like', "%{$query}%")
                   ->limit(10)
                   ->get();

        $faultCodes = FaultCode::where('code', 'like', "%{$query}%")
                               ->orWhere('title_en', 'like', "%{$query}%")
                               ->limit(10)
                               ->get();

        $mechanics = User::where('role', 'mechanic')
                         ->where(function ($q) use ($query) {
                             $q->where('name', 'like', "%{$query}%")
                               ->orWhere('city', 'like', "%{$query}%");
                         })
                         ->limit(10)
                         ->get();

        return view('search.index', compact('cars', 'faultCodes', 'mechanics', 'query'));
    }
}