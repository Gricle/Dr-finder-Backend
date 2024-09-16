<?php

namespace App\Http\Requests\Fly;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFlyRequest extends FormRequest
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
            'origin' => 'string|min:2|max:60',
            'destination' => 'string|min:2|max:60',
            'description' => 'string|min:3|max:255',
            'takeoff_time' => 'date_format:Y-m-d H:i:s',
            'land_time' => 'date_format:Y-m-d H:i:s',
            'seats' => 'integer|min:3|max:100',
            'price' => 'integer|min:3|max:10',

        ];
    }
}
