<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'string|min:3|max:40',
            'last_name' => 'string|min:3|max:40',
            'description' => 'required|string|min:10|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'expertise' => 'string|max:255',
            'address' => 'string|max:255',
            'email' => 'string|max:255',
            'password' => 'min:8|max:50',
        ];
    }
}