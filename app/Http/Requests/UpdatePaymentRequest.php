<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_contract_id' => 'required|exists:user_contracts,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:all_paid,rent,utility,advance',
            'payment_date' => 'required|date',
            'month_paid' => 'required|integer|min:1|max:12',
            'year_paid' => 'nullable|integer|min:1900|max:' . date('Y'),
            'payment_status' => 'nullable'
        ];
    }
}
