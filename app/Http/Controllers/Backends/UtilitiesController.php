<?php

namespace App\Http\Controllers\Backends;

use Exception;
use App\Models\UtilityRate;
use App\Models\UtilityType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CurrencyService;

class UtilitiesController extends Controller
{
    public function index(Request $request, CurrencyService $currencyService)
    {
        $utilityTypes = UtilityType::with('utilityRates')->get();
        $activeUtilityTypeId = $request->query('utility_type_id');
        $baseCurrency = $currencyService->getBaseCurrency();
        $currencySymbol = $baseCurrency === 'USD' ? '$' : '៛';
        $baseExchangeRate = $currencyService->getExchangeRate();
        return view('backends.utilities.index', compact('utilityTypes', 'activeUtilityTypeId', 'baseExchangeRate', 'currencySymbol'));
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

    public function storeRate(Request $request, $utilityType, CurrencyService $currencyService)
    {
        UtilityRate::create([
            'utility_type_id' => $utilityType,
            'rate_per_unit' => $currencyService->convertCurrency($request->rate_per_unit),
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
    public function updateRate(Request $request, $id, CurrencyService $currencyService)
    {
        $utilityRate = UtilityRate::findOrFail($id);
        $convertedRate = $currencyService->convertCurrency($request->rate_per_unit);
        $utilityRate->rate_per_unit = $convertedRate;
        $utilityRate->save();
        return response()->json([
            'success' => true,
            'message' => 'Utility rate update successfully.'
        ]);
    }

    // Delete a utility rate
    public function destroyRate($id)
    {
        $utilityRate = UtilityRate::findOrFail($id);
        $utilityRate->delete();
        return redirect()->route('utilities.index')->with('success', 'Utility Rate deleted successfully.');
    }


}
