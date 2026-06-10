<?php

namespace App\Http\Controllers;

use App\Models\MechanicDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MechanicDocumentController extends Controller
{
    public function showForm()
    {
        $user = Auth::user();
        
        // Only mechanics can access this
        if (!$user->isMechanic()) {
            return redirect()->route('dashboard')->with('error', 'Only mechanics can access this page.');
        }
        
        $mechanicDocument = MechanicDocument::where('user_id', $user->id)->first();
        
        return view('mechanic.verify-documents', compact('mechanicDocument'));
    }

    public function submitDocuments(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_address' => 'required|string|max:500',
            'license_number' => 'nullable|string|max:100',
            'id_card' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'shop_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'license_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'additional_info' => 'nullable|string',
        ]);

        $data = [
            'user_id' => $user->id,
            'shop_name' => $request->shop_name,
            'shop_address' => $request->shop_address,
            'license_number' => $request->license_number,
            'additional_info' => $request->additional_info,
            'status' => 'pending',
        ];

        // Upload ID Card
        if ($request->hasFile('id_card')) {
            $path = $request->file('id_card')->store('mechanic_documents/id_cards', 'public');
            $data['id_card_path'] = $path;
        }

        // Upload Shop Photo
        if ($request->hasFile('shop_photo')) {
            $path = $request->file('shop_photo')->store('mechanic_documents/shop_photos', 'public');
            $data['shop_photo_path'] = $path;
        }

        // Upload License Photo
        if ($request->hasFile('license_photo')) {
            $path = $request->file('license_photo')->store('mechanic_documents/licenses', 'public');
            $data['license_photo_path'] = $path;
        }

        MechanicDocument::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return redirect()->route('mechanic.verify-form')->with('success', 'Documents submitted successfully! Our team will review your application.');
    }
}