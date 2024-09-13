<?php

namespace App\Http\Requests\Tourist;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTouristRequest extends FormRequest
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
    public function rules()
    {
        return [
            'first_name' => 'string|min:3|max:40',
            'last_name' => 'string|min:3|max:40',
            'national_code' => 'integer|min:5|max:20',
            'number' => 'integer|min:5|max:15',
            'birth_date' => 'date',
            'email' => 'string|max:255',
            'password' => 'min:8|max:50',
        ];
    }
}