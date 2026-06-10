@extends('layouts.app')

@section('title', 'Support Requests')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">💬 Support Requests</h1>
        <p class="text-gray-400">View and respond to user support requests</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 bg-fitar-surface border border-white/10 rounded-xl overflow-hidden">
            <div class="p-4 border-b border-white/10 bg-fitar-card">
                <h2 class="text-white font-semibold">Active Conversations</h2>
                <p class="text-gray-400 text-xs">Click on any conversation to view messages</p>
            </div>
            <div id="sessions-list" class="divide-y divide-white/10">
                @forelse($activeSessions as $session)
                    <div class="session-item p-4 cursor-pointer hover:bg-white/5 transition" data-session="{{ $session['session_id'] }}">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-fitar-card flex items-center justify-center text-lg overflow-hidden">
                                @if($session['user'] && $session['user']->profile_photo_path)
                                    <img src="{{ Storage::url($session['user']->profile_photo_path) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <span class="text-2xl">👤</span>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-medium">{{ $session['user']->name ?? 'Guest User' }}</p>
                                <p class="text-gray-400 text-xs">{{ $session['user']->email ?? 'Not logged in' }}</p>
                                <p class="text-gray-500 text-xs mt-1">{{ $session['last_message']->created_at->diffForHumans() }}</p>
                            </div>
                            @if($session['has_agent_request'])
                                <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                            @elseif($session['unread_count'] > 0)
                                <span class="bg-fitar-accent text-white text-xs rounded-full px-2 py-0.5">{{ $session['unread_count'] }}</span>
                            @endif
                        </div>
                        <div class="mt-2 text-gray-400 text-sm truncate">
                            {{ Str::limit($session['messages']->last()->message, 50) }}
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-400">
                        <p class="text-4xl mb-2">💬</p>
                        <p>No active support requests</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-2 bg-fitar-surface border border-white/10 rounded-xl overflow-hidden">
            <div id="chat-header" class="p-4 border-b border-white/10 bg-fitar-card">
                <p class="text-gray-400 text-center">Select a conversation from the left</p>
            </div>
            
            <div id="chat-messages" class="h-96 overflow-y-auto p-4 space-y-3" style="height: 500px;">
                <div class="text-center text-gray-500 py-8">
                    Select a conversation to view messages
                </div>
            </div>
            
            <div id="chat-input-area" class="border-t border-white/10 p-4 hidden">
                <div class="flex gap-2">
                    <textarea id="reply-message" rows="2" placeholder="Type your reply..." class="flex-1 px-3 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none"></textarea>
                    <button id="send-reply" class="px-4 py-2 bg-fitar-accent hover:bg-fitar-accent-hover text-white rounded-lg h-fit">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentSessionId = null;
    let refreshInterval = null;
    
    document.querySelectorAll('.session-item').forEach(item => {
        item.addEventListener('click', function() {
            currentSessionId = this.dataset.session;
            loadMessages(currentSessionId);
            
            document.querySelectorAll('.session-item').forEach(s => s.classList.remove('bg-white/5'));
            this.classList.add('bg-white/5');
            
            document.getElementById('chat-input-area').classList.remove('hidden');
            
            if (refreshInterval) clearInterval(refreshInterval);
            refreshInterval = setInterval(() => {
                if (currentSessionId) loadMessages(currentSessionId);
            }, 5000);
        });
    });
    
    async function loadMessages(sessionId) {
        try {
            const response = await fetch(`/admin/support/messages?session_id=${sessionId}`);
            const messages = await response.json();
            
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.innerHTML = '';
            
            let userName = '';
            
            messages.forEach(msg => {
                if (msg.sender === 'user') {
                    chatMessages.innerHTML += `
                        <div class="flex items-start gap-2 justify-start">
                            <div class="w-8 h-8 rounded-full bg-fitar-accent/20 flex items-center justify-center flex-shrink-0">
                                <span class="text-fitar-accent">👤</span>
                            </div>
                            <div class="bg-fitar-card rounded-lg p-3 max-w-[70%]">
                                <p class="text-white text-sm">${escapeHtml(msg.message)}</p>
                                <p class="text-gray-500 text-xs mt-1">${new Date(msg.created_at).toLocaleTimeString()}</p>
                            </div>
                        </div>
                    `;
                } else if (msg.sender === 'ai') {
                    chatMessages.innerHTML += `
                        <div class="flex items-start gap-2 justify-start">
                            <div class="w-8 h-8 rounded-full bg-orange-500/20 flex items-center justify-center flex-shrink-0">
                                <span class="text-orange-500">🤖</span>
                            </div>
                            <div class="bg-gray-800 rounded-lg p-3 max-w-[70%]">
                                <p class="text-gray-300 text-sm">${escapeHtml(msg.message)}</p>
                                <p class="text-gray-500 text-xs mt-1">${new Date(msg.created_at).toLocaleTimeString()}</p>
                            </div>
                        </div>
                    `;
                } else if (msg.sender === 'admin') {
                    chatMessages.innerHTML += `
                        <div class="flex items-start gap-2 justify-end">
                            <div class="bg-fitar-accent rounded-lg p-3 max-w-[70%]">
                                <p class="text-white text-sm">${escapeHtml(msg.message)}</p>
                                <p class="text-gray-300 text-xs mt-1">${new Date(msg.created_at).toLocaleTimeString()} • Admin</p>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-fitar-accent flex items-center justify-center flex-shrink-0">
                                <span class="text-white">👑</span>
                            </div>
                        </div>
                    `;
                }
            });
            
            document.getElementById('chat-header').innerHTML = `
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white font-semibold">Support Conversation</p>
                        <p class="text-gray-400 text-xs">Session: ${sessionId.substring(0, 20)}...</p>
                    </div>
                </div>
            `;
            
            scrollToBottom();
        } catch (error) {
            console.error('Error loading messages:', error);
        }
    }
    
    document.getElementById('send-reply').addEventListener('click', async () => {
        const message = document.getElementById('reply-message').value.trim();
        if (!message || !currentSessionId) return;
        
        try {
            const response = await fetch('/admin/support/reply', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    session_id: currentSessionId,
                    message: message
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                document.getElementById('reply-message').value = '';
                loadMessages(currentSessionId);
            }
        } catch (error) {
            console.error('Error sending reply:', error);
        }
    });
    
    function scrollToBottom() {
        const chatMessages = document.getElementById('chat-messages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>
@endsection