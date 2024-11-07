<?php

namespace App\Http\Controllers\Backends;

use App\Models\Room;
use App\Models\UtilityType;
use App\Models\MonthlyUsage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreMonthlyUsageRequest;
use App\Http\Requests\UpdateMonthlyUsageRequest;

class MonthlyUsageController extends Controller
{
    // Display a listing of the monthly usages
    public function index()
    {
        $monthlyUsages = MonthlyUsage::with(['room', 'utilityType'])->get();
        return view('backends.monthly_usages.index', compact('monthlyUsages'));
    }

    // Show the form for creating monthly usage
    public function create()
    {
        $rooms = Room::all();
        $utilityTypes = UtilityType::all();
        return view('backends.monthly_usages.create', compact('rooms', 'utilityTypes'));
    }

    // Store the monthly usage
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:2100',
            'utility_types.*.utility_type_id' => 'required|exists:utility_types,id',
            'utility_types.*.usage' => 'required|numeric|min:0',
        ]);

        // Create Monthly Usage for each utility type
        foreach ($request->utility_types as $utility) {
            MonthlyUsage::create([
                'room_id' => $request->room_id,
                'month' => $request->month,
                'year' => $request->year,
                'utility_type_id' => $utility['utility_type_id'],
                'usage' => $utility['usage'],
            ]);
        }

        Session::flash('success', __('Monthly usage created successfully.'));
        return redirect()->route('monthly_usages.index');
    }
    // Show the form for editing the specified monthly usage
    public function edit(MonthlyUsage $monthlyUsage)
    {
        $rooms = Room::all();
        $utilityTypes = UtilityType::all();
        return view('backends.monthly_usages.edit', compact('monthlyUsage', 'rooms', 'utilityTypes'));
    }

    // Update the specified monthly usage
    public function update(UpdateMonthlyUsageRequest $request, MonthlyUsage $monthlyUsage)
    {
        $monthlyUsage->update($request->validated());
        Session::flash('success', __('Monthly usage updated successfully.'));
        return redirect()->route('monthly_usages.index');
    }

    // Remove the specified monthly usage
    public function destroy(MonthlyUsage $monthlyUsage)
    {
        try {
            $monthlyUsage->delete();
            Session::flash('success', __('Monthly usage deleted successfully.'));
        } catch (\Exception $e) {
            Session::flash('error', __('Failed to delete monthly usage.'));
        }

        return redirect()->route('monthly_usages.index');
    }
}
