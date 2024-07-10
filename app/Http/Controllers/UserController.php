<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $todos = User::where('role_id', 2)->get();
        $users = User::all();
        foreach ($users as $user) {
            // Find roles associated with each user
            $userRoles = $user->roles->pluck('name')->implode(', ');
            $user->roles = $userRoles;
        }

        return view('userlist', ['todo' => $users]);
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
        //
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
        $user = User::findOrFail($id);
        if ($request->act == '1') $user->assignRole($request->role);
        else $user->removeRole($request->role);
        return redirect('/user');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the record with the given ID
            $todo = User::findOrFail($id);

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
