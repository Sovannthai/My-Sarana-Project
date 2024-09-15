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
            'utility_type_id' => 'required|exists:utility_types,id',
            'rate_per_unit' => 'required|numeric|min:0',
        ];
    }
}
