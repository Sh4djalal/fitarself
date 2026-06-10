@extends('layouts.app')

@section('title', $user->username ?? $user->name)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-fitar-surface border border-white/10 rounded-2xl p-6">
        
        <div class="mb-6">
            <a href="{{ url()->previous() }}" class="text-gray-400 hover:text-white">← Back</a>
        </div>

        <div class="text-center">
            <div class="w-24 h-24 rounded-full bg-fitar-card flex items-center justify-center text-3xl overflow-hidden mx-auto mb-4 ring-2 ring-fitar-accent/50">
                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
            </div>
            <h1 class="text-2xl font-bold text-white">{{ $user->username ?? $user->name }}</h1>
            <p class="text-gray-400">{{ $user->email }}</p>
            
            @if($user->city)
            <p class="text-gray-400 mt-2">📍 {{ $user->city }}</p>
            @endif
            @if($user->phone)
            <p class="text-gray-400">📞 {{ $user->phone }}</p>
            @endif
            
            @if($user->bio_en)
            <div class="mt-4 pt-3 border-t border-white/10">
                <p class="text-gray-400">📝 Bio</p>
                <p class="text-white">{{ $user->bio_en }}</p>
            </div>
            @endif

            @if($user->role === 'mechanic' && $user->mechanicDetail && $user->mechanicDetail->specialty_tags)
            <div class="mt-4 pt-3 border-t border-white/10">
                <p class="text-gray-400 mb-2">🔧 Specializations</p>
                <div class="flex flex-wrap gap-2 justify-center">
                    @php
                        $specTags = $user->mechanicDetail->specialty_tags ?? null;
                        $specialties = [];
                        if ($specTags && is_string($specTags)) {
                            $specTags = trim($specTags, '"');
                            $specialties = json_decode($specTags, true) ?? [];
                        }
                    @endphp
                    @if($specialties && is_array($specialties) && count($specialties) > 0)
                        @foreach($specialties as $spec)
                            <span class="px-2 py-1 bg-fitar-card rounded-lg text-xs text-gray-300">
                                {{ ucfirst($spec) }}
                            </span>
                        @endforeach
                    @endif
                </div>
            </div>
            @endif

            @if(Auth::check() && Auth::id() !== $user->id && Auth::user()->role === 'user')
            <div class="mt-6">
                <a href="{{ route('chat.start', $user->id) }}" class="inline-block bg-fitar-accent hover:bg-fitar-accent-hover text-white px-6 py-2 rounded-lg transition">
                    💬 Send Message
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection