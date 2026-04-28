@extends('layouts.guest')

@section('content')
<div style="background: #1a1a2e; border: 1px solid #333; border-radius: 16px; padding: 32px;">

    @if(request('type') === 'mechanic')
        {{-- ========== MECHANIC FORM ========== --}}
        <h1 style="font-size: 24px; font-weight: 900; color: white; margin-bottom: 8px;">🔧 Join as Mechanic</h1>
        <p style="color: #999; margin-bottom: 24px;">Create your professional profile.</p>

        <div style="display: flex; gap: 8px; margin-bottom: 24px;">
            <a href="/register" style="flex: 1; padding: 14px; background: #333; color: #ccc; text-align: center; border-radius: 8px; font-size: 15px; font-weight: 600; text-decoration: none;">👤 User</a>
            <a href="/register?type=mechanic" style="flex: 1; padding: 14px; background: #F47920; color: white; text-align: center; border-radius: 8px; font-size: 15px; font-weight: 600; text-decoration: none;">🔧 Mechanic</a>
        </div>

        <form action="/register" method="POST" style="display: flex; flex-direction: column; gap: 14px;">
            @csrf
            <input type="hidden" name="role" value="mechanic">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div>
                    <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">First Name *</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" required
                        style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Last Name *</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" required
                        style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Username *</label>
                <input type="text" name="username" value="{{ old('username') }}" required
                    style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Phone Number *</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required
                    style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">City *</label>
                <input type="text" name="city" value="{{ old('city') }}" required
                    style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; color: #999; margin-bottom: 6px;">Specialization *</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px;">
                    @php $specialties = ['engine-diagnostics' => '🔧 Engine', 'electrical' => '⚡ Electrical', 'diagnostics' => '📱 Diagnostics', 'brakes' => '🛞 Brakes', 'suspension' => '🔩 Suspension', 'transmission' => '🔄 Transmission', 'ac' => '❄️ AC', 'oil' => '🛢️ Oil', 'body' => '🎨 Body', 'tuning' => '💻 Tuning']; @endphp
                    @foreach($specialties as $key => $label)
                    <label style="display: flex; align-items: center; gap: 6px; padding: 8px; background: #1f2937; border: 1px solid #4b5563; border-radius: 6px; cursor: pointer; font-size: 12px; color: #ccc;">
                        <input type="checkbox" name="specialties[]" value="{{ $key }}" style="accent-color: #F47920;">
                        {{ $label }}
                    </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div>
                    <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Password *</label>
                    <input type="password" name="password" required
                        style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Confirm Password *</label>
                    <input type="password" name="password_confirmation" required
                        style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; box-sizing: border-box;">
                </div>
            </div>

            <button type="submit" style="width: 100%; padding: 14px; background: #F47920; color: white; border: none; border-radius: 8px; font-weight: bold; font-size: 15px; cursor: pointer;">🔧 Create Mechanic Account</button>
        </form>

    @else
        {{-- ========== USER FORM ========== --}}
        <h1 style="font-size: 24px; font-weight: 900; color: white; margin-bottom: 8px;">👤 Create Account</h1>
        <p style="color: #999; margin-bottom: 24px;">Join FitarSelf as a user or mechanic.</p>

        <div style="display: flex; gap: 8px; margin-bottom: 24px;">
            <a href="/register" style="flex: 1; padding: 14px; background: #F47920; color: white; text-align: center; border-radius: 8px; font-size: 15px; font-weight: 600; text-decoration: none;">👤 User</a>
            <a href="/register?type=mechanic" style="flex: 1; padding: 14px; background: #333; color: #ccc; text-align: center; border-radius: 8px; font-size: 15px; font-weight: 600; text-decoration: none;">🔧 Mechanic</a>
        </div>

        <form action="/register" method="POST" style="display: flex; flex-direction: column; gap: 14px;">
            @csrf
            <input type="hidden" name="role" value="user">

            <div>
                <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div>
                    <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Password</label>
                    <input type="password" name="password" required
                        style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                        style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; box-sizing: border-box;">
                </div>
            </div>

            <button type="submit" style="width: 100%; padding: 14px; background: #F47920; color: white; border: none; border-radius: 8px; font-weight: bold; font-size: 15px; cursor: pointer;">👤 Create User Account</button>
        </form>
    @endif

    @if($errors->any())
    <div style="background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.3); border-radius: 8px; padding: 12px; margin-top: 16px;">
        @foreach($errors->all() as $error)
        <p style="color: #f87171; font-size: 13px;">{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <p style="text-align: center; font-size: 13px; color: #999; margin-top: 16px;">
        Already have an account? <a href="/login" style="color: #F47920;">Login</a>
    </p>
</div>
@endsection