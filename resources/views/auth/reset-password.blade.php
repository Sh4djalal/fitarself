@extends('layouts.guest')

@section('content')
<div style="background: #1a1a2e; border: 1px solid #333; border-radius: 16px; padding: 32px; max-width: 450px; margin: 0 auto;">

    <h1 style="font-size: 24px; font-weight: 900; color: white; margin-bottom: 8px;">🔐 Create New Password</h1>
    <p style="color: #999; margin-bottom: 24px;">Enter your new password below.</p>

    @if ($errors->any())
        <div style="background: rgba(239,68,68,0.2); border: 1px solid #ef4444; border-radius: 8px; padding: 12px; margin-bottom: 20px;">
            @foreach ($errors->all() as $error)
                <p style="color: #f87171; font-size: 13px;">❌ {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('password.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 16px;">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Email Address *</label>
            <input type="email" name="email" value="{{ old('email', $request->email) }}" required
                style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
            @error('email')
                <p style="color: #f87171; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">New Password *</label>
            <input type="password" name="password" required
                style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
            <p style="color: #666; font-size: 11px; margin-top: 4px;">Minimum 8 characters.</p>
            @error('password')
                <p style="color: #f87171; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Confirm Password *</label>
            <input type="password" name="password_confirmation" required
                style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
        </div>

        <button type="submit" style="width: 100%; padding: 14px; background: #F47920; color: white; border: none; border-radius: 8px; font-weight: bold; font-size: 15px; cursor: pointer;">🔐 Reset Password</button>
    </form>

    <div style="text-align: center; margin-top: 24px; padding-top: 20px; border-top: 1px solid #333;">
        <a href="{{ route('login') }}" style="color: #F47920; text-decoration: none; font-size: 13px;">← Back to Login</a>
    </div>
</div>
@endsection