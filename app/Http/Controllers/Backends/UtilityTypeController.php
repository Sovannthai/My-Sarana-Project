<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Models\UtilityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UtilityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $utilityTypes = UtilityType::all();
        return view('backends.utility_type.index', compact('utilityTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backends.utility_type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|unique:utility_types|max:50',
        ]);

        UtilityType::create($request->all());

        Session::flash('success', __('Utility Type added successfully.'));
        return redirect()->route('utility_types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $utilityType = UtilityType::find($id);
        return view('backends.utility_type.show', compact('utilityType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $utilityType = UtilityType::find($id);
        return view('backends.utility_type.edit', compact('utilityType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|max:50|unique:utility_types,type,' . $id,
        ]);

        $utilityType = UtilityType::find($id);
        $utilityType->update($request->all());

        Session::flash('success', __('Utility Type updated successfully.'));
        return redirect()->route('utility_types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $utilityType = UtilityType::findOrFail($id);
            $utilityType->delete();

            Session::flash('success', __('Utility Type deleted successfully.'));
        } catch (\Exception $e) {
            Session::flash('error', __('Failed to delete Utility Type.'));
        }

        return redirect()->route('utility_types.index');
    }
}
