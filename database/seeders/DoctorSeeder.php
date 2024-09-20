<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run()
    {
        User::factory()
            ->count(1)
            ->create()
            ->each(function ($user) {
                $user->doctor()->create(Doctor::factory()->make()->toArray());
            });
    }
}