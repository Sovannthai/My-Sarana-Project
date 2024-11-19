<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\PriceAdjustment;
use App\Models\Room;
use App\Http\Requests\StorePriceAdjustmentRequest;
use App\Http\Requests\UpdatePriceAdjustmentRequest;

class PriceAdjustmentController extends Controller
{
    public function index()
    {
        $priceAdjustments = PriceAdjustment::all();
        $rooms = Room::all();
        $usedRoomIds = PriceAdjustment::pluck('room_id')->toArray();
        $availableRooms = Room::whereNotIn('id', $usedRoomIds)->get();
        return view('backends.price_adjustment.index', compact('priceAdjustments', 'rooms', 'availableRooms'));
    }

    public function store(StorePriceAdjustmentRequest $request)
    {
        $validated = $request->validated();

        // Handle conditional validation
        if ($validated['type'] === 'long_term' && !isset($validated['min_months'])) {
            return back()->withErrors(['min_months' => 'Minimum months is required for Long-Term type.']);
        }

        if ($validated['type'] === 'seasonal') {
            if (!isset($validated['start_date']) || !isset($validated['end_date'])) {
                return back()->withErrors(['start_date' => 'Start Date and End Date are required for Seasonal type.']);
            }
        }

        if ($validated['type'] === 'prepayment' && !isset($validated['min_prepayment_months'])) {
            return back()->withErrors(['min_prepayment_months' => 'Minimum Prepayment Months is required for Prepayment type.']);
        }

        // Create the PriceAdjustment
        $priceAdjustment = PriceAdjustment::create($validated);

        Session::flash('success', __('Price adjustment added successfully.'));
        return redirect()->route('price_adjustments.index');
    }

    public function show($id)
    {
        $priceAdjustment = PriceAdjustment::findOrFail($id);
        return view('backends.price_adjustment.show', compact('priceAdjustment'));
    }

    public function update(UpdatePriceAdjustmentRequest $request, $id)
    {
        $priceAdjustment = PriceAdjustment::findOrFail($id);
        $validated = $request->validated();

        // Handle conditional validation
        if ($validated['type'] === 'long_term' && !isset($validated['min_months'])) {
            return back()->withErrors(['min_months' => 'Minimum months is required for Long-Term type.']);
        }

        if ($validated['type'] === 'seasonal') {
            if (!isset($validated['start_date']) || !isset($validated['end_date'])) {
                return back()->withErrors(['start_date' => 'Start Date and End Date are required for Seasonal type.']);
            }
        }

        if ($validated['type'] === 'prepayment' && !isset($validated['min_prepayment_months'])) {
            return back()->withErrors(['min_prepayment_months' => 'Minimum Prepayment Months is required for Prepayment type.']);
        }

        // Update the PriceAdjustment
        $priceAdjustment->update($validated);

        Session::flash('success', __('Price adjustment updated successfully.'));
        return redirect()->route('price_adjustments.index');
    }

    public function destroy($id)
    {
        try {
            $priceAdjustment = PriceAdjustment::findOrFail($id);
            $priceAdjustment->delete();
            Session::flash('success', __('Price adjustment deleted successfully.'));
        } catch (\Exception $e) {
            Session::flash('error', __('Failed to delete price adjustment.'));
        }

        return redirect()->route('price_adjustments.index');
    }
}
