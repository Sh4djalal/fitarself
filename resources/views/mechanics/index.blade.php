@extends('layouts.app')

@section('title', 'Verified Mechanics')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    
    <h1 class="text-3xl font-bold text-white mb-2">🔧 Verified Mechanics</h1>
    <p class="text-gray-400 mb-8">Find trusted mechanics and workshops across Iraq.</p>

    <!-- Filter Buttons -->
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="?specialty=all" class="px-4 py-2 rounded-lg {{ request('specialty', 'all') == 'all' ? 'bg-fitar-accent text-white' : 'bg-fitar-surface text-gray-400 border border-white/10' }}">All</a>
        <a href="?specialty=engine" class="px-4 py-2 rounded-lg {{ request('specialty') == 'engine' ? 'bg-fitar-accent text-white' : 'bg-fitar-surface text-gray-400 border border-white/10' }}">🔧 Engine</a>
        <a href="?specialty=electrical" class="px-4 py-2 rounded-lg {{ request('specialty') == 'electrical' ? 'bg-fitar-accent text-white' : 'bg-fitar-surface text-gray-400 border border-white/10' }}">⚡ Electrical</a>
        <a href="?specialty=diagnostics" class="px-4 py-2 rounded-lg {{ request('specialty') == 'diagnostics' ? 'bg-fitar-accent text-white' : 'bg-fitar-surface text-gray-400 border border-white/10' }}">📱 Diagnostics</a>
        <a href="?specialty=brakes" class="px-4 py-2 rounded-lg {{ request('specialty') == 'brakes' ? 'bg-fitar-accent text-white' : 'bg-fitar-surface text-gray-400 border border-white/10' }}">🛞 Brakes</a>
        <a href="?specialty=turbo" class="px-4 py-2 rounded-lg {{ request('specialty') == 'turbo' ? 'bg-fitar-accent text-white' : 'bg-fitar-surface text-gray-400 border border-white/10' }}">💨 Turbo</a>
        <a href="?specialty=transmission" class="px-4 py-2 rounded-lg {{ request('specialty') == 'transmission' ? 'bg-fitar-accent text-white' : 'bg-fitar-surface text-gray-400 border border-white/10' }}">🔧 Transmission</a>
        <a href="?specialty=ac" class="px-4 py-2 rounded-lg {{ request('specialty') == 'ac' ? 'bg-fitar-accent text-white' : 'bg-fitar-surface text-gray-400 border border-white/10' }}">❄️ AC</a>
        <a href="?specialty=suspension" class="px-4 py-2 rounded-lg {{ request('specialty') == 'suspension' ? 'bg-fitar-accent text-white' : 'bg-fitar-surface text-gray-400 border border-white/10' }}">🔩 Suspension</a>
        <a href="?specialty=oil" class="px-4 py-2 rounded-lg {{ request('specialty') == 'oil' ? 'bg-fitar-accent text-white' : 'bg-fitar-surface text-gray-400 border border-white/10' }}">🛢️ Oil</a>
        <a href="?specialty=body" class="px-4 py-2 rounded-lg {{ request('specialty') == 'body' ? 'bg-fitar-accent text-white' : 'bg-fitar-surface text-gray-400 border border-white/10' }}">🎨 Body</a>
        <a href="?specialty=tuning" class="px-4 py-2 rounded-lg {{ request('specialty') == 'tuning' ? 'bg-fitar-accent text-white' : 'bg-fitar-surface text-gray-400 border border-white/10' }}">💻 Tuning</a>
    </div>

    <!-- Mechanics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($mechanics as $mechanic)
        <div class="bg-fitar-surface border border-white/10 rounded-xl p-5 hover:border-fitar-accent/50 transition-all">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-full bg-fitar-card flex items-center justify-center text-2xl overflow-hidden">
                        <img src="{{ $mechanic->profile_photo_url }}" alt="{{ $mechanic->name }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">{{ $mechanic->username ?? $mechanic->name }}</h3>
                        <div class="flex items-center gap-2 mt-1">
                            @if($mechanic->is_verified_mechanic)
                                <span class="text-xs bg-green-500/20 text-green-400 px-2 py-0.5 rounded-full">✅ Verified</span>
                            @else
                                <span class="text-xs bg-yellow-500/20 text-yellow-400 px-2 py-0.5 rounded-full">⏳ Pending Verification</span>
                            @endif
                        </div>
                    </div>
                </div>
                @if($mechanic->id !== Auth::id())
                    <a href="{{ route('chat.start', $mechanic->id) }}" class="text-fitar-accent hover:text-fitar-accent-hover">
                        💬
                    </a>
                @endif
            </div>

            <p class="text-gray-400 text-sm mt-3">
                @php
                    $detail = $mechanic->mechanicDetail;
                    $specs = null;
                    if ($detail && $detail->specialty_tags) {
                        $specs = trim($detail->specialty_tags, '"');
                        $specs = json_decode($specs, true);
                    }
                    if ($specs && is_array($specs) && count($specs) > 0) {
                        echo implode(', ', array_map('ucfirst', $specs));
                    } else {
                        echo 'General Mechanic';
                    }
                @endphp
            </p>
            <p class="text-gray-500 text-sm">📍 {{ $mechanic->city ?? 'Location not specified' }}</p>
            
            @if($mechanic->mechanicDetail && $mechanic->mechanicDetail->experience_years)
            <p class="text-gray-500 text-sm mt-1">⏱️ {{ $mechanic->mechanicDetail->experience_years }} years experience</p>
            @endif

            <div class="flex items-center gap-3 mt-3 pt-3 border-t border-white/10">
                <a href="{{ route('mechanics.show', $mechanic) }}" class="text-fitar-accent text-sm">View Profile →</a>
                @if($mechanic->id !== Auth::id())
                    <a href="{{ route('chat.start', $mechanic->id) }}" class="text-gray-400 text-sm">Message</a>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center text-gray-400 py-8">
            No mechanics found.
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $mechanics->links() }}
    </div>
</div>
@endsection