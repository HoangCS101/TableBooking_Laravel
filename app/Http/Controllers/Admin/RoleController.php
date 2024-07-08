<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles', ['todo' => $roles]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => ['required', 'min:3']]);
        Role::create($validated);
        return to_route('admin.roles.index');
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate(['name' => ['required', 'min:3']]);
        $role = Role::findById($id);
        $role->update($validated);
        return to_route('admin.roles.index');
    }

    public function destroy(Request $request, string $id)
    {
        $role = Role::findById($id);
        $role->delete();
        return to_route('admin.roles.index');
    }

    public function list(Request $request, string $id)
    {
        $role = Role::findById($id);
        $allPermissions = Permission::all();

        $list = '';
        foreach ($allPermissions as $p) {
            if ($role->hasPermissionTo($p->name)) $checked = 'checked';
            else $checked = '';
            $list .= '<div class="permission-item">';
            $list .= '<p>' . $p->name . '</p>';
            $list .= '<div class="custom-control custom-switch">';
            $list .= '<input type="checkbox" class="custom-control-input" id="switch_' . $p->id . '" data-permission-id="' . $p->id . '" onchange="togglePermission('. $p->id .')"'.$checked.'>'; // Add data-permission-id attribute for identification
            $list .= '<label class="custom-control-label" for="switch_' . $p->id . '"></label>';
            $list .= '</div>';
            $list .= '</div>';
        }
        echo $list;
    }

    public function toggle(Request $request, string $id, string $perid) {
        $role = Role::findById($id);
        $pername = Permission::findById($perid)->name;
        if ($role->hasPermissionTo($pername)) $role->revokePermissionTo($pername);
        else $role->givePermissionTo($pername);
    }
}
