<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TableAvailability;

class TableAvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('test');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('test');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $todo = new TableAvailability();
        $todo->guest_name = $request->input('name');
        $todo->pnum = $request->input('phone_num');
        // $bookingDateTime = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $request->input('date'));
        $todo->start_date = $request->input('date');
        $todo->end_date = $request->input('date');
        $todo->save();
        // redirect('/booking');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
