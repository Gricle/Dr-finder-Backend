<?php

namespace App\Http\Requests\Visit;

use Illuminate\Foundation\Http\FormRequest;

class StoreVisitRequest extends FormRequest
{
    public function authorize()
    {
        
        return true;
    }

    public function rules()
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',
            'visit_date' => 'required|date',
        ];
    }
}