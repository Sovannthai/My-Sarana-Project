<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Models\UtilityType;
use App\Models\UtilityRate;
use Illuminate\Http\Request;

class UtilitiesController extends Controller
{
    // Display the list of utility types with expandable rates
    public function index()
    {
        $utilityTypes = UtilityType::with('utilityRates')->get();
        return view('backends.utilities.index', compact('utilityTypes'));
    }

    // Create a new utility type
    public function createType()
    {
        return view('backends.utilities.create_type');
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
        return view('backends.utilities.create_rate', compact('utilityType'));
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

    // Edit a utility type
public function editType($id)
{
    $utilityType = UtilityType::findOrFail($id);
    return view('backends.utilities.edit_type', compact('utilityType'));
}

// Update a utility type
public function updateType(Request $request, $id)
{
    $request->validate([
        'type' => 'required|max:50',
    ]);
    $utilityType = UtilityType::findOrFail($id);
    $utilityType->update($request->all());
    return redirect()->route('utilities.index')->with('success', 'Utility Type updated successfully.');
}

// Edit a utility rate
public function editRate($id)
{
    $utilityRate = UtilityRate::findOrFail($id);
    $utilityType = $utilityRate->utilityType; // Assuming you have the relationship set
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

// Delete a utility type
public function destroyType($id)
{
    $utilityType = UtilityType::findOrFail($id);
    $utilityType->delete();
    return redirect()->route('utilities.index')->with('success', 'Utility Type deleted successfully.');
}

// Delete a utility rate
public function destroyRate($id)
{
    $utilityRate = UtilityRate::findOrFail($id);
    $utilityRate->delete();
    return redirect()->route('utilities.index')->with('success', 'Utility Rate deleted successfully.');
}


}
