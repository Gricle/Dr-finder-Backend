<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\Tourist;
use App\Models\Fly;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run()
    {
        Tourist::all()->each(function ($tourist) {
            Fly::all()->each(function ($fly) use ($tourist) {
                Ticket::factory()
                    ->count(1)
                    ->create([
                        'tourist_id' => $tourist->id,
                        'fly_id' => $fly->id,
                    ]);
            });
        });
    }
}