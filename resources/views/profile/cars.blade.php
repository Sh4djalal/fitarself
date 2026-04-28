@extends('layouts.app')

@section('title', 'My Garage')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-heading font-bold text-white mb-2">🚗 My Garage</h1>
    <p class="text-gray-400 mb-8">Select the cars you own to get personalized recommendations.</p>

    <!-- Owned Cars -->
    <div class="mb-12">
        <h2 class="text-xl font-heading font-bold text-white mb-4">Your Cars</h2>
        @if($ownedCars->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($ownedCars as $car)
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-4 text-center relative">
                <form action="{{ route('profile.cars.destroy', $car) }}" method="POST" class="absolute top-2 right-2">
                    @csrf @method('DELETE')
                    <button class="text-red-400 hover:text-red-300 text-lg">✕</button>
                </form>
                <div class="h-32 bg-fitar-card rounded-lg flex items-center justify-center text-3xl mb-3">🏎️</div>
                <h3 class="text-white font-semibold">{{ $car->make }} {{ $car->model }}</h3>
                <p class="text-gray-400 text-sm">{{ $car->year }}</p>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500">No cars in your garage yet. Add one below!</p>
        @endif
    </div>

    <!-- Add a Car -->
    <div>
        <h2 class="text-xl font-heading font-bold text-white mb-4">➕ Add a Car</h2>
        
        <!-- Brand Filter -->
        <div class="flex gap-2 overflow-x-auto pb-4 mb-4">
            @php $brands = App\Models\Car::select('make')->distinct()->orderBy('make')->pluck('make'); @endphp
            <button onclick="filterCars('all')" class="brand-filter px-4 py-2 rounded-full text-sm font-medium bg-fitar-accent text-white whitespace-nowrap transition" data-brand="all">All</button>
            @foreach($brands as $brand)
            <button onclick="filterCars('{{ $brand }}')" class="brand-filter px-4 py-2 rounded-full text-sm font-medium bg-white/10 text-gray-300 hover:bg-white/20 whitespace-nowrap transition" data-brand="{{ $brand }}">{{ $brand }}</button>
            @endforeach
        </div>

        <!-- Cars Grid -->
        <div id="cars-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @php $allCars = App\Models\Car::orderBy('make')->orderBy('model')->get(); @endphp
            @foreach($allCars as $car)
            <div class="car-option bg-fitar-surface/50 border border-white/10 rounded-xl p-4 text-center" data-brand="{{ $car->make }}">
                <div class="h-28 bg-fitar-card rounded-lg flex items-center justify-center text-2xl mb-2">🏎️</div>
                <h3 class="text-white font-medium text-sm">{{ $car->make }} {{ $car->model }}</h3>
                <p class="text-gray-400 text-xs">{{ $car->year }}</p>
                <form action="{{ route('profile.cars.store') }}" method="POST" class="mt-2">
                    @csrf
                    <input type="hidden" name="car_id" value="{{ $car->id }}">
                    <button class="w-full px-3 py-1.5 bg-fitar-accent hover:bg-fitar-accent-hover text-white rounded-lg text-sm transition">+ Add</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
function filterCars(brand) {
    document.querySelectorAll('.brand-filter').forEach(btn => {
        btn.classList.toggle('bg-fitar-accent', btn.getAttribute('data-brand') === brand);
        btn.classList.toggle('text-white', btn.getAttribute('data-brand') === brand);
        btn.classList.toggle('bg-white/10', btn.getAttribute('data-brand') !== brand);
        btn.classList.toggle('text-gray-300', btn.getAttribute('data-brand') !== brand);
    });
    document.querySelectorAll('.car-option').forEach(car => {
        car.style.display = (brand === 'all' || car.getAttribute('data-brand') === brand) ? '' : 'none';
    });
}
</script>
@endsection