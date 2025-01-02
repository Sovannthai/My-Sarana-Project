<?php

namespace App\Http\Controllers;

use App\Models\ExpenseTransaction;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'this_year');
        $currentYear = date('Y');
        $currentMonth = date('m');
        $lastMonthDate = Carbon::now()->startOfMonth()->subMonth();
        $lastMonth = $lastMonthDate->format('m');
        $lastMonthYear = $lastMonthDate->format('Y');

        if ($filter === 'this_month') {
            $room_income_amount = Payment::whereYear('payment_date', $currentYear)
                ->whereMonth('payment_date', $currentMonth)
                ->sum('total_amount');
            $total_utility_amount = Payment::whereYear('payment_date', $currentYear)
                ->whereMonth('payment_date', $currentMonth)
                ->sum('total_utility_amount');
            $total_due_amount = Payment::whereYear('payment_date', $currentYear)
                ->whereMonth('payment_date', $currentMonth)
                ->sum('total_due_amount');
            $total_expenses = ExpenseTransaction::whereYear('date', $currentYear)
                ->whereMonth('date', $currentMonth)
                ->sum('amount');
        } elseif ($filter === 'last_month') {
            // dd(1);
            $room_income_amount = Payment::whereYear('payment_date', $lastMonthYear)
                ->whereMonth('payment_date', $lastMonth)
                ->sum('total_amount');
            $total_utility_amount = Payment::whereYear('payment_date', $lastMonthYear)
                ->whereMonth('payment_date', $lastMonth)
                ->sum('total_utility_amount');
            $total_due_amount = Payment::whereYear('payment_date', $lastMonthYear)
                ->whereMonth('payment_date', $lastMonth)
                ->sum('total_due_amount');
            $total_expenses = ExpenseTransaction::whereYear('date', $lastMonthYear)
                ->whereMonth('date', $lastMonth)
                ->sum('amount');
        } else {
            $room_income_amount = Payment::whereYear('payment_date', $currentYear)->sum('total_amount');
            $total_utility_amount = Payment::whereYear('payment_date', $currentYear)->sum('total_utility_amount');
            $total_due_amount = Payment::whereYear('payment_date', $currentYear)->sum('total_due_amount');
            $total_expenses = ExpenseTransaction::whereYear('date', $currentYear)->sum('amount');
        }

        $total_renters = User::whereHas('roles', function ($q) {
            $q->where('id', 8);
        })->count();
        $total_rooms = Room::count();
        $total_avilable_rooms = Room::where('status', 'available')->count();
        $total_occupied_rooms = Room::where('status', 'occupied')->count();
        $total_maintenance_rooms = Room::where('status', 'maintenance')->count();

        $totalAmounts = Payment::selectRaw('MONTH(payment_date) as month, SUM(total_amount) as total')
            ->whereYear('payment_date', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $monthlyTotals = array_fill(1, 12, 0);
        foreach ($totalAmounts as $month => $total) {
            $monthlyTotals[$month] = $total;
        }

        return view(
            'backends.index',
            compact(
                'total_rooms',
                'total_renters',
                'total_avilable_rooms',
                'total_occupied_rooms',
                'total_maintenance_rooms',
                'room_income_amount',
                'total_utility_amount',
                'monthlyTotals',
                'total_expenses',
                'total_due_amount'
            )
        );
    }

}
