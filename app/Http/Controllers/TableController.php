<?php

namespace App\Http\Controllers;

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

        return view('listtable', ['todo' => $todos]);
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
    public function store(Request $request)
    {
        $todo = new Table();
        $todo->name = $request->input('name');
        $todo->description = $request->input('description');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the record with the given ID
            $todo = Table::findOrFail($id);

            // Delete the record
            $todo->delete();

            // Optionally, you can return a response indicating success
            return response()->json(['message' => 'Record deleted successfully'], 200);
        } catch (\Exception $e) {
            // Handle any exceptions, such as if the record does not exist
            return response()->json(['error' => 'Failed to delete record: ' . $e->getMessage()], 500);
        }
    }
}
