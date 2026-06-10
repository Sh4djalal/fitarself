@extends('layouts.app')

@section('title', 'Document Verifications')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">📄 Document Verifications</h1>
            <p class="text-gray-400">Review and verify mechanic document submissions</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white">← Back to Dashboard</a>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500 rounded-lg p-3 mb-4">
            <p class="text-green-400">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Tabs -->
    <div class="flex gap-2 mb-6 border-b border-white/10 pb-3">
        <a href="#pending" onclick="showTab('pending')" id="tab-pending" class="px-4 py-2 rounded-lg bg-yellow-500/20 text-yellow-400">⏳ Pending</a>
        <a href="#approved" onclick="showTab('approved')" id="tab-approved" class="px-4 py-2 rounded-lg text-gray-400 hover:text-white">✅ Approved</a>
        <a href="#rejected" onclick="showTab('rejected')" id="tab-rejected" class="px-4 py-2 rounded-lg text-gray-400 hover:text-white">❌ Rejected</a>
    </div>

    <!-- Pending Tab -->
    <div id="pending-tab" class="tab-content">
        <h2 class="text-xl font-semibold text-white mb-4">Pending Verifications ({{ $pendingDocs->count() }})</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($pendingDocs as $doc)
            <div class="bg-fitar-surface border border-white/10 rounded-xl p-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-full bg-fitar-card flex items-center justify-center text-xl">👤</div>
                    <span class="text-xs bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded-full">Pending</span>
                </div>
                <h3 class="text-white font-semibold text-lg">{{ $doc->user->name }}</h3>
                <p class="text-gray-400 text-sm">{{ $doc->user->email }}</p>
                <div class="mt-3 pt-3 border-t border-white/10">
                    <a href="{{ route('admin.document.view', $doc->id) }}" class="block w-full text-center bg-fitar-accent hover:bg-fitar-accent-hover text-white py-2 rounded-lg text-sm transition">📄 View Document</a>
                </div>
            </div>
            @empty
                <div class="col-span-3 text-center text-gray-400 py-8">No pending verifications.</div>
            @endforelse
        </div>
    </div>

    <!-- Approved Tab -->
    <div id="approved-tab" class="tab-content" style="display: none;">
        <h2 class="text-xl font-semibold text-white mb-4">Approved Verifications ({{ $approvedDocs->count() }})</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($approvedDocs as $doc)
            <div class="bg-fitar-surface border border-white/10 rounded-xl p-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-full bg-fitar-card flex items-center justify-center text-xl">✅</div>
                    <span class="text-xs bg-green-500/20 text-green-400 px-2 py-1 rounded-full">Approved</span>
                </div>
                <h3 class="text-white font-semibold text-lg">{{ $doc->user->name }}</h3>
                <p class="text-gray-400 text-sm">{{ $doc->user->email }}</p>
                <div class="mt-3 pt-3 border-t border-white/10">
                    <a href="{{ route('admin.document.view', $doc->id) }}" class="block w-full text-center bg-fitar-accent hover:bg-fitar-accent-hover text-white py-2 rounded-lg text-sm transition">📄 View Document</a>
                </div>
            </div>
            @empty
                <div class="col-span-3 text-center text-gray-400 py-8">No approved verifications.</div>
            @endforelse
        </div>
    </div>

    <!-- Rejected Tab -->
    <div id="rejected-tab" class="tab-content" style="display: none;">
        <h2 class="text-xl font-semibold text-white mb-4">Rejected Verifications ({{ $rejectedDocs->count() }})</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($rejectedDocs as $doc)
            <div class="bg-fitar-surface border border-white/10 rounded-xl p-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-full bg-fitar-card flex items-center justify-center text-xl">❌</div>
                    <span class="text-xs bg-red-500/20 text-red-400 px-2 py-1 rounded-full">Rejected</span>
                </div>
                <h3 class="text-white font-semibold text-lg">{{ $doc->user->name }}</h3>
                <p class="text-gray-400 text-sm">{{ $doc->user->email }}</p>
                <div class="mt-3 pt-3 border-t border-white/10">
                    <a href="{{ route('admin.document.view', $doc->id) }}" class="block w-full text-center bg-fitar-accent hover:bg-fitar-accent-hover text-white py-2 rounded-lg text-sm transition">📄 View Document</a>
                </div>
            </div>
            @empty
                <div class="col-span-3 text-center text-gray-400 py-8">No rejected verifications.</div>
            @endforelse
        </div>
    </div>
</div>

<script>
    function showTab(tab) {
        document.getElementById('pending-tab').style.display = tab === 'pending' ? 'block' : 'none';
        document.getElementById('approved-tab').style.display = tab === 'approved' ? 'block' : 'none';
        document.getElementById('rejected-tab').style.display = tab === 'rejected' ? 'block' : 'none';
        
        document.getElementById('tab-pending').className = tab === 'pending' ? 'px-4 py-2 rounded-lg bg-yellow-500/20 text-yellow-400' : 'px-4 py-2 rounded-lg text-gray-400 hover:text-white';
        document.getElementById('tab-approved').className = tab === 'approved' ? 'px-4 py-2 rounded-lg bg-green-500/20 text-green-400' : 'px-4 py-2 rounded-lg text-gray-400 hover:text-white';
        document.getElementById('tab-rejected').className = tab === 'rejected' ? 'px-4 py-2 rounded-lg bg-red-500/20 text-red-400' : 'px-4 py-2 rounded-lg text-gray-400 hover:text-white';
    }
</script>
@endsection