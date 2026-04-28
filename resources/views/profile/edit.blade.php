@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-heading font-bold text-white mb-8">✏️ Edit Profile</h1>

    <form action="/profile" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')

        <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6 space-y-4">
            <h2 class="text-lg font-heading font-bold text-white mb-4">Personal Info</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                        class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-lg text-white focus:outline-none focus:border-fitar-accent">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                        class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-lg text-white focus:outline-none focus:border-fitar-accent">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}" placeholder="+964 770 123 4567"
                        class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-fitar-accent">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">City</label>
                    <input type="text" name="city" value="{{ old('city', Auth::user()->city) }}" placeholder="Baghdad, Erbil, Sulaymaniyah..."
                        class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-fitar-accent">
                </div>
            </div>
        </div>

        <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6 space-y-4">
            <h2 class="text-lg font-heading font-bold text-white mb-4">About You</h2>
            
            <div>
                <label class="block text-sm text-gray-400 mb-1">Bio (English)</label>
                <textarea name="bio_en" rows="3" placeholder="Tell us about yourself..."
                    class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-fitar-accent">{{ old('bio_en', Auth::user()->bio_en) }}</textarea>
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-1">Bio (Kurdish)</label>
                <textarea name="bio_ku" rows="3" placeholder="کەمێک دەربارەی خۆت..."
                    class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-fitar-accent">{{ old('bio_ku', Auth::user()->bio_ku) }}</textarea>
            </div>
        </div>

        <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6 space-y-4">
            <h2 class="text-lg font-heading font-bold text-white mb-4">🔒 Change Password</h2>
            <p class="text-sm text-gray-400 mb-4">Leave blank to keep current password.</p>
            
            <div>
                <label class="block text-sm text-gray-400 mb-1">Current Password</label>
                <input type="password" name="current_password" 
                    class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-lg text-white focus:outline-none focus:border-fitar-accent">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">New Password</label>
                    <input type="password" name="password" 
                        class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-lg text-white focus:outline-none focus:border-fitar-accent">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Confirm New Password</label>
                    <input type="password" name="password_confirmation" 
                        class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-lg text-white focus:outline-none focus:border-fitar-accent">
                </div>
            </div>
        </div>

        @if(session('status'))
        <div class="bg-green-500/20 border border-green-500/30 rounded-xl p-4">
            <p class="text-green-400">{{ session('status') }}</p>
        </div>
        @endif

        <button type="submit" class="px-8 py-3 bg-fitar-accent hover:bg-fitar-accent-hover text-white rounded-lg font-bold transition">
            💾 Save Changes
        </button>
    </form>
</div>
@endsection