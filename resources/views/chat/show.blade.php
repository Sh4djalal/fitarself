@extends('layouts.app')

@section('title', 'Chat with ' . ($otherUser ? $otherUser->name : 'User'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <a href="/chat" class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1">← Back to Messages</a>

    @if($otherUser)
    <div class="flex items-center gap-3 mb-6 bg-fitar-surface/50 border border-white/10 rounded-xl p-4">
        <div class="w-10 h-10 rounded-full bg-fitar-card flex items-center justify-center overflow-hidden">
            <img src="{{ $otherUser->profile_photo_url }}" alt="{{ $otherUser->name }}" class="w-full h-full object-cover">
        </div>
        <div>
            <h2 class="font-semibold text-white">{{ $otherUser->name }}</h2>
            <span class="text-xs text-gray-400">{{ $otherUser->mechanicDetail->specialization_en ?? 'User' }}</span>
        </div>
    </div>
    @endif

    <div id="messages-container" class="bg-fitar-surface/50 border border-white/10 rounded-xl p-4 h-96 overflow-y-auto mb-4 space-y-3">
        @foreach($messages as $msg)
        <div class="flex {{ $msg->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
            <div class="max-w-[75%] px-4 py-2 rounded-xl {{ $msg->sender_id === Auth::id() ? 'bg-fitar-accent text-white' : 'bg-white/10 text-gray-200' }}">
                <p class="text-sm">{{ $msg->message_text }}</p>
                <p class="text-xs {{ $msg->sender_id === Auth::id() ? 'text-white/60' : 'text-gray-500' }} mt-1">{{ $msg->created_at->format('H:i') }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <form id="message-form" class="flex gap-2">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $otherUser ? $otherUser->id : '' }}">
        <input type="text" name="message_text" id="message-input" placeholder="Type a message..." 
            class="flex-1 px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:border-fitar-accent">
        <button type="submit" class="px-6 py-3 bg-fitar-accent hover:bg-fitar-accent-hover text-white rounded-xl font-medium transition">Send</button>
    </form>

</div>

<script>
    const conversationId = '{{ $conversationId }}';
    const currentUserId = {{ Auth::id() }};

    // Scroll to bottom
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;

    // Send message via AJAX
    document.getElementById('message-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const input = document.getElementById('message-input');
        const message = input.value.trim();
        if (!message) return;

        await fetch('/chat/send', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('[name=_token]').value },
            body: JSON.stringify({
                receiver_id: {{ $otherUser ? $otherUser->id : 0 }},
                message_text: message
            })
        });

        input.value = '';
        loadMessages();
    });

    async function loadMessages() {
        const res = await fetch(`/chat/${conversationId}/messages`);
        const messages = await res.json();
        
        container.innerHTML = '';
        messages.forEach(msg => {
            const isMine = msg.sender_id === currentUserId;
            container.innerHTML += `
                <div class="flex ${isMine ? 'justify-end' : 'justify-start'}">
                    <div class="max-w-[75%] px-4 py-2 rounded-xl ${isMine ? 'bg-fitar-accent text-white' : 'bg-white/10 text-gray-200'}">
                        <p class="text-sm">${msg.message_text}</p>
                        <p class="text-xs ${isMine ? 'text-white/60' : 'text-gray-500'} mt-1">${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</p>
                    </div>
                </div>
            `;
        });
        container.scrollTop = container.scrollHeight;
    }

    // Poll for new messages every 3 seconds
    setInterval(loadMessages, 3000);
</script>
@endsection