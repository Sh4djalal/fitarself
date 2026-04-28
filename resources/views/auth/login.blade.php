@extends('layouts.guest')

@section('content')
<div class="bg-[#1a1a2e] border border-gray-700 rounded-2xl p-8">
    <h1 class="text-2xl font-heading font-bold text-white mb-2">🔑 Login</h1>
    <p class="text-gray-400 mb-6">Welcome back to FitarSelf.</p>

    <form action="/login" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm text-gray-400 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-fitar-accent">
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1">Password</label>
            <input type="password" name="password" required
                class="w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-fitar-accent">
        </div>

        @if($errors->any())
        <div class="bg-red-900/50 border border-red-500/30 rounded-lg p-3">
            @foreach($errors->all() as $error)
            <p class="text-red-400 text-sm">{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <button type="submit" class="w-full py-3 bg-fitar-accent hover:bg-fitar-accent-hover text-white rounded-lg font-bold transition">
            🔑 Login
        </button>

        <div class="text-center text-sm text-gray-400 space-y-2">
            <p>Don't have an account?</p>
            <div class="flex gap-2 justify-center">
                <a href="/register" class="px-4 py-2 bg-fitar-accent text-white rounded-lg text-sm font-medium">👤 User</a>
                <a href="/register/mechanic" class="px-4 py-2 bg-gray-700 text-white rounded-lg text-sm font-medium">🔧 Mechanic</a>
            </div>
        </div>
    </form>
</div>
@endsection