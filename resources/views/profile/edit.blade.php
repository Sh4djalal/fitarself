@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-fitar-surface border border-white/10 rounded-2xl p-6">
        
        <div class="text-center mb-6">
            <div class="text-4xl mb-3">✏️</div>
            <h1 class="text-2xl font-bold text-white">Edit Profile</h1>
            <p class="text-gray-400 mt-1">Update your personal information</p>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500 rounded-lg p-3 mb-4">
                <p class="text-green-400 text-sm">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-500/20 border border-red-500 rounded-lg p-3 mb-4">
                @foreach($errors->all() as $error)
                    <p class="text-red-400 text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <!-- Profile Photo with Hover Effect -->
            <div class="mb-6 flex justify-center">
                <div class="relative group">
                    <div class="w-28 h-28 rounded-full bg-fitar-card flex items-center justify-center text-4xl overflow-hidden ring-2 ring-fitar-accent/50 cursor-pointer" onclick="document.getElementById('profilePhotoInput').click()">
                        <img id="profilePreview" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute inset-0 rounded-full bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition cursor-pointer" onclick="document.getElementById('profilePhotoInput').click()">
                        <span class="text-white text-2xl">📷</span>
                    </div>
                    <input type="file" name="profile_photo" id="profilePhotoInput" accept="image/*" class="hidden">
                </div>
            </div>

            <!-- Full Name -->
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-medium mb-2">Full Name</label>
                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                    class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">
            </div>

            <!-- Username Field -->
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-medium mb-2">Username</label>
                <div>
                    <input type="text" name="username" id="username" value="{{ old('username', Auth::user()->username) }}" 
                        class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">
                    @if(isset($canChangeUsername) && !$canChangeUsername)
                        <p class="text-yellow-400 text-xs mt-1">
                            ⚠️ You can change your username once per week. Next change available in {{ $daysRemaining ?? 0 }} days.
                        </p>
                    @else
                        <p class="text-gray-500 text-xs mt-1">Only letters, numbers, and underscores. Unique username.</p>
                    @endif
                </div>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-medium mb-2">Email</label>
                <div class="flex items-center gap-2">
                    <input type="email" value="{{ Auth::user()->email }}" disabled
                        class="flex-1 px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-gray-400">
                    <a href="{{ route('profile.change-email') }}" class="bg-fitar-accent hover:bg-fitar-accent-hover text-white px-4 py-2 rounded-lg text-sm transition whitespace-nowrap">
                        Change Email
                    </a>
                </div>
            </div>

            <!-- Phone Number -->
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-medium mb-2">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                    class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">
            </div>

            <!-- City -->
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-medium mb-2">City</label>
                <input type="text" name="city" value="{{ old('city', Auth::user()->city) }}"
                    class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">
            </div>

            <!-- Bio -->
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-medium mb-2">Bio</label>
                <textarea name="bio" rows="4" class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">{{ old('bio', Auth::user()->bio_en ?? Auth::user()->bio) }}</textarea>
                <p class="text-gray-500 text-xs mt-1">Tell others about yourself</p>
            </div>

            <!-- Mechanic Only Fields -->
            @if(Auth::user()->role === 'mechanic')
            <div class="border-t border-white/10 pt-4 mt-4">
                <h3 class="text-white font-semibold mb-3">🔧 Mechanic Information</h3>
                
                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-medium mb-2">Years of Experience</label>
                    <input type="number" name="experience_years" id="experience_years" value="{{ old('experience_years', Auth::user()->mechanicDetail->experience_years ?? '') }}" min="0" max="50"
                        class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-medium mb-2">Specializations</label>
                    <div class="grid grid-cols-2 gap-3">
                        @php
                            $currentSpecs = [];
                            $specTags = Auth::user()->mechanicDetail->specialty_tags ?? null;
                            if ($specTags && is_string($specTags)) {
                                $specTags = trim($specTags, '"');
                                $currentSpecs = json_decode($specTags, true) ?? [];
                            }
                            $allSpecs = ['engine', 'electrical', 'diagnostics', 'brakes', 'suspension', 'transmission', 'ac', 'oil', 'body', 'tuning'];
                        @endphp
                        @foreach($allSpecs as $spec)
                        <label class="flex items-center gap-2 p-2 bg-fitar-card border border-white/10 rounded-lg cursor-pointer hover:border-fitar-accent/50">
                            <input type="checkbox" name="specialties[]" value="{{ $spec }}" 
                                {{ in_array($spec, $currentSpecs) ? 'checked' : '' }}
                                style="accent-color: #F47920;">
                            <span class="text-gray-300 text-sm capitalize">{{ $spec }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-medium mb-2">Workshop Name</label>
                    <input type="text" name="workshop_name" id="workshop_name" value="{{ old('workshop_name', Auth::user()->mechanicDetail->workshop_name ?? '') }}"
                        class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-medium mb-2">Workshop Address</label>
                    <input type="text" name="workshop_address" id="workshop_address" value="{{ old('workshop_address', Auth::user()->mechanicDetail->workshop_address ?? '') }}"
                        class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">
                </div>
            </div>
            @endif

            <!-- Regular User Only Fields -->
            @if(Auth::user()->role === 'user')
            <div class="border-t border-white/10 pt-4 mt-4">
                <h3 class="text-white font-semibold mb-3">👤 Preferences</h3>
                
                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-medium mb-2">Favorite Car Brand</label>
                    <input type="text" name="favorite_brand" value="{{ old('favorite_brand', Auth::user()->favorite_brand ?? '') }}"
                        class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-medium mb-2">Interests</label>
                    <textarea name="interests" rows="3" class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none">{{ old('interests', Auth::user()->interests ?? '') }}</textarea>
                    <p class="text-gray-500 text-xs mt-1">What car-related topics interest you?</p>
                </div>
            </div>
            @endif

            <!-- Submit Buttons -->
            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-fitar-accent hover:bg-fitar-accent-hover text-white py-2 rounded-lg font-medium transition">
                    Save Changes
                </button>
                <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-700 hover:bg-gray-800 text-white py-2 rounded-lg text-center transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Cropper Modal -->
<div id="cropperModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50" style="overflow-y: auto;">
    <div class="bg-fitar-surface border border-white/10 rounded-2xl w-full max-w-lg mx-4 my-8 overflow-hidden">
        <div class="p-4 border-b border-white/10 flex justify-between items-center">
            <h3 class="text-white font-bold">Crop Profile Photo</h3>
            <button onclick="closeCropperModal()" class="text-gray-400 hover:text-white text-2xl">&times;</button>
        </div>
        <div class="p-4">
            <div class="bg-fitar-card rounded-lg overflow-hidden">
                <img id="cropperImage" src="" alt="Crop Image" style="max-width: 100%; display: block;">
            </div>
            <div class="flex gap-3 mt-4">
                <button type="button" onclick="zoomOut()" class="flex-1 bg-gray-700 hover:bg-gray-800 text-white py-2 rounded-lg">➖ Zoom Out</button>
                <button type="button" onclick="zoomIn()" class="flex-1 bg-gray-700 hover:bg-gray-800 text-white py-2 rounded-lg">➕ Zoom In</button>
                <button type="button" onclick="rotateLeft()" class="flex-1 bg-gray-700 hover:bg-gray-800 text-white py-2 rounded-lg">↺ Rotate</button>
            </div>
        </div>
        <div class="p-4 border-t border-white/10 flex gap-3">
            <button onclick="cropAndSave()" class="flex-1 bg-fitar-accent hover:bg-fitar-accent-hover text-white py-2 rounded-lg font-medium">✅ Crop & Save</button>
            <button onclick="closeCropperModal()" class="flex-1 bg-gray-700 hover:bg-gray-800 text-white py-2 rounded-lg">Cancel</button>
        </div>
    </div>
</div>

<script>
    let cropper = null;
    let currentFile = null;
    let cropModal = document.getElementById('cropperModal');
    let cropperImage = document.getElementById('cropperImage');
    let profilePreview = document.getElementById('profilePreview');
    let fileInput = document.getElementById('profilePhotoInput');
    
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        if (file.size > 5 * 1024 * 1024) {
            alert('File too large! Maximum 5MB.');
            fileInput.value = '';
            return;
        }
        
        if (!file.type.match('image.*')) {
            alert('Please select an image file (JPG, PNG).');
            fileInput.value = '';
            return;
        }
        
        currentFile = file;
        const reader = new FileReader();
        
        reader.onload = function(event) {
            cropperImage.src = event.target.result;
            cropModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            
            if (cropper) {
                cropper.destroy();
            }
            
            cropper = new Cropper(cropperImage, {
                aspectRatio: 1,
                viewMode: 1,
                dragMode: 'move',
                cropBoxMovable: true,
                cropBoxResizable: true,
                zoomable: true,
                zoomOnWheel: false,
                zoomOnTouch: false,
                rotatable: true,
                scalable: true,
                background: false,
                guides: true,
                center: true,
                highlight: true,
                autoCropArea: 0.8,
                responsive: true,
                checkOrientation: false
            });
        };
        
        reader.readAsDataURL(file);
    });
    
    function zoomIn() {
        if (cropper) cropper.zoom(0.1);
    }
    
    function zoomOut() {
        if (cropper) cropper.zoom(-0.1);
    }
    
    function rotateLeft() {
        if (cropper) cropper.rotate(-90);
    }
    
    async function cropAndSave() {
        if (!cropper || !currentFile) return;
        
        const canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high'
        });
        
        canvas.toBlob(async function(blob) {
            const formData = new FormData();
            formData.append('profile_photo_cropped', blob, 'profile.jpg');
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'PATCH');
            
            formData.append('name', document.querySelector('input[name="name"]').value);
            formData.append('username', document.querySelector('input[name="username"]')?.value || '');
            formData.append('phone', document.querySelector('input[name="phone"]')?.value || '');
            formData.append('city', document.querySelector('input[name="city"]')?.value || '');
            formData.append('bio', document.querySelector('textarea[name="bio"]')?.value || '');
            
            const experienceYears = document.querySelector('input[name="experience_years"]');
            if (experienceYears) formData.append('experience_years', experienceYears.value);
            
            const workshopName = document.querySelector('input[name="workshop_name"]');
            if (workshopName) formData.append('workshop_name', workshopName.value);
            
            const workshopAddress = document.querySelector('input[name="workshop_address"]');
            if (workshopAddress) formData.append('workshop_address', workshopAddress.value);
            
            const specialties = document.querySelectorAll('input[name="specialties[]"]:checked');
            specialties.forEach(spec => formData.append('specialties[]', spec.value));
            
            const response = await fetch('{{ route("profile.update") }}', {
                method: 'POST',
                body: formData
            });
            
            if (response.redirected) {
                window.location.href = response.url;
            } else {
                const result = await response.json();
                if (result.success) {
                    window.location.href = '{{ route("dashboard") }}';
                } else {
                    alert('Error: ' + result.message);
                }
            }
        }, 'image/jpeg', 0.9);
    }
    
    function closeCropperModal() {
        cropModal.style.display = 'none';
        document.body.style.overflow = 'auto';
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        fileInput.value = '';
    }
</script>
@endsection