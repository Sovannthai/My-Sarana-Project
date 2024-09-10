<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUtilityRateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => 'required|in:Electricity,Water',
            'rateperunit' => 'required|numeric|min:0',
        ];
    }
}
