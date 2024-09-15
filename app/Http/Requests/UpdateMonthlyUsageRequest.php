<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMonthlyUsageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'room_id' => 'required|exists:rooms,id',
            'utility_type_id' => 'required|exists:utility_types,id',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:1900|max:2100',
            'usage' => 'required|numeric|min:0',
        ];
    }
}
