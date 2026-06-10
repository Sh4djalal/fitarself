@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">👥 Manage Users</h1>
            <p class="text-gray-400">View and manage all registered users</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white">← Back to Dashboard</a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-fitar-surface border border-white/10 rounded-xl p-4">
            <p class="text-gray-400 text-sm">👤 Users</p>
            <p class="text-2xl font-bold text-white">{{ $totalUsers }}</p>
        </div>
        <div class="bg-fitar-surface border border-white/10 rounded-xl p-4">
            <p class="text-gray-400 text-sm">🔧 Mechanics</p>
            <p class="text-2xl font-bold text-white">{{ $totalMechanics }}</p>
        </div>
        <div class="bg-fitar-surface border border-white/10 rounded-xl p-4">
            <p class="text-gray-400 text-sm">👑 Admins</p>
            <p class="text-2xl font-bold text-white">{{ $totalAdmins }}</p>
        </div>
    </div>

    <!-- Category Tabs -->
    <div class="flex gap-2 mb-6 border-b border-white/10 pb-3">
        <a href="?role=all" class="px-4 py-2 rounded-lg transition {{ $role == 'all' ? 'bg-fitar-accent text-white' : 'text-gray-400 hover:text-white' }}">
            👥 All ({{ $totalUsers + $totalMechanics + $totalAdmins }})
        </a>
        <a href="?role=user" class="px-4 py-2 rounded-lg transition {{ $role == 'user' ? 'bg-fitar-accent text-white' : 'text-gray-400 hover:text-white' }}">
            👤 Users ({{ $totalUsers }})
        </a>
        <a href="?role=mechanic" class="px-4 py-2 rounded-lg transition {{ $role == 'mechanic' ? 'bg-fitar-accent text-white' : 'text-gray-400 hover:text-white' }}">
            🔧 Mechanics ({{ $totalMechanics }})
        </a>
        <a href="?role=admin" class="px-4 py-2 rounded-lg transition {{ $role == 'admin' ? 'bg-fitar-accent text-white' : 'text-gray-400 hover:text-white' }}">
            👑 Admins ({{ $totalAdmins }})
        </a>
    </div>

    <!-- Users Table -->
    <div class="bg-fitar-surface border border-white/10 rounded-xl overflow-hidden">
        <table class="w-full">
            <thead class="bg-fitar-card border-b border-white/10">
                <tr>
                    <th class="text-left px-6 py-3 text-gray-400 font-medium">User</th>
                    <th class="text-left px-6 py-3 text-gray-400 font-medium">Email</th>
                    <th class="text-left px-6 py-3 text-gray-400 font-medium">Role</th>
                    <th class="text-left px-6 py-3 text-gray-400 font-medium">Status</th>
                    <th class="text-left px-6 py-3 text-gray-400 font-medium">Joined</th>
                    <th class="text-left px-6 py-3 text-gray-400 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b border-white/5 hover:bg-white/5 transition">
                    <td class="px-6 py-3">
                        <button onclick="showUserDetails({{ $user->id }})" class="flex items-center gap-3 hover:opacity-80 transition">
                            <div class="w-10 h-10 rounded-full bg-fitar-card flex items-center justify-center text-lg overflow-hidden">
                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            </div>
                            <span class="text-white font-medium hover:text-fitar-accent cursor-pointer">{{ $user->username ?? $user->name }}</span>
                        </button>
                    </td>
                    <td class="px-6 py-3 text-gray-300">{{ $user->email }}</td>
                    <td class="px-6 py-3">
                        @if($user->role === 'admin')
                            <span class="px-2 py-1 rounded-full text-xs bg-purple-500/20 text-purple-400">👑 Admin</span>
                        @elseif($user->role === 'mechanic')
                            <span class="px-2 py-1 rounded-full text-xs bg-blue-500/20 text-blue-400">🔧 Mechanic</span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs bg-green-500/20 text-green-400">👤 User</span>
                        @endif
                    </td>
                    <td class="px-6 py-3">
                        @if($user->is_verified_mechanic)
                            <span class="px-2 py-1 rounded-full text-xs bg-green-500/20 text-green-400">✅ Verified</span>
                        @elseif($user->role === 'mechanic')
                            <span class="px-2 py-1 rounded-full text-xs bg-yellow-500/20 text-yellow-400">⏳ Pending</span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs bg-gray-500/20 text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-gray-400 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-3">
                        @if($user->id !== auth()->id())
                            <button onclick="showDeleteModal({{ $user->id }}, '{{ addslashes($user->name) }}')" class="text-red-400 hover:text-red-300 transition">
                                🗑️ Delete
                            </button>
                        @else
                            <span class="text-gray-500 text-sm">You</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">No users found in this category.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>

<!-- User Details Modal -->
<div id="userModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50" onclick="closeUserModal(event)">
    <div class="bg-fitar-surface border border-white/10 rounded-2xl w-full max-w-2xl mx-4 overflow-hidden" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center p-6 border-b border-white/10">
            <h2 class="text-xl font-bold text-white" id="modalTitle">User Details</h2>
            <button onclick="closeUserModal()" class="text-gray-400 hover:text-white text-2xl">&times;</button>
        </div>
        <div id="modalContent" class="p-6">
            <div class="text-center py-8">
                <div class="inline-block w-12 h-12 border-2 border-fitar-accent border-t-transparent rounded-full animate-spin"></div>
                <p class="text-gray-400 mt-3">Loading...</p>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
    <div class="bg-fitar-surface border border-white/10 rounded-2xl w-full max-w-md mx-4 overflow-hidden">
        <div class="p-6 text-center">
            <div class="text-5xl mb-4">⚠️</div>
            <h3 class="text-xl font-bold text-white mb-2">Delete User</h3>
            <p class="text-gray-400 mb-6" id="deleteMessage">Are you sure you want to delete this user?</p>
            <p class="text-red-400 text-sm mb-6">This action cannot be undone!</p>
            <div class="flex gap-3">
                <button onclick="confirmDelete()" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg transition">Yes, Delete</button>
                <button onclick="closeDeleteModal()" class="flex-1 bg-gray-700 hover:bg-gray-800 text-white py-2 rounded-lg transition">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    let deleteUserId = null;
    let deleteUserName = null;
    
    function showDeleteModal(userId, userName) {
        deleteUserId = userId;
        deleteUserName = userName;
        document.getElementById('deleteMessage').innerHTML = `Are you sure you want to delete <strong class="text-white">${userName}</strong>?`;
        document.getElementById('deleteModal').style.display = 'flex';
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
        deleteUserId = null;
        deleteUserName = null;
    }
    
    async function confirmDelete() {
        if (!deleteUserId) return;
        
        const modalContent = document.getElementById('deleteModal').querySelector('.bg-fitar-surface');
        modalContent.innerHTML = `
            <div class="p-6 text-center">
                <div class="inline-block w-8 h-8 border-2 border-fitar-accent border-t-transparent rounded-full animate-spin mb-4"></div>
                <p class="text-gray-400">Deleting user...</p>
            </div>
        `;
        
        try {
            const response = await fetch(`/admin/users/${deleteUserId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
            
            const result = await response.json();
            
            if (result.success) {
                window.location.reload();
            } else {
                alert('Error: ' + result.message);
                window.location.reload();
            }
        } catch (error) {
            alert('Error deleting user.');
            window.location.reload();
        }
    }
    
    async function showUserDetails(userId) {
        const modal = document.getElementById('userModal');
        const modalContent = document.getElementById('modalContent');
        
        modal.style.display = 'flex';
        modalContent.innerHTML = '<div class="text-center py-8"><div class="inline-block w-12 h-12 border-2 border-fitar-accent border-t-transparent rounded-full animate-spin"></div><p class="text-gray-400 mt-3">Loading...</p></div>';
        
        try {
            const response = await fetch(`/admin/users/${userId}`);
            const user = await response.json();
            
            modalContent.innerHTML = `
                <div class="space-y-4">
                    <div class="flex items-center gap-4 pb-4 border-b border-white/10">
                        <div class="w-20 h-20 rounded-full bg-fitar-card flex items-center justify-center text-3xl overflow-hidden">
                            <img src="${user.profile_photo_url || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name) + '&background=F47920&color=fff'}" alt="${user.name}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">${escapeHtml(user.username ?? user.name)}</h3>
                            <p class="text-gray-400">${escapeHtml(user.email)}</p>
                            <span class="inline-block px-2 py-1 rounded-full text-xs mt-2 
                                ${user.role === 'admin' ? 'bg-purple-500/20 text-purple-400' : 
                                  user.role === 'mechanic' ? 'bg-blue-500/20 text-blue-400' : 
                                  'bg-green-500/20 text-green-400'}">
                                ${user.role === 'admin' ? '👑 Admin' : 
                                  user.role === 'mechanic' ? '🔧 Mechanic' : '👤 User'}
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-500 text-sm">Phone</p>
                            <p class="text-white">${user.phone || 'Not provided'}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">City</p>
                            <p class="text-white">${user.city || 'Not provided'}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Joined</p>
                            <p class="text-white">${new Date(user.created_at).toLocaleDateString()}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Verified</p>
                            <p class="text-white">${user.email_verified_at ? '✅ Yes' : '❌ No'}</p>
                        </div>
                    </div>
                    
                    ${user.role === 'mechanic' && user.mechanic_detail ? `
                        <div class="border-t border-white/10 pt-4">
                            <h4 class="text-white font-semibold mb-2">🔧 Mechanic Details</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-500 text-sm">Specialization</p>
                                    <p class="text-white">${escapeHtml(user.mechanic_detail.specialization_en || 'Not specified')}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Experience</p>
                                    <p class="text-white">${user.mechanic_detail.experience_years || 0} years</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Workshop City</p>
                                    <p class="text-white">${escapeHtml(user.mechanic_detail.workshop_city || user.city || 'Not specified')}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Verification Status</p>
                                    <p class="text-white ${user.is_verified_mechanic ? 'text-green-400' : 'text-yellow-400'}">
                                        ${user.is_verified_mechanic ? '✅ Verified' : '⏳ Pending'}
                                    </p>
                                </div>
                            </div>
                        </div>
                    ` : ''}
                    
                    ${user.bio_en || user.bio_ku ? `
                        <div class="border-t border-white/10 pt-4">
                            <h4 class="text-white font-semibold mb-2">📝 Bio</h4>
                            <p class="text-gray-300">${escapeHtml(user.bio_en || user.bio_ku)}</p>
                        </div>
                    ` : ''}
                </div>
            `;
        } catch (error) {
            modalContent.innerHTML = `<div class="text-center py-8 text-red-400">Error loading user details.</div>`;
        }
    }
    
    function closeUserModal(event) {
        if (!event || event.target === document.getElementById('userModal')) {
            document.getElementById('userModal').style.display = 'none';
        }
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        return text.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }
</script>

<style>
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
</style>
@endsection