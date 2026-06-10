<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'users');
        
        // Users query - get all users with usernames
        $usersQuery = User::where(function($q) {
                $q->where('role', 'user')
                  ->orWhere('role', 'mechanic');
            })
            ->whereNotNull('username');
        
        $users = $usersQuery->orderBy('username')->paginate(12);
        
        // Reviews query
        $reviewsQuery = Review::with(['user', 'reviewable'])
            ->where('is_approved', true)
            ->latest();
        
        $reviews = $reviewsQuery->paginate(15);
        
        return view('community.index', compact('users', 'reviews', 'tab'));
    }
}