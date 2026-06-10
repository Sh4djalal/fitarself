@extends('layouts.app')

@section('title', __('Car Brands'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-heading font-bold text-white mb-2">🚗 {{ __('Car Brands') }}</h1>
    <p class="text-gray-400 mb-4">{{ __('Select a brand to view its models, specs, and reviews.') }}</p>

    @if(request('make') && !request('model'))
        <a href="/cars" class="text-fitar-accent hover:underline mb-6 inline-flex items-center gap-1">← {{ __('All Brands') }}</a>
        <h2 class="text-2xl font-heading font-bold text-white mb-6">{{ request('make') }} {{ __('Models') }}</h2>
        
        @php $uniqueModels = $cars->groupBy('model'); @endphp
        
        @foreach($uniqueModels as $model => $modelCars)
        <div class="mb-4">
            @php $firstCar = $modelCars->first(); @endphp
            <a href="/cars/model/{{ urlencode($firstCar->make) }}/{{ urlencode($firstCar->model) }}" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-5 hover:border-fitar-accent/50 transition-all flex items-center justify-between">
                <div>
                    <h3 class="text-white font-semibold text-lg">🚗 {{ $model }}</h3>
                    <p class="text-sm text-gray-400 mt-1">{{ $modelCars->count() }} {{ __('versions available') }}</p>
                    @if($firstCar->year_start && $firstCar->year_end)
                        <p class="text-xs text-fitar-accent">{{ $firstCar->year_start }}-{{ $firstCar->year_end }}</p>
                    @else
                        <p class="text-xs text-fitar-accent">{{ $firstCar->year }}</p>
                    @endif
                </div>
                <span class="text-fitar-accent text-xl">→</span>
            </a>
        </div>
        @endforeach

    @elseif(!request('make'))
        <div class="mb-6">
            <input type="text" id="brand-search" placeholder="{{ __('Search brands by name...') }}" 
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