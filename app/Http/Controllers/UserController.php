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
        // $user = User::findOrFail($id);
        // if ($request->act == '1') $user->assignRole($request->role);
        // else $user->removeRole($request->role);
        // return redirect('/user');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todo = User::findOrFail($id);
        $todo->delete();
        return redirect('/user');
    }

    public function list(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $allRoles = Role::all();

        $list = '';
        foreach ($allRoles as $r) {
            if ($user->hasRole($r->name)) $checked = 'checked';
            else $checked = '';
            $list .= '<div class="role-item">';
            $list .= '<p>' . $r->name . '</p>';
            $list .= '<div class="custom-control custom-switch">';
            $list .= '<input type="checkbox" class="custom-control-input" id="switch_' . $r->id . '" data-role-id="' . $r->id . '" onchange="toggleRole(' . $r->id . ')"' . $checked . '>';
            $list .= '<label class="custom-control-label" for="switch_' . $r->id . '"></label>';
            $list .= '</div>';
            $list .= '</div>';
        }

        echo $list;
    }

    public function toggle(Request $request, string $id, string $roleid)
    {
        $user = User::findOrFail($id);
        $rolename = Role::findById($roleid)->name;
        if ($user->hasRole($rolename)) $user->removeRole($rolename);
        else $user->assignRole($rolename);
    }
}
