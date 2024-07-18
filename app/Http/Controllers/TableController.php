<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableUpdateForm;
use Illuminate\Http\Request;
use App\Models\Table;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Table::all();

        return view('tablelist', ['todo' => $todos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('createtable');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TableUpdateForm $request)
    {
        $todo = new Table();
        $todo->name = $request->input('name');
        $todo->description = $request->input('description');
        $todo->price = $request->input('price');
        $todo->picture_url = $request->input('picture_url');
        $todo->save();
        return redirect('/table');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
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
    public function update(TableUpdateForm $request, string $id)
    {
        $todo = Table::find($id);
        $todo->name = $request->input('name');
        $todo->description = $request->input('description');
        $todo->price = $request->input('price');
        $todo->picture_url = $request->input('picture_url');
        $todo->update();
        return redirect('/table');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $todo = Table::findOrFail($id);
            $todo->delete();
            return response()->json(['message' => 'Record deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete record: ' . $e->getMessage()], 500);
        }
    }
}
