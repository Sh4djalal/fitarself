@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    @if(session('success'))
    <div id="successMessage" class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 bg-green-500/90 backdrop-blur-md border border-green-400 rounded-lg px-6 py-3 shadow-lg animate-slide-down">
        <div class="flex items-center gap-3">
            <span class="text-green-400 text-xl">✅</span>
            <p class="text-white font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-heading font-bold text-white">👋 Welcome, {{ Auth::user()->name }}</h1>
            <p class="text-gray-400 mt-1">Here's your personal dashboard.</p>
        </div>
        <a href="{{ route('profile.edit') }}" class="bg-fitar-accent hover:bg-fitar-accent-hover text-white px-4 py-2 rounded-lg transition text-sm font-medium">
            ✏️ Edit Profile
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Profile Card -->
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6 text-center">
                <div class="w-24 h-24 rounded-full bg-fitar-card flex items-center justify-center text-3xl overflow-hidden mx-auto mb-4 ring-2 ring-fitar-accent/50">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                </div>
                <h2 class="text-xl font-heading font-bold text-white">{{ Auth::user()->name }}</h2>
                <p class="text-fitar-accent text-sm font-mono mb-2">@ {{ Auth::user()->username }}</p>
                <p class="text-gray-400 text-sm">{{ Auth::user()->email }}</p>
                
                @if(Auth::user()->city)
                <div class="mt-4 pt-3 border-t border-white/10">
                    <p class="text-gray-400 text-sm">📍 {{ Auth::user()->city }}</p>
                </div>
                @endif
                @if(Auth::user()->phone)
                <div class="mt-2">
                    <p class="text-gray-400 text-sm">📞 {{ Auth::user()->phone }}</p>
                </div>
                @endif
                
                <div class="mt-4 pt-3 border-t border-white/10">
                    <p class="text-gray-400 text-sm">📝 Bio</p>
                    @if(Auth::user()->bio_en)
                        <p class="text-white text-sm mt-1">{{ Auth::user()->bio_en }}</p>
                    @else
                        <p class="text-gray-500 text-sm mt-1">No bio added yet. <a href="{{ route('profile.edit') }}" class="text-fitar-accent hover:underline">Add one</a></p>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-5">
                <h3 class="text-sm font-semibold text-gray-400 mb-3">📊 Your Activity</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-400 text-sm">Saved Items</span>
                        <a href="{{ route('saved.items') }}" class="text-white font-bold hover:text-fitar-accent transition">
                            {{ Auth::user()->savedItems()->count() }}
                        </a>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400 text-sm">Reviews Given</span>
                        <a href="{{ route('user.reviews') }}" class="text-white font-bold hover:text-fitar-accent transition">
                            {{ Auth::user()->reviews()->count() }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- My Cars Section -->
            @php
                $myCar = Auth::user()->cars()->first();
            @endphp
            
            @if($myCar)
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-heading font-bold text-white">🚘 My Car</h2>
                    <form action="{{ route('profile.cars.destroy', $myCar->id) }}" method="POST" onsubmit="return confirm('Remove this car from your collection?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-300 text-sm transition">Remove</button>
                    </form>
                </div>
                <div class="flex items-center gap-4 p-4 bg-white/5 rounded-lg">
                    <div class="w-16 h-16 rounded-lg bg-fitar-card flex items-center justify-center text-3xl">🚗</div>
                    <div>
                        <p class="text-white font-bold text-lg">{{ $myCar->make }} {{ $myCar->model }}</p>
                        <p class="text-gray-400 text-sm">{{ $myCar->year }} • {{ $myCar->engine_type ?? 'Engine info not available' }}</p>
                        <a href="{{ route('cars.show', $myCar->id) }}" class="text-fitar-accent text-sm hover:underline">View Details →</a>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6 text-center">
                <p class="text-4xl mb-3">🚗</p>
                <h3 class="text-white font-semibold mb-1">No Car Added Yet</h3>
                <p class="text-gray-400 text-sm mb-4">Browse cars and click "OWN THIS CAR" to add it to your collection.</p>
                <a href="{{ route('cars.index') }}" class="inline-block bg-fitar-accent hover:bg-fitar-accent-hover text-white px-4 py-2 rounded-lg text-sm font-medium transition">Browse Cars</a>
            </div>
            @endif

            <!-- Messages Card -->
            <a href="{{ route('chat.index') }}" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-5 hover:border-fitar-accent/50 transition-all block">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">💬</span>
                    <div>
                        <h3 class="text-white font-semibold">Messages</h3>
                        <p class="text-gray-400 text-sm">Chat with mechanics and sellers</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes slideDown {
        0% { top: -100px; opacity: 0; }
        10% { top: 20px; opacity: 1; }
        90% { top: 20px; opacity: 1; }
        100% { top: -100px; opacity: 0; display: none; }
    }
    .animate-slide-down {
        animation: slideDown 5s ease-in-out forwards;
    }
</style>

<script>
    setTimeout(function() {
        const msg = document.getElementById('successMessage');
        if (msg) msg.style.display = 'none';
    }, 5000);
</script>
@endsection