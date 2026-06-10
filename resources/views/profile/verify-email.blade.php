@extends('layouts.app')

@section('title', 'Verify New Email')

@section('content')
<div class="max-w-md mx-auto px-4 py-8">
    <div class="bg-fitar-surface border border-white/10 rounded-2xl p-6">
        
        <div class="text-center mb-6">
            <div class="text-4xl mb-3">🔐</div>
            <h1 class="text-2xl font-bold text-white">Verify New Email</h1>
            <p class="text-gray-400 mt-1">Enter the 6-digit code sent to</p>
            <p class="text-fitar-accent font-medium">{{ $newEmail }}</p>
        </div>

        @if($errors->any())
            <div class="bg-red-500/20 border border-red-500 rounded-lg p-3 mb-4">
                @foreach($errors->all() as $error)
                    <p class="text-red-400 text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('profile.verify-email-submit') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-300 text-sm font-medium mb-2">Verification Code</label>
                <div class="flex gap-2 justify-center">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none" data-index="0">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none" data-index="1">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none" data-index="2">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none" data-index="3">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none" data-index="4">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none" data-index="5">
                </div>
                <input type="hidden" name="otp" id="otpValue">
            </div>

            <button type="submit" class="w-full bg-fitar-accent hover:bg-fitar-accent-hover text-white py-2 rounded-lg font-medium transition">
                Verify & Change Email
            </button>
        </form>

        <div class="text-center mt-4">
            <form action="{{ route('profile.send-email-otp') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="new_email" value="{{ $newEmail }}">
                <button type="submit" class="text-fitar-accent hover:underline text-sm">Resend Code</button>
            </form>
        </div>
    </div>
</div>

<script>
    const inputs = document.querySelectorAll('.otp-input');
    const otpValue = document.getElementById('otpValue');

    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (e.target.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
            updateOtpValue();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });

    function updateOtpValue() {
        let otp = '';
        inputs.forEach(input => {
            otp += input.value;
        });
        otpValue.value = otp;
    }
</script>
@endsection