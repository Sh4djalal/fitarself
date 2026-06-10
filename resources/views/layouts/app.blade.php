<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="{{ session('theme', 'dark') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FitarSelf') - FitarSelf</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|montserrat:700,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Cropper.js for profile photo cropping -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    
    <style>
        /* Light mode text colors */
        html:not(.dark) body {
            color: #000000;
        }
        html:not(.dark) .text-white {
            color: #000000 !important;
        }
        html:not(.dark) .text-gray-300 {
            color: #333333 !important;
        }
        html:not(.dark) .text-gray-400 {
            color: #555555 !important;
        }
        html:not(.dark) .text-gray-500 {
            color: #666666 !important;
        }
        html:not(.dark) h1,
        html:not(.dark) h2,
        html:not(.dark) h3,
        html:not(.dark) h4,
        html:not(.dark) .font-bold {
            color: #000000 !important;
        }
        html:not(.dark) p:not(.text-fitar-accent) {
            color: #333333 !important;
        }
        html:not(.dark) .bg-black\/80 {
            background-color: rgba(255, 255, 255, 0.95) !important;
        }
        html:not(.dark) .border-white\/10 {
            border-color: rgba(0, 0, 0, 0.1) !important;
        }
        html:not(.dark) .bg-fitar-surface {
            background-color: #f0f0f0 !important;
        }
        html:not(.dark) .bg-fitar-card {
            background-color: #ffffff !important;
        }
        html:not(.dark) .bg-fitar-surface\/50 {
            background-color: rgba(240, 240, 240, 0.5) !important;
        }
        html:not(.dark) footer {
            background-color: rgba(255, 255, 255, 0.95) !important;
        }
        html:not(.dark) footer .text-gray-400 {
            color: #555555 !important;
        }
        html:not(.dark) footer .text-white {
            color: #000000 !important;
        }
        html:not(.dark) input,
        html:not(.dark) textarea {
            color: #000000 !important;
            background-color: #ffffff !important;
        }
        html:not(.dark) input::placeholder,
        html:not(.dark) textarea::placeholder {
            color: #999999 !important;
        }
        html:not(.dark) .text-fitar-accent {
            color: #F47920 !important;
        }
    </style>
</head>
<body class="bg-white dark:bg-fitar-dark text-gray-900 dark:text-white min-h-screen bg-fitar-gradient dark:bg-fitar-gradient-dark bg-no-repeat bg-cover bg-fixed">

    <header class="sticky top-0 z-30 bg-black/80 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <button onclick="document.getElementById('mobile-menu').style.display='block'" class="lg:hidden text-gray-300 hover:text-white text-2xl mr-3">☰</button>

                <a href="/" class="flex items-center gap-2">
                    <span class="text-2xl">🏎️</span>
                    <span class="text-xl font-heading font-black tracking-tight">Fitar<span class="text-fitar-accent">Self</span></span>
                </a>

                <nav class="hidden lg:flex items-center gap-6">
                    <a href="/cars" class="text-gray-300 hover:text-white font-medium">{{ __('Cars') }}</a>
                    <a href="/fault-codes" class="text-gray-300 hover:text-white font-medium">{{ __('Fault Codes') }}</a>
                    <a href="/mechanics" class="text-gray-300 hover:text-white font-medium">{{ __('Mechanics') }}</a>
                    <a href="/parts" class="text-gray-300 hover:text-white font-medium">{{ __('Parts') }}</a>
                    <a href="/community" class="text-gray-300 hover:text-white font-medium">{{ __('Community') }}</a>
                </nav>

                <div class="flex items-center gap-3">
                    <form action="/search" class="hidden sm:block" autocomplete="off">
                        <input type="text" name="q" placeholder="{{ __('Search...') }}" 
                            class="w-28 lg:w-48 px-4 py-1.5 bg-white/10 border border-white/20 rounded-full text-sm placeholder-gray-400 focus:outline-none focus:border-fitar-accent">
                    </form>
                    
                    <div class="hidden sm:flex rounded-full bg-white/5 border border-white/10 overflow-hidden">
                        <button onclick="switchLanguage('en')" class="px-2.5 py-1 text-xs font-medium {{ session('locale', 'en') == 'en' ? 'bg-fitar-accent text-white' : 'text-gray-400' }}">EN</button>
                        <button onclick="switchLanguage('ku')" class="px-2.5 py-1 text-xs font-medium {{ session('locale') == 'ku' ? 'bg-fitar-accent text-white' : 'text-gray-400' }}">KU</button>
                    </div>

                    <form action="/theme/toggle" method="POST" class="hidden sm:inline">
                        @csrf
                        <button class="text-gray-400 hover:text-white p-1 text-lg">{{ session('theme', 'dark') === 'dark' ? '☀️' : '🌙' }}</button>
                    </form>
                    @auth
                        <div class="relative group hidden lg:block">
                            <button class="flex items-center gap-2 text-gray-300 hover:text-white font-medium text-sm">
                                <div class="w-6 h-6 rounded-full bg-fitar-card flex items-center justify-center overflow-hidden">
                                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                </div>
                                {{ Auth::user()->username ?? Auth::user()->name }} <span class="text-xs">▼</span>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-fitar-surface border border-white/10 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                                <a href="/dashboard" class="block px-4 py-2 text-gray-300 hover:text-white hover:bg-white/10 transition">📊 Dashboard</a>
                                <a href="/profile" class="block px-4 py-2 text-gray-300 hover:text-white hover:bg-white/10 transition">✏️ Edit Profile</a>
                                @if(Auth::user()->isMechanic())
                                    <a href="{{ route('mechanic.verify-form') }}" class="block px-4 py-2 text-gray-300 hover:text-white hover:bg-white/10 transition">📄 Verification Status</a>
                                @endif
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-300 hover:text-white hover:bg-white/10 transition">👑 Admin Dashboard</a>
                                @endif
                                <hr class="border-white/10 my-1">
                                <form action="/logout" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-300 hover:text-white hover:bg-white/10 transition">🚪 Logout</button>
                                </form>
                            </div>
                        </div>
                        <a href="/dashboard" class="hidden sm:block text-gray-300 hover:text-white font-medium text-sm">{{ __('Dashboard') }}</a>
                        <form action="/logout" method="POST" class="hidden sm:inline">@csrf <button class="text-gray-400 hover:text-white text-sm">{{ __('Logout') }}</button></form>
                    @else
                        <a href="/login" class="hidden sm:block text-gray-300 hover:text-white font-medium text-sm">{{ __('Login') }}</a>
                        <a href="/register" class="hidden sm:block bg-fitar-accent hover:bg-fitar-accent-hover text-white px-4 py-1.5 rounded-full text-sm font-medium transition">{{ __('Sign Up') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <div id="mobile-menu" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; z-index:999;">
        <div onclick="document.getElementById('mobile-menu').style.display='none'" style="position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7);"></div>
        <div style="position:absolute; top:0; left:0; width:280px; height:100%; background:#1a1a2e; overflow-y:auto; padding:20px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
                <span style="font-size:20px; font-weight:900; color:white;">🏎️ Fitar<span style="color:#F47920;">Self</span></span>
                <button onclick="document.getElementById('mobile-menu').style.display='none'" style="color:white; font-size:28px; background:none; border:none; cursor:pointer;">✕</button>
            </div>
            
            @auth
            <div class="flex items-center gap-3 mb-4 pb-4 border-b border-white/10">
                <div class="w-10 h-10 rounded-full bg-fitar-card flex items-center justify-center overflow-hidden">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <p class="text-white font-medium">{{ Auth::user()->username ?? Auth::user()->name }}</p>
                    <p class="text-gray-400 text-xs">{{ Auth::user()->email }}</p>
                </div>
            </div>
            @endauth
            
            <a href="/cars" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;text-decoration:none;font-size:18px;">🚗 {{ __('Cars') }}</a>
            <a href="/fault-codes" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;text-decoration:none;font-size:18px;">⚡ {{ __('Fault Codes') }}</a>
            <a href="/mechanics" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;text-decoration:none;font-size:18px;">👨‍🔧 {{ __('Mechanics') }}</a>
            <a href="/parts" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;text-decoration:none;font-size:18px;">🔧 {{ __('Parts') }}</a>
            <a href="/community" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;text-decoration:none;font-size:18px;">👥 {{ __('Community') }}</a>
            <hr style="border-color:#333; margin:10px 0;">
            <a href="/search" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;text-decoration:none;font-size:18px;">🔍 {{ __('Search...') }}</a>
            @auth
            <a href="/dashboard" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;text-decoration:none;font-size:18px;">👤 {{ __('Dashboard') }}</a>
            @if(Auth::user()->isMechanic())
            <a href="{{ route('mechanic.verify-form') }}" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;text-decoration:none;font-size:18px;">📄 {{ __('Verification') }}</a>
            @endif
            @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;text-decoration:none;font-size:18px;">👑 {{ __('Admin') }}</a>
            @endif
            <form action="/logout" method="POST"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;background:none;border:none;font-size:18px;width:100%;text-align:left;cursor:pointer;">🚪 {{ __('Logout') }}</button></form>
            @else
            <a href="/login" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;text-decoration:none;font-size:18px;">🔑 {{ __('Login') }}</a>
            <a href="/register" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;background:#F47920;color:white;text-decoration:none;font-size:18px;border-radius:8px;">✨ {{ __('Sign Up') }}</a>
            @endif
        </div>
    </div>

    <main class="min-h-[60vh]">@yield('content')</main>

    <footer class="bg-black/50 border-t border-white/10 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <span class="text-xl font-heading font-black">🏎️ Fitar<span class="text-fitar-accent">Self</span></span>
                    <p class="text-gray-400 text-sm mt-2">{{ __('Your trusted automotive companion.') }}</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3">{{ __('Quick Links') }}</h4>
                    <div class="space-y-2 text-sm text-gray-400">
                        <a href="/cars" class="block hover:text-white">{{ __('All Cars') }}</a>
                        <a href="/fault-codes" class="block hover:text-white">{{ __('Fault Codes') }}</a>
                        <a href="/mechanics" class="block hover:text-white">{{ __('Mechanics') }}</a>
                        <a href="/parts" class="block hover:text-white">{{ __('Parts Marketplace') }}</a>
                        <a href="/community" class="block hover:text-white">{{ __('Community') }}</a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3">{{ __('Company') }}</h4>
                    <div class="space-y-2 text-sm text-gray-400">
                        <a href="#" class="block hover:text-white">{{ __('About Us') }}</a>
                        <a href="#" class="block hover:text-white">{{ __('Privacy Policy') }}</a>
                        <a href="#" class="block hover:text-white">{{ __('Terms of Service') }}</a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3">{{ __('Contact') }}</h4>
                    <div class="space-y-2 text-sm text-gray-400">
                        <p>✉ skillzalan@gmail.com</p>
                        <p>📞 07824932074</p>
                        <div class="flex gap-3 mt-3 text-xl"><a href="#" class="hover:text-white">📘</a><a href="#" class="hover:text-white">🚗</a><a href="#" class="hover:text-white">📸</a></div>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/10 mt-8 pt-8 text-center text-sm text-gray-500">© 2026 FitarSelf. {{ __('All rights reserved.') }}</div>
        </div>
    </footer>

    <!-- Support Chat Widget -->
    <div id="support-chat" style="position: fixed; bottom: 20px; right: 20px; z-index: 99999;">
        <button id="chat-toggle" style="width: 56px; height: 56px; border-radius: 50%; background-color: #F47920; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;">
            <svg style="width: 28px; height: 28px; color: white;" fill="none" stroke="white" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
        </button>

        <div id="chat-window" style="display: none; position: absolute; bottom: 70px; right: 0; width: 350px; background: #1a1a2e; border: 1px solid #333; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
            <div style="background: #F47920; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 32px; height: 32px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 18px; height: 18px; color: #F47920;" fill="none" stroke="#F47920" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div>
                        <div style="color: white; font-weight: bold;">FitarSelf Support</div>
                        <div style="color: #ccc; font-size: 10px;">AI Assistant</div>
                    </div>
                </div>
                <button id="chat-close" style="background: none; border: none; color: white; font-size: 22px; cursor: pointer;">&times;</button>
            </div>
            
            <div id="chat-messages" style="height: 350px; overflow-y: auto; padding: 16px; display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; gap: 8px;">
                    <div style="width: 28px; height: 28px; background: rgba(244,121,32,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 14px; height: 14px; color: #F47920;" fill="none" stroke="#F47920" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div style="background: #1f2937; padding: 8px 12px; border-radius: 12px; max-width: 80%;">
                        <div style="color: #ddd; font-size: 12px;">Hello! 👋 I'm FitarSelf AI assistant. How can I help you today?</div>
                    </div>
                </div>
            </div>
            
            <div style="border-top: 1px solid #333; padding: 12px;">
                <div style="display: flex; gap: 8px;">
                    <input type="text" id="chat-input" placeholder="Type your message..." style="flex: 1; padding: 8px 12px; background: #0f0f1a; border: 1px solid #333; border-radius: 8px; outline: none;">
                    <button id="chat-send" style="padding: 8px 16px; background: #F47920; border: none; border-radius: 8px; color: white; cursor: pointer;">Send</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchLanguage(lang) {
            fetch('/language/' + lang, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    window.location.reload();
                }
            }).catch(error => {
                window.location.reload();
            });
        }

        const chatToggle = document.getElementById('chat-toggle');
        const chatWindow = document.getElementById('chat-window');
        const chatClose = document.getElementById('chat-close');
        const chatSend = document.getElementById('chat-send');
        const chatInput = document.getElementById('chat-input');
        const chatMessages = document.getElementById('chat-messages');
        
        function addMessage(text, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.style.display = 'flex';
            messageDiv.style.gap = '8px';
            messageDiv.style.marginBottom = '12px';
            messageDiv.style.justifyContent = sender === 'user' ? 'flex-end' : 'flex-start';
            
            if (sender === 'user') {
                messageDiv.innerHTML = `
                    <div style="background: #F47920; padding: 8px 12px; border-radius: 12px; max-width: 75%;">
                        <div style="color: white; font-size: 12px;">${escapeHtml(text)}</div>
                    </div>
                `;
            } else {
                messageDiv.innerHTML = `
                    <div style="width: 28px; height: 28px; background: rgba(244,121,32,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 14px; height: 14px; color: #F47920;" fill="none" stroke="#F47920" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div style="background: #1f2937; padding: 8px 12px; border-radius: 12px; max-width: 75%;">
                        <div style="color: #ddd; font-size: 12px;">${escapeHtml(text)}</div>
                    </div>
                `;
            }
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        async function sendMessage() {
            const message = chatInput.value.trim();
            if (!message) return;
            
            addMessage(message, 'user');
            chatInput.value = '';
            
            try {
                const response = await fetch('/support/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: message })
                });
                const data = await response.json();
                if (data.ai_message) {
                    addMessage(data.ai_message.message, 'ai');
                }
            } catch (error) {
                addMessage('Sorry, I encountered an error. Please try again.', 'ai');
            }
        }
        
        chatToggle.onclick = () => {
            if (chatWindow.style.display === 'none' || chatWindow.style.display === '') {
                chatWindow.style.display = 'block';
            } else {
                chatWindow.style.display = 'none';
            }
        };
        
        chatClose.onclick = () => chatWindow.style.display = 'none';
        chatSend.onclick = sendMessage;
        chatInput.onkeypress = (e) => { if (e.key === 'Enter') sendMessage(); };
    </script>

</body>
</html>