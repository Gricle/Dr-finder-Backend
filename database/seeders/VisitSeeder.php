<?php

namespace Database\Seeders;

use App\Models\Visit;
use App\Models\Tourist;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
{
    public function run()
    {

        Tourist::all()->each(function ($tourist) {
            Doctor::all()->each(function ($doctor) use ($tourist) {
                Visit::factory()
                    ->count(1)
                    ->create([
                        'tourist_id' => $tourist->id,
                        'doctor_id' => $doctor->id,
                    ]);
            });
        });
    }
}