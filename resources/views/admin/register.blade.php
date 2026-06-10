@extends('layouts.guest')

@section('title', 'Admin Registration')

@section('content')
<div style="background: #1a1a2e; border: 1px solid #333; border-radius: 16px; padding: 32px; max-width: 450px; margin: 0 auto;">

    <div class="text-center mb-6">
        <div class="text-5xl mb-3">👑</div>
        <h1 class="text-2xl font-heading font-bold text-white">Admin Registration</h1>
        <p class="text-gray-400 mt-1">Create administrator account</p>
    </div>

    @if ($errors->any())
        <div style="background: rgba(239,68,68,0.2); border: 1px solid #ef4444; border-radius: 8px; padding: 12px; margin-bottom: 20px;">
            @foreach ($errors->all() as $error)
                <p class="text-red-400 text-sm">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.register.submit') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-300 text-sm font-medium mb-2">Full Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">
        </div>

        <div class="mb-4">
            <label class="block text-gray-300 text-sm font-medium mb-2">Email Address *</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">
        </div>

        <div class="mb-4">
            <label class="block text-gray-300 text-sm font-medium mb-2">Admin Secret Key *</label>
            <input type="password" name="admin_secret" required
                class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">
            <p class="text-gray-500 text-xs mt-1">Contact the system administrator for the secret key.</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-300 text-sm font-medium mb-2">Password *</label>
            <input type="password" name="password" required
                class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">
        </div>

        <div class="mb-6">
            <label class="block text-gray-300 text-sm font-medium mb-2">Confirm Password *</label>
            <input type="password" name="password_confirmation" required
                class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">
        </div>

        <button type="submit" class="w-full bg-fitar-accent hover:bg-fitar-accent-hover text-white py-3 rounded-lg font-medium transition">
            👑 Register as Admin
        </button>
    </form>

    <div class="text-center mt-6">
        <p class="text-gray-400 text-sm">Already have an account?</p>
        <a href="{{ route('login') }}" class="text-fitar-accent hover:text-fitar-accent-hover text-sm font-medium">Sign In →</a>
    </div>
</div>
@endsection