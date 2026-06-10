@extends('layouts.app')

@section('title', app()->getLocale() == 'ku' ? ($faultCode->title_ku ?? $faultCode->code) : ($faultCode->title_en ?? $faultCode->code))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <a href="/fault-codes?make={{ $faultCode->make }}" class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1">
        ← {{ __('Back to') }} {{ $faultCode->make }} {{ __('Fault Codes') }}
    </a>

    <!-- Header -->
    <div class="bg-fitar-surface/50 border border-{{ $faultCode->severity_color ?? 'yellow' }}-500/30 rounded-2xl p-6 mb-8">
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-mono font-bold text-white mb-2">{{ $faultCode->code }}</h1>
                <p class="text-xl text-gray-200">{{ app()->getLocale() == 'ku' ? ($faultCode->title_ku ?? $faultCode->code) : ($faultCode->title_en ?? $faultCode->code) }}</p>
            </div>
            <div class="flex gap-3">
                <span class="px-4 py-1.5 rounded-full text-sm font-medium bg-{{ $faultCode->severity_color ?? 'yellow' }}-500/20 text-{{ $faultCode->severity_color ?? 'yellow' }}-400 capitalize">{{ $faultCode->severity ?? 'unknown' }}</span>
                <span class="px-4 py-1.5 rounded-full text-sm font-medium bg-white/10 text-gray-300">{{ $faultCode->system ?? 'General' }}</span>
            </div>
        </div>
    </div>

    @if($faultCode->description_en)
        {{-- FAULT CODE IMAGE --}}
        @php
            $imageService = new \App\Services\ImageSearchService();
            $images = $imageService->searchImage($faultCode->make . ' ' . $faultCode->code . ' OBD-II car part');
            $image = $images[0] ?? null;
        @endphp

        @if($image)
        <div class="bg-fitar-surface/50 border border-white/10 rounded-2xl overflow-hidden mb-8">
            <img src="{{ $image['url'] }}" alt="{{ $faultCode->title_en }}" class="w-full h-64 sm:h-80 object-cover" onerror="this.style.display='none'">
        </div>
        @endif

        {{-- FULL DETAIL VIEW --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <h2 class="text-lg font-heading font-bold text-white mb-3">📋 {{ __('Description') }}</h2>
                <p class="text-gray-300 leading-relaxed">{{ app()->getLocale() == 'ku' ? $faultCode->description_ku : $faultCode->description_en }}</p>
            </div>
            <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
                <h2 class="text-lg font-heading font-bold text-white mb-3">⚠️ {{ __('Symptoms') }}</h2>
                <ul class="space-y-2 text-gray-300">
                    @foreach(explode("\n", app()->getLocale() == 'ku' ? ($faultCode->symptoms_ku ?? '') : ($faultCode->symptoms_en ?? '')) as $symptom)
                        @if(trim($symptom) !== '')
                        <li class="flex items-start gap-2"><span class="text-fitar-accent mt-1">•</span>{{ trim($symptom) }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6 mb-8">
            <h2 class="text-lg font-heading font-bold text-white mb-3">🔧 {{ __('Possible Causes') }}</h2>
            <ol class="list-decimal list-inside space-y-2 text-gray-300">
                @foreach(explode("\n", app()->getLocale() == 'ku' ? ($faultCode->possible_causes_ku ?? '') : ($faultCode->possible_causes_en ?? '')) as $cause)
                    @if(trim($cause) !== '')<li>{{ trim($cause) }}</li>@endif
                @endforeach
            </ol>
        </div>

        @if(app()->getLocale() == 'ku' ? $faultCode->how_to_fix_ku : $faultCode->how_to_fix_en)
        <div class="bg-fitar-accent/5 border border-fitar-accent/30 rounded-xl p-6 mb-8">
            <h2 class="text-lg font-heading font-bold text-white mb-3">🛠️ {{ __('How to Fix — Step by Step') }}</h2>
            <div class="text-gray-300 whitespace-pre-line leading-relaxed">
                {!! nl2br(e(app()->getLocale() == 'ku' ? $faultCode->how_to_fix_ku : $faultCode->how_to_fix_en)) !!}
            </div>
        </div>
        @endif

        {{-- YOUTUBE VIDEOS --}}
        @php
            $youtube = new \App\Services\YouTubeService();
            $videos = $youtube->searchVideos($faultCode->make . ' ' . $faultCode->code . ' fix');
        @endphp

        @if(count($videos) > 0)
        <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6 mb-8">
            <h2 class="text-lg font-heading font-bold text-white mb-4">📺 {{ __('Fix Videos on YouTube') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($videos as $video)
                <a href="{{ $video['url'] }}" target="_blank" class="bg-black/30 rounded-xl overflow-hidden hover:border-fitar-accent/50 border border-white/5 transition-all group">
                    <img src="{{ $video['thumbnail'] }}" alt="{{ $video['title'] }}" class="w-full h-36 object-cover">
                    <div class="p-3">
                        <p class="text-sm text-gray-300 group-hover:text-white line-clamp-2">{{ $video['title'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">⏱️ {{ $video['duration'] }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    @else
        {{-- COMING SOON VIEW --}}
        <div class="text-center py-16">
            <span class="text-7xl mb-6 block">🚧</span>
            <h2 class="text-2xl font-heading font-bold text-white mb-4">{{ __('Detailed Guide Coming Soon') }}</h2>
            <p class="text-gray-400 max-w-lg mx-auto mb-2">
                {{ __('We have identified this fault code for') }} <span class="text-fitar-accent font-semibold">{{ $faultCode->make }}</span>.
            </p>
            <p class="text-gray-500 max-w-lg mx-auto mb-8">
                {{ __('Our AI system is generating the complete guide with description, symptoms, possible causes, step-by-step fix instructions, and Kurdish translation.') }}
            </p>
            <div class="inline-flex items-center gap-2 px-6 py-3 bg-fitar-accent/20 border border-fitar-accent/30 rounded-xl text-fitar-accent text-sm">
                ⏳ {{ __('Estimated completion: Within 24 hours') }}
            </div>
        </div>
    @endif

    <!-- Disclaimer -->
    <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-xl p-4 mb-8">
        <p class="text-yellow-400 text-sm">
            <span class="font-bold">⚠️ {{ __('Disclaimer:') }}</span> {{ __('This guide is for informational purposes only. FitarSelf is not responsible for any damage or injury resulting from DIY repairs. Always consult a qualified mechanic if you\'re unsure.') }}
        </p>
    </div>

    <!-- Related Codes -->
    @if($relatedCodes->count() > 0)
    <div>
        <h2 class="text-lg font-heading font-bold text-white mb-3">{{ __('Related Fault Codes') }}</h2>
        <div class="flex flex-wrap gap-2">
            @foreach($relatedCodes as $rc)
            <a href="/fault-codes/{{ $rc->id }}" class="px-3 py-1.5 bg-{{ $rc->severity_color ?? 'yellow' }}-500/20 text-{{ $rc->severity_color ?? 'yellow' }}-400 rounded-full text-sm font-mono hover:bg-{{ $rc->severity_color ?? 'yellow' }}-500/30 transition">
                {{ $rc->code }}
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection