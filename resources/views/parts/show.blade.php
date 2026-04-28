@extends('layouts.app')

@section('title', $part->name_en)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <a href="/parts" class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1">← Back to Parts</a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-fitar-surface/50 border border-white/10 rounded-2xl overflow-hidden mb-6">
                <div class="h-64 bg-fitar-card flex items-center justify-center text-6xl">🔧</div>
            </div>

            @if($part->description_en)
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <h2 class="text-lg font-heading font-bold text-white mb-3">📝 Description</h2>
                <p class="text-gray-300">{{ $part->description_en }}</p>
            </div>
            @endif
        </div>
        <div>
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6 sticky top-20">
                <span class="text-xs px-2 py-1 bg-fitar-accent/20 text-fitar-accent rounded-full capitalize">{{ $part->condition }}</span>
                <h1 class="text-2xl font-heading font-bold text-white mt-3">{{ $part->name_en }}</h1>
                <p class="text-gray-400 text-sm mt-1">Brand: {{ $part->brand }}</p>
                <p class="text-gray-500 text-xs mt-1">Part #: {{ $part->part_number }}</p>
                <p class="text-3xl font-bold text-fitar-accent mt-4">{{ number_format($part->price) }} IQD</p>
                <p class="text-sm {{ $part->in_stock ? 'text-green-400' : 'text-red-400' }} mt-1">{{ $part->in_stock ? '✅ In Stock (' . $part->stock_quantity . ' available)' : '❌ Out of Stock' }}</p>

                <!-- Seller Card -->
                @if($part->seller)
                <div class="mt-6 pt-6 border-t border-white/10">
                    <h3 class="font-semibold text-white mb-3">👨‍🔧 Sold by</h3>
                    <a href="/mechanics/{{ $part->seller->id }}" class="flex items-center gap-3 bg-white/5 hover:bg-white/10 rounded-lg p-3 transition">
                        <div class="w-10 h-10 rounded-full bg-fitar-card flex items-center justify-center overflow-hidden">
                            <img src="{{ $part->seller->profile_photo_url }}" alt="{{ $part->seller->name }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">{{ $part->seller->name }}</p>
                            <p class="text-xs text-gray-400">{{ $part->seller->mechanicDetail->workshop_name ?? 'Mechanic' }}</p>
                        </div>
                        @if($part->seller->is_verified_mechanic)
                        <span class="text-green-400 text-xs ml-auto">✅ Verified</span>
                        @endif
                    </a>
                    @if($part->seller->mechanicDetail)
                    <p class="text-xs text-gray-500 mt-2">📍 {{ $part->seller->city ?? 'Iraq' }}</p>
                    <p class="text-xs text-gray-500">📞 {{ $part->seller->mechanicDetail->workshop_phone ?? 'N/A' }}</p>
                    @endif
                </div>
                @endif

                @if($part->in_stock)
                <button class="w-full mt-6 px-6 py-3 bg-fitar-accent hover:bg-fitar-accent-hover text-white rounded-lg font-medium transition">🛒 Add to Cart</button>
                @endif

                <div class="mt-6 pt-6 border-t border-white/10">
                    <h3 class="font-semibold text-white mb-2">Compatible With</h3>
                    @if($part->compatible_cars)
                    <ul class="space-y-1">
                        @foreach(json_decode($part->compatible_cars) as $car)
                        <li class="text-sm text-gray-400">🚗 {{ $car }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($relatedParts->count() > 0)
    <div class="mt-12">
        <h2 class="text-xl font-heading font-bold text-white mb-6">Related Parts</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($relatedParts as $rp)
            <a href="/parts/{{ $rp->id }}" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-3 hover:border-fitar-accent/50 transition-all">
                <div class="h-20 bg-fitar-card rounded-lg flex items-center justify-center text-2xl mb-2">🔧</div>
                <p class="text-sm font-medium text-white truncate">{{ $rp->name_en }}</p>
                <p class="text-xs text-fitar-accent font-bold">{{ number_format($rp->price) }} IQD</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection