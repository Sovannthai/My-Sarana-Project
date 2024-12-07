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

    public function getUtilityAmount($contractId)
    {
        $contract = UserContract::with([
            'room.monthlyUsages.details.utilityType.utilityrates'
        ])->findOrFail($contractId);

        $monthlyUsages = $contract->room->monthlyUsages;

        if (!$monthlyUsages || $monthlyUsages->isEmpty()) {
            return response()->json([
                'price' => 0,
                'message' => 'No monthly usage details found.'
            ]);
        }

        $monthlyUsageDetails = $monthlyUsages->flatMap(function ($usage) {
            return $usage->details;
        });

        if ($monthlyUsageDetails->isEmpty()) {
            return response()->json([
                'price' => 0,
                'message' => 'No monthly usage details found.'
            ]);
        }

        $totalUtilityPrice = $monthlyUsageDetails->reduce(function ($carry, $detail) {
            $activeRate = $detail->utilityType->utilityrates->where('status', '1')->first();

            if ($activeRate) {
                $ratePerUnit = $activeRate->rate_per_unit ?? 0;
                return $carry + ($detail->usage * $ratePerUnit);
            }

            return $carry;
        }, 0);

        return response()->json([
            'price' => $totalUtilityPrice
        ]);
    }

    public function getTotalAmount($contractId)
    {
        $contract = UserContract::with([
            'room.roomPricing' => function ($query) {
                $query->latest()->first();
            },
            'room.amenities',
            'room.monthlyUsages.details.utilityType.utilityrates'
        ])->findOrFail($contractId);

        $basePrice = $contract->room->roomPricing->first()?->base_price ?? 0;
        $additionalPrice = $contract->room->amenities->sum('additional_price');
        $roomPrice = $basePrice + $additionalPrice;

        $monthlyUsages = $contract->room->monthlyUsages;

        $utilityPrice = $monthlyUsages?->flatMap(fn($usage) => $usage->details)
            ->reduce(function ($carry, $detail) {
                $activeRate = $detail->utilityType->utilityrates->where('status', '1')->first();
                return $carry + (($detail->usage ?? 0) * ($activeRate?->rate_per_unit ?? 0));
            }, 0) ?? 0;

        $totalAmount = $roomPrice + $utilityPrice;

        return response()->json([
            'totalAmount' => $totalAmount,
            'roomPrice' => $roomPrice,
            'utilityPrice' => $utilityPrice
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
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
