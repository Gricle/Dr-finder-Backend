<?php

namespace Database\Factories;

use App\Models\Tourist;
use Illuminate\Database\Eloquent\Factories\Factory;

class TouristFactory extends Factory
{
    protected $model = Tourist::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'national_code' => $this->faker->numerify('#########'),
            'number' => $this->faker->numberBetween(100000,10000000),
            'birth_date' => $this->faker->date(),
        ];
    }
}