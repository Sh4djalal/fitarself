@extends('layouts.app')

@section('title', $make . ' ' . $model)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <a href="/cars?make={{ $make }}" class="text-fitar-accent hover:underline mb-4 inline-flex items-center gap-1">← {{ __('Back to') }} {{ $make }}</a>
    <h1 class="text-3xl font-heading font-bold text-white mb-2">🚗 {{ $make }} {{ $model }}</h1>
    <p class="text-gray-400 mb-8">{{ __('Choose your region to see specifications.') }}</p>
    
    @if(request('region'))
        @php $region = request('region'); @endphp
        <a href="/cars/model/{{ $make }}/{{ urlencode($model) }}" class="text-fitar-accent hover:underline mb-6 inline-flex items-center gap-1">← {{ __('Change Region') }}</a>
        <h2 class="text-xl font-heading font-bold text-white mb-4">
            🌍 {{ $region == 'GCC' ? __('Middle East Spec') : __('USA Spec') }}
        </h2>
        
        @php $filteredCars = $cars->filter(fn($c) => $c->region === $region); @endphp
        
        @if($filteredCars->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach($filteredCars as $car)
            <a href="/cars/{{ $car->id }}?from=brand&make={{ $make }}" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-4 hover:border-fitar-accent/50 transition-all">
                <span class="text-white font-medium">
                    @if($car->year_start && $car->year_end)
                        {{ $car->year_start }}-{{ $car->year_end }}
                    @else
                        {{ $car->year }}
                    @endif
                </span>
                <div class="space-y-1 text-xs text-gray-400 mt-2">
                    @if($car->engine_type)<p>🔧 {{ $car->engine_type }}</p>@endif
                    @if($car->transmission)<p>⚙️ {{ ucfirst($car->transmission) }}</p>@endif
                    @if($car->oil_density_type)<p>🛢️ {{ $car->oil_density_type }}</p>@endif
                </div>
            </a>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 text-sm">{{ __('No versions available for this region yet.') }}</p>
        @endif
        
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @if($cars->where('region', 'GCC')->count() > 0)
            <a href="?region=GCC" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-8 hover:border-fitar-accent/50 transition-all text-center no-underline">
                <span class="text-6xl mb-4 block">🇸🇦</span>
                <h3 class="text-xl font-heading font-bold text-white mb-2">{{ __('Middle East') }} {{ __('Spec') }}</h3>
                <p class="text-sm text-gray-400">{{ $cars->where('region', 'GCC')->count() }} {{ __('versions available') }}</p>
            </a>
            @endif
            @if($cars->where('region', 'USA')->count() > 0)
            <a href="?region=USA" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-8 hover:border-fitar-accent/50 transition-all text-center no-underline">
                <span class="text-6xl mb-4 block">🇺🇸</span>
                <h3 class="text-xl font-heading font-bold text-white mb-2">{{ __('USA') }} {{ __('Spec') }}</h3>
                <p class="text-sm text-gray-400">{{ $cars->where('region', 'USA')->count() }} {{ __('versions available') }}</p>
            </a>
            @endif
        </div>
    @endif
</div>
@endsection