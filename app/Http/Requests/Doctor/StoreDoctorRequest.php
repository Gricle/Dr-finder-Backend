<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|min:3|max:40',
            'last_name' => 'required|string|min:3|max:40',
            'description' => 'required|string|min:10|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'expertise' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|min:8|max:50',
        ];
    }
}