<?php

namespace App\Http\Controllers\Backends;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function room(Request $request)
{
    if ($request->ajax()) {
        $query = Room::join('user_contracts', 'rooms.id', '=', 'user_contracts.room_id')
            ->join('users', 'user_contracts.user_id', '=', 'users.id') // Join with the users table
            ->select(
                'rooms.id as room_id',
                'rooms.room_number',
                'rooms.description',
                'rooms.size',
                'rooms.floor',
                'rooms.status',
                'user_contracts.user_id',
                'users.name as user_name', // Include the user's name
                'user_contracts.start_date',
                'user_contracts.end_date',
                'user_contracts.monthly_rent',
                'user_contracts.status'
            );

        // Apply filters
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_contracts.user_id', $request->user_id);
        }

        if ($request->has('room_id') && $request->room_id) {
            $query->where('rooms.id', $request->room_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('user_contracts.status', $request->status);
        }

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('user_contracts.start_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('user_contracts.end_date', '<=', $request->end_date);
        }

        // Pagination (Server-Side)
        $perPage = $request->input('length', 10);
        $page = $request->input('start', 0);
        $data = $query->skip($page)->take($perPage)->get();

        // Total records count
        $totalCount = $query->count();

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalCount,
            'recordsFiltered' => $totalCount,
            'data' => $data,
        ]);
    }

    $rooms = Room::all();
    $users = User::all();
    return view('backends.reports.room_report', compact('rooms', 'users'));
}



}
