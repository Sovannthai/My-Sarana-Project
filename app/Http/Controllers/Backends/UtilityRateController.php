<?php

namespace App\Http\Controllers;

use App\Models\UtilityType;
use App\Models\UtilityRate;
use Illuminate\Http\Request;

class UtilitiesController extends Controller
{
    // Display the list of utility types with expandable rates
    public function index()
    {
        $utilityTypes = UtilityType::with('utilityRates')->get();
        return view('utilities.index', compact('utilityTypes'));
    }

    // Create a new utility type
    public function createType()
    {
        return view('utilities.create_type');
    }

    // Store a new utility type
    public function storeType(Request $request)
    {
        $request->validate([
            'type' => 'required|max:50',
        ]);
        UtilityType::create($request->all());
        return redirect()->route('utilities.index')->with('success', 'Utility Type created successfully.');
    }

    // Create a new utility rate
    public function createRate($utilityTypeId)
    {
        $utilityType = UtilityType::findOrFail($utilityTypeId);
        return view('utilities.create_rate', compact('utilityType'));
    }

    // Store a new utility rate
    public function storeRate(Request $request, $utilityTypeId)
    {
        $request->validate([
            'rate_per_unit' => 'required|numeric',
        ]);
        UtilityRate::create([
            'utility_type_id' => $utilityTypeId,
            'rate_per_unit' => $request->rate_per_unit,
        ]);
        return redirect()->route('utilities.index')->with('success', 'Utility Rate created successfully.');
    }
}
