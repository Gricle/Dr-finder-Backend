<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

     public function run()
     {
         User::factory()
             ->count(1) 
             ->has(Hotel::factory()->count(1))
             ->create();
     }

}