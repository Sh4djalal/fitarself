@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Ad Carousel -->
    @if($ads->count() > 0)
    <div class="bg-white dark:bg-fitar-surface/50 border border-gray-200 dark:border-white/10 rounded-2xl p-6 mb-8 shadow-sm dark:shadow-none">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-heading font-bold text-gray-900 dark:text-white">📢 Sponsored</h3>
            <span class="text-xs text-gray-400 dark:text-gray-500">Paid Promotion</span>
        </div>
        <div class="relative overflow-hidden rounded-xl h-48">
            @foreach($ads as $index => $ad)
            <div class="ad-slide absolute inset-0 transition-opacity duration-500 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" data-slide="{{ $index }}">
                <div class="bg-gray-100 dark:bg-fitar-card/50 rounded-xl h-48 flex flex-col items-center justify-center text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-white/5 p-6">
                    <p class="text-2xl font-bold text-fitar-accent mb-2">{{ $ad->title_en }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ad->sponsor_name }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="flex justify-center gap-2 mt-4">
            @foreach($ads as $index => $ad)
            <button onclick="showSlide({{ $index }})" class="w-2 h-2 rounded-full {{ $index === 0 ? 'bg-fitar-accent' : 'bg-gray-300 dark:bg-gray-600' }} transition-all" data-dot="{{ $index }}"></button>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Popular Cars -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-heading font-bold text-gray-900 dark:text-white">🚗 Popular Cars</h2>
            <a href="/cars" class="text-fitar-accent hover:text-fitar-accent-hover font-medium text-sm">View All →</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($popularCars as $car)
            <a href="/cars/{{ $car->id }}?from=home" class="bg-white dark:bg-fitar-surface/50 border border-gray-200 dark:border-white/10 rounded-xl overflow-hidden hover:border-fitar-accent/50 hover:shadow-lg transition-all group shadow-sm dark:shadow-none">
                @php
                    $homeCardImage = null;
                    $homePath = public_path('images/' . $car->image_path);
                    if ($car->image_path && is_dir($homePath)) {
                        $homeFiles = glob($homePath . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
                        if (count($homeFiles) > 0) {
                            $homeCardImage = '/images/' . $car->image_path . '/' . basename($homeFiles[0]);
                        }
                    } elseif ($car->image_path && file_exists(public_path('images/' . $car->image_path . '.jpg'))) {
                        $homeCardImage = '/images/' . $car->image_path . '.jpg';
                    } elseif ($car->image_path && file_exists(public_path('images/' . $car->image_path . '.png'))) {
                        $homeCardImage = '/images/' . $car->image_path . '.png';
                    }
                @endphp
                <div class="h-40 bg-gray-100 dark:bg-fitar-card flex items-center justify-center text-4xl overflow-hidden">
                    @if($homeCardImage)
                    <img src="{{ $homeCardImage }}" alt="{{ $car->make }} {{ $car->model }}" class="w-full h-full object-cover">
                    @else
                    🏎️
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $car->make }} {{ $car->model }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $car->year }} • {{ $car->body_type ?? 'Car' }}</p>
                    <div class="flex items-center gap-1 mt-2">
                        <span class="text-yellow-500">{{ str_repeat('★', floor($car->average_rating)) }}</span>
<span class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($car->average_rating, 1) }} ★ ({{ $car->review_count }} reviews)</span>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-4 text-center text-gray-400 dark:text-gray-500 py-8">No cars found.</div>
            @endforelse
        </div>
    </section>

    <!-- Common Fault Codes -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-heading font-bold text-gray-900 dark:text-white">⚡ Common Fault Codes</h2>
            <a href="/fault-codes" class="text-fitar-accent hover:text-fitar-accent-hover font-medium text-sm">View All →</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse($faultCodes as $code)
            <a href="/fault-codes/{{ $code->id }}" class="bg-white dark:bg-fitar-surface/50 border border-gray-200 dark:border-white/10 rounded-xl p-4 hover:border-{{ $code->severity_color }}-500/50 transition-all shadow-sm dark:shadow-none">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-lg font-mono font-bold text-gray-900 dark:text-white">{{ $code->code }}</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $code->severity_color }}-100 dark:bg-{{ $code->severity_color }}-500/20 text-{{ $code->severity_color }}-700 dark:text-{{ $code->severity_color }}-400 capitalize">{{ $code->severity }}</span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $code->title_en }}</p>
            </a>
            @empty
            <div class="col-span-4 text-center text-gray-400 dark:text-gray-500 py-8">No fault codes found.</div>
            @endforelse
        </div>
    </section>

    <!-- Featured Mechanics -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-heading font-bold text-gray-900 dark:text-white">🔧 Featured Mechanics</h2>
            <a href="/mechanics" class="text-fitar-accent hover:text-fitar-accent-hover font-medium text-sm">View All →</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($mechanics as $mechanic)
            <a href="/mechanics/{{ $mechanic->id }}" class="bg-white dark:bg-fitar-surface/50 border border-gray-200 dark:border-white/10 rounded-xl p-5 hover:border-fitar-accent/50 transition-all shadow-sm dark:shadow-none">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-gray-200 dark:bg-fitar-card flex items-center justify-center text-2xl overflow-hidden">
                        <img src="{{ $mechanic->profile_photo_url }}" alt="{{ $mechanic->name }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $mechanic->name }}</h3>
                        <span class="text-xs text-green-600 dark:text-green-400">✅ Verified</span>
                    </div>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-3">{{ $mechanic->mechanicDetail?->specialization_en ?? 'Mechanic' }}</p>
                <p class="text-sm text-gray-400 dark:text-gray-500">📍 {{ $mechanic->city ?? 'Iraq' }}</p>
                <div class="flex items-center gap-1 mt-2">
                    <span class="text-yellow-500">★★★★★</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $mechanic->reviews->avg('rating') ? number_format($mechanic->reviews->avg('rating'), 1) : '5.0' }} ({{ $mechanic->reviews->count() }})</span>
                </div>
            </a>
            @empty
            <div class="col-span-3 text-center text-gray-400 dark:text-gray-500 py-8">No mechanics found.</div>
            @endforelse
        </div>
    </section>

</div>

<script>
    let currentSlide = 0;
    const totalSlides = {{ $ads->count() }};
    function showSlide(index) {
        document.querySelectorAll('.ad-slide').forEach((slide, i) => {
            slide.classList.toggle('opacity-100', i === index);
            slide.classList.toggle('opacity-0', i !== index);
        });
        document.querySelectorAll('[data-dot]').forEach((dot, i) => {
            dot.classList.toggle('bg-fitar-accent', i === index);
            dot.classList.toggle('bg-gray-300', i !== index);
            dot.classList.toggle('dark:bg-gray-600', i !== index);
        });
        currentSlide = index;
    }
    setInterval(() => {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }, 4000);
</script>
@endsection