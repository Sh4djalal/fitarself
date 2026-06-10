@extends('layouts.app')

@section('title', 'Change Email')

@section('content')
<div class="max-w-md mx-auto px-4 py-8">
    <div class="bg-fitar-surface border border-white/10 rounded-2xl p-6">
        
        <div class="text-center mb-6">
            <div class="text-4xl mb-3">📧</div>
            <h1 class="text-2xl font-bold text-white">Change Email Address</h1>
            <p class="text-gray-400 mt-1">We'll send a verification code to your new email</p>
        </div>

        @if($errors->any())
            <div class="bg-red-500/20 border border-red-500 rounded-lg p-3 mb-4">
                @foreach($errors->all() as $error)
                    <p class="text-red-400 text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('profile.send-email-otp') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-medium mb-2">Current Email</label>
                <input type="email" value="{{ Auth::user()->email }}" disabled
                    class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-gray-400">
            </div>

            <div class="mb-6">
                <label class="block text-gray-300 text-sm font-medium mb-2">New Email Address</label>
                <input type="email" name="new_email" value="{{ old('new_email') }}" required
                    class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">
                <p class="text-gray-500 text-xs mt-1">A verification code will be sent to this email.</p>
            </div>

            <button type="submit" class="w-full bg-fitar-accent hover:bg-fitar-accent-hover text-white py-2 rounded-lg font-medium transition">
                Send Verification Code
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('profile.edit') }}" class="text-gray-400 hover:text-white text-sm">← Back to Profile</a>
        </div>
    </div>
</div>
@endsection