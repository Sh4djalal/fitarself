@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">👑 Admin Dashboard</h1>
        <p class="text-gray-400">Manage your platform from here.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-fitar-surface border border-white/10 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Total Users</p>
                    <p class="text-3xl font-bold text-white">{{ $totalUsers }}</p>
                </div>
                <span class="text-4xl">👥</span>
            </div>
        </div>
        
        <div class="bg-fitar-surface border border-white/10 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Total Mechanics</p>
                    <p class="text-3xl font-bold text-white">{{ $totalMechanics }}</p>
                </div>
                <span class="text-4xl">🔧</span>
            </div>
        </div>
        
        <div class="bg-fitar-surface border border-white/10 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Pending Verifications</p>
                    <p class="text-3xl font-bold text-yellow-400">{{ $pendingVerifications }}</p>
                </div>
                <span class="text-4xl">⏳</span>
            </div>
        </div>
        
        <div class="bg-fitar-surface border border-white/10 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Total Cars</p>
                    <p class="text-3xl font-bold text-white">{{ $totalCars }}</p>
                </div>
                <span class="text-4xl">🚗</span>
            </div>
        </div>
        
        <div class="bg-fitar-surface border border-white/10 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Fault Codes</p>
                    <p class="text-3xl font-bold text-white">{{ $totalFaultCodes }}</p>
                </div>
                <span class="text-4xl">⚡</span>
            </div>
        </div>
        
        <div class="bg-fitar-surface border border-white/10 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Parts Listed</p>
                    <p class="text-3xl font-bold text-white">{{ $totalParts }}</p>
                </div>
                <span class="text-4xl">🛒</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('admin.verifications') }}" class="bg-fitar-surface border border-white/10 rounded-xl p-6 hover:border-fitar-accent/50 transition-all group">
            <div class="flex items-center gap-4">
                <div class="text-4xl">📄</div>
                <div>
                    <h3 class="text-white font-semibold text-lg">Pending Verifications</h3>
                    <p class="text-gray-400 text-sm">Review mechanic document submissions</p>
                    @if($pendingVerifications > 0)
                        <span class="inline-block mt-2 px-2 py-1 bg-yellow-500/20 text-yellow-400 text-xs rounded-full">{{ $pendingVerifications }} pending</span>
                    @endif
                </div>
            </div>
        </a>
        
        <a href="{{ route('admin.users') }}" class="bg-fitar-surface border border-white/10 rounded-xl p-6 hover:border-fitar-accent/50 transition-all group">
            <div class="flex items-center gap-4">
                <div class="text-4xl">👥</div>
                <div>
                    <h3 class="text-white font-semibold text-lg">Manage Users</h3>
                    <p class="text-gray-400 text-sm">View and manage all registered users</p>
                    <span class="inline-block mt-2 px-2 py-1 bg-fitar-accent/20 text-fitar-accent text-xs rounded-full">{{ $totalUsers }} total users</span>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection