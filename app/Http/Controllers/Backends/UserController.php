<?php

namespace App\Http\Controllers\Backends;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function uploadImage($image)
    {
        $extension = $image->getClientOriginalExtension();
        $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $extension;
        $image->move(public_path('uploads/all_photo/'), $imageName);
        return $imageName;
    }
    public function view_profile(Request $request, $id)
    {
        $user = User::find($id);
        return view('backends.user.profile', compact('user'));
    }
    public function update_profile(Request $request, $id)
    {
        try {
            $user = User::find($id);
            $old_photo_path = $user->photo;
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }
            if ($request->hasFile('photo')) {
                $user->photo = $this->uploadImage($request->file('photo'));
                if ($old_photo_path && File::exists(public_path('uploads/all_photo/' . $old_photo_path))) {
                    File::delete(public_path('uploads/all_photo/' . $old_photo_path));
                }
            }
            $user->save();
            $output = [
                'success' => 1,
                'msg' => Lang::get('Profile Updated successfully')
            ];
        } catch (\Exception $e) {
            $output = [
                'error' => 0,
                'msg' => trans('Something went wrong')
            ];
        }

        return redirect()->route('home')->with($output);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if (!auth()->user()->can('view.user')) {
        //     abort(403, 'Unauthorized action.');
        // }
        $users = User::all();
        $role = Role::all();
        return view('backends.user.index', compact('users', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // if (!auth()->user()->can('create.user')) {
        //     abort(403, 'Unauthorized action.');
        // }
        $roles = Role::all();
        return view('backends.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            if ($request->hasFile('image')) {
                $user->image =  
            }

            $role = Role::findOrFail($request->role);
            $user->assignRole($role->name);

            $user->save();
            $output = [
                'success' =>__('Create successfully')
            ];
        } catch (\Exception $e) {
            $output = [
                'error' =>__('Something went wrong')
            ];
        }
        return redirect()->route('users.index')->with($output);
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
        // if (!auth()->user()->can('edit.user')) {
        //     abort(403, 'Unauthorized action.');
        // }
        $user = User::find($id);
        $roles = Role::all();
        return view('backends.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'email' => 'required|unique:users,email,' . $id,
        ]);
        try {
            $user = User::find($id);
            $old_photo_path = $user->image;
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            if ($request->hasFile('image')) {
                $user->image = $this->uploadImage($request->file('image'));
                if ($old_photo_path && File::exists(public_path('uploads/all_photo/' . $old_photo_path))) {
                    File::delete(public_path('uploads/all_photo/' . $old_photo_path));
                }
            }
            $role = Role::findOrFail($request->role);
            $user->assignRole($role->name);

            $user->save();
            $output = [
                'success' =>__('Updated successfully')
            ];
        } catch (\Exception $e) {
            dd($e);
            $output = [
                'error' =>__('Something went wrong')
            ];
        }
        return redirect()->route('users.index')->with($output);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            $photoPath = public_path('uploads/all_photo/' . $user->photo);
            if (!empty($user->photo) && file_exists($photoPath)) {
                unlink($photoPath);
            }
            DB::commit();
            $output = [
                'success' =>__('Deleted successfully')
            ];
        } catch (\Exception $e) {
            $output = [
                'error' =>__('Something went wrong')
            ];
        }
        return redirect()->route('users.index')->with($output);
    }
}
