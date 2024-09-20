<?php

namespace Database\Seeders;

use App\Models\Tourist;
use App\Models\Rating;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    public function run()
    {
        Tourist::all()->each(function ($tourist) {
            Rating::factory()
                ->count(1)
                ->create(['tourist_id' => $tourist->id]);
        });
    }
}