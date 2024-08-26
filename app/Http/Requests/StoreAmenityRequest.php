<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAmenityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Change to true if authorization is handled elsewhere
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // Ensure you are not setting any default values here
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100|unique:amenities,name',
            'description' => 'nullable|string',
            'additional_price' => 'required|numeric|min:0',
        ];
    }


    /**
     * Customize the error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 100 characters.',
            'description.string' => 'The description must be a string.',
            'additional_price.required' => 'The additional price field is required.',
            'additional_price.numeric' => 'The additional price must be a number.',
            'additional_price.min' => 'The additional price must be at least 0.',
        ];
    }
}
