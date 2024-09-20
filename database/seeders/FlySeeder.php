<?php

namespace Database\Seeders;

use App\Models\Airport;
use App\Models\Fly;
use Illuminate\Database\Seeder;

class FlySeeder extends Seeder
{
    public function run()
    {
        Airport::all()->each(function ($airport) {
            Fly::factory()
                ->count(1)
                ->create(['airport_id' => $airport->id]);
        });
    }
}