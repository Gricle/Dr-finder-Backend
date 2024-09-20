<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'description' => $this->faker->paragraph(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'expertise' => $this->faker->word(),
            'address' => $this->faker->address(),
            'visit_price' => $this->faker->numberBetween(50, 200),
        ];
    }
}