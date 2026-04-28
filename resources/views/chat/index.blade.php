@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-heading font-bold text-white mb-8">💬 Messages</h1>

    @if($conversations->count() > 0)
    <div class="space-y-2">
        @foreach($conversations as $conv)
        <a href="/chat/{{ $conv['conversation_id'] }}" class="flex items-center gap-4 bg-fitar-surface/50 border border-white/10 rounded-xl p-4 hover:border-fitar-accent/50 transition-all">
            <div class="w-12 h-12 rounded-full bg-fitar-card flex items-center justify-center overflow-hidden flex-shrink-0">
                <img src="{{ $conv['other_user']->profile_photo_url }}" alt="{{ $conv['other_user']->name }}" class="w-full h-full object-cover">
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                    <span class="font-semibold text-white">{{ $conv['other_user']->name }}</span>
                    <span class="text-xs text-gray-500">{{ $conv['updated_at']->diffForHumans() }}</span>
                </div>
                <p class="text-sm text-gray-400 truncate">{{ $conv['last_message'] }}</p>
            </div>
            @if($conv['unread_count'] > 0)
            <span class="bg-fitar-accent text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">{{ $conv['unread_count'] }}</span>
            @endif
        </a>
        @endforeach
    </div>
    @else
    <div class="text-center text-gray-500 py-16">
        <p class="text-4xl mb-4">💬</p>
        <p>No messages yet. Find a mechanic and start chatting!</p>
        <a href="/mechanics" class="text-fitar-accent hover:underline mt-2 inline-block">Browse Mechanics →</a>
    </div>
    @endif
</div>
@endsection