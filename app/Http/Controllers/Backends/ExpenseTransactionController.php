<?php

namespace App\Http\Controllers\Backends;

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
    $totalTransactions = ExpenseTransaction::count();
    $totalCategories = ExpenseCategory::count();
    $totalExpense = ExpenseTransaction::sum('amount');
    $recentTransactions = ExpenseTransaction::latest()->take(5)->get();

    return view('backends.expense_transaction.dashboard', compact('totalTransactions', 'totalCategories', 'totalExpense', 'recentTransactions'));
}


    public function index()
    {
        $expenseTransactions = ExpenseTransaction::all();
        $expenseCategories = ExpenseCategory::all();

        return view('backends.expense_transaction.index', compact('expenseTransactions', 'expenseCategories'));
    }

    public function store(StoreExpenseTransactionRequest $request)
    {
        ExpenseTransaction::create($request->validated());

        Session::flash('success', __('Transaction added successfully.'));

        return redirect()->route('expense_transactions.index');
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
