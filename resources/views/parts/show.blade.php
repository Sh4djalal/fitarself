@extends('layouts.app')

@section('title', 'Part Details - Coming Soon')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center py-20">
        <div class="text-8xl mb-6">🔧</div>
        <h1 class="text-4xl font-heading font-bold text-white mb-4">{{ __('Coming Soon!') }}</h1>
        <p class="text-gray-400 text-lg mb-8">{{ __('This feature is coming soon.') }}</p>
        <p class="text-gray-500">{{ __('Parts marketplace details will be available shortly.') }}</p>
        <a href="/parts" class="inline-block mt-8 px-6 py-3 bg-fitar-accent hover:bg-fitar-accent-hover text-white rounded-lg transition">
            ← {{ __('Back to Parts') }}
        </a>
    </div>
</div>
@endsection