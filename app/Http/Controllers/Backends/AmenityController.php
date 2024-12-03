<?php

namespace App\Http\Controllers\Backends;

use Exception;
use App\Models\Amenity;
use App\Services\CurrencyService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreAmenityRequest;
use App\Http\Requests\UpdateAmenityRequest;

class AmenityController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CurrencyService $currencyService)
    {
        $amenities = Amenity::all();
        $baseCurrency = $currencyService->getBaseCurrency();
        $currencySymbol = $baseCurrency === 'USD' ? '$' : '៛';
        $baseExchangeRate = $currencyService->getExchangeRate();
        $amenities->each(function ($amenity) use ($baseExchangeRate) {
            $amenity->converted_price = $baseExchangeRate * $amenity->additional_price;
        });
        return view('backends.amenity.index', compact('amenities', 'currencySymbol'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backends.amenity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAmenityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAmenityRequest $request, CurrencyService $currencyService)
    {
        $amenity = new Amenity();
        $amenity->name = $request->input('name');
        $amenity->description = $request->input('description');
        $amenity->additional_price = $currencyService->convertCurrency($request->input('additional_price'));
        $amenity->save();

        Session::flash('success', __('Amenity added successfully.'));
        return redirect()->route('amenities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Amenity  $amenity
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $amenity = Amenity::find($id);
        return view('backends.amenity.show', compact('amenity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Amenity  $amenity
     * @return \Illuminate\Http\Response
     */
    public function edit(CurrencyService $currencyService, $id)
    {
        $amenity = Amenity::find($id);
        $baseCurrency = $currencyService->getBaseCurrency();
        $currencySymbol = $baseCurrency === 'USD' ? '$' : '៛';
        $baseExchangeRate = $currencyService->getExchangeRate();
        $amenity->converted_price = $baseExchangeRate * $amenity->additional_price;
        return view('backends.amenity.edit', compact('amenity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAmenityRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAmenityRequest $request, CurrencyService $currencyService, $id)
    {
        $amenity = Amenity::find($id);
        $amenity->name = $request->input('name');
        $amenity->description = $request->input('description');
        $amenity->additional_price = $currencyService->convertCurrency($request->input('additional_price'));
        $amenity->save();

        Session::flash('success', __('Amenity updated successfully.'));
        return redirect()->route('amenities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $amenity = Amenity::findOrFail($id);
            $amenity->delete();
            Session::flash('success', __('Amenity deleted successfully.'));
        } catch (\Exception $e) {
            Session::flash('error', __('Failed to delete amenity.'));
        }

        return redirect()->route('amenities.index');
    }

    public function updateStatus(Request $request)
    {
        try {
            $status = $request->input('status') === 'true' ? "1" : "0";
            $amenity = Amenity::findOrFail($request->input('id'));
            $amenity->status = $status;
            $amenity->save();
            $output = [
                'success' => 1,
                'msg' => ('Status update successfully')
            ];
        } catch (Exception $e) {
            Log::info("message");
            dd($e);
            $output = [
                'error' => 0,
                'msg' => ('Something went wrong')
            ];
        }
        return response()->json($output);
    }
}
