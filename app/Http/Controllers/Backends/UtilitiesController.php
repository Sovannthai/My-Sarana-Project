<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Models\UtilityType;
use App\Models\UtilityRate;
use Illuminate\Http\Request;

class UtilitiesController extends Controller
{
    public function index(Request $request)
    {
        $utilityTypes = UtilityType::with('utilityRates')->get();
        $activeUtilityTypeId = $request->query('utility_type_id');
        return view('backends.utilities.index', compact('utilityTypes', 'activeUtilityTypeId'));
    }
    public function getRate($id)
    {
        $rates = UtilityRate::with('utilityType')->where('utility_type_id', $id)->get();
        return response()->json($rates);
    }
    public function storeRate(Request $request, $utilityTypeId)
    {
        $utilityRate = UtilityRate::create([
            'utility_type_id' => $utilityTypeId,
            'rate_per_unit' => $request->rate_per_unit,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Utility Rate created successfully.',
        ]);
    }

    public function editRate($id)
    {
        $utilityRate = UtilityRate::findOrFail($id);
        $utilityType = $utilityRate->utilityType;
        return view('backends.utilities.edit_rate', compact('utilityRate', 'utilityType'));
    }

    // Update a utility rate
    public function updateRate(Request $request, $id)
    {
        $request->validate([
            'rate_per_unit' => 'required|numeric',
        ]);
        $utilityRate = UtilityRate::findOrFail($id);
        $utilityRate->update($request->all());
        return redirect()->route('utilities.index')->with('success', 'Utility Rate updated successfully.');
    }

    // Delete a utility rate
    public function destroyRate($id)
    {
        $utilityRate = UtilityRate::findOrFail($id);
        $utilityRate->delete();
        return redirect()->route('utilities.index')->with('success', 'Utility Rate deleted successfully.');
    }


}
