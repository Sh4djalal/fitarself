<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'mechanic')
                     ->with('mechanicDetail');

        if ($request->has('specialty')) {
            $specialty = $request->specialty;
            $query->whereHas('mechanicDetail', function ($q) use ($specialty) {
                $q->where('specialty_tags', 'like', '%' . $specialty . '%');
            });
        }
        if ($request->has('city')) {
            $query->where('city', $request->city);
        }

        $mechanics = $query->latest()->paginate(12);
        $cities = User::where('role', 'mechanic')->select('city')->distinct()->whereNotNull('city')->pluck('city');

        return view('mechanics.index', compact('mechanics', 'cities'));
    }

    public function show(User $mechanic)
    {
        $mechanic->load(['mechanicDetail', 'reviews' => function ($q) {
            $q->where('is_approved', true)->latest()->limit(10);
        }, 'reviews.user']);

        return view('mechanics.show', compact('mechanic'));
    }
}