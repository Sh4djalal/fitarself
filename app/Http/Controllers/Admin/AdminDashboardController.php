<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MechanicDocument;
use App\Models\Car;
use App\Models\FaultCode;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalMechanics = User::where('role', 'mechanic')->count();
        $totalCars = Car::count();
        $totalFaultCodes = FaultCode::count();
        $totalParts = Part::count();
        $pendingVerifications = MechanicDocument::where('status', 'pending')->count();
        
        return view('admin.dashboard', compact(
            'totalUsers', 'totalMechanics', 'totalCars', 
            'totalFaultCodes', 'totalParts', 'pendingVerifications'
        ));
    }
    
    public function verifications()
    {
        $pendingDocs = MechanicDocument::where('status', 'pending')->with('user')->latest()->get();
        $approvedDocs = MechanicDocument::where('status', 'approved')->with('user')->latest()->get();
        $rejectedDocs = MechanicDocument::where('status', 'rejected')->with('user')->latest()->get();
        
        return view('admin.verifications', compact('pendingDocs', 'approvedDocs', 'rejectedDocs'));
    }
    
    public function viewDocumentPage($id)
    {
        $doc = MechanicDocument::with('user')->findOrFail($id);
        return view('admin.simple-document', compact('doc'));
    }
    
    public function approve($id)
    {
        $document = MechanicDocument::findOrFail($id);
        $document->status = 'approved';
        $document->approved_at = now();
        $document->save();
        
        // Update user to verified mechanic
        $user = $document->user;
        $user->is_verified_mechanic = 1;
        $user->save();
        
        return redirect()->back()->with('success', 'Mechanic verified successfully!');
    }
    
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);
        
        $document = MechanicDocument::findOrFail($id);
        $document->status = 'rejected';
        $document->rejection_reason = $request->reason;
        $document->save();
        
        // Remove verified status
        $user = $document->user;
        $user->is_verified_mechanic = 0;
        $user->save();
        
        return redirect()->back()->with('success', 'Application rejected.');
    }
    
    public function delete($id)
    {
        $document = MechanicDocument::findOrFail($id);
        
        if ($document->id_card_path) {
            Storage::disk('public')->delete($document->id_card_path);
        }
        if ($document->shop_photo_path) {
            Storage::disk('public')->delete($document->shop_photo_path);
        }
        if ($document->license_photo_path) {
            Storage::disk('public')->delete($document->license_photo_path);
        }
        
        $document->delete();
        
        return redirect()->back()->with('success', 'Documents deleted successfully.');
    }
    
    public function viewDocument($id, $type)
    {
        $document = MechanicDocument::findOrFail($id);
        
        $path = match($type) {
            'id_card' => $document->id_card_path,
            'shop_photo' => $document->shop_photo_path,
            'license_photo' => $document->license_photo_path,
            default => null,
        };
        
        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'File not found');
        }
        
        return response()->file(Storage::disk('public')->path($path));
    }
}