<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Airport;
use Illuminate\Database\Seeder;

class AirportSeeder extends Seeder
{
    public function run()
    {
   
        User::factory()
            ->count(1) 
            ->create()
            ->each(function ($user) {
                $user->airport()->create(Airport::factory()->make()->toArray());
            });
    }
}