<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Show chat page
     */
    public function index()
    {
        $user = Auth::user();

        // Ensure user is admin (redundant if route has middleware, but safe)
        if (!$user->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        // Admin sees all chat rooms
        $chatRooms = ChatRoom::with(['user', 'latestMessage'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $selectedRoom = request('room')
            ? ChatRoom::with('messages.user')->find(request('room'))
            : null;

        if ($selectedRoom) {
            $selectedRoom->load('messages.user');
        }

        return view('chat.index', [
            'chatRooms' => $chatRooms,
            'selectedRoom' => $selectedRoom,
            'isAdmin' => true, // Explicitly passing true for admin view
        ]);
    }

    /**
     * Send a message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'room_id' => 'required|exists:chat_rooms,id',
        ]);

        $user = Auth::user();
        $room = ChatRoom::findOrFail($request->room_id);

        // Logic check: if user is admin, sending as admin
        $isAdminMessage = $user->is_admin == 1;

        $message = ChatMessage::create([
            'chat_room_id' => $room->id,
            'user_id' => $user->id,
            'message' => $request->message,
            'is_admin_message' => $isAdminMessage,
        ]);

        // Update room timestamp
        $room->touch();

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'is_admin_message' => $message->is_admin_message,
                'sender_name' => $isAdminMessage ? 'Admin' : $user->name,
                'created_at' => $message->created_at->format('H:i'),
            ],
        ]);
    }

    /**
     * Get messages for a room (for polling)
     */
    public function getMessages(Request $request, $roomId = null)
    {
        if (!$roomId) {
            return response()->json(['messages' => []]);
        }

        $room = ChatRoom::with('messages.user')->findOrFail($roomId);

        // Admin can access any room
        $lastMessageId = $request->query('last_id', 0);

        $messages = $room->messages()
            ->when($lastMessageId > 0, function ($query) use ($lastMessageId) {
                return $query->where('id', '>', $lastMessageId);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) use ($room) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'is_admin_message' => $message->is_admin_message,
                    'sender_name' => $message->is_admin_message ? 'Admin' : $room->user->name,
                    'created_at' => $message->created_at->format('H:i'),
                ];
            });

        return response()->json([
            'messages' => $messages,
            'room_name' => $room->room_name,
        ]);
    }

    /**
     * Get chat rooms list (for admin polling)
     */
    public function getRooms()
    {
        $rooms = ChatRoom::with(['user', 'latestMessage'])
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($room) {
                return [
                    'id' => $room->id,
                    'room_name' => $room->room_name,
                    'user_email' => $room->user->email,
                    'last_message' => $room->latestMessage?->message,
                    'last_message_time' => $room->latestMessage?->created_at->format('H:i'),
                    'updated_at' => $room->updated_at->toISOString(),
                ];
            });

        return response()->json(['rooms' => $rooms]);
    }
}
