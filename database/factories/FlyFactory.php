<?php

namespace Database\Factories;

use App\Models\Fly;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlyFactory extends Factory
{
    protected $model = Fly::class;

    public function definition()
    {
        return [
            'origin' => $this->faker->city(),
            'destination' => $this->faker->city(),
            'description' => $this->faker->sentence(1),
            'takeoff_time' => $this->faker->dateTimeBetween('now', '+1 month'), 
            'land_time' => $this->faker->dateTimeBetween('+1 hour', '+2 months'),
            'seats' => $this->faker->numberBetween(2, 400),
            'price' => $this->faker->numberBetween(2, 30000), 
        ];
    }
}