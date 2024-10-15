<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Models\MonthlyUsage;
use App\Models\Room;
use App\Models\UtilityType;
use App\Http\Requests\StoreMonthlyUsageRequest;
use App\Http\Requests\UpdateMonthlyUsageRequest;
use Illuminate\Support\Facades\Session;

class MonthlyUsageController extends Controller
{
    // Display a listing of the monthly usages
    public function index()
    {
        // Eager load the room and utilityType relationships
        $monthlyUsages = MonthlyUsage::with(['room', 'utilityType'])->get();
        return view('backends.monthly_usages.index', compact('monthlyUsages'));
    }

    // Show the form for creating a new monthly usage
    public function create()
    {
        $rooms = Room::all();
        $utilityTypes = UtilityType::all();
        return view('backends.monthly_usages.create', compact('rooms', 'utilityTypes'));
    }

    // Store a newly created monthly usage
    public function store(StoreMonthlyUsageRequest $request)
    {
        MonthlyUsage::create($request->validated());
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
