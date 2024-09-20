<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run()
    {
        Hotel::all()->each(function ($hotel) {
            Room::factory()
                ->count(2)
                ->create(['hotel_id' => $hotel->id]);
        });
    }
}