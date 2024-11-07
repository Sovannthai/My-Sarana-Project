<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('roomPricings')->get(); // Eager load the pricing data
        return view('backends.room.index', compact('rooms'));
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
    public function store(StoreRoomRequest $request)
    {
        $room = new Room();
        $room->room_number = $request->input('room_number');
        $room->description = $request->input('description');
        $room->size = $request->input('size');
        $room->floor = $request->input('floor');
        $room->status = $request->input('status');
        $room->save();

        Session::flash('success', __('Room added successfully.'));
        return redirect()->route('rooms.index');
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
    public function update(UpdateRoomRequest $request, $id)
    {
        $room = Room::find($id);
        $room->room_number = $request->input('room_number');
        $room->description = $request->input('description');
        $room->size = $request->input('size');
        $room->floor = $request->input('floor');
        $room->status = $request->input('status');
        $room->save();

        Session::flash('success', __('Room updated successfully.'));
        return redirect()->route('rooms.index');
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
