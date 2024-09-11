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
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer',
            'waterusage' => 'nullable|numeric|min:0',
            'electricityusage' => 'nullable|numeric|min:0',
        ];
    }
}
