<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TableAvailability;
use App\Models\Table;
use App\Models\Timeslot;
use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = TableAvailability::all();
        return BookingResource::collection($bookings);
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
    public function store(BookingRequest $request)
    {
        $validated = $request->validated();
        $booking = new TableAvailability();
        $booking->fill($validated);
        $booking->total = intval(Table::where('id', $booking->table_id)->value('price'))
            + intval(Timeslot::where('id', $booking->timeslot_id)->value('price'));
        // $booking = TableAvailability::create($validated);
        $booking->save();
        return new BookingResource($booking);
    }

    /**
     * Display the specified resource.
     */
    public function show(TableAvailability $tableAvailability)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TableAvailability $tableAvailability)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookingRequest $request, $id)
    {
        $validated = $request->validated();
        $booking = TableAvailability::findOrFail($id);
        $booking->fill($validated);
        $booking->total = intval(Table::where('id', $booking->table_id)->value('price'))
            + intval(Timeslot::where('id', $booking->timeslot_id)->value('price'));
        $booking->update();
        return new BookingResource($booking);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $booking = TableAvailability::findOrFail($id);
        $booking->delete();
        return response(null, 204);
    }
}
