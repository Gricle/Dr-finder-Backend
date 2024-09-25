<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            HotelSeeder::class,
            DoctorSeeder::class,
            AirportSeeder::class,
            FlySeeder::class,
            RatingSeeder::class,
            RoomSeeder::class,
            TouristSeeder::class,            
            TicketSeeder::class,
            VisitSeeder::class,
        ]);
    }
}