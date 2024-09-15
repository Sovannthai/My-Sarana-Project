<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePriceAdjustmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'room_id' => 'required|exists:rooms,id',
            'amount' => 'required|numeric|min:0',
            'reason' => 'nullable|string',
            'startdate' => 'required|date',
            'enddate' => 'nullable|date|after_or_equal:startdate',
        ];
    }
}
