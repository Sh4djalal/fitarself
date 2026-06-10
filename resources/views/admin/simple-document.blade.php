@extends('layouts.app')

@section('content')
<div style="max-width:800px; margin:0 auto; padding:20px;">
    <a href="/admin/verifications" style="color:#F47920; text-decoration:none;">← Back to Verifications</a>
    
    <div style="background:#1a1a2e; border:1px solid #333; border-radius:16px; padding:24px; margin-top:20px;">
        <h1 style="color:white; font-size:24px;">📄 Document Review</h1>
        
        <hr style="border-color:#333; margin:20px 0;">
        
        <!-- Mechanic Information -->
        <h2 style="color:white; font-size:18px; margin-bottom:15px;">👤 Mechanic Information</h2>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:20px;">
            <div><p style="color:#aaa;">Full Name</p><p style="color:white; font-weight:bold;">{{ $doc->user->name }}</p></div>
            <div><p style="color:#aaa;">Email</p><p style="color:white;">{{ $doc->user->email }}</p></div>
            <div><p style="color:#aaa;">Phone</p><p style="color:white;">{{ $doc->user->phone ?? 'Not provided' }}</p></div>
            <div><p style="color:#aaa;">City</p><p style="color:white;">{{ $doc->user->city ?? 'Not provided' }}</p></div>
        </div>
        
        <hr style="border-color:#333; margin:20px 0;">
        
        <!-- Shop Information -->
        <h2 style="color:white; font-size:18px; margin-bottom:15px;">🏪 Shop Information</h2>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:20px;">
            <div><p style="color:#aaa;">Shop/Workshop Name</p><p style="color:white; font-weight:bold;">{{ $doc->shop_name }}</p></div>
            <div><p style="color:#aaa;">Shop Address</p><p style="color:white;">{{ $doc->shop_address }}</p></div>
            @if($doc->license_number)
            <div><p style="color:#aaa;">License Number</p><p style="color:white;">{{ $doc->license_number }}</p></div>
            @endif
            @if($doc->additional_info)
            <div class="full-width"><p style="color:#aaa;">Additional Information</p><p style="color:white;">{{ $doc->additional_info }}</p></div>
            @endif
        </div>
        
        <hr style="border-color:#333; margin:20px 0;">
        
        <!-- Documents Section -->
        <h2 style="color:white; font-size:18px; margin-bottom:15px;">📎 Uploaded Documents</h2>
        
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:15px; margin-bottom:20px;">
            @if($doc->id_card_path)
            <div style="background:#1f2937; border-radius:12px; padding:15px; text-align:center;">
                <div style="font-size:40px; margin-bottom:10px;">🆔</div>
                <p style="color:#aaa; margin-bottom:10px;">ID Card</p>
                <a href="{{ route('admin.file', ['id' => $doc->id, 'type' => 'id_card']) }}" target="_blank" style="background:#F47920; padding:8px 16px; border-radius:8px; color:white; text-decoration:none; display:inline-block;">View Image</a>
            </div>
            @endif
            
            @if($doc->shop_photo_path)
            <div style="background:#1f2937; border-radius:12px; padding:15px; text-align:center;">
                <div style="font-size:40px; margin-bottom:10px;">🏪</div>
                <p style="color:#aaa; margin-bottom:10px;">Workshop Photo</p>
                <a href="{{ route('admin.file', ['id' => $doc->id, 'type' => 'shop_photo']) }}" target="_blank" style="background:#F47920; padding:8px 16px; border-radius:8px; color:white; text-decoration:none; display:inline-block;">View Image</a>
            </div>
            @endif
            
            @if($doc->license_photo_path)
            <div style="background:#1f2937; border-radius:12px; padding:15px; text-align:center;">
                <div style="font-size:40px; margin-bottom:10px;">📜</div>
                <p style="color:#aaa; margin-bottom:10px;">License/Certificate</p>
                <a href="{{ route('admin.file', ['id' => $doc->id, 'type' => 'license_photo']) }}" target="_blank" style="background:#F47920; padding:8px 16px; border-radius:8px; color:white; text-decoration:none; display:inline-block;">View Image</a>
            </div>
            @endif
        </div>
        
        @if(!$doc->id_card_path && !$doc->shop_photo_path && !$doc->license_photo_path)
            <p style="color:#aaa; text-align:center; padding:20px;">No documents uploaded yet.</p>
        @endif
        
        <hr style="border-color:#333; margin:20px 0;">
        
        <!-- Actions -->
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <form action="{{ route('admin.approve', $doc->id) }}" method="POST">
                @csrf
                <button style="background:#22c55e; padding:10px 20px; border-radius:8px; color:white; cursor:pointer; border:none;">✅ Approve & Verify</button>
            </form>
            
            <button onclick="showReject()" style="background:#ef4444; padding:10px 20px; border-radius:8px; color:white; cursor:pointer; border:none;">❌ Reject Application</button>
            
            <form action="{{ route('admin.delete', $doc->id) }}" method="POST" onsubmit="return confirm('Delete this application permanently?')">
                @csrf
                @method('DELETE')
                <button style="background:#6b7280; padding:10px 20px; border-radius:8px; color:white; cursor:pointer; border:none;">🗑️ Delete Documents</button>
            </form>
        </div>
        
        <!-- Status -->
        <div style="margin-top:20px; padding:12px; background:#1f2937; border-radius:8px;">
            <p style="color:#aaa;">Status: 
                <strong style="color:{{ $doc->status === 'pending' ? '#eab308' : ($doc->status === 'approved' ? '#22c55e' : '#ef4444') }}">
                    {{ ucfirst($doc->status) }}
                </strong>
            </p>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); justify-content:center; align-items:center; z-index:999;">
    <div style="background:#1a1a2e; border-radius:16px; padding:24px; width:400px;">
        <h3 style="color:white; margin-bottom:15px;">Reject Verification</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <textarea name="reason" required rows="4" placeholder="Enter rejection reason..." style="width:100%; padding:10px; background:#1f2937; color:white; border:1px solid #333; border-radius:8px; margin-bottom:15px;"></textarea>
            <div style="display:flex; gap:10px;">
                <button type="submit" style="background:#ef4444; padding:10px 20px; border-radius:8px; color:white; cursor:pointer; border:none;">Confirm Reject</button>
                <button type="button" onclick="closeReject()" style="background:#6b7280; padding:10px 20px; border-radius:8px; color:white; cursor:pointer; border:none;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showReject() {
        document.getElementById('rejectModal').style.display = 'flex';
        document.getElementById('rejectForm').action = '{{ route("admin.reject", $doc->id) }}';
    }
    function closeReject() {
        document.getElementById('rejectModal').style.display = 'none';
    }
</script>
@endsection