<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index() {
        $pers = Permission::all();
        return view('admin.permission', ['todo' => $pers]);
    }

    public function store(Request $request) {
        $validated = $request->validate(['name' => ['required', 'min:3']]);
        Permission::create($validated);
        return to_route('admin.permissions.index');
    }

    public function update(Request $request, string $id) {
        $validated = $request->validate(['name' => ['required', 'min:3']]);
        $role = Permission::findById($id);
        $role->update($validated);
        return to_route('admin.permissions.index');
    }

    public function destroy(Request $request, string $id) {
        $role = Permission::findById($id);
        $role->delete();
        return to_route('admin.permissions.index');
    }
}
