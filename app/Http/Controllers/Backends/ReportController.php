<?php

namespace App\Http\Controllers\Backends;

use App\Models\Room;
use App\Models\User;
use App\Models\UtilityType;
use App\Models\MonthlyUsage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function room(Request $request)
{
    if ($request->ajax()) {
        $query = Room::join('user_contracts', 'rooms.id', '=', 'user_contracts.room_id')
            ->join('users', 'user_contracts.user_id', '=', 'users.id')
            ->select(
                'rooms.id as room_id',
                'rooms.room_number',
                'rooms.description',
                'rooms.size',
                'rooms.floor',
                'rooms.status',
                'user_contracts.user_id',
                'users.name as user_name',
                'user_contracts.start_date',
                'user_contracts.end_date',
                'user_contracts.monthly_rent',
                'user_contracts.status'
            );

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

        $perPage = $request->input('length', 10);
        $page = $request->input('start', 0);
        $data = $query->skip($page)->take($perPage)->get();

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

public function utility(Request $request)
    {
        if ($request->ajax()) {
            $query = MonthlyUsage::join('rooms', 'monthly_usages.room_id', '=', 'rooms.id')
                ->join('monthly_usage_details', 'monthly_usages.id', '=', 'monthly_usage_details.monthly_usage_id')
                ->join('utility_types', 'monthly_usage_details.utility_type_id', '=', 'utility_types.id')
                ->select(
                    'rooms.room_number',
                    'monthly_usages.month',
                    'monthly_usages.year',
                    'utility_types.type as utility_type',
                    'monthly_usage_details.usage'
                );

            if ($request->has('room_id') && $request->room_id) {
                $query->where('rooms.id', $request->room_id);
            }
            if ($request->has('utility_type_id') && $request->utility_type_id) {
                $query->where('utility_types.id', $request->utility_type_id);
            }
            if ($request->has('month') && $request->month) {
                $query->where('monthly_usages.month', $request->month);
            }
            if ($request->has('year') && $request->year) {
                $query->where('monthly_usages.year', $request->year);
            }

            $perPage = $request->input('length', 10);
            $page = $request->input('start', 0);
            $data = $query->skip($page)->take($perPage)->get();

            $totalCount = $query->count();

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $totalCount,
                'recordsFiltered' => $totalCount,
                'data' => $data,
            ]);
        }

        $rooms = Room::all();
        $utilityTypes = UtilityType::all();

        return view('backends.reports.utility_report', compact('rooms', 'utilityTypes'));
    }

}
