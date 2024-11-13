<?php

namespace App\Services;

use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Cache;

class CurrencyService
{
    protected $baseCurrency;
    protected $exchangeRates;

    public function __construct()
    {
        $businessSetting = BusinessSetting::first();
        $currencyData = json_decode($businessSetting->base_currency, true);
        $baseCurrency = collect($currencyData)->firstWhere('base_currencies', true);
        $this->baseCurrency = $baseCurrency['code'] ?? null;
        $this->exchangeRates = json_decode($businessSetting->exchange_rates, true);
    }

    public function getBaseCurrency()
    {
        return $this->baseCurrency;
    }
    /**
     * Get the exchange rate from one currency to another.
     *
     * @param string $from The currency to convert from.
     * @param string $to The currency to convert to.
     */

    public function getExchangeRate($from = 'USD', $to = 'KHR')
    {
        if ($this->baseCurrency === 'USD') {
            $rate = collect($this->exchangeRates)->first(function ($rate) use ($from, $to) {
                return $rate['from_currency'] === 'USD' && $rate['to_currency'] === 'KHR';
            });
        } else {
            $rate = collect($this->exchangeRates)->first(function ($rate) use ($from, $to) {
                return $rate['from_currency'] === 'KHR' && $rate['to_currency'] === 'USD';
            });
        }

        return $rate ? (float) $rate['rate'] : 1;
    }

    public function convertCurrency($amount, $from = 'USD', $to = 'KHR')
    {
        $exchangeRate = $this->getExchangeRate($from, $to);
        return $amount / $exchangeRate;
    }
}
