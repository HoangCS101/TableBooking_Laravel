<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\User;

class ConversationController extends Controller
{
    public function index(Request $request) {
        $user = $request->user();
        // $conversations = Conversation::whereHas('users', function ($query) use ($user) {
        //     $query->where('users.id', $user->id);
        // })->get();
        $conversations = Conversation::find(1)->messages()->pluck('message');
        return response()->json(['conversations' => $conversations]);
    }
    public function online(Request $request) {
        $users = User::where('id', '!=', $request->user()->id)->get();
        // Conversation::where();
        return response()->json(['users' => $users]);
    }
}
