<?php

namespace App\Http\Controllers;

use App\Models\MechanicDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MechanicDocumentController extends Controller
{
    public function showForm()
    {
        $user = Auth::user();
        
        if (!$user->isMechanic()) {
            return redirect()->route('dashboard')->with('error', 'Only mechanics can access this page.');
        }
        
        $mechanicDocument = MechanicDocument::where('user_id', $user->id)->first();
        
        return view('mechanic.verify-documents', compact('mechanicDocument'));
    }

    public function submitDocuments(Request $request)
    {
        $user = Auth::user();
        
        Log::info('=== SUBMISSION START ===');
        Log::info('User ID: ' . $user->id);

        // Less strict validation - accept any file
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_address' => 'required|string|max:500',
            'license_number' => 'nullable|string|max:100',
            'id_card' => 'required|file|max:20480', // 20MB max
            'shop_photo' => 'required|file|max:20480', // 20MB max
            'license_photo' => 'nullable|file|max:20480', // 20MB max
            'additional_info' => 'nullable|string',
        ]);

        Log::info('Validation passed');

        $data = [
            'user_id' => $user->id,
            'shop_name' => $request->shop_name,
            'shop_address' => $request->shop_address,
            'license_number' => $request->license_number,
            'additional_info' => $request->additional_info,
            'status' => 'pending',
        ];

        // Upload ID Card - accept any file type
        if ($request->hasFile('id_card')) {
            $file = $request->file('id_card');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_idcard.' . ($extension ?: 'file');
            $path = $file->storeAs('mechanic_documents', $filename, 'public');
            $data['id_card_path'] = $path;
            Log::info('ID Card saved: ' . $path);
        }

        // Upload Shop Photo - accept any file type
        if ($request->hasFile('shop_photo')) {
            $file = $request->file('shop_photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_shop.' . ($extension ?: 'file');
            $path = $file->storeAs('mechanic_documents', $filename, 'public');
            $data['shop_photo_path'] = $path;
            Log::info('Shop photo saved: ' . $path);
        }

        // Upload License Photo - accept any file type
        if ($request->hasFile('license_photo')) {
            $file = $request->file('license_photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_license.' . ($extension ?: 'file');
            $path = $file->storeAs('mechanic_documents', $filename, 'public');
            $data['license_photo_path'] = $path;
            Log::info('License photo saved: ' . $path);
        }

        // Delete existing document if exists
        $existing = MechanicDocument::where('user_id', $user->id)->first();
        if ($existing) {
            if ($existing->id_card_path) Storage::disk('public')->delete($existing->id_card_path);
            if ($existing->shop_photo_path) Storage::disk('public')->delete($existing->shop_photo_path);
            if ($existing->license_photo_path) Storage::disk('public')->delete($existing->license_photo_path);
            $existing->delete();
            Log::info('Deleted existing document');
        }
        
        $doc = MechanicDocument::create($data);
        Log::info('Document created with ID: ' . $doc->id);
        Log::info('=== SUBMISSION END ===');
        
        return redirect()->route('mechanic.verify-form')->with('success', 'Documents submitted successfully! Our team will review your application.');
    }
}