<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\Tourist;
use App\Models\Fly;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        return [
            'tourist_id' => Tourist::factory(), 
            'fly_id' => Fly::factory(),
            'seat_number' => $this->faker->unique()->numberBetween(1, 100),
        ];
    }
}