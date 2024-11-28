<?php

namespace App\Http\Controllers\Backends;

use App\Models\Payment;
use App\Models\UserContract;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all payments
        $payments = Payment::all();
        $contracts = UserContract::all();
        return view('backends.payment.index', compact('payments', 'contracts'));
    }

    public function getRoomPrice($contractId)
{
    $contract = UserContract::with(['room.roomPricing' => function ($query) {
        $query->latest()->first();
    }])->findOrFail($contractId);

    $price = $contract->room->roomPricing->first()?->base_price ?? 0;

    return response()->json([
        'price' => $price
    ]);
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        // Store payment data
        Payment::create([
            'user_contract_id' => $request->user_contract_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'payment_date' => $request->payment_date,
            'month_paid' => $request->month_paid,
            'year_paid' => $request->year_paid,
        ]);

        // Flash success message and redirect
        Session::flash('success', __('Payment added successfully.'));
        return redirect()->route('payments.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        // Update payment data
        $payment->update([
            'user_contract_id' => $request->user_contract_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'payment_date' => $request->payment_date,
            'month_paid' => $request->month_paid,
            'year_paid' => $request->year_paid,
        ]);

        // Flash success message and redirect
        Session::flash('success', __('Payment updated successfully.'));
        return redirect()->route('payments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        try {
            // Delete payment record
            $payment->delete();

            // Flash success message
            Session::flash('success', __('Payment deleted successfully.'));
        } catch (\Exception $e) {
            // Flash error message in case of failure
            Session::flash('error', __('Failed to delete payment.'));
        }

        return redirect()->route('payments.index');
    }
}
