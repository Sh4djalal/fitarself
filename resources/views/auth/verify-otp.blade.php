@extends('layouts.app')

@section('title', 'Verify Your Email')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full bg-fitar-surface border border-white/10 rounded-2xl p-8">
        
        <div class="text-center mb-8">
            <div class="text-5xl mb-4">📧</div>
            <h1 class="text-2xl font-heading font-bold text-white mb-2">Verify Your Email</h1>
            <p class="text-gray-400">Enter the 6-digit code sent to <strong id="emailDisplay">{{ $email }}</strong></p>
        </div>

        <!-- Alert Messages -->
        <div id="alertMessage" class="hidden mb-4 p-3 rounded-lg text-center"></div>

        <!-- OTP Input Form -->
        <form id="otpForm" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div class="mb-6">
                <label class="block text-gray-300 text-sm font-medium mb-2">Verification Code</label>
                <div class="flex justify-center gap-3">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none" data-index="0">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none" data-index="1">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none" data-index="2">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none" data-index="3">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none" data-index="4">
                    <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-2xl font-bold bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none" data-index="5">
                </div>
                <input type="hidden" name="otp" id="otpValue">
            </div>

            <button type="submit" id="verifyBtn" class="w-full bg-fitar-accent hover:bg-fitar-accent-hover text-white py-3 rounded-lg font-medium transition">
                Verify Account
            </button>
        </form>

        <!-- Resend Section -->
        <div class="text-center mt-6">
            <p class="text-gray-400 text-sm">Didn't receive the code?</p>
            <button id="resendBtn" class="text-fitar-accent hover:text-fitar-accent-hover text-sm font-medium mt-1 transition">
                Resend Code
            </button>
            <span id="countdown" class="text-gray-500 text-sm hidden"></span>
        </div>

        <div class="text-center mt-6 pt-4 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-gray-400 text-sm transition">
                    ← Back to Login
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Auto-focus and move between OTP inputs
    const inputs = document.querySelectorAll('.otp-input');
    const otpValue = document.getElementById('otpValue');
    const verifyBtn = document.getElementById('verifyBtn');
    const resendBtn = document.getElementById('resendBtn');
    const countdownSpan = document.getElementById('countdown');
    const alertDiv = document.getElementById('alertMessage');
    const email = '{{ $email }}';

    let countdownTimer = null;
    let canResend = true;

    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (e.target.value.length === 1) {
                if (index < inputs.length - 1) {
                    inputs[index + 1].focus();
                } else {
                    inputs[index].blur();
                }
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
        
        // Auto-submit when all 6 digits are entered
        if (otp.length === 6) {
            verifyBtn.click();
        }
    }

    function showAlert(message, type = 'error') {
        alertDiv.textContent = message;
        alertDiv.className = `mb-4 p-3 rounded-lg text-center ${
            type === 'success' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400'
        }`;
        alertDiv.classList.remove('hidden');
        
        setTimeout(() => {
            alertDiv.classList.add('hidden');
        }, 5000);
    }

    // Verify OTP
    document.getElementById('otpForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const otp = otpValue.value;
        if (otp.length !== 6) {
            showAlert('Please enter the complete 6-digit code.');
            return;
        }

        verifyBtn.disabled = true;
        verifyBtn.textContent = 'Verifying...';

        try {
            const response = await fetch('{{ route("verification.otp.verify") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    email: email,
                    otp: otp
                })
            });

            const data = await response.json();

            if (data.success) {
                showAlert(data.message, 'success');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1500);
            } else {
                showAlert(data.message);
                // Clear OTP inputs on error
                inputs.forEach(input => input.value = '');
                otpValue.value = '';
                inputs[0].focus();
                verifyBtn.disabled = false;
                verifyBtn.textContent = 'Verify Account';
            }
        } catch (error) {
            showAlert('Something went wrong. Please try again.');
            verifyBtn.disabled = false;
            verifyBtn.textContent = 'Verify Account';
        }
    });

    // Resend OTP with cooldown
    resendBtn.addEventListener('click', async () => {
        if (!canResend) return;

        canResend = false;
        resendBtn.classList.add('opacity-50');
        
        showAlert('Sending verification code...', 'success');

        try {
            const response = await fetch('{{ route("verification.otp.resend") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: email })
            });

            const data = await response.json();

            if (data.success) {
                showAlert(data.message, 'success');
                startCooldown(60);
            } else {
                showAlert(data.message);
                canResend = true;
                resendBtn.classList.remove('opacity-50');
            }
        } catch (error) {
            showAlert('Failed to resend code. Please try again.');
            canResend = true;
            resendBtn.classList.remove('opacity-50');
        }
    });

    function startCooldown(seconds) {
        resendBtn.classList.add('hidden');
        countdownSpan.classList.remove('hidden');
        
        let remaining = seconds;
        countdownSpan.textContent = `Resend available in ${remaining}s`;
        
        countdownTimer = setInterval(() => {
            remaining--;
            if (remaining <= 0) {
                clearInterval(countdownTimer);
                countdownSpan.classList.add('hidden');
                resendBtn.classList.remove('hidden');
                canResend = true;
                resendBtn.classList.remove('opacity-50');
            } else {
                countdownSpan.textContent = `Resend available in ${remaining}s`;
            }
        }, 1000);
    }
</script>
@endsection