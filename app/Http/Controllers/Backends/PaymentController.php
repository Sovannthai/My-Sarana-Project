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
        $payments = Payment::all();
        $contracts = UserContract::all();
        return view('backends.payment.index', compact('payments', 'contracts'));
    }

    public function getRoomPrice($contractId)
{
    $contract = UserContract::with([
        'room.roomPricing' => function ($query) {
            $query->latest()->first();
        },
        'room.amenities'
    ])->findOrFail($contractId);

    $basePrice = $contract->room->roomPricing->first()?->base_price ?? 0;

    $additionalPrice = $contract->room->amenities->sum('additional_price');

    $totalPrice = $basePrice + $additionalPrice;

    return response()->json([
        'price' => $totalPrice
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

        Session::flash('success', __('Payment updated successfully.'));
        return redirect()->route('payments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        try {
            $payment->delete();

            Session::flash('success', __('Payment deleted successfully.'));
        } catch (\Exception $e) {
            Session::flash('error', __('Failed to delete payment.'));
        }

        return redirect()->route('payments.index');
    }
}
