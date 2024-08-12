<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Allow all users to update a room for now. Modify if needed.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'room_number' => 'required|string',
            'description' => 'nullable|string',
            'size' => 'nullable|string',
            'floor' => 'nullable|integer',
            'status' => 'nullable|string|in:available,occupied,maintenance',
        ];
    }
}
