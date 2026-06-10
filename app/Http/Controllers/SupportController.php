<?php

namespace App\Http\Controllers;

use App\Models\SupportMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function index()
    {
        $sessionId = session()->getId();
        $messages = SupportMessage::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();
        
        return response()->json($messages);
    }

    public function send(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            $sessionId = session()->getId();
            $userId = Auth::id();

            // Save user message
            $userMessage = SupportMessage::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'message' => $request->message,
                'sender' => 'user',
                'is_read' => false,
            ]);

            // Simple AI response
            $message = strtolower($request->message);
            $aiText = "Thank you for your message. How can I help you with FitarSelf today?";
            
            if (strpos($message, 'car') !== false) {
                $aiText = "You can browse cars by make, model, and year. Visit the Cars section to explore! 🚗";
            } elseif (strpos($message, 'mechanic') !== false) {
                $aiText = "You can find verified mechanics in your area. Check out the Mechanics section! 🔧";
            } elseif (strpos($message, 'fault') !== false) {
                $aiText = "Fault codes can be searched by code number or description. Each code includes causes and solutions. ⚡";
            } elseif (strpos($message, 'register') !== false) {
                $aiText = "Click 'Sign Up' in the top right corner to create an account. ✨";
            } elseif (strpos($message, 'login') !== false) {
                $aiText = "Click the 'Login' button in the top right corner to access your account. 🔑";
            } elseif (strpos($message, 'help') !== false) {
                $aiText = "I can help you with: Cars, Fault Codes, Mechanics, Parts, Registration, Login, and Profile. What would you like to know?";
            } elseif (strpos($message, 'hello') !== false || strpos($message, 'hi') !== false) {
                $aiText = "Hello! Welcome to FitarSelf. How can I assist you today? 👋";
            } elseif (strpos($message, 'part') !== false) {
                $aiText = "Our parts marketplace allows you to buy and sell car parts. Check the Parts section! 🛒";
            } elseif (strpos($message, 'community') !== false) {
                $aiText = "The Community page lets you connect with other car enthusiasts and mechanics. 👥";
            } elseif (strpos($message, 'profile') !== false) {
                $aiText = "You can edit your profile by clicking your name in the top right and selecting 'Edit Profile'. ✏️";
            }
            
            $aiMessage = SupportMessage::create([
                'user_id' => null,
                'session_id' => $sessionId,
                'message' => $aiText,
                'sender' => 'ai',
                'is_read' => false,
            ]);

            return response()->json([
                'success' => true,
                'user_message' => $userMessage,
                'ai_message' => $aiMessage,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function connectAgent(Request $request)
    {
        $sessionId = session()->getId();
        $userId = Auth::id();

        $agentRequest = SupportMessage::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'message' => '🔴 User requested agent 🔴',
            'sender' => 'user',
            'is_read' => false,
        ]);

        $aiMessage = SupportMessage::create([
            'user_id' => null,
            'session_id' => $sessionId,
            'message' => '🔗 An agent has been notified. They will respond shortly.',
            'sender' => 'ai',
            'is_read' => false,
        ]);

        return response()->json(['success' => true]);
    }

    public function checkNewMessages(Request $request)
    {
        $sessionId = session()->getId();
        $lastId = $request->get('last_id', 0);
        
        $messages = SupportMessage::where('session_id', $sessionId)
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'asc')
            ->get();
        
        return response()->json([
            'messages' => $messages,
            'last_id' => $messages->last()->id ?? $lastId
        ]);
    }
}