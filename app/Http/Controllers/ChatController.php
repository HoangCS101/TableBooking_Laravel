<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class ChatController extends Controller
{
    // public function rooms(Request $request) {
    //     return ChatRoom::all();
    // }

    // public function messages(Request $request, $roomId) {
    //     return ChatMessage::where('chat_room_id', $roomId)
    //         ->with('user') // cuz we created that 'user' relationship in model
    //         ->orderBy('created_at', 'DESC')
    //         ->get();
    // }

    // public function newMessages(Request $request, $roomId) {
    //     $newMessage = new ChatMessage;
    //     $newMessage->user_id = Auth::id();
    //     $newMessage->chat_romm_id = $roomId;
    //     $newMessage->message = $request->message;
    //     $newMessage->save();

    //     broadcast(new MessageSent($newMessage))->toOthers();

    //     return $newMessage;
    // }

    // public function index(Request $request)
    // {
    //     $user = $request->user();
    //     // $chats = Chat::whereHas('users', function ($query) use ($user) {
    //     //     $query->where('users.id', $user->id);
    //     // })->get();
    //     $chats = Chat::find(1)->messages()->pluck('message');
    //     return response()->json(['chats' => $chats]);
    // }
    public function checkOnline(Request $request)
    {
        $currentUser = $request->user();
        $users = User::where('id', '!=', $request->user()->id)->get();

        foreach ($users as $user) {
            // Find the chat where $currentUser and $user are involved
            $chat = Chat::where(function ($query) use ($currentUser, $user) {
                $query->where('user1_id', $currentUser->id)
                    ->where('user2_id', $user->id);
            })
                ->orWhere(function ($query) use ($currentUser, $user) {
                    $query->where('user1_id', $user->id)
                        ->where('user2_id', $currentUser->id);
                })
                ->first();

            // Add chat_id to user object
            if (!$chat) {
                $chat = new Chat();
                $chat->user1_id = $currentUser->id;
                $chat->user2_id = $user->id;
                $chat->save();
            }

            $user->chat_id = $chat->id;
        }

        return response()->json(['users' => $users]);
    }

    public function viewChat(Request $request, $chatId) {
        $user = $request->user();
        $chat = Chat::where('id', $chatId)->first();

        $receiver_id = ($user->id == $chat->user1_id) ? $chat->user2_id : $chat->user1_id;
        $receiver = User::where('id', $receiver_id);

        $messages = Message::where('chat_id', $chatId)
                            ->select('message', 'sender_id', 'created_at')
                            ->orderBy('created_at', 'asc')
                            ->get();

        foreach ($messages as $message){
            if ($message->sender_id == $user->id) {
                $message->type = 'me';
                $message->name = $user->name;
            }
            else {
                $message->type = 'you';
                $message->name = $receiver->pluck('name');
            }
        }

        return response()->json([
            'messages' => $messages,
            'name' => $receiver->pluck('name'),
            'pic' => $receiver->pluck('picture_url'),
        ]);
    }

    public function sendMessage(Request $request, $chatId) {
        $user = $request->user();
        $chat = Chat::where('id', $chatId)->first();

        $message = new Message();
        $message->message = $request->input('message');
        $message->chat_id = $chat->id;
        $message->sender_id = $user->id;
        $message->save();
        broadcast(new MessageSent($message));
    }
}
