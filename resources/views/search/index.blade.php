@extends('layouts.app')

@section('title', 'Search')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Search Bar -->
    <form action="/search" method="GET" class="mb-8">
        <input type="text" name="q" id="search-input" value="{{ $query }}" placeholder="Search cars, fault codes, mechanics..." 
            class="w-full max-w-2xl px-6 py-4 bg-white/10 border border-white/20 rounded-xl text-white text-lg placeholder-gray-400 focus:outline-none focus:border-fitar-accent"
            oninput="liveSearch(this.value)">
    </form>

    <!-- Live Results Container -->
    <div id="live-results"></div>

    @if($query)
    <h1 class="text-2xl font-heading font-bold text-white mb-8">🔍 Results for "{{ $query }}"</h1>

    <!-- Cars Section -->
    @if($cars->count() > 0)
    <section class="mb-10">
        <h2 class="text-xl font-heading font-bold text-white mb-4">🚗 Cars ({{ $cars->count() }})</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($cars as $car)
            <a href="/cars/{{ $car->id }}" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-4 hover:border-fitar-accent/50 transition-all">
                <div class="h-24 bg-fitar-card rounded-lg flex items-center justify-center text-2xl mb-2">🏎️</div>
                <p class="font-medium text-white">{{ $car->make }} {{ $car->model }}</p>
                <p class="text-xs text-gray-400">{{ $car->year }}</p>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Fault Codes Section -->
    @if($faultCodes->count() > 0)
    <section class="mb-10">
        <h2 class="text-xl font-heading font-bold text-white mb-4">⚡ Fault Codes ({{ $faultCodes->count() }})</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($faultCodes as $code)
            <a href="/fault-codes/{{ $code->id }}" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-4 hover:border-{{ $code->severity_color }}-500/50 transition-all">
                <span class="text-lg font-mono font-bold text-white">{{ $code->code }}</span>
                <p class="text-sm text-gray-400 mt-1">{{ $code->title_en }}</p>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Mechanics Section -->
    @if($mechanics->count() > 0)
    <section class="mb-10">
        <h2 class="text-xl font-heading font-bold text-white mb-4">👨‍🔧 Mechanics ({{ $mechanics->count() }})</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($mechanics as $mechanic)
            <a href="/mechanics/{{ $mechanic->id }}" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-4 hover:border-fitar-accent/50 transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-fitar-card flex items-center justify-center overflow-hidden">
                        <img src="{{ $mechanic->profile_photo_url }}" alt="{{ $mechanic->name }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <p class="font-medium text-white">{{ $mechanic->name }}</p>
                        <p class="text-xs text-gray-400">{{ $mechanic->city ?? 'Iraq' }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    <!-- No Results -->
    @if($cars->count() == 0 && $faultCodes->count() == 0 && $mechanics->count() == 0)
    <div class="text-center py-16">
        <p class="text-4xl mb-4">🔍</p>
        <p class="text-xl text-gray-400 mb-2">No results found for "{{ $query }}".</p>
        <p class="text-gray-500">Try different keywords or browse our categories.</p>
    </div>
    @endif

    @else
    <div class="text-center py-16">
        <p class="text-4xl mb-4">🔍</p>
        <p class="text-xl text-gray-400">Search for cars, fault codes, or mechanics.</p>
    </div>
    @endif

</div>

<script>
function liveSearch(val) {
    if (val.length < 1) {
        document.getElementById('live-results').innerHTML = '';
        return;
    }
    
    fetch('/api/search?q=' + encodeURIComponent(val))
        .then(res => res.json())
        .then(data => {
            let html = '';
            
            if (data.cars && data.cars.length > 0) {
                html += '<div class="mb-6"><h3 class="text-sm font-semibold text-gray-400 mb-2">🚗 Cars</h3><div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">';
                data.cars.forEach(car => {
                    html += `<a href="/cars/${car.id}" class="bg-fitar-surface/50 border border-white/10 rounded-lg p-3 hover:border-fitar-accent/50 transition-all">
                        <p class="text-sm font-medium text-white">${car.make} ${car.model}</p>
                        <p class="text-xs text-gray-400">${car.year}</p>
                    </a>`;
                });
                html += '</div></div>';
            }
            
            if (data.faultCodes && data.faultCodes.length > 0) {
                html += '<div class="mb-6"><h3 class="text-sm font-semibold text-gray-400 mb-2">⚡ Fault Codes</h3><div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">';
                data.faultCodes.forEach(fc => {
                    html += `<a href="/fault-codes/${fc.id}" class="bg-fitar-surface/50 border border-white/10 rounded-lg p-3 hover:border-fitar-accent/50 transition-all">
                        <p class="text-sm font-mono font-bold text-white">${fc.code}</p>
                        <p class="text-xs text-gray-400 truncate">${fc.title_en}</p>
                    </a>`;
                });
                html += '</div></div>';
            }
            
            if (data.mechanics && data.mechanics.length > 0) {
                html += '<div class="mb-6"><h3 class="text-sm font-semibold text-gray-400 mb-2">👨‍🔧 Mechanics</h3><div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">';
                data.mechanics.forEach(m => {
                    html += `<a href="/mechanics/${m.id}" class="bg-fitar-surface/50 border border-white/10 rounded-lg p-3 hover:border-fitar-accent/50 transition-all">
                        <p class="text-sm font-medium text-white">${m.name}</p>
                        <p class="text-xs text-gray-400">${m.city || 'Iraq'}</p>
                    </a>`;
                });
                html += '</div></div>';
            }
            
            document.getElementById('live-results').innerHTML = html;
        });
}
</script>
@endsection