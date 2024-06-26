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
        $todos = TableAvailability::all();

        return view('index', ['todo' => $todos]);
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
        $todo->table_id = $request->input('table_id');

        // Split Date and Time
        $dateTimeString = $request->input('date');
        list($datePart, $timePart) = explode(' ', $dateTimeString, 2);
        $dateObj = \DateTime::createFromFormat('d/m/Y', $datePart);
        $timeObj = \DateTime::createFromFormat('H:i', $timePart);

        // Get the period from the form input (in HH:mm format)
        $period = $request->input('period');

        // Parse hours and minutes from the period
        list($hours, $minutes) = explode(':', $period);
        $hours = (int) $hours;
        $minutes = (int) $minutes;

        // Clone the original time object to manipulate
        $timeGo = clone $timeObj;

        // Add hours and minutes to the time object
        $timeGo->modify("+$hours hours");
        $timeGo->modify("+$minutes minutes");

        // Format the new time after modification
        $formattedNewTime = $timeGo->format('H:i');

        $todo->date = $dateObj;
        $todo->start_time = $timeObj;
        $todo->end_time = $formattedNewTime;

        $todo->save();
        return redirect('/booking');
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
