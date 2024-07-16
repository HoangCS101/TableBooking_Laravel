<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function rooms(Request $request) {
        return ChatRoom::all();
    }

    public function messages(Request $request, $roomId) {
        return ChatMessage::where('chat_room_id', $roomId)
            ->with('user') // cuz we created that 'user' relationship in model
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function newMessages(Request $request, $roomId) {
        $newMessage = new ChatMessage;
        $newMessage->user_id = Auth::id();
        $newMessage->chat_romm_id = $roomId;
        $newMessage->message = $request->message;
        $newMessage->save();

        broadcast(new MessageSent($newMessage))->toOthers();

        return $newMessage;
    }
}
