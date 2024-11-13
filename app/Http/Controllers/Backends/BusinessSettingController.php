<?php

namespace App\Http\Controllers\Backends;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class BusinessSettingController extends Controller
{
    public function index()
    {
        $business_setting = BusinessSetting::first();
        $exchangeRates = json_decode($business_setting->exchange_rates, true);
        $base_currencies = json_decode($business_setting->base_currency, true);
        return view('backends.business_setting.index', compact('business_setting', 'exchangeRates', 'base_currencies'));
    }
    public function update(Request $request)
    {
        try {
            $business_setting = BusinessSetting::firstOrNew();
            $old_logo_path = $business_setting->business_logo;
            $old_logo_path = $business_setting->web_logo;
            $baseCurrencyCode = $request->input('base_currency');

            if ($request->hasFile('business_logo')) {
                $business_logo = $request->file('business_logo');
                $extension = $business_logo->getClientOriginalExtension();
                $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $extension;
                $business_logo->move(public_path('uploads/all_photo/'), $imageName);

                if ($old_logo_path && File::exists(public_path('uploads/all_photo/' . $old_logo_path))) {
                    File::delete(public_path('uploads/all_photo/' . $old_logo_path));
                }

                $business_setting->business_logo = $imageName;
            }
            if ($request->hasFile('web_logo')) {
                $web_logo = $request->file('web_logo');
                $extension = $web_logo->getClientOriginalExtension();
                $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $extension;
                $web_logo->move(public_path('uploads/all_photo/'), $imageName);

                if ($old_logo_path && File::exists(public_path('uploads/all_photo/' . $old_logo_path))) {
                    File::delete(public_path('uploads/all_photo/' . $old_logo_path));
                }

                $business_setting->web_logo = $imageName;
            }
            $currencyData = [
                [
                    "id" => 1,
                    "name" => 'USD',
                    "symbol" => '$',
                    "code" => "USD",
                    "base_currencies" => $baseCurrencyCode === 'USD'
                ],
                [
                    "id" => 2,
                    "name" => 'Khmer Riel',
                    "symbol" => '៛',
                    "code" => "KHR",
                    "base_currencies" => $baseCurrencyCode === 'KHR'
                ]
            ];
            $exchange_rates = [
                [
                    "from_currency" => "USD",
                    "to_currency"   => "KHR",
                    // 'rate'       => @$request->input('usd_to_khr')
                    'rate'          => '1'
                ],
                [
                    "from_currency" => "KHR",
                    "to_currency"   => "USD",
                    // 'rate'       => @$request->input('khr_to_usd')
                    'rate'          => '4000'
                ]
            ];
            $currencyData = json_decode($business_setting->base_currency, true);

            foreach ($currencyData as &$currency) {
                if ($currency['code'] === $baseCurrencyCode) {
                    $currency['base_currencies'] = true;
                } else {
                    $currency['base_currencies'] = false;
                }
            }
            $business_setting->base_currency = json_encode($currencyData);
            $business_setting->exchange_rates = json_encode($exchange_rates);

            $business_setting->save();

            $output = [
                'success' => ('Setting Updated Successfully')
            ];
        } catch (Exception $e) {
            dd($e);
            $output = [
                'error' => ('Something went wrong')
            ];
        }

        return redirect()->route('business_setting.index')->with($output);
    }
}
