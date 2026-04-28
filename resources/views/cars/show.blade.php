@extends('layouts.app')

@section('title', $car->make . ' ' . $car->model)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    @if(request('from') === 'home')
        <a href="/" class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1">← Back to Home</a>
    @elseif(request('from') === 'dashboard')
        <a href="/dashboard" class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1">← Back to Dashboard</a>
    @elseif(request('from') === 'brand')
        <a href="/cars?make={{ request('make', $car->make) }}" class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1">← Back to {{ request('make', $car->make) }}</a>
    @else
        <a href="/cars" class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1">← Back to Cars</a>
    @endif

    <!-- Hero Image Slider -->
    @php
        $images = [];
        $folderPath = public_path('images/' . $car->image_path);
        if ($car->image_path && is_dir($folderPath)) {
            $files = glob($folderPath . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
            foreach ($files as $file) {
                $images[] = '/images/' . $car->image_path . '/' . basename($file);
            }
        }
    @endphp

    @if(count($images) > 0)
    <div class="bg-fitar-surface/50 border border-white/10 rounded-2xl overflow-hidden mb-8 relative" id="slider-container">
        @foreach($images as $index => $image)
        <div class="slider-slide w-full h-64 sm:h-96 {{ $index === 0 ? '' : 'hidden' }}" data-slide="{{ $index }}">
            <img src="{{ $image }}" alt="{{ $car->make }} {{ $car->model }}" class="w-full h-full object-cover">
        </div>
        @endforeach

        @if(count($images) > 1)
        <button onclick="prevSlide()" class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white w-10 h-10 rounded-full flex items-center justify-center text-xl transition z-10">‹</button>
        <button onclick="nextSlide()" class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white w-10 h-10 rounded-full flex items-center justify-center text-xl transition z-10">›</button>
        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
            @foreach($images as $index => $image)
            <button onclick="goToSlide({{ $index }})" class="slider-dot w-2.5 h-2.5 rounded-full transition-all {{ $index === 0 ? 'bg-fitar-accent w-6' : 'bg-white/50' }}" data-dot="{{ $index }}"></button>
            @endforeach
        </div>
        @endif
    </div>
    @else
    <div class="bg-fitar-surface/50 border border-white/10 rounded-2xl overflow-hidden mb-8">
        <div class="h-64 sm:h-96 bg-fitar-card flex items-center justify-center text-6xl">🏎️</div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div>
                <h1 class="text-3xl font-heading font-bold text-white">{{ $car->make }} {{ $car->model }} {{ $car->year }}</h1>
                <p class="text-gray-400 mt-1">{{ $car->trim ?? '' }} • {{ $car->body_type ?? '' }}</p>
            </div>

            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <h2 class="text-xl font-heading font-bold text-white mb-4">📋 Specifications</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    @php $specs = [['Engine', $car->engine_type], ['Horsepower', $car->horsepower ? $car->horsepower.' hp' : null], ['0-100 km/h', $car->zero_to_100_kmh ? $car->zero_to_100_kmh.' sec' : null], ['Top Speed', $car->top_speed_kmh ? $car->top_speed_kmh.' km/h' : null], ['Transmission', $car->transmission ? ucfirst($car->transmission).($car->gears ? ' ('.$car->gears.'-Speed)' : '') : null], ['Drivetrain', $car->drivetrain]]; @endphp
                    @foreach($specs as $spec)
                    <div class="flex justify-between py-2 border-b border-white/5"><span class="text-gray-400">{{ $spec[0] }}</span><span class="text-white">{{ $spec[1] ?? 'N/A' }}</span></div>
                    @endforeach
                </div>
            </div>

            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <h2 class="text-xl font-heading font-bold text-white mb-4">🛢️ Oil & Fluids</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    @php $fluids = [['Engine Oil Capacity', $car->oil_capacity_l ? $car->oil_capacity_l.' L' : null], ['Oil Type/Density', $car->oil_density_type], ['Hydraulic Fluid Capacity', $car->hydraulic_capacity_l ? $car->hydraulic_capacity_l.' L' : null], ['Hydraulic Fluid Type', $car->hydraulic_fluid_type]]; @endphp
                    @foreach($fluids as $f)
                    <div class="flex justify-between py-2 border-b border-white/5"><span class="text-gray-400">{{ $f[0] }}</span><span class="text-white">{{ $f[1] ?? 'N/A' }}</span></div>
                    @endforeach
                </div>
            </div>

            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <h2 class="text-xl font-heading font-bold text-white mb-4">⛽ Fuel Consumption</h2>
                <div class="grid grid-cols-3 gap-4 text-center">
                    @php $fuel = [['Combined', $car->fuel_combined_l_100km], ['City', $car->fuel_city_l_100km], ['Highway', $car->fuel_highway_l_100km]]; @endphp
                    @foreach($fuel as $f)
                    <div><p class="text-2xl font-bold text-white">{{ $f[1] ?? '—' }}</p><p class="text-xs text-gray-400">{{ $f[0] }}<br>L/100km</p></div>
                    @endforeach
                </div>
            </div>

            @if($car->description_en)
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <h2 class="text-xl font-heading font-bold text-white mb-4">📝 Description</h2>
                <p class="text-gray-300 leading-relaxed">{{ $car->description_en }}</p>
            </div>
            @endif

            @if($car->faultCodes->count() > 0)
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <h2 class="text-xl font-heading font-bold text-white mb-4">🔗 Related Fault Codes</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($car->faultCodes as $fc)
                    <a href="/fault-codes/{{ $fc->id }}" class="px-3 py-1.5 bg-{{ $fc->severity_color }}-500/20 text-{{ $fc->severity_color }}-400 rounded-full text-sm font-mono">{{ $fc->code }}</a>
                    @endforeach
                </div>
            </div>
            @endif

            <x-review-form reviewable-type="App\Models\Car" reviewable-id="{{ $car->id }}" reviewable-name="{{ $car->make }} {{ $car->model }}" />

            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6" id="reviews-section">
                <h2 class="text-lg font-heading font-bold text-white mb-4">💬 All Reviews ({{ $car->review_count }})</h2>
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
                            <button class="text-xs text-red-400 hover:text-red-300">Delete</button>
                        </form>
                        @endif
                    </div>
                    <p class="text-gray-400 text-sm">{{ $review->review_text_en }}</p>
                </div>
                @empty
                <p class="text-gray-500 text-sm">No reviews yet.</p>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6 text-center sticky top-20">
                <p class="text-5xl font-bold text-fitar-accent mb-2">{{ number_format($car->average_rating, 1) }}</p>
                <div class="text-yellow-500 text-xl mb-1">{{ str_repeat('★', floor($car->average_rating)) }}{{ $car->average_rating - floor($car->average_rating) >= 0.5 ? '★' : '☆' }}</div>
                <p class="text-sm text-gray-400 mb-4">{{ $car->review_count }} Reviews</p>
                <a href="#write-review" class="block w-full bg-fitar-accent hover:bg-fitar-accent-hover text-white py-2 rounded-lg font-medium transition mb-2">✍️ Write a Review</a>
                
                <form action="/my-cars" method="POST">
                    @csrf
                    <input type="hidden" name="car_id" value="{{ $car->id }}">
                    <button class="block w-full bg-fitar-accent hover:bg-fitar-accent-hover text-white py-3 rounded-lg font-bold text-sm transition mt-2">🏎️ OWN THIS CAR</button>
                </form>
                
                <button class="block w-full bg-white/10 hover:bg-white/20 text-white py-2 rounded-lg font-medium transition mt-2">♡ Save</button>
            </div>
        </div>
    </div>

   @if($relatedCars->count() > 0)
<div class="mt-12">
    <h2 class="text-xl font-heading font-bold text-white mb-6">More from {{ $car->make }}</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($relatedCars as $rc)
        <a href="/cars/{{ $rc->id }}?from=brand&make={{ $rc->make }}" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-3 hover:border-fitar-accent/50 transition-all">
            @php
                $relImage = null;
                $relPath = public_path('images/' . $rc->image_path);
                if ($rc->image_path && is_dir($relPath)) {
                    $relFiles = glob($relPath . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
                    if (count($relFiles) > 0) {
                        $relImage = '/images/' . $rc->image_path . '/' . basename($relFiles[0]);
                    }
                } elseif ($rc->image_path && file_exists(public_path('images/' . $rc->image_path . '.jpg'))) {
                    $relImage = '/images/' . $rc->image_path . '.jpg';
                } elseif ($rc->image_path && file_exists(public_path('images/' . $rc->image_path . '.png'))) {
                    $relImage = '/images/' . $rc->image_path . '.png';
                }
            @endphp
            <div class="h-24 bg-fitar-card rounded-lg flex items-center justify-center text-2xl mb-2 overflow-hidden">
                @if($relImage)
                <img src="{{ $relImage }}" alt="{{ $rc->make }} {{ $rc->model }}" class="w-full h-full object-cover">
                @else
                🏎️
                @endif
            </div>
            <p class="text-sm font-medium text-white">{{ $rc->model }}</p>
            <p class="text-xs text-gray-400">{{ $rc->year }}</p>
        </a>
        @endforeach
    </div>
</div>
@endif
</div>

<script>
let currentSlide = 0;
const totalSlides = {{ count($images) }};

function showSlide(index) {
    document.querySelectorAll('.slider-slide').forEach((slide, i) => {
        slide.classList.toggle('hidden', i !== index);
    });
    document.querySelectorAll('.slider-dot').forEach((dot, i) => {
        dot.classList.toggle('bg-fitar-accent', i === index);
        dot.classList.toggle('w-6', i === index);
        dot.classList.toggle('bg-white/50', i !== index);
        dot.classList.toggle('w-2.5', i !== index);
    });
    currentSlide = index;
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    showSlide(currentSlide);
}

function goToSlide(index) {
    showSlide(index);
}
</script>
@endsection