<?php

namespace App\Http\Controllers;

use App\Models\ExpenseTransaction;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
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
    public function index()
    {
        $total_renters = User::whereHas('roles', function ($q) {
            $q->where('id', 8);
        })->count();
        $total_rooms = Room::count();
        $total_avilable_rooms = Room::where('status', 'available')->count();
        $total_occupied_rooms = Room::where('status', 'occupied')->count();
        $total_maintenance_rooms = Room::where('status', 'maintenance')->count();
        $room_income_amount = Payment::sum('total_amount');
        $total_utility_amount = Payment::sum('total_utility_amount');
        $total_due_amount = Payment::sum('total_due_amount');
        $total_expenses = ExpenseTransaction::sum('amount');

        $currentYear = date('Y');
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
