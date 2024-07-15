<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()//: View
    {
        
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
    public function store(Request $request)//: RedirectResponse
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $chirp)//: View
    {
        // Gate::authorize('update', $chirp);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $chirp)//: RedirectResponse
    {
        // Gate::authorize('update', $chirp);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $chirp)//: RedirectResponse
    {
        // Gate::authorize('delete', $chirp);
    }
}
