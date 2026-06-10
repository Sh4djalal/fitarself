@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full bg-fitar-surface border border-white/10 rounded-2xl p-8 text-center">
        
        @if (session('status') == 'verification-link-sent')
            <div class="bg-green-500/20 text-green-400 p-3 rounded-lg mb-4">
                {{ __('A new verification link has been sent to your email address.') }}
            </div>
        @endif
        
        <div class="text-6xl mb-4">📧</div>
        
        <h1 class="text-2xl font-heading font-bold text-white mb-2">
            {{ __('Verify Your Email Address') }}
        </h1>
        
        <p class="text-gray-400 mb-6">
            {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking the link we sent to your email. If you didn\'t receive the email, click the button below.') }}
        </p>
        
        <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
            @csrf
            <button type="submit" class="w-full bg-fitar-accent hover:bg-fitar-accent-hover text-white py-3 rounded-lg font-medium transition">
                {{ __('Resend Verification Email') }}
            </button>
        </form>
        
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="text-gray-500 hover:text-gray-400 text-sm transition">
                {{ __('Logout') }}
            </button>
        </form>
    </div>
</div>
@endsection