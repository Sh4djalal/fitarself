@extends('layouts.app')

@section('title', 'Mechanics')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-heading font-bold text-white mb-2">👨‍🔧 Verified Mechanics</h1>
    <p class="text-gray-400 mb-8">Find trusted mechanics and workshops across Iraq.</p>

    <!-- Specialty Filters -->
    <div class="flex gap-3 overflow-x-auto pb-4 mb-8">
        <a href="/mechanics" class="px-4 py-2 rounded-full text-sm font-medium {{ !request('specialty') ? 'bg-fitar-accent text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20' }} whitespace-nowrap transition">All</a>
        <a href="/mechanics?specialty=engine-diagnostics" class="px-4 py-2 rounded-full text-sm font-medium {{ request('specialty') == 'engine-diagnostics' ? 'bg-fitar-accent text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20' }} whitespace-nowrap transition">🔧 Engine</a>
        <a href="/mechanics?specialty=electrical" class="px-4 py-2 rounded-full text-sm font-medium {{ request('specialty') == 'electrical' ? 'bg-fitar-accent text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20' }} whitespace-nowrap transition">⚡ Electrical</a>
        <a href="/mechanics?specialty=diagnostics" class="px-4 py-2 rounded-full text-sm font-medium {{ request('specialty') == 'diagnostics' ? 'bg-fitar-accent text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20' }} whitespace-nowrap transition">📱 Diagnostics</a>
        <a href="/mechanics?specialty=brakes" class="px-4 py-2 rounded-full text-sm font-medium {{ request('specialty') == 'brakes' ? 'bg-fitar-accent text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20' }} whitespace-nowrap transition">🛞 Brakes</a>
        <a href="/mechanics?specialty=turbo-repair" class="px-4 py-2 rounded-full text-sm font-medium {{ request('specialty') == 'turbo-repair' ? 'bg-fitar-accent text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20' }} whitespace-nowrap transition">🔧 Turbo</a>
    </div>

    <!-- Mechanics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($mechanics as $mechanic)
        <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-5 hover:border-fitar-accent/50 transition-all">
            <a href="/mechanics/{{ $mechanic->id }}">
                <div class="flex items-center gap-4 mb-3">
                    <div class="w-16 h-16 rounded-full bg-fitar-card flex items-center justify-center text-2xl overflow-hidden">
                        <img src="{{ $mechanic->profile_photo_url }}" alt="{{ $mechanic->name }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h3 class="font-semibold text-white text-lg">{{ $mechanic->name }}</h3>
                        <span class="text-xs text-green-400">✅ Verified</span>
                    </div>
                </div>
                <p class="text-sm text-gray-400">{{ $mechanic->mechanicDetail?->specialization_en ?? 'Mechanic' }}</p>
                <p class="text-sm text-gray-500">
                    📍 {{ $mechanic->city ?? 'Iraq' }}
                    @if($mechanic->mechanicDetail && $mechanic->mechanicDetail->latitude)
                    <a href="https://www.google.com/maps?q={{ $mechanic->mechanicDetail->latitude }},{{ $mechanic->mechanicDetail->longitude }}" 
                       target="_blank" 
                       class="text-fitar-accent hover:underline ml-1 text-xs"
                       onclick="event.stopPropagation()">
                       📌 View on Map
                    </a>
                    @endif
                </p>
                <p class="text-sm text-gray-500">🏢 {{ $mechanic->mechanicDetail?->workshop_name ?? 'Workshop' }}</p>
                <div class="flex items-center gap-1 mt-2">
                    <span class="text-yellow-500">★</span>
                    <span class="text-sm text-gray-300">{{ $mechanic->reviews->avg('rating') ? number_format($mechanic->reviews->avg('rating'), 1) : 'New' }}</span>
                    <span class="text-xs text-gray-500">({{ $mechanic->reviews->count() }})</span>
                </div>
            </a>
            <a href="/chat/start/{{ $mechanic->id }}" class="mt-3 block text-center px-4 py-2 bg-fitar-accent hover:bg-fitar-accent-hover text-white rounded-lg text-sm font-medium transition">💬 Message</a>
        </div>
        @empty
        <div class="col-span-full text-center text-gray-500 py-16">
            <p class="text-xl mb-2">👨‍🔧</p>
            <p>No mechanics found.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $mechanics->links() }}
    </div>
</div>
@endsection