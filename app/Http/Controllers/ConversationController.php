<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\User;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        // $conversations = Conversation::whereHas('users', function ($query) use ($user) {
        //     $query->where('users.id', $user->id);
        // })->get();
        $conversations = Conversation::find(1)->messages()->pluck('message');
        return response()->json(['conversations' => $conversations]);
    }
    public function online(Request $request)
    {
        $currentUser = $request->user();
        $users = User::where('id', '!=', $request->user()->id)->get();

        foreach ($users as $user) {
            // Find the conversation where $currentUser and $user are involved
            $conversation = Conversation::where(function ($query) use ($currentUser, $user) {
                $query->where('user1_id', $currentUser->id)
                    ->where('user2_id', $user->id);
            })
                ->orWhere(function ($query) use ($currentUser, $user) {
                    $query->where('user1_id', $user->id)
                        ->where('user2_id', $currentUser->id);
                })
                ->first();

            // Add conversation_id to user object
            if (!$conversation) {
                $conversation = new Conversation();
                $conversation->user1_id = $currentUser->id;
                $conversation->user2_id = $user->id;
                $conversation->save();
            }

            $user->conversation_id = $conversation->id;
        }

        return response()->json(['users' => $users]);
    }
}
