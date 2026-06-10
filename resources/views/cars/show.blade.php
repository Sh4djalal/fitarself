@extends('layouts.app')

@section('title', $car->make . ' ' . $car->model)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    @if(request('from') === 'home')
        <a href="/" class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1">← {{ __('Back to Home') }}</a>
    @elseif(request('from') === 'dashboard')
        <a href="/dashboard" class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1">← {{ __('Back to Dashboard') }}</a>
    @elseif(request('from') === 'brand')
        <a href="/cars?make={{ request('make', $car->make) }}" class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1">← {{ __('Back to') }} {{ request('make', $car->make) }}</a>
    @else
        <a href="/cars" class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1">← {{ __('Back to Cars') }}</a>
    @endif

    <!-- Hero Image from Unsplash -->
    @php
        try {
            $unsplash = new \App\Services\UnsplashService();
            $carYear = $car->year_start ?? $car->year;
            $carImage = $unsplash->searchCarImage($car->make, $car->model, $carYear);
        } catch (\Exception $e) {
            $carImage = null;
        }
        $imageId = 'car_img_' . uniqid();
        $fallbackId = 'fallback_' . uniqid();
    @endphp

    <div class="bg-fitar-surface/50 border border-white/10 rounded-2xl overflow-hidden mb-8 relative">
        @if($carImage && isset($carImage['url']))
            <img id="{{ $imageId }}" 
                 src="{{ $carImage['url'] }}" 
                 alt="{{ $carYear }} {{ $car->make }} {{ $car->model }} - Exterior"
                 class="w-full h-64 sm:h-96 object-cover"
                 loading="eager"
                 onerror="this.style.display='none'; document.getElementById('{{ $fallbackId }}').style.display='flex';">
            <div id="{{ $fallbackId }}" class="h-64 sm:h-96 bg-fitar-card flex flex-col items-center justify-center text-6xl" style="display: none;">
                <div>🏎️</div>
                <p class="text-sm text-gray-400 mt-2">{{ $carYear }} {{ $car->make }} {{ $car->model }}</p>
            </div>
            @if(isset($carImage['photographer']) && $carImage['photographer'] != 'Placeholder Image')
            <p class="absolute bottom-2 right-3 text-[10px] text-gray-400 bg-black/50 px-2 py-0.5 rounded">
                📸 {{ $carImage['photographer'] }} / Unsplash
            </p>
            @endif
        @else
            <div class="h-64 sm:h-96 bg-fitar-card flex flex-col items-center justify-center text-6xl">
                <div>🏎️</div>
                <p class="text-sm text-gray-400 mt-2">{{ $carYear }} {{ $car->make }} {{ $car->model }}</p>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div>
                <div class="flex items-center gap-3 flex-wrap mb-2">
                    <h1 class="text-3xl font-heading font-bold text-white">
                        {{ $car->make }} {{ $car->model }}
                        @if($car->year_start && $car->year_end)
                            {{ $car->year_start }}-{{ $car->year_end }}
                        @else
                            {{ $car->year }}
                        @endif
                    </h1>
                    @if($car->region)
                    <span class="px-3 py-1 bg-fitar-accent/20 text-fitar-accent rounded-full text-xs font-medium">
                        🌍 {{ $car->region }} Spec
                    </span>
                    @endif
                </div>
                <p class="text-gray-400 mt-1">{{ $car->trim ?? '' }} • {{ $car->body_type ?? '' }}</p>
            </div>

            <!-- Specifications -->
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <h2 class="text-xl font-heading font-bold text-white mb-4">📋 {{ __('Specifications') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="flex justify-between py-2 border-b border-white/5"><span class="text-gray-400">{{ __('Engine') }}</span><span class="text-white">{{ $car->engine_type ?? 'N/A' }}</span></div>
                    <div class="flex justify-between py-2 border-b border-white/5"><span class="text-gray-400">{{ __('Horsepower') }}</span><span class="text-white">{{ $car->horsepower ? $car->horsepower.' hp' : 'N/A' }}</span></div>
                    <div class="flex justify-between py-2 border-b border-white/5"><span class="text-gray-400">0-100 km/h</span><span class="text-white">{{ $car->zero_to_100_kmh ? $car->zero_to_100_kmh.' sec' : 'N/A' }}</span></div>
                    <div class="flex justify-between py-2 border-b border-white/5"><span class="text-gray-400">{{ __('Top Speed') }}</span><span class="text-white">{{ $car->top_speed_kmh ? $car->top_speed_kmh.' km/h' : 'N/A' }}</span></div>
                    <div class="flex justify-between py-2 border-b border-white/5"><span class="text-gray-400">{{ __('Transmission') }}</span><span class="text-white">{{ $car->transmission ? ucfirst($car->transmission).($car->gears ? ' ('.$car->gears.'-Speed)' : '') : 'N/A' }}</span></div>
                    <div class="flex justify-between py-2 border-b border-white/5"><span class="text-gray-400">{{ __('Drivetrain') }}</span><span class="text-white">{{ $car->drivetrain ?? 'N/A' }}</span></div>
                </div>
            </div>

            <!-- Oil & Fluids -->
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <h2 class="text-xl font-heading font-bold text-white mb-4">🛢️ {{ __('Oil & Fluids') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="flex justify-between py-2 border-b border-white/5"><span class="text-gray-400">{{ __('Engine Oil Capacity') }}</span><span class="text-white">{{ $car->oil_capacity_l ? $car->oil_capacity_l.' L' : 'N/A' }}</span></div>
                    <div class="flex justify-between py-2 border-b border-white/5"><span class="text-gray-400">{{ __('Oil Type/Density') }}</span><span class="text-white">{{ $car->oil_density_type ?? 'N/A' }}</span></div>
                    <div class="flex justify-between py-2 border-b border-white/5"><span class="text-gray-400">{{ __('Hydraulic Fluid Capacity') }}</span><span class="text-white">{{ $car->hydraulic_capacity_l ? $car->hydraulic_capacity_l.' L' : 'N/A' }}</span></div>
                    <div class="flex justify-between py-2 border-b border-white/5"><span class="text-gray-400">{{ __('Hydraulic Fluid Type') }}</span><span class="text-white">{{ $car->hydraulic_fluid_type ?? 'N/A' }}</span></div>
                </div>
            </div>

            <!-- Fuel Consumption -->
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <h2 class="text-xl font-heading font-bold text-white mb-4">⛽ {{ __('Fuel Consumption') }}</h2>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div><p class="text-2xl font-bold text-white">{{ $car->fuel_combined_l_100km ?? '—' }}</p><p class="text-xs text-gray-400">{{ __('Combined') }}<br>L/100km</p></div>
                    <div><p class="text-2xl font-bold text-white">{{ $car->fuel_city_l_100km ?? '—' }}</p><p class="text-xs text-gray-400">{{ __('City') }}<br>L/100km</p></div>
                    <div><p class="text-2xl font-bold text-white">{{ $car->fuel_highway_l_100km ?? '—' }}</p><p class="text-xs text-gray-400">{{ __('Highway') }}<br>L/100km</p></div>
                </div>
            </div>

            @if($car->description_en)
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <h2 class="text-xl font-heading font-bold text-white mb-4">📝 {{ __('Description') }}</h2>
                <p class="text-gray-300 leading-relaxed">{{ app()->getLocale() == 'ku' ? $car->description_ku : $car->description_en }}</p>
            </div>
            @endif

           

            <!-- Review Form Component -->
            <x-review-form reviewable-type="App\Models\Car" reviewable-id="{{ $car->id }}" reviewable-name="{{ $car->make }} {{ $car->model }}" />

            <!-- Reviews Section -->
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6" id="reviews-section">
                <h2 class="text-lg font-heading font-bold text-white mb-4">💬 {{ __('All Reviews') }} ({{ $car->review_count }})</h2>
                @php $allReviews = $car->reviews()->where('is_approved', true)->latest()->get(); @endphp
                @forelse($allReviews as $review)
                <div class="border-b border-white/5 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-yellow-500 text-sm">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                        <span class="text-sm text-gray-300">{{ $review->user->name ?? 'User' }}</span>
                        <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                        @if(Auth::id() === $review->user_id)
                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Delete this review?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-400 hover:text-red-300">{{ __('Delete') }}</button>
                        </form>
                        @endif
                    </div>
                    <p class="text-gray-400 text-sm">{{ $review->review_text_en ?? $review->review_text_ku }}</p>
                </div>
                @empty
                <p class="text-gray-500 text-sm">{{ __('No reviews yet. Be the first!') }}</p>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6 text-center sticky top-20">
                <div class="text-5xl font-bold text-fitar-accent mb-2">{{ number_format($car->average_rating, 1) }}</div>
                <div class="text-yellow-500 text-xl mb-1">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($car->average_rating))
                            ★
                        @elseif($i - 0.5 <= $car->average_rating)
                            ½
                        @else
                            ☆
                        @endif
                    @endfor
                </div>
                <p class="text-sm text-gray-400 mb-4">{{ $car->review_count }} {{ __('Reviews') }}</p>
                <a href="#write-review" class="block w-full bg-fitar-accent hover:bg-fitar-accent-hover text-white py-2 rounded-lg font-medium transition mb-2">✍️ {{ __('Write a Review') }}</a>
                
                <!-- OWN THIS CAR Button Logic -->
                @php
                    $userCar = Auth::check() ? Auth::user()->cars()->where('car_id', $car->id)->exists() : false;
                    $hasCar = Auth::check() ? Auth::user()->cars()->count() > 0 : false;
                @endphp

                @if(Auth::check() && Auth::user()->role === 'user')
                    @if(!$hasCar && !$userCar)
                        <form action="{{ route('profile.cars.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="car_id" value="{{ $car->id }}">
                            <button type="submit" class="block w-full bg-fitar-accent hover:bg-fitar-accent-hover text-white py-3 rounded-lg font-bold text-sm transition mt-2">🏎️ OWN THIS CAR</button>
                        </form>
                    @elseif($userCar)
                        <div class="block w-full bg-green-500/20 text-green-400 py-3 rounded-lg font-bold text-sm text-center mt-2">
                            ✅ You own this car
                        </div>
                    @else
                        <div class="block w-full bg-gray-500/20 text-gray-400 py-3 rounded-lg font-bold text-sm text-center mt-2">
                            You already own a car
                        </div>
                    @endif
                @elseif(!Auth::check())
                    <a href="{{ route('login') }}" class="block w-full bg-fitar-accent hover:bg-fitar-accent-hover text-white py-3 rounded-lg font-bold text-sm text-center mt-2">🔑 Login to Own This Car</a>
                @endif
                
                <button onclick="toggleSave({{ $car->id }}, 'car')" class="block w-full bg-white/10 hover:bg-white/20 text-white py-2 rounded-lg font-medium transition mt-2" id="saveBtn-{{ $car->id }}">
                    <span id="saveText-{{ $car->id }}">♡ Save</span>
                </button>
            </div>
        </div>
    </div>

    @if(isset($relatedCars) && $relatedCars->count() > 0)
    <div class="mt-12">
        <h2 class="text-xl font-heading font-bold text-white mb-6">{{ __('More from') }} {{ $car->make }}</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($relatedCars as $rc)
            <a href="/cars/{{ $rc->id }}?from=brand&make={{ $rc->make }}" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-3 hover:border-fitar-accent/50 transition-all group">
                @php
                    try {
                        $relUnsplash = new \App\Services\UnsplashService();
                        $relYear = $rc->year_start ?? $rc->year;
                        $relImage = $relUnsplash->searchCarImage($rc->make, $rc->model, $relYear);
                    } catch (\Exception $e) {
                        $relImage = null;
                    }
                    $relImageId = 'rel_img_' . uniqid();
                @endphp
                <div class="h-24 bg-fitar-card rounded-lg flex items-center justify-center text-2xl mb-2 overflow-hidden relative">
                    @if($relImage && isset($relImage['thumb']))
                    <img id="{{ $relImageId }}" src="{{ $relImage['thumb'] }}" alt="{{ $relYear }} {{ $rc->make }} {{ $rc->model }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.style.display='none'; this.parentElement.innerHTML='🏎️'; this.parentElement.classList.add('text-4xl');">
                    @else
                    🏎️
                    @endif
                </div>
                <p class="text-sm font-medium text-white">{{ $rc->model }}</p>
                <p class="text-xs text-gray-400">{{ $rc->year_start ?? $rc->year }}</p>
                @if($rc->region)
                <p class="text-[10px] text-fitar-accent mt-1">🌍 {{ $rc->region }}</p>
                @endif
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
async function toggleSave(id, type) {
    const btn = document.getElementById('saveBtn-' + id);
    const textSpan = document.getElementById('saveText-' + id);
    const isSaved = textSpan.innerHTML === '❤️ Saved';
    
    const method = isSaved ? 'DELETE' : 'POST';
    const url = '/save/' + type + '/' + id;
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        });
        
        const data = await response.json();
        
        if (data.success) {
            if (method === 'POST') {
                textSpan.innerHTML = '❤️ Saved';
                btn.classList.remove('bg-white/10', 'hover:bg-white/20');
                btn.classList.add('bg-red-500/20', 'hover:bg-red-500/30');
            } else {
                textSpan.innerHTML = '♡ Save';
                btn.classList.remove('bg-red-500/20', 'hover:bg-red-500/30');
                btn.classList.add('bg-white/10', 'hover:bg-white/20');
            }
        } else {
            alert(data.message || 'Operation failed');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error: ' + error.message);
    }
}

// Check if item is already saved on page load
async function checkSavedStatus(id, type) {
    try {
        const response = await fetch('/check-saved/' + type + '/' + id, {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        if (data.saved) {
            const textSpan = document.getElementById('saveText-' + id);
            const btn = document.getElementById('saveBtn-' + id);
            textSpan.innerHTML = '❤️ Saved';
            btn.classList.remove('bg-white/10', 'hover:bg-white/20');
            btn.classList.add('bg-red-500/20', 'hover:bg-red-500/30');
        }
    } catch (error) {
        console.error('Error checking saved status:', error);
    }
}

// Check saved status when page loads
checkSavedStatus({{ $car->id }}, 'car');
</script>
@endsection