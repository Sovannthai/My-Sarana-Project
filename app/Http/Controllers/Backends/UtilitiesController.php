<?php

namespace App\Http\Controllers\Backends;

use Exception;
use App\Models\UtilityRate;
use App\Models\UtilityType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
    //Update Status
    public function updateStatus(Request $request)
    {
        try {
            $status = $request->input('status') === 'true' ? '1' : '0';
            $utilityRate = UtilityRate::findOrFail($request->input('id'));
            if ($status === '1') {
                UtilityRate::where('utility_type_id', $utilityRate->utility_type_id)
                    ->where('id', '!=', $utilityRate->id)
                    ->update(['status' => '0']);
            }
            $utilityRate->update(['status' => $status]);

            $output = [
                'success' => true,
                'msg' => 'Status updated successfully'
            ];
        } catch (Exception $e) {
            $output = [
                'error' => true,
                'msg' => 'Something went wrong'
            ];
        }
        return response()->json($output);
    }

    public function storeRate(Request $request, $utilityType)
    {
        UtilityRate::create([
            'utility_type_id' => $utilityType,
            'rate_per_unit' => $request->rate_per_unit,
            'status' => '0', // Default status
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Utility rate created successfully.'
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
