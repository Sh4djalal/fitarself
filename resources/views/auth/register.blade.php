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
            <a href="/register?type=admin" style="flex: 1; padding: 14px; background: #333; color: #ccc; text-align: center; border-radius: 8px; font-size: 15px; font-weight: 600; text-decoration: none;">👑 Admin</a>
        </div>

        <form action="{{ route('register') }}" method="POST" style="display: flex; flex-direction: column; gap: 14px;" id="mechanicForm">
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
                    style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;"
                    placeholder="e.g., mechanic_john">
                <p style="color: #666; font-size: 11px; margin-top: 4px;">Only letters, numbers, and underscores. Unique username.</p>
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
                    <label style="display: flex; align-items: center; gap: 6px; padding: 8px; background: #1f2937; border: 1px solid #4b5563; border-radius: 6px; cursor: pointer; font-size: 12px; color: #ccc;">
                        <input type="checkbox" name="specialties[]" value="engine" class="specialty-checkbox" style="accent-color: #F47920;"> 🔧 Engine
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; padding: 8px; background: #1f2937; border: 1px solid #4b5563; border-radius: 6px; cursor: pointer; font-size: 12px; color: #ccc;">
                        <input type="checkbox" name="specialties[]" value="electrical" class="specialty-checkbox" style="accent-color: #F47920;"> ⚡ Electrical
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; padding: 8px; background: #1f2937; border: 1px solid #4b5563; border-radius: 6px; cursor: pointer; font-size: 12px; color: #ccc;">
                        <input type="checkbox" name="specialties[]" value="diagnostics" class="specialty-checkbox" style="accent-color: #F47920;"> 📱 Diagnostics
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; padding: 8px; background: #1f2937; border: 1px solid #4b5563; border-radius: 6px; cursor: pointer; font-size: 12px; color: #ccc;">
                        <input type="checkbox" name="specialties[]" value="brakes" class="specialty-checkbox" style="accent-color: #F47920;"> 🛞 Brakes
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; padding: 8px; background: #1f2937; border: 1px solid #4b5563; border-radius: 6px; cursor: pointer; font-size: 12px; color: #ccc;">
                        <input type="checkbox" name="specialties[]" value="suspension" class="specialty-checkbox" style="accent-color: #F47920;"> 🔩 Suspension
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; padding: 8px; background: #1f2937; border: 1px solid #4b5563; border-radius: 6px; cursor: pointer; font-size: 12px; color: #ccc;">
                        <input type="checkbox" name="specialties[]" value="transmission" class="specialty-checkbox" style="accent-color: #F47920;"> 🔧 Transmission
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; padding: 8px; background: #1f2937; border: 1px solid #4b5563; border-radius: 6px; cursor: pointer; font-size: 12px; color: #ccc;">
                        <input type="checkbox" name="specialties[]" value="ac" class="specialty-checkbox" style="accent-color: #F47920;"> ❄️ AC
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; padding: 8px; background: #1f2937; border: 1px solid #4b5563; border-radius: 6px; cursor: pointer; font-size: 12px; color: #ccc;">
                        <input type="checkbox" name="specialties[]" value="oil" class="specialty-checkbox" style="accent-color: #F47920;"> 🛢️ Oil
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; padding: 8px; background: #1f2937; border: 1px solid #4b5563; border-radius: 6px; cursor: pointer; font-size: 12px; color: #ccc;">
                        <input type="checkbox" name="specialties[]" value="body" class="specialty-checkbox" style="accent-color: #F47920;"> 🎨 Body
                    </label>
                    <label style="display: flex; align-items: center; gap: 6px; padding: 8px; background: #1f2937; border: 1px solid #4b5563; border-radius: 6px; cursor: pointer; font-size: 12px; color: #ccc;">
                        <input type="checkbox" name="specialties[]" value="tuning" class="specialty-checkbox" style="accent-color: #F47920;"> 💻 Tuning
                    </label>
                </div>
            </div>

            <div>
                <label style="display: flex; align-items: center; gap: 8px; padding: 8px; background: #1f2937; border: 1px solid #4b5563; border-radius: 6px; cursor: pointer;">
                    <input type="checkbox" id="selectAllCheckbox" style="width: 16px; height: 16px; accent-color: #F47920; cursor: pointer;">
                    <span style="color: #ccc; font-size: 13px;">✅ Select ALL Specializations</span>
                </label>
            </div>

            <div>
                <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Years of Experience *</label>
                <input type="number" name="years_experience" value="{{ old('years_experience', 0) }}" required min="0" max="50" step="1"
                    style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
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

            <div style="background: rgba(244,121,32,0.1); border: 1px solid #F47920; border-radius: 8px; padding: 12px; margin-top: 8px;">
                <p style="color: #F47920; font-size: 12px; text-align: center;">
                    ⚠️ After registration, you'll need to submit verification documents to become a verified mechanic.
                </p>
            </div>

            <button type="submit" style="width: 100%; padding: 14px; background: #F47920; color: white; border: none; border-radius: 8px; font-weight: bold; font-size: 15px; cursor: pointer;">🔧 Create Mechanic Account</button>
        </form>

        <script>
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const specialtyCheckboxes = document.querySelectorAll('.specialty-checkbox');

            selectAllCheckbox.addEventListener('change', function() {
                specialtyCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });

            specialtyCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(specialtyCheckboxes).every(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                });
            });
        </script>

    @elseif(request('type') === 'admin')
        {{-- ========== ADMIN FORM ========== --}}
        <h1 style="font-size: 24px; font-weight: 900; color: white; margin-bottom: 8px;">👑 Join as Admin</h1>
        <p style="color: #999; margin-bottom: 24px;">Create administrator account.</p>

        <div style="display: flex; gap: 8px; margin-bottom: 24px;">
            <a href="/register" style="flex: 1; padding: 14px; background: #333; color: #ccc; text-align: center; border-radius: 8px; font-size: 15px; font-weight: 600; text-decoration: none;">👤 User</a>
            <a href="/register?type=mechanic" style="flex: 1; padding: 14px; background: #333; color: #ccc; text-align: center; border-radius: 8px; font-size: 15px; font-weight: 600; text-decoration: none;">🔧 Mechanic</a>
            <a href="/register?type=admin" style="flex: 1; padding: 14px; background: #F47920; color: white; text-align: center; border-radius: 8px; font-size: 15px; font-weight: 600; text-decoration: none;">👑 Admin</a>
        </div>

        <form action="{{ route('admin.register.submit') }}" method="POST" style="display: flex; flex-direction: column; gap: 14px;">
            @csrf

            <div>
                <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Username *</label>
                <input type="text" name="username" value="{{ old('username') }}" required
                    style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;"
                    placeholder="e.g., admin_user">
                <p style="color: #666; font-size: 11px; margin-top: 4px;">Only letters, numbers, and underscores. Unique username.</p>
            </div>

            <div>
                <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Email Address *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Admin Secret Key *</label>
                <input type="password" name="admin_secret" id="admin_secret" required
                    style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
                <p style="color: #666; font-size: 11px; margin-top: 4px;">Enter the administrator secret key: <strong style="color: #F47920;">fitarself</strong></p>
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

            <button type="submit" style="width: 100%; padding: 14px; background: #F47920; color: white; border: none; border-radius: 8px; font-weight: bold; font-size: 15px; cursor: pointer;">👑 Register as Admin</button>
        </form>

    @else
        {{-- ========== USER FORM ========== --}}
        <h1 style="font-size: 24px; font-weight: 900; color: white; margin-bottom: 8px;">👤 Create Account</h1>
        <p style="color: #999; margin-bottom: 24px;">Join FitarSelf as a user or mechanic.</p>

        <div style="display: flex; gap: 8px; margin-bottom: 24px;">
            <a href="/register" style="flex: 1; padding: 14px; background: #F47920; color: white; text-align: center; border-radius: 8px; font-size: 15px; font-weight: 600; text-decoration: none;">👤 User</a>
            <a href="/register?type=mechanic" style="flex: 1; padding: 14px; background: #333; color: #ccc; text-align: center; border-radius: 8px; font-size: 15px; font-weight: 600; text-decoration: none;">🔧 Mechanic</a>
            <a href="/register?type=admin" style="flex: 1; padding: 14px; background: #333; color: #ccc; text-align: center; border-radius: 8px; font-size: 15px; font-weight: 600; text-decoration: none;">👑 Admin</a>
        </div>

        <form action="{{ route('register') }}" method="POST" style="display: flex; flex-direction: column; gap: 14px;">
            @csrf
            <input type="hidden" name="role" value="user">

            <div>
                <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;">
            </div>

            <div>
                <label style="display: block; font-size: 13px; color: #999; margin-bottom: 4px;">Username *</label>
                <input type="text" name="username" value="{{ old('username') }}" required
                    style="width: 100%; padding: 12px; background: #1f2937; border: 1px solid #4b5563; border-radius: 8px; color: white; font-size: 14px; box-sizing: border-box;"
                    placeholder="e.g., john_doe">
                <p style="color: #666; font-size: 11px; margin-top: 4px;">Only letters, numbers, and underscores. Unique username.</p>
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