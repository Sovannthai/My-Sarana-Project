<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware('permission:show permission', ['only' => ['show', 'index']]);
    //     $this->middleware('permission:create permission', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:update permission', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:delete permission', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('backends.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backends.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        $name = $request->input('name');
        $guardName = 'web';
        Permission::create([
            'name'       => $name,
            'guard_name' => $guardName
        ]);
        //    Alert::toast('Add permission sucessfully', 'success');
        Session::flash('success', __('Permission Added successfully.'));
        return redirect()->route('permission.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::find($id);
        return view('backends.permission.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('backends.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissionRequest  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, $id)
    {
        $name = $request->input('name');
        $guardName = 'web';
        Permission::where('id', $id)->update([
            'name'       => $name,
            'guard_name' => $guardName
        ]);
        Alert::toast('Update permission sucessfully', 'success');
        return redirect('permission');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            Session::flash('success', __('Permission deleted successfully.'));
        } catch (\Exception $e) {
            Session::flash('error', __('Failed to delete permission.'));
        }

        return redirect()->route('permission.index');
    }
}
