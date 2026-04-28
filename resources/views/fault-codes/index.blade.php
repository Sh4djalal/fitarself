@extends('layouts.app')

@section('title', 'Fault Codes')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-heading font-bold text-white mb-2">⚡ Fault Codes</h1>
    <p class="text-gray-400 mb-8">Browse OBD-II diagnostic trouble codes with explanations, symptoms, and fixes.</p>

    <!-- Type Filters -->
    <div class="flex flex-wrap gap-3 mb-6">
        <a href="/fault-codes" class="px-4 py-2 rounded-full text-sm font-medium {{ !request('type') ? 'bg-fitar-accent text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20' }} transition">All</a>
        <a href="/fault-codes?type=P" class="px-4 py-2 rounded-full text-sm font-medium {{ request('type') == 'P' ? 'bg-fitar-accent text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20' }} transition">🔴 P-Codes</a>
        <a href="/fault-codes?type=B" class="px-4 py-2 rounded-full text-sm font-medium {{ request('type') == 'B' ? 'bg-fitar-accent text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20' }} transition">⚙️ B-Codes</a>
        <a href="/fault-codes?type=C" class="px-4 py-2 rounded-full text-sm font-medium {{ request('type') == 'C' ? 'bg-fitar-accent text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20' }} transition">🛡️ C-Codes</a>
        <a href="/fault-codes?type=U" class="px-4 py-2 rounded-full text-sm font-medium {{ request('type') == 'U' ? 'bg-fitar-accent text-white' : 'bg-white/10 text-gray-300 hover:bg-white/20' }} transition">📡 U-Codes</a>
    </div>

    <!-- Live Search -->
    <div class="mb-6">
        <input type="text" id="live-search" name="search" value="{{ request('search') }}" placeholder="Search by code or keyword..." 
            class="w-full max-w-md px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:border-fitar-accent"
            oninput="filterCodes()">
    </div>

    <!-- Fault Codes List -->
    <div id="codes-list" class="space-y-3">
        @forelse($faultCodes as $code)
        <a href="/fault-codes/{{ $code->id }}" class="code-item flex items-center justify-between bg-fitar-surface/50 border border-white/10 rounded-xl p-5 hover:border-{{ $code->severity_color }}-500/50 transition-all w-full" data-code="{{ $code->code }}" data-title="{{ strtolower($code->title_en) }}">
            <div class="flex items-center gap-4">
                <span class="text-xl font-mono font-bold text-white w-24">{{ $code->code }}</span>
                <span class="text-gray-300 code-title">{{ $code->title_en }}</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-500 hidden sm:block">{{ $code->system ?? '' }}</span>
                <span class="px-3 py-1 rounded-full text-xs font-medium bg-{{ $code->severity_color }}-500/20 text-{{ $code->severity_color }}-400 capitalize">{{ $code->severity }}</span>
            </div>
        </a>
        @empty
        <div class="text-center text-gray-500 py-16" id="no-results">
            <p class="text-xl mb-2">🔍</p><p>No fault codes found.</p>
        </div>
        @endforelse
    </div>
    
    <div class="mt-8">
        {{ $faultCodes->links() }}
    </div>
</div>

<script>
function filterCodes() {
    const search = document.getElementById('live-search').value.toLowerCase();
    const items = document.querySelectorAll('.code-item');
    let visible = 0;
    
    items.forEach(item => {
        const code = item.getAttribute('data-code').toLowerCase();
        const title = item.getAttribute('data-title');
        if (code.includes(search) || title.includes(search)) {
            item.style.display = 'flex';
            visible++;
        } else {
            item.style.display = 'none';
        }
    });
    
    if (visible === 0 && search.length > 0) {
        document.getElementById('no-results').style.display = 'block';
    } else {
        const nr = document.getElementById('no-results');
        if (nr) nr.style.display = 'none';
    }
}
</script>
@endsection