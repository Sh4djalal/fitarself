@extends('layouts.app')

@section('title', 'Community')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">👥 Community</h1>
        <p class="text-gray-400">Connect with other car enthusiasts and mechanics</p>
    </div>

    <!-- Search Bar - Filters by first letter only -->
    <div class="mb-6">
        <input type="text" id="user-search" placeholder="Search by username (first letter)..." 
            class="w-full max-w-md px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:border-fitar-accent text-lg"
            oninput="filterUsers()">
        <p class="text-gray-500 text-xs mt-2">Type a letter to filter users by the first letter of their username</p>
    </div>

    <!-- Tabs -->
    <div class="flex gap-2 mb-6 border-b border-white/10 pb-3">
        <a href="?tab=users" 
           class="px-4 py-2 rounded-lg transition {{ $tab == 'users' ? 'bg-fitar-accent text-white' : 'text-gray-400 hover:text-white' }}">
            👤 Users ({{ $users->total() }})
        </a>
        <a href="?tab=reviews" 
           class="px-4 py-2 rounded-lg transition {{ $tab == 'reviews' ? 'bg-fitar-accent text-white' : 'text-gray-400 hover:text-white' }}">
            ⭐ Recent Reviews ({{ $reviews->total() }})
        </a>
    </div>

    <!-- Users Tab -->
    @if($tab == 'users')
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="users-grid">
            @forelse($users as $user)
                <div class="user-card bg-fitar-surface border border-white/10 rounded-xl p-4 hover:border-fitar-accent/50 transition-all group" data-username="{{ strtolower($user->username ?? $user->name) }}" data-first-letter="{{ strtolower(substr($user->username ?? $user->name, 0, 1)) }}">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-fitar-card">
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <a href="{{ route('profile.show', $user->id) }}" class="text-white font-semibold hover:text-fitar-accent transition">
                                {{ $user->username ?? $user->name }}
                            </a>
                            <p class="text-gray-400 text-xs">{{ $user->city ?? 'Location not set' }}</p>
                            <span class="text-xs {{ $user->role === 'mechanic' ? 'text-blue-400' : 'text-green-400' }}">
                                {{ $user->role === 'mechanic' ? '🔧 Mechanic' : '👤 User' }}
                            </span>
                        </div>
                        @if(Auth::id() !== $user->id)
                            <a href="{{ route('chat.start', $user->id) }}" class="text-gray-400 hover:text-fitar-accent transition opacity-0 group-hover:opacity-100">
                                💬
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-4xl mb-3">👥</p>
                    <p class="text-gray-400">No users found</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-6">
            {{ $users->appends(['tab' => 'users'])->links() }}
        </div>
    @endif

    <!-- Reviews Tab -->
    @if($tab == 'reviews')
        <div class="space-y-4">
            @forelse($reviews as $review)
                <div class="bg-fitar-surface border border-white/10 rounded-xl p-5 hover:border-fitar-accent/50 transition-all">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden bg-fitar-card">
                                <img src="{{ $review->user->profile_photo_url }}" alt="" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <a href="{{ route('profile.show', $review->user_id) }}" class="text-white font-semibold hover:text-fitar-accent transition">
                                        {{ $review->user->username ?? $review->user->name }}
                                    </a>
                                    <span class="text-gray-500 text-xs">•</span>
                                    <span class="text-gray-500 text-xs">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-yellow-500 text-sm mt-1">
                                    {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                </div>
                            </div>
                        </div>
                        <div>
                            @php
                                $reviewable = $review->reviewable;
                                $reviewableName = '';
                                $reviewableLink = '#';
                                if ($reviewable) {
                                    if ($review->reviewable_type === 'App\\Models\\Car') {
                                        $reviewableName = $reviewable->make . ' ' . $reviewable->model;
                                        $reviewableLink = route('cars.show', $reviewable->id);
                                    } elseif ($review->reviewable_type === 'App\\Models\\User') {
                                        $reviewableName = $reviewable->name . ' (Mechanic)';
                                        $reviewableLink = route('mechanics.show', $reviewable->id);
                                    }
                                }
                            @endphp
                            <a href="{{ $reviewableLink }}" class="text-fitar-accent text-sm hover:underline">
                                {{ $reviewableName }}
                            </a>
                        </div>
                    </div>
                    <p class="text-gray-300 mt-3">{{ $review->review_text_en ?? $review->review_text_ku }}</p>
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-4xl mb-3">⭐</p>
                    <p class="text-gray-400">No reviews found</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-6">
            {{ $reviews->appends(['tab' => 'reviews'])->links() }}
        </div>
    @endif
</div>

<script>
function filterUsers() {
    const search = document.getElementById('user-search').value.toLowerCase();
    const userCards = document.querySelectorAll('.user-card');
    
    // Get only the first character of the search input
    const firstLetter = search.length > 0 ? search.charAt(0) : '';
    
    userCards.forEach(card => {
        const firstLetterData = card.getAttribute('data-first-letter');
        
        if (firstLetter === '') {
            // If search is empty, show all users
            card.style.display = '';
        } else if (firstLetterData === firstLetter) {
            // Show only users whose username starts with the searched letter
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
@endsection