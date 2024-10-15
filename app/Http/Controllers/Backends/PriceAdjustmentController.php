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
        return view('backends.price_adjustment.index', compact('priceAdjustments'));
    }

    public function create()
    {
        $rooms = Room::all();
        return view('backends.price_adjustment.create', compact('rooms'));
    }

    public function store(StorePriceAdjustmentRequest $request)
    {
        $priceAdjustment = PriceAdjustment::create($request->validated());
        Session::flash('success', __('Price adjustment added successfully.'));
        return redirect()->route('price_adjustments.index');
    }

    public function show($id)
    {
        $priceAdjustment = PriceAdjustment::findOrFail($id);
        return view('backends.price_adjustment.show', compact('priceAdjustment'));
    }

    public function edit($id)
    {
        $priceAdjustment = PriceAdjustment::findOrFail($id);
        $rooms = Room::all();
        return view('backends.price_adjustment.edit', compact('priceAdjustment', 'rooms'));
    }

    public function update(UpdatePriceAdjustmentRequest $request, $id)
    {
        $priceAdjustment = PriceAdjustment::findOrFail($id);
        $priceAdjustment->update($request->validated());
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