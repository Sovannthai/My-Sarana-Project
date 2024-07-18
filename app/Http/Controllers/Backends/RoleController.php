<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware('permission:show role', ['only' => ['show', 'index']]);
    //     $this->middleware('permission:create role', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:update role', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:delete role', ['only' => ['destroy']]);
    // }
    public function index()
    {
        $roles = Role::paginate(10);
        return view('backends.role.index', compact('roles'));
    }
    public function create()
    {
        $permissions = Permission::get()->groupBy(function ($data) {
            return $data->module;
        });
        return view('backends.role.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
        ]);

        $roleName = $request->input('name');
        $roleDescription = $request->description;
        $permissions = $request->input('permissions');

        $role = new Role;
        $role->name = $roleName;
        $role->description = $roleDescription;
        $role->save();

        if (!empty($permissions)) {
            $validPermissions = Permission::whereIn('id', $permissions)->get();

            if ($validPermissions->count() != count($permissions)) {
                $notFoundPermissions = array_diff($permissions, $validPermissions->pluck('id')->toArray());
                return redirect()->back()->withErrors(['permissions' => 'Invalid permissions: ' . implode(', ', $notFoundPermissions)]);
            }

            $role->syncPermissions($validPermissions);
        }

        Session::flash('success', __('Role Added successfully!'));
        return redirect('roles');
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);
        $permissions = Permission::get()->groupBy(function ($data) {
            return $data->module;
        });
        $rolePermissions = [];
        foreach ($role->permissions as $rolePerm) {
            $rolePermissions[] = $rolePerm->name;
        }
        return view('backends.role.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, $id)
{
    $this->validate($request, [
        'name' => 'required|unique:roles,name,' . $id,
        // Uncomment this if you want to validate description
        // 'description' => 'sometimes|string|max:255',
    ]);

    $roleName = $request->input('name');
    $roleDescription = $request->input('description');
    $permissions = $request->input('permissions', []);

    $role = Role::findOrFail($id);
    $role->name = $roleName;
    $role->description = $roleDescription;
    $role->save();

    if (!empty($permissions)) {
        $validPermissions = Permission::whereIn('name', $permissions)->get();

        if ($validPermissions->count() != count($permissions)) {
            $notFoundPermissions = array_diff($permissions, $validPermissions->pluck('name')->toArray());
            return redirect()->back()->withErrors(['permissions' => 'Invalid permissions: ' . implode(', ', $notFoundPermissions)]);
        }

        $role->syncPermissions($validPermissions);
    } else {
        $role->syncPermissions([]);
    }

    Session::flash('success', __('Role Updated successfully!'));
    return redirect()->route('roles.index');
}

    public function show($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::get()->groupBy(function ($data) {
            return $data->module;
        });
        $rolePermissions = [];
        foreach ($role->permissions as $rolePerm) {
            $rolePermissions[] = $rolePerm->name;
        }
        return view('backends.role.show', compact(['role', 'permissions', 'rolePermissions']));
    }
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->revokePermissionTo($role->permissions);
        $role->delete();
        Session::flash('success', __('Role Deleted successfully!'));
        return redirect('roles');
    }
}
