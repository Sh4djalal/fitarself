@extends('layouts.app')

@section('title', 'All Car Brands')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-heading font-bold text-white mb-2">🚗 Car Brands</h1>
    <p class="text-gray-400 mb-4">Select a brand to view its models, specs, and reviews.</p>

    @if(request('make'))
        <a href="/cars" class="text-fitar-accent hover:underline mb-6 inline-flex items-center gap-1">← All Brands</a>
        <h2 class="text-2xl font-heading font-bold text-white mb-6">{{ request('make') }} Models</h2>
        
        @if($cars->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($cars as $car)
            <a href="/cars/{{ $car->id }}?from=brand&make={{ $car->make }}" class="bg-fitar-surface/50 border border-white/10 rounded-xl overflow-hidden hover:border-fitar-accent/50 hover:shadow-lg transition-all group">
                @php
                    $cardImage = null;
                    $cardFolder = public_path('images/' . $car->image_path);
                    if ($car->image_path && is_dir($cardFolder)) {
                        $cardFiles = glob($cardFolder . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
                        if (count($cardFiles) > 0) {
                            $cardImage = '/images/' . $car->image_path . '/' . basename($cardFiles[0]);
                        }
                    } elseif ($car->image_path && file_exists(public_path('images/' . $car->image_path . '.jpg'))) {
                        $cardImage = '/images/' . $car->image_path . '.jpg';
                    } elseif ($car->image_path && file_exists(public_path('images/' . $car->image_path . '.png'))) {
                        $cardImage = '/images/' . $car->image_path . '.png';
                    }
                @endphp
                <div class="h-48 bg-fitar-card flex items-center justify-center text-5xl group-hover:scale-105 transition-transform overflow-hidden">
                    @if($cardImage)
                    <img src="{{ $cardImage }}" alt="{{ $car->make }} {{ $car->model }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                    @else
                    🏎️
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-white text-lg">{{ $car->make }} {{ $car->model }}</h3>
                    <p class="text-sm text-gray-400">{{ $car->year }} • {{ $car->trim ?? '' }}</p>
                    <div class="flex items-center justify-between mt-3">
                        <div class="flex items-center gap-1">
                            <span class="text-yellow-500">★</span>
                            <span class="text-sm text-gray-300">{{ number_format($car->average_rating, 1) }}</span>
<span class="text-xs text-gray-500">{{ number_format($car->average_rating, 1) }} ★ ({{ $car->review_count }} reviews)</span>
                        </div>
                        <span class="text-xs text-fitar-accent">{{ $car->engine_type ?? '' }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center text-gray-500 py-16">
            <p class="text-4xl mb-2">🚗</p><p>No models found for this brand yet.</p>
        </div>
        @endif

    @else
        <!-- Live Search -->
        <div class="mb-6">
            <input type="text" id="brand-search" placeholder="Search brands by name..." 
                class="w-full max-w-md px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:border-fitar-accent text-lg"
                oninput="filterBrands()">
        </div>

        @php
        $allBrands = [
            'Acura','Alfa Romeo','Alpine','Aston Martin','Audi',
            'BAIC','Bentley','BMW','Brilliance','Bugatti','Buick','BYD',
            'Cadillac','Changan','Chery','Chevrolet','Chrysler','Citroen','Cupra',
            'Dacia','Daewoo','Daihatsu','Datsun','Dodge','Dongfeng','DS',
            'FAW','Ferrari','Fiat','Ford','Foton',
            'GAZ','Geely','Genesis','GMC','Great Wall',
            'Haval','Honda','Hongqi','Hummer','Hyundai',
            'Infiniti','Isuzu','Iveco',
            'JAC','Jaguar','Jeep','Jetour',
            'Kia','Koenigsegg',
            'Lada','Lamborghini','Lancia','Land Rover','Lexus','Lincoln','Lotus','Lynk & Co',
            'Mahindra','Maserati','Maybach','Mazda','McLaren','Mercedes-Benz','MG','MINI','Mitsubishi','Morgan',
            'NIO','Nissan',
            'Opel','Ora',
            'Pagani','Peugeot','Polestar','Pontiac','Porsche','Proton',
            'RAM','Renault','Rolls-Royce','Rover',
            'Saab','SEAT','Skoda','Smart','SsangYong','Subaru','Suzuki',
            'Tata','Tesla','Toyota',
            'Vauxhall','Volkswagen','Volvo',
            'Wuling','ZAZ','Zotye',
        ];
        @endphp

        <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($allBrands as $brand)
            <a href="/cars?make={{ $brand }}" data-brand="{{ $brand }}" class="brand-card bg-fitar-surface/50 border border-white/10 rounded-xl p-5 text-center hover:border-fitar-accent/50 hover:bg-fitar-surface transition-all flex flex-col items-center justify-center min-h-[180px] sm:min-h-[200px]">
                <img src="{{ asset('images/brands/' . Str::slug($brand) . '.png') }}" 
                     onerror="this.style.display='none'"
                     class="w-14 h-14 sm:w-16 sm:h-16 object-contain mx-auto mb-3"
                     alt="{{ $brand }} logo">
                <span class="text-4xl sm:text-5xl block mb-3 brand-fallback">{{ substr($brand, 0, 2) }}</span>
                <p class="text-xs sm:text-sm text-gray-300 font-medium truncate w-full">{{ $brand }}</p>
            </a>
            @endforeach
        </div>

        <style>
            img[src*="images/brands"]:not([style*="display: none"]) + .brand-fallback { display: none; }
        </style>

        <script>
        function filterBrands() {
            const search = document.getElementById('brand-search').value.toLowerCase();
            document.querySelectorAll('.brand-card').forEach(card => {
                const brand = card.getAttribute('data-brand').toLowerCase();
                card.style.display = brand.includes(search) ? '' : 'none';
            });
        }
        </script>
    @endif
</div>
@endsection