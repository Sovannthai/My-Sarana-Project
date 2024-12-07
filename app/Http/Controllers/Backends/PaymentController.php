<?php

namespace App\Http\Controllers\Backends;

use Exception;
use App\Models\Amenity;
use App\Models\Payment;
use App\Models\UtilityRate;
use App\Models\MonthlyUsage;
use App\Models\UserContract;
use App\Models\PriceAdjustment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
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
    public function getTotalRoomPrice($id)
    {
        $contract = UserContract::with([
            'room.roomPricing' => function ($query) {
                $query->latest()->first();
            },
            'room.amenities'
        ])->findOrFail($id);

        $basePrice = $contract->room->roomPricing->first()?->base_price ?? 0;
        $amenityIds = DB::table('room_amenity')
            ->whereIn('room_id', [$contract->room_id])
            ->pluck('amenity_id')
            ->toArray();
        $amenity_prices = Amenity::whereIn('id', $amenityIds)->sum('additional_price');
        $discount = PriceAdjustment::where('room_id', $contract->room_id)->where('status', 'active')->first();
        if ($discount->discount_type == 'amount') {
            $basePrice = $basePrice - $discount->discount_value;
        } else {
            $basePrice = $basePrice - ($basePrice * $discount->discount_value / 100);
        }
        $utility = MonthlyUsage::whereIn('room_id', [$contract->room_id])->latest()->first();
        $utilityUsage = [];
        $totalCost = 0;

        if ($utility) {
            foreach ($utility->utilityTypes as $type) {
                $utilityUsage[] = [
                    'utility_type_id' => $type->id,
                    'utility_type' => $type->type,
                    'usage' => $type->pivot->usage,
                ];
            }
        } else {
            $utilityUsage[] = ['message' => 'not found'];
        }
        $utilityRates = UtilityRate::where('status', 1)->get();
        foreach ($utilityUsage as $usageData) {
            if (isset($usageData['utility_type_id'])) {
                $rate = $utilityRates->firstWhere('utility_type_id', $usageData['utility_type_id']);
                if ($rate) {
                    $totalCost += $usageData['usage'] * $rate->rate_per_unit;
                }
            }
        }
        $totalPrice = $basePrice + $amenity_prices;
        $totalRoomPrice = $totalCost + $totalPrice;

        return response()->json([
            'price' => $totalRoomPrice
        ]);
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
        $amenityIds = DB::table('room_amenity')
            ->whereIn('room_id', [$contract->room_id])
            ->pluck('amenity_id')
            ->toArray();
        $amenity_prices = Amenity::whereIn('id', $amenityIds)->sum('additional_price');
        $discount = PriceAdjustment::where('room_id', $contract->room_id)->where('status', 'active')->first();
        if ($discount->discount_type == 'amount') {
            $basePrice = $basePrice - $discount->discount_value;
        } else {
            $basePrice = $basePrice - ($basePrice * $discount->discount_value / 100);
        }
        $totalPrice = $basePrice + $amenity_prices;

        return response()->json([
            'price' => $totalPrice
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Store payment data
            $total_amount = request()->input('total_amount');
            $total_paid = request()->input('amount');
            if ($total_amount == $total_paid) {
                $total_due = 0;
            } else {
                $total_due = $total_amount - $total_paid;
            }
            Payment::create([
                'user_contract_id' => $request->user_contract_id,
                'amount' => $request->amount,
                'type' => $request->type,
                'payment_date' => $request->payment_date,
                'month_paid' => $request->month_paid,
                'year_paid' => $request->year_paid,
                'payment_status' => $request->payment_status,
                'total_amount' => $total_amount,
                'total_due_amount' => $total_due,
            ]);
            Session::flash('success', __('Payment added successfully.'));
            return redirect()->route('payments.index');
        } catch (Exception $e) {
            dd($e);
            Session::flash('error', __('Failed to add payment.'));
            return redirect()->route('payments.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $payment = Payment::findOrFail($id);
            $total_amount = $request->input('total_amount');
            $total_paid = $request->input('amount');

            if ($total_amount == $total_paid) {
                $total_due = 0;
            } else {
                $total_due = $total_amount - $total_paid;
            }

            $payment->update([
                'user_contract_id' => $request->user_contract_id,
                'amount' => $request->amount,
                'type' => $request->type,
                'payment_date' => $request->payment_date,
                'month_paid' => $request->month_paid,
                'year_paid' => $request->year_paid,
                'payment_status' => $request->payment_status,
                'total_amount' => $total_amount,
                'total_due_amount' => $total_due,
            ]);

            Session::flash('success', __('Payment updated successfully.'));
            return redirect()->route('payments.index');
        } catch (Exception $e) {
            Session::flash('error', __('Failed to update payment.'));
            return redirect()->route('payments.index');
        }
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
