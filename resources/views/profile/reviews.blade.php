@extends('layouts.app')

@section('title', 'My Reviews')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">⭐ My Reviews</h1>
            <p class="text-gray-400">All reviews you have written</p>
        </div>
        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white">← Back to Dashboard</a>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500 rounded-lg p-3 mb-4">
            <p class="text-green-400 text-sm">{{ session('success') }}</p>
        </div>
    @endif

    @if($reviews->count() > 0)
        <div class="space-y-4">
            @foreach($reviews as $review)
                <div class="bg-fitar-surface border border-white/10 rounded-xl p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-yellow-500 text-lg">
                                    {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                </span>
                                <span class="text-gray-500 text-sm">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <a href="{{ $review->reviewable_type === 'App\Models\Car' ? route('cars.show', $review->reviewable_id) : route('mechanics.show', $review->reviewable_id) }}" class="text-white font-semibold text-lg hover:text-fitar-accent transition">
                                @php
                                    if ($review->reviewable_type === 'App\Models\Car') {
                                        echo $review->reviewable->make . ' ' . $review->reviewable->model;
                                    } elseif ($review->reviewable_type === 'App\Models\User') {
                                        // Show the mechanic's name instead of "User"
                                        echo $review->reviewable->name;
                                    } else {
                                        echo class_basename($review->reviewable_type);
                                    }
                                @endphp
                            </a>
                            <p class="text-gray-300 mt-2">{{ $review->review_text_en ?? $review->review_text_ku }}</p>
                        </div>
                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Delete this review?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300 text-sm transition">🗑️ Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $reviews->links() }}
        </div>
    @else
        <div class="bg-fitar-surface border border-white/10 rounded-xl p-12 text-center">
            <p class="text-6xl mb-4">⭐</p>
            <h3 class="text-white text-xl font-semibold mb-2">No Reviews Yet</h3>
            <p class="text-gray-400 mb-4">You haven't written any reviews yet.</p>
            <a href="{{ route('cars.index') }}" class="inline-block bg-fitar-accent hover:bg-fitar-accent-hover text-white px-6 py-2 rounded-lg transition">Browse Cars to Review</a>
        </div>
    @endif
</div>
@endsection