<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MechanicDocument;
use App\Models\MechanicDetail;
use App\Models\OtpVerification;
use App\Models\Message;
use App\Models\Review;
use App\Models\SavedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminUsersController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role', 'all');
        
        $query = User::query();
        
        if ($role === 'user') {
            $query->where('role', 'user');
        } elseif ($role === 'mechanic') {
            $query->where('role', 'mechanic');
        } elseif ($role === 'admin') {
            $query->where('role', 'admin');
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(20);
        
        $totalUsers = User::where('role', 'user')->count();
        $totalMechanics = User::where('role', 'mechanic')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        
        return view('admin.users', compact('users', 'totalUsers', 'totalMechanics', 'totalAdmins', 'role'));
    }
    
    public function show($id)
    {
        $user = User::with('mechanicDetail', 'mechanicDocument')->findOrFail($id);
        return response()->json($user);
    }
    
    public function destroy($id)
    {
        Log::info('Delete user attempt: ' . $id);
        
        $user = User::findOrFail($id);
        
        if ($user->id == auth()->id()) {
            return response()->json(['success' => false, 'message' => 'You cannot delete your own account.'], 403);
        }
        
        try {
            DB::beginTransaction();
            
            Log::info('Deleting related data for user: ' . $user->email);
            
            MechanicDocument::where('user_id', $user->id)->delete();
            MechanicDetail::where('user_id', $user->id)->delete();
            OtpVerification::where('email', $user->email)->delete();
            Message::where('sender_id', $user->id)->orWhere('receiver_id', $user->id)->delete();
            Review::where('user_id', $user->id)->delete();
            SavedItem::where('user_id', $user->id)->delete();
            DB::table('user_cars')->where('user_id', $user->id)->delete();
            
            $user->delete();
            
            DB::commit();
            
            Log::info('User deleted successfully: ' . $user->email);
            
            return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Delete user error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}