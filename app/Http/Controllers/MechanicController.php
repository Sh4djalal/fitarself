<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'mechanic');
        
        // Filter by specialty if provided and not 'all'
        $specialty = $request->get('specialty', 'all');
        
        if ($specialty !== 'all') {
            $query->whereHas('mechanicDetail', function($q) use ($specialty) {
                $q->where('specialty_tags', 'like', '%' . $specialty . '%');
            });
        }
        
        // Get all mechanics (verified + unverified)
        $mechanics = $query->orderBy('is_verified_mechanic', 'desc')
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);
        
        return view('mechanics.index', compact('mechanics'));
    }
    
    public function show($id)
    {
        $mechanic = User::where('role', 'mechanic')->findOrFail($id);
        return view('mechanics.show', compact('mechanic'));
    }
}