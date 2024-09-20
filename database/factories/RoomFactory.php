<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition()
    {
        return [
            'beds' => $this->faker->numberBetween(1, 9),
            'description' => $this->faker->sentence(3, true),
            'price' => $this->faker->numberBetween(50, 500),
        ];
    }
}