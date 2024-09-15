<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tourist_id' => 'sometimes|exists:tourists,id',
            'room_id' => 'sometimes|exists:rooms,id',
            'check_in' => 'sometimes|date',
            'check_out' => 'sometimes|date|after:check_in',
        ];
    }
}