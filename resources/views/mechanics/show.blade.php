@extends('layouts.app')

@section('title', $mechanic->username ?? $mechanic->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    
    <div class="mb-6">
        <a href="{{ route('mechanics.index') }}" class="text-gray-400 hover:text-white">← Back to Mechanics</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Profile -->
        <div class="lg:col-span-1">
            <div class="bg-fitar-surface border border-white/10 rounded-xl p-6 text-center sticky top-20">
                <!-- Profile Image -->
                <div class="flex justify-center mb-4">
                    <div style="width: 128px; height: 128px; border-radius: 50% !important; overflow: hidden; background-color: #1f2937; border: 2px solid #F47920;">
                        @if($mechanic->profile_photo_path && Storage::disk('public')->exists($mechanic->profile_photo_path))
                            <img src="{{ Storage::url($mechanic->profile_photo_path) }}" alt="{{ $mechanic->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #F47920, #d46218); display: flex; align-items: center; justify-content: center;">
                                <span style="font-size: 48px; font-weight: bold; color: white;">{{ strtoupper(substr($mechanic->name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <h1 class="text-2xl font-heading font-bold text-white">{{ $mechanic->username ?? $mechanic->name }}</h1>
                <p class="text-gray-400 text-sm">{{ $mechanic->email }}</p>
                
                <div class="mt-4">
                    @if($mechanic->is_verified_mechanic)
                        <span class="inline-block bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm">✅ Verified Mechanic</span>
                    @else
                        <span class="inline-block bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-sm">⏳ Pending Verification</span>
                    @endif
                </div>

                @if($mechanic->city)
                <div class="mt-4 pt-3 border-t border-white/10">
                    <p class="text-gray-400 text-sm">📍 {{ $mechanic->city }}</p>
                </div>
                @endif
                @if($mechanic->phone)
                <div class="mt-2">
                    <p class="text-gray-400 text-sm">📞 {{ $mechanic->phone }}</p>
                </div>
                @endif

                @if($mechanic->mechanicDetail && $mechanic->mechanicDetail->experience_years)
                <div class="mt-2">
                    <p class="text-gray-400 text-sm">⏱️ {{ $mechanic->mechanicDetail->experience_years }} years experience</p>
                </div>
                @endif

                @if($mechanic->bio_en)
                <div class="mt-4 pt-3 border-t border-white/10">
                    <p class="text-gray-400 text-sm">📝 Bio</p>
                    <p class="text-white text-sm mt-1">{{ $mechanic->bio_en }}</p>
                </div>
                @endif

                <!-- Specializations -->
                @if($mechanic->mechanicDetail && $mechanic->mechanicDetail->specialty_tags)
                <div class="mt-4 pt-3 border-t border-white/10">
                    <p class="text-gray-400 text-sm mb-2">🔧 Specializations</p>
                    <div class="flex flex-wrap gap-2 justify-center">
                        @php
                            $specTags = $mechanic->mechanicDetail->specialty_tags ?? null;
                            $specialties = [];
                            if ($specTags && is_string($specTags)) {
                                $specTags = trim($specTags, '"');
                                $specialties = json_decode($specTags, true) ?? [];
                            }
                        @endphp
                        @if($specialties && is_array($specialties) && count($specialties) > 0)
                            @foreach($specialties as $spec)
                                <span class="px-2 py-1 bg-fitar-card rounded-lg text-xs text-gray-300">
                                    {{ ucfirst($spec) }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>
                @endif

                @if(Auth::check() && $mechanic->id !== Auth::id())
                    <div class="mt-6">
                        <a href="{{ route('chat.start', $mechanic->id) }}" class="block w-full bg-fitar-accent hover:bg-fitar-accent-hover text-white px-4 py-2 rounded-lg transition">
                            💬 Send Message
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column - Reviews -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Review Form -->
            @auth
                @if(Auth::user()->role === 'user' && Auth::id() !== $mechanic->id)
                <div class="bg-fitar-surface border border-white/10 rounded-xl p-6">
                    <h2 class="text-lg font-heading font-bold text-white mb-4">✍️ Write a Review for {{ $mechanic->username ?? $mechanic->name }}</h2>
                    
                    @if(session('success'))
                        <div class="bg-green-500/20 border border-green-500 rounded-lg p-3 mb-4">
                            <p class="text-green-400 text-sm">{{ session('success') }}</p>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="bg-red-500/20 border border-red-500 rounded-lg p-3 mb-4">
                            @foreach($errors->all() as $error)
                                <p class="text-red-400 text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="reviewable_type" value="App\Models\User">
                        <input type="hidden" name="reviewable_id" value="{{ $mechanic->id }}">
                        
                        <div class="mb-4">
                            <label class="block text-gray-300 text-sm font-medium mb-2">Rating</label>
                            <div class="flex gap-1">
                                <button type="button" onclick="setRating(1)" class="rating-star text-3xl text-gray-500 hover:text-yellow-400 transition" data-rating="1">☆</button>
                                <button type="button" onclick="setRating(2)" class="rating-star text-3xl text-gray-500 hover:text-yellow-400 transition" data-rating="2">☆</button>
                                <button type="button" onclick="setRating(3)" class="rating-star text-3xl text-gray-500 hover:text-yellow-400 transition" data-rating="3">☆</button>
                                <button type="button" onclick="setRating(4)" class="rating-star text-3xl text-gray-500 hover:text-yellow-400 transition" data-rating="4">☆</button>
                                <button type="button" onclick="setRating(5)" class="rating-star text-3xl text-gray-500 hover:text-yellow-400 transition" data-rating="5">☆</button>
                            </div>
                            <input type="hidden" name="rating" id="ratingValue" required>
                            <div id="ratingText" class="text-yellow-400 text-sm mt-1"></div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-300 text-sm font-medium mb-2">Your Review</label>
                            <textarea name="review_text" rows="4" required class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none" placeholder="Share your experience with {{ $mechanic->username ?? $mechanic->name }}..."></textarea>
                        </div>
                        
                        <button type="submit" class="bg-fitar-accent hover:bg-fitar-accent-hover text-white px-6 py-2 rounded-lg transition">
                            Submit Review
                        </button>
                    </form>
                </div>
                @endif
            @else
                <div class="bg-fitar-surface border border-white/10 rounded-xl p-6 text-center">
                    <p class="text-gray-400">Please <a href="{{ route('login') }}" class="text-fitar-accent hover:underline">login</a> to write a review.</p>
                </div>
            @endauth

            <!-- Customer Reviews Section -->
            <div class="bg-fitar-surface border border-white/10 rounded-xl p-6">
                <h2 class="text-xl font-heading font-bold text-white mb-4">⭐ Customer Reviews for {{ $mechanic->username ?? $mechanic->name }}</h2>
                
                @php
                    $reviews = \App\Models\Review::where('reviewable_type', 'App\Models\User')
                        ->where('reviewable_id', $mechanic->id)
                        ->where('is_approved', true)
                        ->with('user')
                        ->orderBy('created_at', 'desc')
                        ->get();
                @endphp
                
                @if($reviews->count() > 0)
                    <div class="space-y-4">
                        @foreach($reviews as $review)
                        <div class="border-b border-white/10 pb-4 last:border-0 last:pb-0">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div style="width: 32px; height: 32px; border-radius: 50% !important; overflow: hidden; background-color: #1f2937;">
                                        @if($review->user && $review->user->profile_photo_path && Storage::disk('public')->exists($review->user->profile_photo_path))
                                            <img src="{{ Storage::url($review->user->profile_photo_path) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #F47920, #d46218); display: flex; align-items: center; justify-content: center;">
                                                <span style="font-size: 14px; font-weight: bold; color: white;">{{ strtoupper(substr($review->user ? $review->user->name : 'U', 0, 1)) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="/profile/{{ $review->user_id }}" class="text-white text-sm hover:text-fitar-accent transition font-medium">
                                            {{ $review->user ? ($review->user->username ?? $review->user->name) : 'User' }}
                                        </a>
                                        <p class="text-gray-500 text-xs">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="text-yellow-500 text-sm">
                                    {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                </div>
                            </div>
                            <p class="text-gray-300 text-sm mt-2">"{{ $review->review_text_en ?? $review->review_text_ku }}"</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-4xl mb-2">⭐</p>
                        <p class="text-gray-400">No reviews yet</p>
                        <p class="text-gray-500 text-sm">Be the first to review {{ $mechanic->username ?? $mechanic->name }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    let currentRating = 0;
    const stars = document.querySelectorAll('.rating-star');
    
    function updateStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.innerHTML = '★';
                star.classList.remove('text-gray-500');
                star.classList.add('text-yellow-400');
            } else {
                star.innerHTML = '☆';
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-500');
            }
        });
        
        const ratingTexts = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
        document.getElementById('ratingText').innerHTML = ratingTexts[rating] + ' - ' + rating + ' out of 5';
    }
    
    function setRating(rating) {
        currentRating = rating;
        document.getElementById('ratingValue').value = rating;
        updateStars(rating);
    }
    
    stars.forEach(star => {
        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            updateStars(rating);
        });
        
        star.addEventListener('mouseleave', function() {
            updateStars(currentRating);
        });
    });
</script>
@endsection