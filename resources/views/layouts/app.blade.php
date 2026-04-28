<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="{{ session('theme', 'dark') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FitarSelf') - FitarSelf</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|montserrat:700,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white dark:bg-fitar-dark text-gray-900 dark:text-white min-h-screen bg-fitar-gradient dark:bg-fitar-gradient-dark bg-no-repeat bg-cover bg-fixed">

        <header class="sticky top-0 z-30 bg-black/80 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Hamburger - only on mobile -->
                <button onclick="document.getElementById('mobile-menu').style.display='block'" class="lg:hidden text-gray-300 hover:text-white text-2xl mr-3">☰</button>

                <a href="/" class="flex items-center gap-2">
                    <span class="text-2xl">🏎️</span>
                    <span class="text-xl font-heading font-black tracking-tight">Fitar<span class="text-fitar-accent">Self</span></span>
                </a>

                <!-- Desktop Nav - only on desktop -->
                <nav class="hidden lg:flex items-center gap-6">
                    <a href="/cars" class="text-gray-300 hover:text-white font-medium">Cars</a>
                    <div class="relative group">
                        <button class="text-gray-300 hover:text-white font-medium flex items-center gap-1">Fault Codes ▾</button>
                        <div class="absolute top-full left-0 mt-2 w-64 bg-fitar-surface border border-white/10 rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all p-4 z-50">
                            <a href="/fault-codes" class="block text-white font-semibold mb-3 hover:text-fitar-accent">📋 All Fault Codes</a>
                            <div class="space-y-1">
                                <a href="/fault-codes?type=P" class="block px-3 py-2 rounded-lg hover:bg-white/5 text-sm text-gray-300">🔴 P-Codes</a>
                                <a href="/fault-codes?type=B" class="block px-3 py-2 rounded-lg hover:bg-white/5 text-sm text-gray-300">⚙️ B-Codes</a>
                                <a href="/fault-codes?type=C" class="block px-3 py-2 rounded-lg hover:bg-white/5 text-sm text-gray-300">🛡️ C-Codes</a>
                                <a href="/fault-codes?type=U" class="block px-3 py-2 rounded-lg hover:bg-white/5 text-sm text-gray-300">📡 U-Codes</a>
                            </div>
                        </div>
                    </div>
                    <div class="relative group">
                        <button class="text-gray-300 hover:text-white font-medium flex items-center gap-1">Mechanics ▾</button>
                        <div class="absolute top-full left-0 mt-2 w-64 bg-fitar-surface border border-white/10 rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all p-4 z-50">
                            <a href="/mechanics" class="block text-white font-semibold mb-3 hover:text-fitar-accent">👨‍🔧 All Mechanics</a>
                            @php $specialties = ['engine-diagnostics'=>'🔧 Engine','electrical'=>'⚡ Electrical','diagnostics'=>'📱 Diagnostics','brakes'=>'🛞 Brakes','turbo-repair'=>'🔧 Turbo']; @endphp
                            @foreach($specialties as $key => $label)
                            <a href="/mechanics?specialty={{ $key }}" class="block px-3 py-2 rounded-lg hover:bg-white/5 text-sm text-gray-300">{{ $label }}</a>
                            @endforeach
                        </div>
                    </div>
                    <a href="/parts" class="text-gray-300 hover:text-white font-medium">Parts</a>
                </nav>

                <!-- Right Section -->
                <div class="flex items-center gap-3">
                    <form action="/search" class="hidden sm:block" autocomplete="off">
                        <input type="text" name="q" placeholder="Search..." 
                            class="w-28 lg:w-48 px-4 py-1.5 bg-white/10 border border-white/20 rounded-full text-sm text-white placeholder-gray-400 focus:outline-none focus:border-fitar-accent">
                    </form>
                    <div class="hidden sm:flex rounded-full bg-white/5 border border-white/10 overflow-hidden">
                        <a href="/language/en" class="px-2.5 py-1 text-xs font-medium {{ app()->getLocale() == 'en' ? 'bg-fitar-accent text-white' : 'text-gray-400' }}">EN</a>
                        <a href="/language/ku" class="px-2.5 py-1 text-xs font-medium {{ app()->getLocale() == 'ku' ? 'bg-fitar-accent text-white' : 'text-gray-400' }}">KU</a>
                    </div>
                    <form action="/theme/toggle" method="POST" class="hidden sm:inline">
                        @csrf
                        <button class="text-gray-400 hover:text-white p-1 text-lg">{{ session('theme', 'dark') === 'dark' ? '☀️' : '🌙' }}</button>
                    </form>
                    @auth
                        <a href="/dashboard" class="hidden sm:block text-gray-300 hover:text-white font-medium text-sm">Dashboard</a>
                        <form action="/logout" method="POST" class="hidden sm:inline">@csrf <button class="text-gray-400 hover:text-white text-sm">Logout</button></form>
                    @else
                        <a href="/login" class="hidden sm:block text-gray-300 hover:text-white font-medium text-sm">Login</a>
                        <a href="/register" class="hidden sm:block bg-fitar-accent hover:bg-fitar-accent-hover text-white px-4 py-1.5 rounded-full text-sm font-medium transition">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Menu - absolutely positioned overlay -->
    <div id="mobile-menu" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; z-index:999;">
        <div onclick="document.getElementById('mobile-menu').style.display='none'" style="position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7);"></div>
        <div style="position:absolute; top:0; left:0; width:280px; height:100%; background:#1a1a2e; overflow-y:auto; padding:20px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
                <span style="font-size:20px; font-weight:900; color:white;">🏎️ Fitar<span style="color:#F47920;">Self</span></span>
                <button onclick="document.getElementById('mobile-menu').style.display='none'" style="color:white; font-size:28px; background:none; border:none; cursor:pointer;">✕</button>
            </div>
            <a href="/cars" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;text-decoration:none;font-size:18px;">🚗 Cars</a>
            <a href="/fault-codes" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;text-decoration:none;font-size:18px;">⚡ Fault Codes</a>
            <a href="/mechanics" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;text-decoration:none;font-size:18px;">👨‍🔧 Mechanics</a>
            <a href="/parts" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;text-decoration:none;font-size:18px;">🔧 Parts</a>
            <hr style="border-color:#333; margin:10px 0;">
            <a href="/search" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;text-decoration:none;font-size:18px;">🔍 Search</a>
            @auth
            <a href="/dashboard" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;text-decoration:none;font-size:18px;">👤 Dashboard</a>
            <form action="/logout" method="POST"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;background:none;border:none;font-size:18px;width:100%;text-align:left;cursor:pointer;">🚪 Logout</button></form>
            @else
            <a href="/login" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;color:#ddd;text-decoration:none;font-size:18px;">🔑 Login</a>
            <a href="/register" onclick="document.getElementById('mobile-menu').style.display='none'" style="display:flex;align-items:center;gap:12px;padding:14px;background:#F47920;color:white;text-decoration:none;font-size:18px;border-radius:8px;">✨ Sign Up</a>
            @endif
        </div>
    </div>

    <!-- Mobile Slide-Out Menu (hidden by default) -->
    <div id="mobile-menu" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; z-index:50;">
        <div style="position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6);" onclick="closeMenu()"></div>
        <div style="position:absolute; top:0; left:0; width:280px; height:100%; background:#1a1a2e; overflow-y:auto; padding:20px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
                <span style="font-size:20px; font-weight:900; color:white;">🏎️ Fitar<span style="color:#F47920;">Self</span></span>
                <button onclick="closeMenu()" style="color:#999; font-size:24px; background:none; border:none; cursor:pointer;">✕</button>
            </div>
            <div style="display:flex; flex-direction:column; gap:5px;">
                <a href="/cars" onclick="closeMenu()" style="display:flex; align-items:center; gap:12px; padding:12px; color:#ccc; text-decoration:none; font-size:18px; border-radius:8px;">🚗 Cars</a>
                <a href="/fault-codes" onclick="closeMenu()" style="display:flex; align-items:center; gap:12px; padding:12px; color:#ccc; text-decoration:none; font-size:18px; border-radius:8px;">⚡ Fault Codes</a>
                <a href="/mechanics" onclick="closeMenu()" style="display:flex; align-items:center; gap:12px; padding:12px; color:#ccc; text-decoration:none; font-size:18px; border-radius:8px;">👨‍🔧 Mechanics</a>
                <a href="/parts" onclick="closeMenu()" style="display:flex; align-items:center; gap:12px; padding:12px; color:#ccc; text-decoration:none; font-size:18px; border-radius:8px;">🔧 Parts</a>
                <hr style="border-color:#333; margin:10px 0;">
                <a href="/search" onclick="closeMenu()" style="display:flex; align-items:center; gap:12px; padding:12px; color:#ccc; text-decoration:none; font-size:18px; border-radius:8px;">🔍 Search</a>
                @auth
                <a href="/dashboard" onclick="closeMenu()" style="display:flex; align-items:center; gap:12px; padding:12px; color:#ccc; text-decoration:none; font-size:18px; border-radius:8px;">👤 Dashboard</a>
                <form action="/logout" method="POST">
                    @csrf
                    <button style="display:flex; align-items:center; gap:12px; padding:12px; color:#ccc; background:none; border:none; cursor:pointer; font-size:18px; width:100%; text-align:left;">🚪 Logout</button>
                </form>
                @else
                <a href="/login" onclick="closeMenu()" style="display:flex; align-items:center; gap:12px; padding:12px; color:#ccc; text-decoration:none; font-size:18px; border-radius:8px;">🔑 Login</a>
                <a href="/register" onclick="closeMenu()" style="display:flex; align-items:center; gap:12px; padding:12px; background:#F47920; color:white; text-decoration:none; font-size:18px; border-radius:8px;">✨ Sign Up</a>
                @endif
            </div>
        </div>
    </div>

    <main class="min-h-[60vh]">@yield('content')</main>

    <footer class="bg-black/50 border-t border-white/10 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <span class="text-xl font-heading font-black">🏎️ Fitar<span class="text-fitar-accent">Self</span></span>
                    <p class="text-gray-400 text-sm mt-2">Your trusted automotive companion.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3">Quick Links</h4>
                    <div class="space-y-2 text-sm text-gray-400">
                        <a href="/cars" class="block hover:text-white">All Cars</a><a href="/fault-codes" class="block hover:text-white">Fault Codes</a><a href="/mechanics" class="block hover:text-white">Mechanics</a><a href="/parts" class="block hover:text-white">Parts Marketplace</a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3">Company</h4>
                    <div class="space-y-2 text-sm text-gray-400"><a href="#" class="block hover:text-white">About Us</a><a href="#" class="block hover:text-white">Privacy Policy</a><a href="#" class="block hover:text-white">Terms of Service</a></div>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3">Contact</h4>
                    <div class="space-y-2 text-sm text-gray-400"><p>✉ contact@fitarself.com</p><p>📞 +964 000 000 0000</p><div class="flex gap-3 mt-3 text-xl"><a href="#" class="hover:text-white">📘</a><a href="#" class="hover:text-white">🐦</a><a href="#" class="hover:text-white">📸</a></div></div>
                </div>
            </div>
            <div class="border-t border-white/10 mt-8 pt-8 text-center text-sm text-gray-500">© 2026 FitarSelf. All rights reserved.</div>
        </div>
    </footer>

    <script>
        function openMenu() {
            document.getElementById('mobile-menu').style.display = 'block';
        }
        function closeMenu() {
            document.getElementById('mobile-menu').style.display = 'none';
        }
    </script>

</body>
</html>