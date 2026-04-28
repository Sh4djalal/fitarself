@extends('layouts.app')

@section('title', $mechanic->name . ' - Mechanic Profile')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <a href="/mechanics" class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1">← Back to Mechanics</a>

    <div class="bg-fitar-surface/50 border border-white/10 rounded-2xl p-6 mb-8">
        <div class="flex flex-col sm:flex-row items-start gap-6">
            <div class="w-24 h-24 rounded-full bg-fitar-card flex items-center justify-center text-3xl overflow-hidden flex-shrink-0">
                <img src="{{ $mechanic->profile_photo_url }}" alt="{{ $mechanic->name }}" class="w-full h-full object-cover">
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-3 flex-wrap mb-2">
                    <h1 class="text-2xl font-heading font-bold text-white">{{ $mechanic->name }}</h1>
                    @if($mechanic->is_verified_mechanic)
                    <span class="px-2 py-0.5 bg-green-500/20 text-green-400 rounded-full text-xs font-medium">✅ Verified</span>
                    @endif
                </div>
                <p class="text-gray-400">{{ $mechanic->mechanicDetail->specialization_en ?? 'Mechanic' }}</p>
                <p class="text-gray-500 text-sm mt-1">📍 {{ $mechanic->city ?? 'Iraq' }} • ⏳ {{ $mechanic->mechanicDetail->experience_years ?? 'N/A' }} years experience</p>
                <div class="flex gap-2 mt-4">
                  <a href="/chat/start/{{ $mechanic->id }}" class="px-4 py-2 bg-fitar-accent hover:bg-fitar-accent-hover text-white rounded-lg font-medium text-sm transition inline-block">💬 Message</a>
                    <a href="#write-review" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg font-medium text-sm transition inline-block">⭐ Review</a>
                </div>
            </div>
            @php
                $avgRating = $mechanic->reviews()->where('is_approved', true)->avg('rating') ?? 0;
                $reviewCount = $mechanic->reviews()->where('is_approved', true)->count();
            @endphp
            <div class="text-center flex-shrink-0">
                <p class="text-4xl font-bold text-fitar-accent">{{ number_format($avgRating, 1) }}</p>
                <div class="text-yellow-500">{{ str_repeat('★', floor($avgRating)) }}</div>
                <p class="text-xs text-gray-400">{{ $reviewCount }} reviews</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            
            @if($mechanic->bio_en)
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <h2 class="text-lg font-heading font-bold text-white mb-3">📝 About</h2>
                <p class="text-gray-300 leading-relaxed">{{ $mechanic->bio_en }}</p>
            </div>
            @endif

            @if($mechanic->mechanicDetail)
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <h2 class="text-lg font-heading font-bold text-white mb-3">🏢 Workshop Info</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="flex justify-between py-2 border-b border-white/5"><span class="text-gray-400">Workshop</span><span class="text-white">{{ $mechanic->mechanicDetail->workshop_name ?? 'N/A' }}</span></div>
                    <div class="flex justify-between py-2 border-b border-white/5"><span class="text-gray-400">City</span><span class="text-white">{{ $mechanic->mechanicDetail->workshop_city ?? 'N/A' }}</span></div>
                    <div class="flex justify-between py-2 border-b border-white/5"><span class="text-gray-400">Phone</span><span class="text-white">{{ $mechanic->mechanicDetail->workshop_phone ?? 'N/A' }}</span></div>
                    <div class="flex justify-between py-2 border-b border-white/5"><span class="text-gray-400">Experience</span><span class="text-white">{{ $mechanic->mechanicDetail->experience_years ?? 'N/A' }} years</span></div>
                </div>
            </div>
            @endif

            <!-- Review Form -->
            <x-review-form 
                reviewable-type="App\Models\User" 
                reviewable-id="{{ $mechanic->id }}" 
                reviewable-name="{{ $mechanic->name }}" 
            />

            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6" id="reviews-section">
                <h2 class="text-lg font-heading font-bold text-white mb-4">💬 Reviews ({{ $reviewCount }})</h2>
                @if($reviewCount > 0)
                    @foreach($mechanic->reviews()->where('is_approved', true)->latest()->get() as $review)
                    <div class="border-b border-white/5 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-yellow-500">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                            <span class="text-sm text-gray-400">{{ $review->user->name ?? 'User' }}</span>
                            <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                            @if(Auth::id() === $review->user_id)
                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Delete this review?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-400 hover:text-red-300">Delete</button>
                            </form>
                            @endif
                        </div>
                        <p class="text-gray-300 text-sm">{{ $review->review_text_en }}</p>
                    </div>
                    @endforeach
                @else
                <p class="text-gray-500 text-sm">No reviews yet. Be the first!</p>
                @endif
            </div>

        </div>

        <div class="space-y-6">
            @if($mechanic->mechanicDetail && $mechanic->mechanicDetail->specialty_tags)
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <h3 class="font-semibold text-white mb-3">📋 Specialties</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach(json_decode($mechanic->mechanicDetail->specialty_tags) as $tag)
                    <span class="px-3 py-1 bg-fitar-accent/20 text-fitar-accent rounded-full text-xs capitalize">{{ str_replace('-', ' ', $tag) }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection