<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VisitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tourist_id' => $this->tourist_id,
            'doctor_id' => $this->doctor_id,
            'price' => $this->price,
            'visit_date' => $this->visit_date,

        ];
    }
}