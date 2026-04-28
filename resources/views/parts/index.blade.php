@extends('layouts.app')

@section('title', 'Parts Marketplace')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-heading font-bold text-white mb-2">🔧 Parts Marketplace</h1>
    <p class="text-gray-400 mb-8">Buy car parts directly from verified mechanics across Iraq.</p>

    <div class="flex gap-3 overflow-x-auto pb-4 mb-6">
        <a href="/parts" class="px-4 py-2 rounded-full text-sm font-medium {{ !request('category') ? 'bg-fitar-accent text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20' }} whitespace-nowrap transition">All</a>
        @foreach($categories as $cat)
        <a href="/parts?category={{ $cat }}" class="px-4 py-2 rounded-full text-sm font-medium {{ request('category') == $cat ? 'bg-fitar-accent text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20' }} whitespace-nowrap transition capitalize">{{ $cat }}</a>
        @endforeach
    </div>

    <form action="/parts" class="mb-8">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search parts by name or part number..." 
            class="w-full max-w-md px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:border-fitar-accent">
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($parts as $part)
        <a href="/parts/{{ $part->id }}" class="bg-fitar-surface/50 border border-white/10 rounded-xl overflow-hidden hover:border-fitar-accent/50 hover:shadow-lg transition-all group">
            <div class="h-40 bg-fitar-card flex items-center justify-center text-4xl">🔧</div>
            <div class="p-4">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs px-2 py-0.5 bg-fitar-accent/20 text-fitar-accent rounded-full capitalize">{{ $part->condition }}</span>
                    <span class="text-xs text-gray-500">{{ $part->brand }}</span>
                </div>
                <h3 class="font-semibold text-white mt-2">{{ $part->name_en }}</h3>
                <p class="text-xs text-gray-400 mt-1">#{{ $part->part_number }}</p>
                
                <!-- Seller Info -->
                @if($part->seller)
                <div class="flex items-center gap-2 mt-2 py-2 border-t border-white/5">
                    <div class="w-6 h-6 rounded-full bg-fitar-card flex items-center justify-center overflow-hidden">
                        <img src="{{ $part->seller->profile_photo_url }}" alt="{{ $part->seller->name }}" class="w-full h-full object-cover">
                    </div>
                    <span class="text-xs text-gray-400">{{ $part->seller->name }}</span>
                    @if($part->seller->is_verified_mechanic)
                    <span class="text-xs text-green-400">✅</span>
                    @endif
                </div>
                @endif

                <div class="flex items-center justify-between mt-2">
                    <span class="text-lg font-bold text-fitar-accent">{{ number_format($part->price) }} IQD</span>
                    <span class="text-xs {{ $part->in_stock ? 'text-green-400' : 'text-red-400' }}">{{ $part->in_stock ? 'In Stock' : 'Out of Stock' }}</span>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full text-center text-gray-500 py-16">
            <p class="text-4xl mb-2">🔧</p><p>No parts found.</p>
        </div>
        @endforelse
    </div>
    <div class="mt-8">{{ $parts->links() }}</div>
</div>
@endsection