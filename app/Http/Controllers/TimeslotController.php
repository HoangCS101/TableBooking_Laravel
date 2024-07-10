<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timeslot;
use Ramsey\Uuid\Type\Time;

class TimeslotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $t = Timeslot::all();
        return view('timeslot', ['todo' => $t]);
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'slot_name' => ['required', 'min:3'],
            'price'=> ['required']
        ]);
        if ($validated)
        {
            $ts = new Timeslot();
            $ts->slot_name = $request->input('slot_name');
            $ts->price = $request->input('price');
            $ts->save();
        }
        return redirect('/timeslot');
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
        $ts = Timeslot::findOrFail($id);
        $ts->slot_name = $request->input('slot_name');
        $ts->price = $request->input('price');
        $ts->update();
        return redirect('/timeslot');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ts = Timeslot::findOrFail($id);
        $ts->delete();
        return redirect('/timeslot');
    }

    public function list() {
        $ts = Timeslot::all();
        $response = '';
        foreach($ts as $t){
            $response .= '<option value="'.$t->id.'">'.$t->slot_name.'</option>';
        }
        echo $response;
    }
}
