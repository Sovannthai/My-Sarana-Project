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
    public function index()
    {
        $rooms = Room::all();
        $monthlyUsages = MonthlyUsage::with(['room', 'utilityType'])->get();
        return view('backends.monthly_usages.index', compact('rooms', 'monthlyUsages'));
    }

    public function show($roomId)
    {
        $room = Room::findOrFail($roomId);
        $monthlyUsages = MonthlyUsage::where('room_id', $roomId)->get();
        $utilityTypes = UtilityType::all();
        $rooms = Room::all();

        return view('backends.monthly_usages.show', compact('room', 'monthlyUsages', 'utilityTypes', 'rooms'));
    }

    public function store(StoreMonthlyUsageRequest $request)
    {
        try {
            MonthlyUsage::create($request->validated());
            Session::flash('success', __('Monthly usage added successfully.'));
        } catch (\Exception $e) {
            Session::flash('error', __('Failed to add monthly usage.'));
        }

        return redirect()->route('monthly_usages.show', $request->room_id);
    }

    public function update(UpdateMonthlyUsageRequest $request, MonthlyUsage $monthlyUsage)
    {
        try {
            $monthlyUsage->update($request->validated());
            Session::flash('success', __('Monthly usage updated successfully.'));
        } catch (\Exception $e) {
            Session::flash('error', __('Failed to update monthly usage.'));
        }

        return redirect()->route('monthly_usages.show', $monthlyUsage->room_id);
    }

    public function destroy(MonthlyUsage $monthlyUsage)
    {
        try {
            $roomId = $monthlyUsage->room_id;
            $monthlyUsage->delete();
            Session::flash('success', __('Monthly usage deleted successfully.'));
        } catch (\Exception $e) {
            Session::flash('error', __('Failed to delete monthly usage.'));
        }

        return redirect()->route('monthly_usages.show', $roomId);
    }
}
