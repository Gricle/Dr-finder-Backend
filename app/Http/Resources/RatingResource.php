<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rateable_id' => $this->rateable_id,
            'rateable_type' => $this->rateable_type,
            'score' => $this->score,
            'tourist_id' => $this->tourist_id,
        ];
    }
}