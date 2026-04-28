<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = Message::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->latest()
            ->get()
            ->groupBy('conversation_id')
            ->map(function ($messages) {
                $lastMessage = $messages->first();
                $otherUserId = $lastMessage->sender_id === Auth::id() ? $lastMessage->receiver_id : $lastMessage->sender_id;
                $otherUser = User::find($otherUserId);
                $unread = $messages->where('receiver_id', Auth::id())->where('is_read', false)->count();
                return [
                    'conversation_id' => $lastMessage->conversation_id,
                    'other_user' => $otherUser,
                    'last_message' => $lastMessage->message_text,
                    'unread_count' => $unread,
                    'updated_at' => $lastMessage->created_at,
                ];
            })
            ->sortByDesc('updated_at')
            ->values();

        return view('chat.index', compact('conversations'));
    }

    public function show($conversationId)
    {
        $messages = Message::where('conversation_id', $conversationId)
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        Message::where('conversation_id', $conversationId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        $otherUser = null;
        $firstMessage = $messages->first();
        if ($firstMessage) {
            $otherUserId = $firstMessage->sender_id === Auth::id() ? $firstMessage->receiver_id : $firstMessage->sender_id;
            $otherUser = User::find($otherUserId);
        }

        return view('chat.show', compact('messages', 'conversationId', 'otherUser'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message_text' => 'required|string|max:1000',
        ]);

        $existing = Message::where(function ($q) use ($request) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $request->receiver_id);
        })->orWhere(function ($q) use ($request) {
            $q->where('sender_id', $request->receiver_id)->where('receiver_id', Auth::id());
        })->first();

        $conversationId = $existing ? $existing->conversation_id : Str::uuid()->toString();

        $message = Message::create([
            'conversation_id' => $conversationId,
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message_text' => $request->message_text,
        ]);

        return response()->json(['message' => $message->load('sender')]);
    }

    public function getMessages($conversationId)
    {
        $messages = Message::where('conversation_id', $conversationId)
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        Message::where('conversation_id', $conversationId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json($messages);
    }
}