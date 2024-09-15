<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomPricingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'room_id' => 'sometimes|exists:rooms,id',
            'base_price' => 'sometimes|numeric|min:0',
            'effective_date' => 'sometimes|date',
        ];
    }
}
