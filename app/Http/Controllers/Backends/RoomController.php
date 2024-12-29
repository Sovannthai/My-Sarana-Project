<?php

namespace App\Http\Controllers\Backends;

use Exception;
use App\Services;
use App\Models\Room;
use App\Models\Amenity;
use App\Http\Requests\Request;
use App\Services\CurrencyService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateRoomRequest;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CurrencyService $currencyService)
    {
        if (!auth()->user()->can('view room')) {
            abort(403, 'Unauthorized action.');
        }
        $rooms = Room::with('roomPricing')->get();
        $baseCurrency = $currencyService->getBaseCurrency();
        $currencySymbol = $baseCurrency === 'USD' ? '$' : '៛';
        $baseExchangeRate = $currencyService->getExchangeRate();
        $amenities = Amenity::where('status', '1')->get();
        return view('backends.room.index', compact('rooms', 'currencySymbol', 'baseExchangeRate', 'amenities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backends.room.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $room = new Room();
            $room->room_number = $request->input('room_number');
            $room->description = $request->input('description');
            $room->size = $request->input('size');
            $room->floor = $request->input('floor');
            $room->status = $request->input('status') ?? 'available';
            $room->save();
            if ($request->has('amenity_id')) {
                $room->amenities()->attach($request->input('amenity_id'));
            }

            Session::flash('success', __('Room added successfully.'));
            return redirect()->route('rooms.index');
        } catch (Exception $e) {
            dd($e);
            Session::flash('error', __('An error occurred while adding room.'));
            return redirect()->route('rooms.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $room = Room::find($id);
        return view('backends.room.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $room = Room::find($id);
        return view('backends.room.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $room = Room::find($id);
            $room->room_number = $request->input('room_number');
            $room->description = $request->input('description');
            $room->size = $request->input('size');
            $room->floor = $request->input('floor');
            $room->status = $request->input('status');
            $room->save();
            if ($request->has('amenity_id')) {
                $room->amenities()->sync($request->input('amenity_id'));
            }

            Session::flash('success', __('Room updated successfully.'));
            return redirect()->route('rooms.index');
        } catch (Exception $e) {
            dd($e);
            Session::flash('error', __('An error occurred while updating room.'));
            return redirect()->route('rooms.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $room = Room::findOrFail($id);
            $room->delete();
            Session::flash('success', __('Room deleted successfully.'));
        } catch (\Exception $e) {
            Session::flash('error', __('Failed to delete room.'));
        }

        return redirect()->route('rooms.index');
    }
}
