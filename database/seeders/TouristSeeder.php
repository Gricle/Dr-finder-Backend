<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tourist;
use Illuminate\Database\Seeder;

class TouristSeeder extends Seeder
{
    public function run()
    {

        User::factory()
            ->count(50)
            ->create()
            ->each(function ($user) {
                Tourist::factory()->create(['user_id' => $user->id]);
            });
    }
}