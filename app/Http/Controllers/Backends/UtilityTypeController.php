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
        return view('backends.utilitie_type.index', compact('utilityTypes'));
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
        return redirect()->route('utilities_type.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $utilityType = UtilityType::findOrFail($id);
        $utilityType->update($request->all());

        Session::flash('success', __('Utility Type updated successfully.'));
        return redirect()->route('utilities_type.index');
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

        return redirect()->route('utilities_type.index');
    }
}
