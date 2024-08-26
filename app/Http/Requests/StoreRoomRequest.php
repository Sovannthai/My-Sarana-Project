<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
            'room_number' => 'required|string|max:10',
            'description' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:50',
            'floor' => 'nullable|integer|min:1',
            'status' => 'nullable|string|in:available,occupied,maintenance',
        ];
    }

    /**
     * Get custom validation messages for attributes.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'room_number.required' => 'The room number is required.',
            'room_number.string' => 'The room number must be a string.',
            'room_number.max' => 'The room number may not be greater than 10 characters.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 255 characters.',
            'size.string' => 'The size must be a string.',
            'size.max' => 'The size may not be greater than 50 characters.',
            'floor.integer' => 'The floor must be an integer.',
            'floor.min' => 'The floor must be at least 1.',
            'status.string' => 'The status must be a string.',
            'status.in' => 'The status must be one of the following: available, occupied, maintenance.',
        ];
    }
}
