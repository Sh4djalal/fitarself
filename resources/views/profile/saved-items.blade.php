@extends('layouts.app')

@section('title', 'Saved Items')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">❤️ Saved Items</h1>
            <p class="text-gray-400">All items you have saved</p>
        </div>
        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white">← Back to Dashboard</a>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500 rounded-lg p-3 mb-4">
            <p class="text-green-400 text-sm">{{ session('success') }}</p>
        </div>
    @endif

    @if($savedItems->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($savedItems as $item)
                <div class="bg-fitar-surface border border-white/10 rounded-xl p-4 hover:border-fitar-accent/50 transition-all">
                    @php
                        $savable = $item->savable;
                        $itemType = class_basename($item->savable_type);
                    @endphp
                    
                    @if($itemType === 'Car' && $savable)
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 rounded-lg bg-fitar-card flex items-center justify-center text-2xl">🚗</div>
                            <button onclick="unsaveItem({{ $savable->id }}, 'car', {{ $item->id }})" class="text-red-400 hover:text-red-300 text-sm">Remove</button>
                        </div>
                        <a href="{{ route('cars.show', $savable->id) }}">
                            <h3 class="text-white font-semibold text-lg">{{ $savable->make }} {{ $savable->model }}</h3>
                            <p class="text-gray-400 text-sm">{{ $savable->year }} • {{ $savable->engine_type ?? 'Car' }}</p>
                        </a>
                    @elseif($itemType === 'Part' && $savable)
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 rounded-lg bg-fitar-card flex items-center justify-center text-2xl">🛒</div>
                            <button onclick="unsaveItem({{ $savable->id }}, 'part', {{ $item->id }})" class="text-red-400 hover:text-red-300 text-sm">Remove</button>
                        </div>
                        <a href="{{ route('parts.show', $savable->id) }}">
                            <h3 class="text-white font-semibold text-lg">{{ $savable->name ?? 'Part' }}</h3>
                            <p class="text-gray-400 text-sm">{{ $savable->car_make ?? '' }} {{ $savable->car_model ?? '' }}</p>
                        </a>
                    @elseif($itemType === 'User' && $savable)
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 rounded-lg bg-fitar-card flex items-center justify-center text-2xl">🔧</div>
                            <button onclick="unsaveItem({{ $savable->id }}, 'mechanic', {{ $item->id }})" class="text-red-400 hover:text-red-300 text-sm">Remove</button>
                        </div>
                        <a href="{{ route('mechanics.show', $savable->id) }}">
                            <h3 class="text-white font-semibold text-lg">{{ $savable->name }}</h3>
                            <p class="text-gray-400 text-sm">{{ $savable->city ?? 'Mechanic' }}</p>
                        </a>
                    @else
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 rounded-lg bg-fitar-card flex items-center justify-center text-2xl">📦</div>
                            <button onclick="unsaveItem({{ $item->id }}, 'item', {{ $item->id }})" class="text-red-400 hover:text-red-300 text-sm">Remove</button>
                        </div>
                        <p class="text-gray-400">Item not available</p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-fitar-surface border border-white/10 rounded-xl p-12 text-center">
            <p class="text-6xl mb-4">❤️</p>
            <h3 class="text-white text-xl font-semibold mb-2">No Saved Items</h3>
            <p class="text-gray-400 mb-4">You haven't saved any items yet.</p>
            <a href="{{ route('cars.index') }}" class="inline-block bg-fitar-accent hover:bg-fitar-accent-hover text-white px-6 py-2 rounded-lg transition">Browse Cars to Save</a>
        </div>
    @endif
</div>

<script>
async function unsaveItem(id, type, itemId) {
    if (!confirm('Remove this item from your saved list?')) return;
    
    try {
        const response = await fetch('/save/' + type + '/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Remove the item from the DOM
            const itemElement = document.querySelector(`button[onclick*="unsaveItem(${id},"]`)?.closest('.bg-fitar-surface');
            if (itemElement) itemElement.remove();
            
            // If no items left, show empty state
            if (document.querySelectorAll('.grid > div').length === 0) {
                location.reload();
            }
        } else {
            alert(data.message || 'Failed to remove item');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error removing item');
    }
}
</script>
@endsection