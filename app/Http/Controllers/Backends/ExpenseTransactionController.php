<?php

namespace App\Http\Controllers\Backends;

use DB;
use Carbon\Carbon;
use App\Models\Payment;
use App\Http\Requests\Request;
use App\Models\ExpenseCategory;
use App\Models\ExpenseTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreExpenseTransactionRequest;
use App\Http\Requests\UpdateExpenseTransactionRequest;

class ExpenseTransactionController extends Controller
{
    public function dashboard()
    {
        if (!auth()->user()->can('dashboard expense')) {
            abort(403, 'Unauthorized action.');
        }

        $totalAmount = Payment::sum('total_amount');
        $totalUtilityAmount = Payment::sum('total_utility_amount');
        $totalIncome = $totalAmount + $totalUtilityAmount;

        $totalExpense = ExpenseTransaction::sum('amount');
        $balance = $totalIncome - $totalExpense;

        $recentTransactions = ExpenseTransaction::latest()->take(5)->get();

        $expensesByCategory = ExpenseTransaction::selectRaw('SUM(amount) as total, category_id')
            ->groupBy('category_id')
            ->with('category')
            ->get();

        $chartLabels = $expensesByCategory->map(fn($expense) => $expense->category->title ?? 'Uncategorized');
        $chartValues = $expensesByCategory->pluck('total');

        $monthlyRoomData = Payment::selectRaw('MONTH(payment_date) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyUtilityData = Payment::selectRaw('MONTH(payment_date) as month, SUM(total_utility_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = $monthlyRoomData->pluck('month')->map(fn($m) => date('F', mktime(0, 0, 0, $m, 1)));

        $monthlyRoomValues = $monthlyRoomData->pluck('total');
        $monthlyUtilityValues = $monthlyUtilityData->pluck('total');

        return view('backends.expense_transaction.dashboard', compact(
            'totalIncome',
            'balance',
            'totalExpense',
            'recentTransactions',
            'chartLabels',
            'chartValues',
            'months',
            'monthlyRoomValues',
            'monthlyUtilityValues'
        ));
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ExpenseTransaction::with('category');

            if ($request->has('category_id') && $request->category_id) {
                $query->where('category_id', $request->category_id);
            }
            if ($request->has('date') && $request->date) {
                $query->whereDate('date', $request->date);
            }
            $lastMonthDate = Carbon::now()->startOfMonth()->subMonth();
            $lastMonth = $lastMonthDate->format('m');
            if ($request->has('date_range') && $request->date_range) {
                $dateRange = $request->date_range;

                switch ($dateRange) {
                    case 'today':
                        $query->whereDate('date', today());
                        break;
                    case 'this_week':
                        $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case 'this_month':
                        $query->whereMonth('date', now()->month);
                        break;
                    case 'last_month':
                        $query->whereMonth('date', $lastMonth);
                        break;
                    case 'this_year':
                        $query->whereYear('date', now()->year);
                        break;
                    case 'last_year':
                        $query->whereYear('date', now()->subYear()->year);
                        break;
                    default:
                        break;
                }
            }

            if ($request->has('from_date') && $request->from_date && $request->has('to_date') && $request->to_date) {
                $query->whereBetween('date', [$request->from_date, $request->to_date]);
            }

            $expenseTransactions = $query->get();

            return response()->json([
                'expenseTransactions' => $expenseTransactions
            ]);
        }

        $expenseCategories = ExpenseCategory::all();
        $expenseTransactions = ExpenseTransaction::all();
        return view('backends.expense_transaction.index', compact('expenseCategories', 'expenseTransactions'));
    }


    public function store(StoreExpenseTransactionRequest $request)
    {
        ExpenseTransaction::create($request->validated());

        Session::flash('success', __('Transaction added successfully.'));

        return redirect()->route('expense_transactions.index');
    }

    public function edit($id)
    {
        $transaction = ExpenseTransaction::findOrFail($id);
        $expenseCategories = ExpenseCategory::all();

        return view('backends.expense_transaction.edit', compact('transaction', 'expenseCategories'));
    }

    public function update(UpdateExpenseTransactionRequest $request, $id)
    {
        $expenseTransaction = ExpenseTransaction::findOrFail($id);

        $expenseTransaction->update($request->validated());

        Session::flash('success', __('Transaction updated successfully.'));

        return redirect()->route('expense_transactions.index');
    }

    public function destroy($id)
    {
        try {
            $expenseTransaction = ExpenseTransaction::findOrFail($id);
            $expenseTransaction->delete();

            Session::flash('success', __('Transaction deleted successfully.'));
        } catch (\Exception $e) {
            Session::flash('error', __('Failed to delete transaction.'));
        }

        return redirect()->route('expense_transactions.index');
    }
}
