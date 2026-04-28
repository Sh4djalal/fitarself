@extends('layouts.app')

@section('title', $faultCode->code . ' - ' . $faultCode->title_en)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <a href="/fault-codes" class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1">
        ← Back to Fault Codes
    </a>

    <!-- Header -->
    <div class="bg-fitar-surface/50 border border-{{ $faultCode->severity_color }}-500/30 rounded-2xl p-6 mb-8">
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-mono font-bold text-white mb-2">{{ $faultCode->code }}</h1>
                <p class="text-xl text-gray-200">{{ $faultCode->title_en }}</p>
            </div>
            <div class="flex gap-3">
                <span class="px-4 py-1.5 rounded-full text-sm font-medium bg-{{ $faultCode->severity_color }}-500/20 text-{{ $faultCode->severity_color }}-400 capitalize">{{ $faultCode->severity }}</span>
                <span class="px-4 py-1.5 rounded-full text-sm font-medium bg-white/10 text-gray-300">{{ $faultCode->system ?? 'General' }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Description -->
        <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
            <h2 class="text-lg font-heading font-bold text-white mb-3">📋 Description</h2>
            <p class="text-gray-300 leading-relaxed">{{ $faultCode->description_en }}</p>
        </div>

        <!-- Symptoms -->
        <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6">
            <h2 class="text-lg font-heading font-bold text-white mb-3">⚠️ Symptoms</h2>
            <ul class="space-y-2 text-gray-300">
                @foreach(explode("\n", $faultCode->symptoms_en ?? '') as $symptom)
                    @if(trim($symptom) !== '')
                    <li class="flex items-start gap-2">
                        <span class="text-fitar-accent mt-1">•</span>
                        {{ trim($symptom) }}
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Possible Causes -->
    <div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6 mb-8">
        <h2 class="text-lg font-heading font-bold text-white mb-3">🔧 Possible Causes</h2>
        <ol class="list-decimal list-inside space-y-2 text-gray-300">
            @foreach(explode("\n", $faultCode->possible_causes_en ?? '') as $cause)
                @if(trim($cause) !== '')
                <li>{{ trim($cause) }}</li>
                @endif
            @endforeach
        </ol>
    </div>

    <!-- Step-by-Step How to Fix — FROM DATABASE -->
    @if($faultCode->how_to_fix_en)
    <div class="bg-fitar-accent/5 border border-fitar-accent/30 rounded-xl p-6 mb-8">
        <h2 class="text-lg font-heading font-bold text-white mb-3">🛠️ How to Fix — Step by Step</h2>
        <div class="text-gray-300 whitespace-pre-line leading-relaxed">
            {!! nl2br(e($faultCode->how_to_fix_en)) !!}
        </div>
    </div>
    @endif

    <!-- Disclaimer -->
    <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-xl p-4 mb-8">
        <p class="text-yellow-400 text-sm">
            <span class="font-bold">⚠️ Disclaimer:</span> This guide is for informational purposes only. FitarSelf is not responsible for any damage or injury resulting from DIY repairs. Always consult a qualified mechanic if you're unsure.
        </p>
    </div>

    <!-- Related Codes -->
    @if($relatedCodes->count() > 0)
    <div>
        <h2 class="text-lg font-heading font-bold text-white mb-3">Related Fault Codes</h2>
        <div class="flex flex-wrap gap-2">
            @foreach($relatedCodes as $rc)
            <a href="/fault-codes/{{ $rc->id }}" class="px-3 py-1.5 bg-{{ $rc->severity_color }}-500/20 text-{{ $rc->severity_color }}-400 rounded-full text-sm font-mono hover:bg-{{ $rc->severity_color }}-500/30 transition">
                {{ $rc->code }}
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection