<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response; 
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View 
    {
        return view('chirps.index', [
            'chirps' => Chirp::with('user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $request->user()->chirps()->create($validated);
 
        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        // Gate::authorize('update', $chirp);
 
        return view('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        // Gate::authorize('update', $chirp);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $chirp->update($validated);
 
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        // Gate::authorize('delete', $chirp);
 
        $chirp->delete();
 
        return redirect(route('chirps.index'));
    }

    public function getMessages(Request $request)
    {
        // Example: Fetch messages from database
        $messages = Chirp::select('message', 'sender_id', 'receiver_id', 'created_at')
                            ->orderBy('created_at', 'asc')
                            ->get();
        Log::info('Request received to fetch messages:', [
            'request_method' => $request->method(),
            'request_url' => $request->fullUrl(),
            'request_parameters' => $request->all(),
        ]);
        Log::info($messages);

        // $messages = [
        //     ['message' => 'Hello', 'sender_name' => 'John', 'time' => '10:00 AM'],
        //     ['message' => 'Hi there', 'sender_name' => 'Jane', 'time' => '10:05 AM'],
        //     ['message' => 'How are you?', 'sender_name' => 'John', 'time' => '10:10 AM'],
        // ];
    
        return response()->json(['messages' => $messages]);
        // return response()->json(['messages' => 'cul']);
        // return response('yes');
    }

    public function sendMessage(Request $request) {
        $user = $request->user();
        Log::info($user->id);
        $message = new Chirp();
        $message->message = $request->input('message');
        $message->sender_id = $user->id;
        $message->receiver_id = $user->id ? 1 : 2;
        $message->save();
    }
}
