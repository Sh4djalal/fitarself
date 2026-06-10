@extends('layouts.app')

@section('title', __('Home'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Ad Carousel -->
    @if($ads->count() > 0)
    <div class="bg-white dark:bg-fitar-surface/50 border border-gray-200 dark:border-white/10 rounded-2xl p-6 mb-8 shadow-sm dark:shadow-none">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-heading font-bold text-gray-900 dark:text-white">📢 {{ __('Sponsored') }}</h3>
            <span class="text-xs text-gray-400 dark:text-gray-500">{{ __('Paid Promotion') }}</span>
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
            <h2 class="text-2xl font-heading font-bold text-gray-900 dark:text-white">🚗 {{ __('Popular Cars') }}</h2>
            <a href="/cars" class="text-fitar-accent hover:text-fitar-accent-hover font-medium text-sm">{{ __('View All') }} →</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($popularCars as $car)
            <a href="/cars/{{ $car->id }}?from=home" class="bg-white dark:bg-fitar-surface/50 border border-gray-200 dark:border-white/10 rounded-xl overflow-hidden hover:border-fitar-accent/50 hover:shadow-lg transition-all group shadow-sm dark:shadow-none">
                <div class="h-48 bg-gray-800 relative overflow-hidden">
                    @php
                        $brandImages = [
                            'BMW' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=400&h=300&fit=crop',
                            'Toyota' => 'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?w=400&h=300&fit=crop',
                            'GMC' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=400&h=300&fit=crop',
                            'Honda' => 'https://images.unsplash.com/photo-1606016159991-dfe4f2746ad5?w=400&h=300&fit=crop',
                            'Mercedes' => 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?w=400&h=300&fit=crop',
                            'Audi' => 'https://images.unsplash.com/photo-1606664515524-8b5a27a2a7c9?w=400&h=300&fit=crop',
                            'Ford' => 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=400&h=300&fit=crop',
                            'Chevrolet' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?w=400&h=300&fit=crop',
                            'Nissan' => 'https://images.unsplash.com/photo-1590362891991-f776e747a588?w=400&h=300&fit=crop',
                            'Hyundai' => 'https://images.unsplash.com/photo-1580274455191-1c62238fa333?w=400&h=300&fit=crop',
                            'Kia' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=400&h=300&fit=crop',
                            'Volkswagen' => 'https://images.unsplash.com/photo-1606156591283-7d4f5c6e7e8a?w=400&h=300&fit=crop',
                            'Lexus' => 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=400&h=300&fit=crop',
                            'default' => 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=400&h=300&fit=crop'
                        ];
                        $imageUrl = isset($brandImages[$car->make]) ? $brandImages[$car->make] : $brandImages['default'];
                    @endphp
                    <img src="{{ $imageUrl }}" 
                         alt="{{ $car->make }} {{ $car->model }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-3 left-3 bg-black/60 backdrop-blur-sm px-2 py-1 rounded-lg">
                        <span class="text-white text-xs font-medium">{{ $car->year }}</span>
                    </div>
                    <div class="absolute bottom-3 right-3 bg-fitar-accent/90 px-2 py-1 rounded-lg">
                        <span class="text-white text-xs font-medium">{{ $car->body_type ?? 'Car' }}</span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between mb-1">
                        <h3 class="font-bold text-gray-900 dark:text-white">{{ $car->make }} {{ $car->model }}</h3>
                        <div class="flex items-center gap-1">
                            <span class="text-yellow-500 text-sm">★</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($car->average_rating, 1) }}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">({{ $car->review_count }})</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">{{ $car->engine ?? 'Premium' }} • {{ $car->transmission ?? 'Automatic' }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500 dark:text-gray-400">🏎️ {{ $car->horsepower ?? rand(150, 600) }} HP</span>
                        <span class="text-fitar-accent text-xs font-medium">View →</span>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-4 text-center text-gray-400 dark:text-gray-500 py-8">{{ __('No cars found.') }}</div>
            @endforelse
        </div>
    </section>

    <!-- Common Fault Codes -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-heading font-bold text-gray-900 dark:text-white">⚡ {{ __('Common Fault Codes') }}</h2>
            <a href="/fault-codes" class="text-fitar-accent hover:text-fitar-accent-hover font-medium text-sm">{{ __('View All') }} →</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse($faultCodes as $code)
            <a href="/fault-codes/{{ $code->id }}" class="bg-white dark:bg-fitar-surface/50 border border-gray-200 dark:border-white/10 rounded-xl p-4 hover:border-fitar-accent/50 transition-all shadow-sm dark:shadow-none">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-lg font-mono font-bold text-gray-900 dark:text-white">{{ $code->code }}</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $code->severity_color }}-100 dark:bg-{{ $code->severity_color }}-500/20 text-{{ $code->severity_color }}-700 dark:text-{{ $code->severity_color }}-400 capitalize">{{ $code->severity }}</span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ app()->getLocale() == 'ku' ? $code->title_ku : $code->title_en }}</p>
            </a>
            @empty
            <div class="col-span-4 text-center text-gray-400 dark:text-gray-500 py-8">{{ __('No fault codes found.') }}</div>
            @endforelse
        </div>
    </section>

    <!-- Featured Mechanics -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-heading font-bold text-gray-900 dark:text-white">🔧 {{ __('Featured Mechanics') }}</h2>
            <a href="/mechanics" class="text-fitar-accent hover:text-fitar-accent-hover font-medium text-sm">{{ __('View All') }} →</a>
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
                        <span class="text-xs text-green-600 dark:text-green-400">✅ {{ __('Verified') }}</span>
                    </div>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-3">{{ $mechanic->mechanicDetail?->specialization_en ?? __('Mechanic') }}</p>
                <p class="text-sm text-gray-400 dark:text-gray-500">📍 {{ $mechanic->city ?? 'Iraq' }}</p>
                <div class="flex items-center gap-1 mt-2">
                    <span class="text-yellow-500">★★★★★</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $mechanic->reviews->avg('rating') ? number_format($mechanic->reviews->avg('rating'), 1) : '5.0' }} ({{ $mechanic->reviews->count() }})</span>
                </div>
            </a>
            @empty
            <div class="col-span-3 text-center text-gray-400 dark:text-gray-500 py-8">{{ __('No mechanics found.') }}</div>
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