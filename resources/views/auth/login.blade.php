@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div style="background: #1a1a2e; border: 1px solid #333; border-radius: 16px; padding: 32px; max-width: 450px; margin: 0 auto;">

    <div class="text-center mb-6">
        <div class="text-5xl mb-3">🏎️</div>
        <h1 class="text-2xl font-heading font-bold text-white">Welcome Back</h1>
        <p class="text-gray-400 mt-1">Sign in to your FitarSelf account</p>
    </div>

    @if(session('success'))
        <div style="background: rgba(34,197,94,0.2); border: 1px solid #22c55e; border-radius: 8px; padding: 12px; margin-bottom: 20px;">
            <p class="text-green-400 text-sm">{{ session('success') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div style="background: rgba(239,68,68,0.2); border: 1px solid #ef4444; border-radius: 8px; padding: 12px; margin-bottom: 20px;">
            @foreach($errors->all() as $error)
                <p class="text-red-400 text-sm">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-300 text-sm font-medium mb-2">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
        </div>

        <div class="mb-4">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                <label class="block text-gray-300 text-sm font-medium">Password</label>
                <a href="{{ route('password.request') }}" style="font-size: 12px; color: #F47920; text-decoration: none;">Forgot?</a>
            </div>
            <input type="password" name="password" required
                style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
        </div>

        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
            <input type="checkbox" name="remember" id="remember" style="accent-color: #F47920;">
            <label for="remember" style="color: #ccc; font-size: 13px;">Remember me</label>
        </div>

        <button type="submit" style="width: 100%; padding: 14px; background: #F47920; color: white; border: none; border-radius: 8px; font-weight: bold; font-size: 15px; cursor: pointer;">Sign In</button>
    </form>

    <div class="text-center mt-6">
        <p class="text-gray-400 text-sm">Don't have an account?</p>
        <a href="{{ route('register') }}" style="color: #F47920; text-decoration: none; font-size: 13px; font-weight: 500;">Create Account →</a>
    </div>

    <p style="text-align: center; font-size: 11px; color: #555; margin-top: 24px;">
        © {{ date('Y') }} FitarSelf. All rights reserved.
    </p>
</div>
@endsection