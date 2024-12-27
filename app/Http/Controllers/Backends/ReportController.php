<?php

namespace App\Http\Controllers\Backends;

use App\Models\Room;
use App\Models\User;
use App\Models\UtilityType;
use App\Models\MonthlyUsage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;

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

    public function paymentReport(Request $request)
    {
        if ($request->ajax()) {
            $query = Payment::with('userContract.user');

            // Apply filters if provided
            if ($request->has('month') && $request->month) {
                $query->where('month_paid', $request->month);
            }
            if ($request->has('year') && $request->year) {
                $query->where('year_paid', $request->year);
            }
            if ($request->has('type') && $request->type) {
                $query->where('type', $request->type);
            }
            if ($request->has('status') && $request->status) {
                $query->where('payment_status', $request->status);
            }

            $payments = $query->get();

            // Format response
            $formattedData = $payments->map(function ($payment) {
                return [
                    'invoice_no' => $payment->invoice_no,
                    'user_name' => $payment->userContract->user->name ?? 'N/A',
                    'room_number' => $payment->userContract->room->room_number ?? 'N/A',
                    'room_price' => $payment->room_price,
                    'total_amount' => $payment->total_amount,
                    'amount_paid' => $payment->amount,
                    'total_due_amount' => $payment->total_due_amount,
                    'payment_status' => $payment->payment_status,
                    'payment_date' => $payment->payment_date,
                    'type' => $payment->type,
                ];
            });
            $totalPayment = $payments->sum('total_amount');
            $amountPaid = $payments->sum('amount');
            $totalDueAmount = $payments->sum('total_due_amount');

            return response()->json([
                'data' => $formattedData,
                'total_payment' => $totalPayment,
                'amount_paid' => $amountPaid,
                'total_due_amount' => $totalDueAmount,
            ]);
        }

        $rooms = Room::all();
        return view('backends.reports.payment_report', compact('rooms'));
    }

}
