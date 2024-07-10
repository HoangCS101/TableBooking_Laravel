<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateRequest;
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
        if ($request->user()->hasRole('admin')) $todos = TableAvailability::all();
        else $todos = TableAvailability::where('user_id', $request->user()->id)->get();

        // Add table_name to each $todos item
        $todos->transform(function ($item) {
            $item->table_name = $item->table->name; // Assuming 'name' is the column in the 'tables' table
            $item->time_slot = \App\Models\Timeslot::where('id', $item->timeslot_id)->value('slot_name');
            return $item;
        });

        return view('booking', ['todo' => $todos]);
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
    public function store(ValidateRequest $request)
    {
        $todo = new TableAvailability();
        $todo->guest_name = $request->input('name');
        $todo->pnum = $request->input('phone_num');
        $todo->table_id = $request->input('AT');
        $todo->date = $request->input('date');
        $todo->timeslot_id = $request->input('time_slot');
        $todo->total = intval(Table::where('id',$todo->table_id)->value('price')) + intval(Timeslot::where('id',$todo->timeslot_id)->value('price'));
        $todo->user_id = $request->user()->id;

        $todo->save();
        return redirect('/booking');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $todos = TableAvailability::where('id', $id)->get();

        // Add table_name to each $todos item
        $todos->transform(function ($item) {
            $item->table_name = $item->table->name; // Assuming 'name' is the column in the 'tables' table
            $item->picture_url = $item->table->picture_url;
            $item->time_slot = \App\Models\Timeslot::where('id', $item->timeslot_id)->value('slot_name');
            return $item;
        });

        return view('table', ['todo' => $todos]);
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
    public function update(ValidateRequest $request, string $id)
    {
        $todo = TableAvailability::find($id);
        $todo->guest_name = $request->input('name');
        $todo->pnum = $request->input('phone_num');
        $todo->table_id = $request->input('AT');
        $todo->date = $request->input('date');
        $todo->timeslot_id = $request->input('time_slot');
        $todo->total = intval(Table::where('id',$todo->table_id)->value('price')) + intval(Timeslot::where('id',$todo->timeslot_id)->value('price'));
        $todo->user_id = $request->user()->id;

        $todo->update();
        return redirect('/booking/'.$id);
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
            ->pluck('table_id')
            ->toArray();

        // Get tables that are NOT in the $bookedTableIds array
        $availableTables = Table::whereNotIn('id', $bookedTableIds)
            ->select('id', 'name')
            ->get();

        $options = '';
        foreach ($availableTables as $table) {
            $options .= '<option value="' . $table->id . '">' . $table->name . '</option>';
        }
        echo $options;
    }

    public function tablePreview(string $id) {
        $table = Table::findOrFail($id);
        $preview = '';
        $preview .= '<img src="' . $table->picture_url. '" alt="Photo 2" class="img-fluid" style="width: 100%; height: auto;">';
        $preview .= '<p style="margin-top: 20px"><strong>Description: </strong>' . $table->description . '</p>';
        echo $preview;
    }
}
