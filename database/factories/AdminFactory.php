<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class AdminFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'email' => 'meyti.ms2@gmail.com',
            'password' => Hash::make('SerpeghisReal!1'),
            'is_admin' => true
        ];
    }
}