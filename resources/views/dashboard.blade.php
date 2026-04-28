@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-heading font-bold text-white">👋 Welcome, {{ Auth::user()->name }}</h1>
            <p class="text-gray-400 mt-1">Here's your personal dashboard.</p>
        </div>
        <a href="/profile" class="bg-fitar-accent hover:bg-fitar-accent-hover text-white px-4 py-2 rounded-lg transition text-sm font-medium">
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
            </div>

            <!-- Quick Stats -->
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-5">
                <h3 class="text-sm font-semibold text-gray-400 mb-3">📊 Your Activity</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-400 text-sm">Saved Items</span>
                        <span class="text-white font-bold">{{ Auth::user()->savedItems()->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400 text-sm">My Cars</span>
                        <span class="text-white font-bold">{{ Auth::user()->ownedCars()->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400 text-sm">Reviews Given</span>
                        <span class="text-white font-bold">{{ Auth::user()->reviews()->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Quick Actions Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="/cars" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-5 hover:border-fitar-accent/50 transition-all block">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">🚗</span>
                        <div>
                            <h3 class="text-white font-semibold">Browse Cars</h3>
                            <p class="text-gray-400 text-sm">Explore vehicle database</p>
                        </div>
                    </div>
                </a>
                
                <a href="/fault-codes" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-5 hover:border-fitar-accent/50 transition-all block">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">⚡</span>
                        <div>
                            <h3 class="text-white font-semibold">Fault Codes</h3>
                            <p class="text-gray-400 text-sm">Diagnose issues</p>
                        </div>
                    </div>
                </a>
                
                <a href="/mechanics" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-5 hover:border-fitar-accent/50 transition-all block">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">🔧</span>
                        <div>
                            <h3 class="text-white font-semibold">Find Mechanics</h3>
                            <p class="text-gray-400 text-sm">Trusted professionals</p>
                        </div>
                    </div>
                </a>
                
                <a href="/parts" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-5 hover:border-fitar-accent/50 transition-all block">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">🛒</span>
                        <div>
                            <h3 class="text-white font-semibold">Parts Market</h3>
                            <p class="text-gray-400 text-sm">Buy & sell parts</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- My Cars Section -->
            @php $myCars = Auth::user()->ownedCars()->take(4)->get(); @endphp
            @if($myCars->count() > 0)
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-heading font-bold text-white">🚘 My Cars</h2>
                    <a href="/my-cars" class="text-fitar-accent hover:text-fitar-accent-hover text-sm font-medium">Manage →</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($myCars as $car)
                    <a href="/cars/{{ $car->id }}" class="flex items-center gap-3 p-3 bg-white/5 rounded-lg hover:bg-white/10 transition">
                        <div class="w-12 h-12 rounded-lg bg-fitar-card flex items-center justify-center text-xl">🚗</div>
                        <div>
                            <p class="text-white font-medium text-sm">{{ $car->make }} {{ $car->model }}</p>
                            <p class="text-gray-400 text-xs">{{ $car->year }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @else
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6 text-center">
                <p class="text-4xl mb-3">🚗</p>
                <h3 class="text-white font-semibold mb-1">No Cars Added Yet</h3>
                <p class="text-gray-400 text-sm mb-4">Add your vehicles to get personalized fault code help.</p>
                <a href="/my-cars" class="inline-block bg-fitar-accent hover:bg-fitar-accent-hover text-white px-4 py-2 rounded-lg text-sm font-medium transition">Add My First Car</a>
            </div>
            @endif

            <!-- Messages -->
            <a href="/chat" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-5 hover:border-fitar-accent/50 transition-all block">
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
@endsection

