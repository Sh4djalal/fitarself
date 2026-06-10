@extends('layouts.app')

@section('title', 'Verify Your Mechanic Profile')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-fitar-surface border border-white/10 rounded-2xl p-6">
        
        <div class="text-center mb-6">
            <div class="text-5xl mb-3">🔧</div>
            <h1 class="text-2xl font-bold text-white">Verify Your Mechanic Profile</h1>
            <p class="text-gray-400 mt-2">Submit your documents to become a verified mechanic</p>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500 rounded-lg p-3 mb-4">
                <p class="text-green-400 text-sm">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/20 border border-red-500 rounded-lg p-3 mb-4">
                <p class="text-red-400 text-sm">{{ session('error') }}</p>
            </div>
        @endif

        @if(isset($mechanicDocument) && $mechanicDocument && $mechanicDocument->status === 'pending')
            <div class="bg-yellow-500/20 border border-yellow-500 rounded-lg p-4 mb-6 text-center">
                <p class="text-yellow-400">⏳ Your documents are being reviewed by our team. You'll receive an email once verified.</p>
            </div>
        @elseif(isset($mechanicDocument) && $mechanicDocument && $mechanicDocument->status === 'approved')
            <div class="bg-green-500/20 border border-green-500 rounded-lg p-4 mb-6 text-center">
                <p class="text-green-400">✅ Congratulations! You are now a verified mechanic on FitarSelf.</p>
            </div>
        @elseif(isset($mechanicDocument) && $mechanicDocument && $mechanicDocument->status === 'rejected')
            <div class="bg-red-500/20 border border-red-500 rounded-lg p-4 mb-6">
                <p class="text-red-400">❌ Your verification was rejected.</p>
                <p class="text-gray-400 text-sm mt-1">Reason: {{ $mechanicDocument->rejection_reason }}</p>
            </div>
        @endif

        @if(!isset($mechanicDocument) || $mechanicDocument->status !== 'approved')
            <form action="{{ route('mechanic.submit-documents') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Shop/Workshop Name *</label>
                    <input type="text" name="shop_name" value="{{ old('shop_name', isset($mechanicDocument) ? $mechanicDocument->shop_name : '') }}" required
                        class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">
                </div>

                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Shop/Workshop Address *</label>
                    <input type="text" name="shop_address" value="{{ old('shop_address', isset($mechanicDocument) ? $mechanicDocument->shop_address : '') }}" required
                        class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">
                </div>

                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">License Number (If available)</label>
                    <input type="text" name="license_number" value="{{ old('license_number', isset($mechanicDocument) ? $mechanicDocument->license_number : '') }}"
                        class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">
                </div>

                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">ID Card / Identification Photo *</label>
                    <input type="file" name="id_card" accept="image/*" {{ !isset($mechanicDocument) ? 'required' : '' }}
                        class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white file:mr-3 file:py-1 file:px-3 file:rounded file:bg-fitar-accent file:text-white file:border-0">
                    <p class="text-gray-500 text-xs mt-1">Upload a clear photo of your ID card.</p>
                </div>

                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Workshop Photo *</label>
                    <input type="file" name="shop_photo" accept="image/*" {{ !isset($mechanicDocument) ? 'required' : '' }}
                        class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white file:mr-3 file:py-1 file:px-3 file:rounded file:bg-fitar-accent file:text-white file:border-0">
                    <p class="text-gray-500 text-xs mt-1">Upload a photo of your workshop.</p>
                </div>

                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">License/Certificate Photo</label>
                    <input type="file" name="license_photo" accept="image/*"
                        class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white file:mr-3 file:py-1 file:px-3 file:rounded file:bg-fitar-accent file:text-white file:border-0">
                    <p class="text-gray-500 text-xs mt-1">Upload your mechanic license or certificate if available.</p>
                </div>

                <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Additional Information</label>
                    <textarea name="additional_info" rows="3" 
                        class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">{{ old('additional_info', isset($mechanicDocument) ? $mechanicDocument->additional_info : '') }}</textarea>
                    <p class="text-gray-500 text-xs mt-1">Tell us about your experience, specialties, etc.</p>
                </div>

                <button type="submit" class="w-full bg-fitar-accent hover:bg-fitar-accent-hover text-white py-3 rounded-lg font-medium transition mt-4">
                    Submit Verification Documents
                </button>
            </form>
        @endif

        <div class="text-center mt-6">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white text-sm">← Back to Dashboard</a>
        </div>
    </div>
</div>
@endsection