<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
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

    public function store(Request $request)
    {
        $priceAdjustment = PriceAdjustment::create($request->all());

        Session::flash('success', __('Price adjustment added successfully.'));
        return redirect()->route('price_adjustments.index');
    }

    public function show($id)
    {
        $priceAdjustment = PriceAdjustment::findOrFail($id);
        return view('backends.price_adjustment.show', compact('priceAdjustment'));
    }

    public function update(Request $request, $id)
    {
        $priceAdjustment = PriceAdjustment::findOrFail($id);
        $priceAdjustment->update($request->all());

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
