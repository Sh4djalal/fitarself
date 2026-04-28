@extends('layouts.app')

@section('title', 'Mechanic Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-heading font-bold text-white mb-8">🔧 Mechanic Dashboard</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Profile Info -->
        <div class="lg:col-span-1">
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6 text-center">
                <div class="w-24 h-24 rounded-full bg-fitar-card flex items-center justify-center text-3xl overflow-hidden mx-auto mb-4 ring-2 ring-fitar-accent/50">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                </div>
                <h2 class="text-xl font-heading font-bold text-white">{{ Auth::user()->name }}</h2>
                <p class="text-gray-400 text-sm">{{ Auth::user()->email }}</p>
                
                @if(Auth::user()->is_verified_mechanic)
                <span class="mt-2 inline-block px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-xs font-medium">✅ Verified</span>
                @else
                <span class="mt-2 inline-block px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-xs font-medium">⏳ Pending Verification</span>
                @endif

                <div class="mt-4 space-y-2 text-sm">
                    @if(Auth::user()->city)
                    <p class="text-gray-400">📍 {{ Auth::user()->city }}</p>
                    @endif
                    @if(Auth::user()->phone)
                    <p class="text-gray-400">📞 {{ Auth::user()->phone }}</p>
                    @endif
                </div>

                <a href="/profile" class="mt-4 inline-flex items-center gap-1 text-fitar-accent hover:text-fitar-accent-hover text-sm font-medium transition">✏️ Edit Profile</a>
            </div>

            <!-- Workshop Info -->
            @php $detail = Auth::user()->mechanicDetail; @endphp
            @if($detail)
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-5 mt-6">
                <h3 class="text-sm font-semibold text-gray-400 mb-3">🏢 Workshop Info</h3>
                <div class="space-y-2 text-sm">
                    <p class="text-gray-300"><span class="text-gray-500">Name:</span> {{ $detail->workshop_name ?? 'Not set' }}</p>
                    <p class="text-gray-300"><span class="text-gray-500">City:</span> {{ $detail->workshop_city ?? 'Not set' }}</p>
                    <p class="text-gray-300"><span class="text-gray-500">Phone:</span> {{ $detail->workshop_phone ?? 'Not set' }}</p>
                    <p class="text-gray-300"><span class="text-gray-500">Experience:</span> {{ $detail->experience_years ?? '0' }} years</p>
                </div>
            </div>
            @endif

            <!-- Specialties -->
            @if($detail && $detail->specialty_tags)
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-5 mt-6">
                <h3 class="text-sm font-semibold text-gray-400 mb-3">📋 My Specialties</h3>
                <div class="flex flex-wrap gap-2">
                    @php $tags = is_string($detail->specialty_tags) ? json_decode($detail->specialty_tags, true) : $detail->specialty_tags; @endphp
                    @if(is_array($tags))
                    @foreach($tags as $tag)
                    <span class="px-3 py-1 bg-fitar-accent/20 text-fitar-accent rounded-full text-xs capitalize">{{ str_replace('-', ' ', $tag) }}</span>
                    @endforeach
                    @endif
                </div>
            </div>
            @endif

            <!-- Stats -->
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6 mt-6">
                <h3 class="text-lg font-heading font-bold text-white mb-4">📊 My Stats</h3>
                <div class="space-y-3">
                    @php
                        $myReviewsCount = App\Models\Review::where('reviewable_type', 'App\Models\User')
                            ->where('reviewable_id', Auth::id())
                            ->count();
                        $myRating = App\Models\Review::where('reviewable_type', 'App\Models\User')
                            ->where('reviewable_id', Auth::id())
                            ->avg('rating') ?? 0;
                        $myMessages = App\Models\Message::where('receiver_id', Auth::id())
                            ->where('is_read', false)
                            ->count();
                    @endphp
                    <div class="flex justify-between">
                        <span class="text-gray-400 text-sm">Rating</span>
                        <span class="text-yellow-500 font-bold">⭐ {{ number_format($myRating, 1) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400 text-sm">Reviews</span>
                        <span class="text-white font-bold">{{ $myReviewsCount }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400 text-sm">Unread Messages</span>
                        <span class="text-fitar-accent font-bold">{{ $myMessages }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Activity -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Reviews from Customers -->
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <h2 class="text-lg font-heading font-bold text-white mb-4">⭐ Customer Reviews</h2>
                @php 
                    $customerReviews = App\Models\Review::where('reviewable_type', 'App\Models\User')
                        ->where('reviewable_id', Auth::id())
                        ->latest()
                        ->take(10)
                        ->get(); 
                @endphp
                @forelse($customerReviews as $review)
                <div class="border-b border-white/5 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-yellow-500 text-sm">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                        <span class="text-sm text-gray-300">{{ $review->user->name ?? 'Customer' }}</span>
                        <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-400">{{ $review->review_text_en }}</p>
                </div>
                @empty
                <p class="text-gray-500 text-sm">No customer reviews yet.</p>
                @endforelse
            </div>

            <!-- Messages -->
            <a href="/chat" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-5 hover:border-fitar-accent/50 transition-all block">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">💬</span>
                    <div>
                        <h3 class="text-white font-semibold">Messages</h3>
                        <p class="text-gray-400 text-sm">Chat with customers</p>
                        @if($myMessages > 0)
                        <span class="text-fitar-accent text-xs">{{ $myMessages }} unread</span>
                        @endif
                    </div>
                </div>
            </a>

            <!-- Sell Parts -->
            <a href="/parts" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-5 hover:border-fitar-accent/50 transition-all block">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">🔧</span>
                    <div>
                        <h3 class="text-white font-semibold">Parts Marketplace</h3>
                        <p class="text-gray-400 text-sm">Sell parts to customers</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection