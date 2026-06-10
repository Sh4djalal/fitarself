@extends('layouts.app')

@section('title', 'Mechanic Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    @if(session('success'))
    <div id="successMessage" class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 bg-green-500/90 backdrop-blur-md border border-green-400 rounded-lg px-6 py-3 shadow-lg animate-slide-down">
        <div class="flex items-center gap-3">
            <span class="text-green-400 text-xl">✅</span>
            <p class="text-white font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-heading font-bold text-white">🔧 Welcome, {{ Auth::user()->name }}</h1>
            <p class="text-gray-400 mt-1">Manage your mechanic profile and services.</p>
        </div>
        <a href="{{ route('profile.edit') }}" class="bg-fitar-accent hover:bg-fitar-accent-hover text-white px-4 py-2 rounded-lg transition text-sm font-medium">
            ✏️ Edit Profile
        </a>
    </div>

    <!-- Verification Status Card -->
    <div class="bg-fitar-surface border border-white/10 rounded-xl p-6 mb-8">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <div class="text-4xl">
                    @if(Auth::user()->is_verified_mechanic)
                        ✅
                    @elseif(Auth::user()->mechanicDocument && Auth::user()->mechanicDocument->status === 'pending')
                        ⏳
                    @elseif(Auth::user()->mechanicDocument && Auth::user()->mechanicDocument->status === 'rejected')
                        ❌
                    @else
                        ⚠️
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white">Verification Status</h3>
                    @if(Auth::user()->is_verified_mechanic)
                        <p class="text-green-400 text-lg font-bold">✅ APPROVED! You are a verified mechanic.</p>
                        <p class="text-gray-400 text-sm">Customers can now trust your services. You will appear in mechanic listings.</p>
                    @elseif(Auth::user()->mechanicDocument && Auth::user()->mechanicDocument->status === 'pending')
                        <p class="text-yellow-400">⏳ Your documents are being reviewed. We'll notify you once verified.</p>
                    @elseif(Auth::user()->mechanicDocument && Auth::user()->mechanicDocument->status === 'rejected')
                        <p class="text-red-400">❌ Your verification was rejected. Please resubmit with correct documents.</p>
                        @if(Auth::user()->mechanicDocument->rejection_reason)
                            <p class="text-gray-400 text-sm mt-1">Reason: {{ Auth::user()->mechanicDocument->rejection_reason }}</p>
                        @endif
                    @else
                        <p class="text-orange-400">⚠️ You are not verified yet. Complete verification to appear in mechanic listings.</p>
                    @endif
                </div>
            </div>
            @if(!Auth::user()->is_verified_mechanic)
                <a href="{{ route('mechanic.verify-form') }}" class="bg-fitar-accent hover:bg-fitar-accent-hover text-white px-6 py-2 rounded-lg font-medium transition">
                    @if(Auth::user()->mechanicDocument && Auth::user()->mechanicDocument->status === 'pending')
                        📄 View Application Status
                    @elseif(Auth::user()->mechanicDocument && Auth::user()->mechanicDocument->status === 'rejected')
                        📤 Resubmit Documents
                    @else
                        📝 Submit Verification Documents
                    @endif
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Profile Card -->
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6 text-center">
                <div class="w-24 h-24 rounded-full bg-fitar-card flex items-center justify-center text-3xl overflow-hidden mx-auto mb-4 ring-2 ring-fitar-accent/50">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                </div>
                <h2 class="text-xl font-heading font-bold text-white">{{ Auth::user()->name }}</h2>
                <p class="text-fitar-accent text-sm font-mono mb-2">@ {{ Auth::user()->username }}</p>
                <p class="text-gray-400 text-sm">{{ Auth::user()->email }}</p>
                
                @if(Auth::user()->city)
                <div class="mt-4 pt-3 border-t border-white/10">
                    <p class="text-gray-400 text-sm">📍 {{ Auth::user()->city }}</p>
                </div>
                @endif
                @if(Auth::user()->phone)
                <div class="mt-2">
                    <p class="text-gray-400 text-sm">📞 {{ Auth::user()->phone }}</p>
                </div>
                @endif
                
                @if(Auth::user()->bio_en)
                <div class="mt-4 pt-3 border-t border-white/10">
                    <p class="text-gray-400 text-sm">📝 Bio</p>
                    <p class="text-white text-sm mt-1">{{ Auth::user()->bio_en }}</p>
                </div>
                @endif
            </div>

            <!-- Stats Cards -->
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-5">
                <h3 class="text-sm font-semibold text-gray-400 mb-3">📊 Your Stats</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-400 text-sm">⭐ Reviews Received</span>
                        <span class="text-white font-bold">{{ Auth::user()->reviews()->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400 text-sm">⭐ Average Rating</span>
                        <span class="text-white font-bold">
                            @php
                                $avgRating = Auth::user()->reviews()->avg('rating');
                            @endphp
                            {{ number_format($avgRating ?: 0, 1) }} / 5.0
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400 text-sm">💬 Messages</span>
                        <span class="text-white font-bold">{{ Auth::user()->messages()->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400 text-sm">🔧 Experience Years</span>
                        <span class="text-white font-bold">
                            @if(Auth::user()->mechanicDetail && Auth::user()->mechanicDetail->experience_years)
                                {{ Auth::user()->mechanicDetail->experience_years }} years
                            @else
                                Not specified
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Specializations -->
            @if(Auth::user()->mechanicDetail && Auth::user()->mechanicDetail->specialty_tags)
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-5">
                <h3 class="text-sm font-semibold text-gray-400 mb-3">🔧 Specializations</h3>
                <div class="flex flex-wrap gap-2">
                    @php
                        $specTags = Auth::user()->mechanicDetail->specialty_tags ?? null;
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
                    @else
                        <p class="text-gray-500 text-sm">No specializations added</p>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Right Content - Reviews Section -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <h2 class="text-lg font-heading font-bold text-white mb-4">⭐ Customer Reviews</h2>
                
                @php
                    $reviews = Auth::user()->reviews()->with('user')->latest()->take(5)->get();
                @endphp
                
                @if($reviews->count() > 0)
                    <div class="space-y-4">
                        @foreach($reviews as $review)
                        <div class="border-b border-white/10 pb-4 last:border-0 last:pb-0">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-fitar-card flex items-center justify-center text-sm overflow-hidden">
                                        <img src="{{ $review->user->profile_photo_url }}" alt="" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <span class="text-white text-sm">{{ $review->user->name }}</span>
                                        <p class="text-gray-500 text-xs">@ {{ $review->user->username }}</p>
                                    </div>
                                </div>
                                <div class="text-yellow-500 text-sm">
                                    {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                </div>
                            </div>
                            <p class="text-gray-400 text-sm">{{ $review->review_text_en ?? $review->review_text_ku }}</p>
                            <p class="text-gray-500 text-xs mt-1">{{ $review->created_at->diffForHumans() }}</p>
                        </div>
                        @endforeach
                    </div>
                    
                    @if(Auth::user()->reviews()->count() > 5)
                    <div class="text-center mt-4">
                        <a href="#" class="text-fitar-accent text-sm hover:underline">View all {{ Auth::user()->reviews()->count() }} reviews →</a>
                    </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <p class="text-4xl mb-2">⭐</p>
                        <p class="text-gray-400">No reviews yet</p>
                        <p class="text-gray-500 text-sm">When customers review your work, they'll appear here</p>
                    </div>
                @endif
            </div>

            <!-- Messages Card -->
            <a href="{{ route('chat.index') }}" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-5 hover:border-fitar-accent/50 transition-all block">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">💬</span>
                    <div>
                        <h3 class="text-white font-semibold">Messages</h3>
                        <p class="text-gray-400 text-sm">Chat with customers and sellers</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes slideDown {
        0% { top: -100px; opacity: 0; }
        10% { top: 20px; opacity: 1; }
        90% { top: 20px; opacity: 1; }
        100% { top: -100px; opacity: 0; display: none; }
    }
    .animate-slide-down {
        animation: slideDown 5s ease-in-out forwards;
    }
</style>

<script>
    setTimeout(function() {
        const msg = document.getElementById('successMessage');
        if (msg) msg.style.display = 'none';
    }, 5000);
</script>
@endsection