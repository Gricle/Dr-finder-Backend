<?php

namespace Database\Factories;

use App\Models\Rating;
use App\Models\Doctor;
use App\Models\Hotel;
use App\Models\Airport;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    protected $model = Rating::class;

    public function definition()
    {
        $rateableType = $this->faker->randomElement([
            Doctor::class,
            Hotel::class,
            Airport::class,
        ]);

        return [
            'score' => $this->faker->numberBetween(1, 10),
            'rateable_id' => $this->getRandomRateableId($rateableType),
            'rateable_type' => $rateableType,
        ];
    }

    private function getRandomRateableId($rateableType)
    {

        return $rateableType::inRandomOrder()->first()->id ?? null;
    }
}