<?php

namespace Database\Factories;

use App\Models\Visit;
use App\Models\Tourist;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class VisitFactory extends Factory
{
    protected $model = Visit::class;

    public function definition()
    {
        return [
            'tourist_id' => Tourist::factory(),
            'doctor_id' => Doctor::factory(),
            'visit_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'price' => $this->faker->numberBetween(50, 500),
        ];
    }
}