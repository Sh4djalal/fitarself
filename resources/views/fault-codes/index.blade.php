@extends('layouts.app')

@section('title', __('Fault Codes'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-heading font-bold text-white mb-2">⚡ {{ __('Fault Codes') }}</h1>
    <p class="text-gray-400 mb-4">{{ __('Select your car brand to see all fault codes.') }}</p>

    @if(request('make'))
        <a href="/fault-codes" class="text-fitar-accent hover:underline mb-6 inline-flex items-center gap-1">← {{ __('All Brands') }}</a>
        
        <div class="mb-8">
            <h2 class="text-2xl font-heading font-bold text-white mb-2">
                @php $brandIcon = ['Toyota'=>'🚗','BMW'=>'🚘','Mercedes-Benz'=>'⭐','Honda'=>'🚙','Ford'=>'🦅','Hyundai'=>'🐎','Nissan'=>'🏔️','Mitsubishi'=>'💠']; @endphp
                {{ $brandIcon[request('make')] ?? '🔧' }} {{ request('make') }} {{ __('Fault Codes') }}
            </h2>
            <p class="text-gray-400">{{ __('Browse all OBD-II fault codes for') }} {{ request('make') }}.</p>
        </div>

        {{-- LIVE SEARCH --}}
        <div class="mb-6">
            <input type="text" id="live-search" placeholder="{{ __('Type to filter codes... (e.g., P03, misfire)') }}" 
                class="w-full max-w-lg px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:border-fitar-accent text-lg"
                onkeyup="filterCodes()">
        </div>

        {{-- Results --}}
        <div id="codes-list" class="space-y-3">
            @forelse($faultCodes as $code)
            <a href="/fault-codes/{{ $code->id }}" class="code-item flex items-center justify-between bg-fitar-surface/50 border border-white/10 rounded-xl p-5 hover:border-{{ $code->severity_color }}-500/50 transition-all w-full" 
                data-code="{{ strtolower($code->code) }}" 
                data-title="{{ strtolower($code->title_en) }}">
                <div class="flex items-center gap-4">
                    <span class="text-xl font-mono font-bold text-white w-24">{{ $code->code }}</span>
                    <div>
                        <span class="code-title text-gray-300">{{ $code->title_en }}</span>
                        <div class="flex gap-2 mt-1">
                            @if($code->make !== 'All')
                            <span class="text-[10px] px-2 py-0.5 bg-fitar-accent/20 text-fitar-accent rounded-full">{{ $code->make }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-500 hidden sm:block">{{ $code->system ?? '' }}</span>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-{{ $code->severity_color }}-500/20 text-{{ $code->severity_color }}-400 capitalize">{{ $code->severity }}</span>
                </div>
            </a>
            @empty
            <div class="text-center py-16" id="no-results">
                <span class="text-5xl mb-4 block">🚧</span>
                <h3 class="text-xl font-heading font-bold text-white mb-2">{{ __('Coming Soon!') }}</h3>
                <p class="text-gray-400">{{ __('Fault codes for') }} {{ request('make') }} {{ __('are being added.') }}</p>
                <a href="/fault-codes" class="inline-block mt-6 px-6 py-3 bg-fitar-accent hover:bg-fitar-accent-hover text-white rounded-lg font-medium transition">
                    ← {{ __('Browse All Brands') }}
                </a>
            </div>
            @endforelse
        </div>

    @else
        {{-- Brand Grid --}}
        <div class="mb-6">
            <input type="text" id="brand-search" placeholder="{{ __('Search brands by name...') }}" 
                class="w-full max-w-md px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:border-fitar-accent text-lg"
                onkeyup="filterBrands()">
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
            <a href="/fault-codes?make={{ $brand }}" data-brand="{{ $brand }}" class="brand-card bg-fitar-surface/50 border border-white/10 rounded-xl p-5 text-center hover:border-fitar-accent/50 hover:bg-fitar-surface transition-all flex flex-col items-center justify-center min-h-[180px] sm:min-h-[200px]">
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
    @endif
</div>

<script>
function filterBrands() {
    var search = document.getElementById('brand-search').value.toLowerCase();
    document.querySelectorAll('.brand-card').forEach(function(card) {
        var brand = card.getAttribute('data-brand').toLowerCase();
        card.style.display = brand.includes(search) ? '' : 'none';
    });
}

function filterCodes() {
    var search = document.getElementById('live-search').value.toLowerCase();
    var items = document.querySelectorAll('.code-item');
    var visible = 0;
    
    items.forEach(function(item) {
        var code = item.getAttribute('data-code');
        var title = item.getAttribute('data-title');
        if (code.includes(search) || title.includes(search)) {
            item.style.display = 'flex';
            visible++;
        } else {
            item.style.display = 'none';
        }
    });
}
</script>
@endsection