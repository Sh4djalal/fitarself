<?php

namespace App\Http\Controllers;

use App\Models\SavedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SavedItemController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $savedItems = $user->savedItems()->with('savable')->latest()->get();
        return view('profile.saved-items', compact('savedItems'));
    }
    
    public function store($type, $id)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Please login to save items'], 401);
            }
            
            $savableType = 'App\\Models\\' . ucfirst($type);
            
            $exists = SavedItem::where('user_id', $user->id)
                ->where('savable_type', $savableType)
                ->where('savable_id', $id)
                ->exists();
            
            if (!$exists) {
                SavedItem::create([
                    'user_id' => $user->id,
                    'savable_type' => $savableType,
                    'savable_id' => $id,
                ]);
                return response()->json(['success' => true, 'message' => 'Saved!']);
            }
            
            return response()->json(['success' => false, 'message' => 'Already saved']);
            
        } catch (\Exception $e) {
            Log::error('Save item error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
    
    public function destroy($type, $id)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Please login'], 401);
            }
            
            $savableType = 'App\\Models\\' . ucfirst($type);
            
            SavedItem::where('user_id', $user->id)
                ->where('savable_type', $savableType)
                ->where('savable_id', $id)
                ->delete();
            
            return response()->json(['success' => true, 'message' => 'Removed']);
            
        } catch (\Exception $e) {
            Log::error('Unsave item error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
    
    public function check($type, $id)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['saved' => false]);
        }
        
        $savableType = 'App\\Models\\' . ucfirst($type);
        
        $exists = SavedItem::where('user_id', $user->id)
            ->where('savable_type', $savableType)
            ->where('savable_id', $id)
            ->exists();
        
        return response()->json(['saved' => $exists]);
    }
}