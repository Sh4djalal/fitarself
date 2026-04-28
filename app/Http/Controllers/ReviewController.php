<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reviewable_type' => 'required|in:App\Models\Car,App\Models\User',
            'reviewable_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'review_text_en' => 'required|string|min:10|max:1000',
            'review_text_ku' => 'nullable|string|max:1000',
        ]);

        $exists = Review::where('user_id', Auth::id())
            ->where('reviewable_type', $request->reviewable_type)
            ->where('reviewable_id', $request->reviewable_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You have already reviewed this item.');
        }

        if ($request->reviewable_type === 'App\Models\User') {
            $reviewedUser = \App\Models\User::find($request->reviewable_id);
            if ($reviewedUser && $reviewedUser->id === Auth::id()) {
                return back()->with('error', 'You cannot review yourself.');
            }
        }

        $review = Review::create([
            'user_id' => Auth::id(),
            'reviewable_type' => $request->reviewable_type,
            'reviewable_id' => $request->reviewable_id,
            'rating' => $request->rating,
            'review_text_en' => $request->review_text_en,
            'review_text_ku' => $request->review_text_ku ?? $request->review_text_en,
            'is_approved' => true,
        ]);

        $this->updateAverageRating($request->reviewable_type, $request->reviewable_id);

        return back()->with('success', 'Review submitted successfully!');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $reviewableType = $review->reviewable_type;
        $reviewableId = $review->reviewable_id;

        $review->delete();

        $this->updateAverageRating($reviewableType, $reviewableId);

        return back()->with('success', 'Review deleted.');
    }

    private function updateAverageRating($type, $id)
    {
        $avg = Review::where('reviewable_type', $type)
            ->where('reviewable_id', $id)
            ->where('is_approved', true)
            ->avg('rating');

        $count = Review::where('reviewable_type', $type)
            ->where('reviewable_id', $id)
            ->where('is_approved', true)
            ->count();

        if ($type === 'App\Models\Car') {
            \App\Models\Car::where('id', $id)->update([
                'average_rating' => $avg ?? 0,
                'review_count' => $count,
            ]);
        }
    }
}