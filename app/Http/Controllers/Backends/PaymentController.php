<?php

namespace App\Http\Controllers\Backends;

use Exception;
use Carbon\Carbon;
use App\Models\Amenity;
use App\Models\Payment;
use App\Models\UtilityRate;
use App\Models\MonthlyUsage;
use App\Models\UserContract;
use App\Http\Requests\Request;
use App\Models\PaymentAmenity;
use App\Models\PaymentUtility;
use App\Models\PriceAdjustment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::orderByDesc('created_at')->get();
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
        $room_price_befor_discount = $contract->room->roomPricing->first()?->base_price ?? 0;
        $basePrice = $contract->room->roomPricing->first()?->base_price ?? 0;
        $amenityIds = DB::table('room_amenity')
            ->whereIn('room_id', [$contract->room_id])
            ->pluck('amenity_id')
            ->toArray();
        $amenity_prices = Amenity::whereIn('id', $amenityIds)->sum('additional_price');
        $amenities = Amenity::whereIn('id', $amenityIds)->get(['id', 'name', 'additional_price']);
        // dd($amenities);
        $discount = PriceAdjustment::where('room_id', $contract->room_id)->where('status', 'active')->first();
        if (@$discount->discount_type == 'amount') {
            $basePrice = $basePrice - $discount->discount_value;
        } elseif (@$discount->discount_type == 'percentage') {
            $basePrice = $basePrice - ($basePrice * $discount->discount_value / 100);
        } else {
            $basePrice;
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
        // dd($basePrice);

        return response()->json([
            'price' => $totalRoomPrice,
            'discount' => $discount,
            'amenities' => $amenities,
            'amenity_prices' => $amenity_prices,
            'utilityUsage' => $utilityUsage,
            'totalCost' => $totalCost,
            'utilityRates' => $utilityRates,
            'room_price' => $room_price_befor_discount,
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
        if (@$discount->discount_type == 'amount') {
            $basePrice = $basePrice - $discount->discount_value;
        } elseif (@$discount->discount_type == 'percentage') {
            $basePrice = $basePrice - ($basePrice * $discount->discount_value / 100);
        } else {
            $basePrice;
        }
        $totalPrice = $basePrice + $amenity_prices;

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
    public function create()
    {
        $payments = Payment::orderBy('id', 'desc')->get();
        $contracts = UserContract::all();
        return view('backends.payment.create', compact('payments', 'contracts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Store payment data
            // dd($request->all());
            $contractId = $request->input('user_contract_id');
            $currentDate = Carbon::now();
            $existingPayment = Payment::where('user_contract_id', $contractId)
                ->whereYear('payment_date', $currentDate->year)
                ->whereMonth('payment_date', $currentDate->month)
                ->first();

            if ($existingPayment) {
                Session::flash('error', __('This contract has already been created in this month.'));
                return redirect()->back();
            }
            $total_amount = $request->input('total_amount');
            $total_paid = $request->input('amount');
            if ($request->input('advance_payment_amount')) {
                dd($request->all());
                $total_due = 0;
                $total_amount = $request->input('advance_payment_amount');
            } else {
                $total_due = max(0, $total_amount - $total_paid);
                $total_amount = $request->input('total_amount');
            }
            $status = '';
            $status = in_array($request->input('type'), ['rent', 'utility']) ? 'partial' : 'completed';
            $payment = Payment::create([
                'room_price' => $request->room_price,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_discount' => $request->discount_value,
                'discount_type' => $request->discount_type,
                'total_amount_amenity' => $request->total_amount_amenity,
                'total_utility_amount' => $request->total_utility_amount,
                'user_contract_id' => $request->user_contract_id,
                'amount' => $request->amount ?? $request->input('advance_payment_amount'),
                'type' => $request->type,
                'payment_date' => $request->payment_date,
                'month_paid' => $request->month_paid,
                'year_paid' => $request->year_paid,
                'payment_status' => $status,
                'total_amount' => $total_amount,
                'total_due_amount' => $total_due,
            ]);
            // Check amenity
            if ($request->has('amenity_ids')) {
                $amenityIds = $request->input('amenity_ids');
                $amenityPrices = $request->input('amenity_prices');

                foreach ($amenityIds as $index => $amenityId) {
                    PaymentAmenity::create([
                        'payment_id' => $payment->id,
                        'amenity_id' => $amenityId,
                        'amenity_price' => $amenityPrices[$index],
                    ]);
                }
            }
            // Check Utility
            if ($request->has('utility_ids')) {
                $utilityIds = $request->input('utility_ids');
                $utilityUsages = $request->input('utility_usages');
                $utilityRates = $request->input('utility_rates');
                $utilityTotals = $request->input('utility_totals');

                foreach ($utilityIds as $index => $utilityId) {
                    PaymentUtility::create([
                        'payment_id' => $payment->id,
                        'utility_id' => $utilityId,
                        'usage' => $utilityUsages[$index],
                        'rate_per_unit' => str_replace('$', '', trim($utilityRates[$index])),
                        'total_amount' => str_replace('$', '', trim($utilityTotals[$index])),
                        'month_paid' => $payment->month_paid,
                        'year_paid' => $payment->year_paid,
                    ]);
                }
            }
            Session::flash('success', __('Payment added successfully.'));
            return redirect()->route('payments.index');
        } catch (Exception $e) {
            dd($e);
            Session::flash('error', __('Failed to add payment.'));
            return redirect()->route('payments.index');
        }
    }

    public function createUitilityPayment($id)
    {
        $payment = Payment::findOrFail($id);
        $contract = UserContract::where('room_id', $payment->userContract->room_id)->first();
        return view('backends.payment.partial.payment_utility', compact('payment', 'contract'));
    }
    public function advanceUtilityPayment($id)
    {
        $month_paid = request()->input('month_paid');
        $contract = UserContract::with([
            'room.roomPricing' => function ($query) {
                $query->latest()->first();
            },
            'room.amenities'
        ])->findOrFail($id);
        $utility = MonthlyUsage::where('room_id', $contract->room_id)->where('month', $month_paid)->latest()->first();
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

        return response()->json([
            'utility_usage' => $utilityUsage,
            'total_cost' => $totalCost,
            'utilityRates' => $utilityRates,
        ]);
    }
    public function storeAdvanceUtilityPayment(Request $request)
    {
        try {
            $payment_id = $request->input('payment_id');
            $month_paid = $request->input('month_paid');
            $year_paid = $request->input('year_paid');
            $utilityIds = $request->input('utility_ids');
            $utilityUsages = $request->input('utility_usages');
            $utilityRates = $request->input('utility_rates');
            $utilityTotals = $request->input('utility_totals');

            foreach ($utilityIds as $index => $utilityId) {
                $exists = PaymentUtility::where('payment_id', $payment_id)
                ->where('utility_id', $utilityId)
                ->where('month_paid', $month_paid)
                ->where('year_paid', $year_paid)
                ->exists();
                if ($exists) {
                    Session::flash('error', __('The utility payment of this month is paid already.'));
                    return redirect()->back();
                }
                PaymentUtility::create([
                    'payment_id' => $payment_id,
                    'utility_id' => $utilityId,
                    'usage' => $utilityUsages[$index],
                    'rate_per_unit' => $utilityRates[$index],
                    'total_amount' => $utilityTotals[$index],
                    'month_paid' => $month_paid,
                    'year_paid' => $year_paid,
                ]);
            }
            Session::flash('success', __('Utility payment added successfully.'));
            return redirect()->route('payments.index');
        } catch (Exception $e) {
            dd($e);
            Session::flash('error', __('Something went wrong'));
            return redirect()->route('payments.index');
        }
    }
    public function deleteUtilityAdvancePayment($id)
    {
        try {
            $paymentUtility = PaymentUtility::where('payment_id', $id);

            if (!$paymentUtility->exists()) {
                return response()->json(['status' => 'error', 'message' => 'Payment not found'], 404);
            }
            $paymentUtility->delete();
            return response()->json(['status' => 'success', 'message' => 'Utility payment deleted successfully.']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again.'], 500);
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
            if ($request->input('payment_status') === 'partial') {
                $befor_paid_amount = $request->input('befor_paid_amount');
                $total_amount_paid = $request->input('total_amount_paid');
                $paid_due_amount = $request->input('paid_due_amount');
                $update_due_amount = $befor_paid_amount + $paid_due_amount;
                $last_due_amount = $total_amount_paid - $update_due_amount;
                if ($update_due_amount == $total_amount_paid) {
                    $status = 'completed';
                    $type = 'all_paid';
                } else {
                    $status = 'partial';
                    $type = $request->input('type');
                }
                $payment->update([
                    'amount' => $update_due_amount,
                    'total_due_amount' => $last_due_amount,
                    'payment_status' => $status,
                    'type' => $type,
                ]);
            } else {
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
            }

            Session::flash('success', __('Payment updated successfully.'));
            return redirect()->route('payments.index');
        } catch (Exception $e) {
            dd($e);
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
            $payment->paymentamenities()->delete();
            $payment->paymentutilities()->delete();
            $payment->delete();

            Session::flash('success', __('Payment deleted successfully.'));
        } catch (Exception $e) {
            Session::flash('error', __('Failed to delete payment.'));
        }

        return redirect()->route('payments.index');
    }
}
