<?php

namespace App\Http\Requests\Fly;

use Illuminate\Foundation\Http\FormRequest;

class StoreFlyRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'takeoff_time' => 'required|date|after_or_equal:now',
            'land_time' => 'required|date|after:takeoff_time',
            'seats' => 'required|integer|min:2|max:400',
            'price' => 'required|numeric|min:2|max:30000'
        ];
    }

}