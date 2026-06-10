<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reviewable_type' => 'required|string',
            'reviewable_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|min:3',
        ]);

        $review = new Review();
        $review->user_id = Auth::id();
        $review->reviewable_type = $request->reviewable_type;
        $review->reviewable_id = $request->reviewable_id;
        $review->rating = $request->rating;
        $review->review_text_en = $request->review_text;
        $review->review_text_ku = $request->review_text;
        $review->is_approved = true;
        $review->save();

        // Update the average rating for the reviewable item (only for Car models)
        if ($request->reviewable_type === 'App\\Models\\Car') {
            $car = Car::find($request->reviewable_id);
            if ($car) {
                $averageRating = $car->reviews()->where('is_approved', true)->avg('rating');
                $car->average_rating = $averageRating ?: 0;
                $car->review_count = $car->reviews()->where('is_approved', true)->count();
                $car->save();
            }
        }

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }
        
        $reviewable = $review->reviewable;
        $review->delete();
        
        // Update the average rating for the reviewable item (only for Car models)
        if ($reviewable && $reviewable instanceof Car) {
            $averageRating = $reviewable->reviews()->where('is_approved', true)->avg('rating');
            $reviewable->average_rating = $averageRating ?: 0;
            $reviewable->review_count = $reviewable->reviews()->where('is_approved', true)->count();
            $reviewable->save();
        }
        
        return redirect()->back()->with('success', 'Review deleted successfully!');
    }

    public function userReviews()
    {
        $reviews = Review::where('user_id', Auth::id())
            ->with('reviewable')
            ->latest()
            ->paginate(10);
        
        return view('profile.reviews', compact('reviews'));
    }
}