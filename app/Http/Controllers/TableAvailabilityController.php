<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationForm;
use Illuminate\Http\Request;
use App\Models\TableAvailability;
use App\Models\Table;
use App\Models\Timeslot;

class TableAvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->hasRole('admin')) $bookings = TableAvailability::all();
        else $bookings = TableAvailability::where('user_id', $request->user()->id)->get();

        // Add table_name to each $todos item
        $bookings->transform(function ($item) {
            $item->table_name = $item->table->name;
            $item->time_slot = Timeslot::where('id', $item->timeslot_id)->value('slot_name');
            return $item;
        });

        return view('booking', ['todo' => $bookings]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reservation');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationForm $request)
    {
        $booking = new TableAvailability();
        $booking->guest_name = $request->input('name');
        $booking->pnum = $request->input('phone_num');
        $booking->date = $request->input('date');
        $booking->table_id = $request->input('table');
        $booking->timeslot_id = $request->input('time_slot');
        $booking->total = intval(Table::where('id', $booking->table_id)->value('price')) + intval(Timeslot::where('id', $booking->timeslot_id)->value('price'));
        $booking->user_id = $request->user()->id;

        $booking->save();
        return redirect('/booking/' . $booking->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        if ($request->user()->hasRole('admin')) {
            $booking = TableAvailability::where('id', $id)->first();
        } else {
            $booking = TableAvailability::where('user_id', $request->user()->id)
                ->where('id', $id)
                ->first();
        }

        if (!$booking) {
            return abort(404);
        }

        // Additional data for $booking
        $booking->table_name = $booking->table->name;
        $booking->picture_url = $booking->table->picture_url;
        $booking->time_slot = Timeslot::where('id', $booking->timeslot_id)->value('slot_name');

        return view('table', ['t' => $booking]);
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
    public function update(ReservationForm $request, string $id)
    {
        $booking = TableAvailability::find($id);
        $booking->guest_name = $request->input('name');
        $booking->pnum = $request->input('phone_num');
        $booking->date = $request->input('date');
        $booking->table_id = $request->input('table');
        $booking->timeslot_id = $request->input('time_slot');
        $booking->total = intval(Table::where('id', $booking->table_id)->value('price')) + intval(Timeslot::where('id', $booking->timeslot_id)->value('price'));
        $booking->user_id = $request->user()->id;

        $booking->update();
        return redirect('/booking/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the record with the given ID
            $todo = TableAvailability::findOrFail($id);

            // Delete the record
            $todo->delete();

            // Optionally, you can return a response indicating success
            return response()->json(['message' => 'Record deleted successfully'], 200);
        } catch (\Exception $e) {
            // Handle any exceptions, such as if the record does not exist
            return response()->json(['error' => 'Failed to delete record: ' . $e->getMessage()], 500);
        }
    }

    public function filter(string $date, string $timeslot)
    {
        // return "Filtering for $date and $timeslot";
        $bookedTableIds = TableAvailability::where('date', $date)
            ->where('timeslot_id', $timeslot)
            ->where(function ($query) {
                $query->where('state', 'locked')
                    ->orWhere('state', 'paid');
            })
            ->pluck('table_id')
            ->toArray();

        // Get tables that are NOT in the $bookedTableIds array
        $availableTables = Table::whereNotIn('id', $bookedTableIds)
            ->select('id', 'name')
            ->get();

        $options = [];
        foreach ($availableTables as $table) {
            $options[] = [
                'value' => $table->id,
                'name' => $table->name,
            ];
        }
        return response()->json($options);
    }

    public function previewTable(string $id)
    {
        $table = Table::findOrFail($id);

        $previewData = [
            'picture_url' => $table->picture_url,
            'description' => $table->description,
        ];
        return response()->json($previewData);
    }
}
