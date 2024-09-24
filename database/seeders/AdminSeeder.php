<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'email' => 'meyti.ms2@gmail.com',
            'password' => Hash::make('SerpeghisReal!1'),
            'is_admin' => true,
        ]);
    }
}