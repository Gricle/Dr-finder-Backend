<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersCanRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testTouristCanRegister()
    {
        $response = $this->postJson('/api/tourists', [
        
            "email" => "john1.d111o1e@example.com",
            "password" => "password123",
            "password_confirmation" => "password123",
            "first_name" => "John",
            "last_name" => "Doe",
            "national_code" => "1123567890",
            "number" => "123456789",
            "birth_date" => "1990-01-01"
            
        ]);
    
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'john1.d111o1e@example.com',
        ]);
        $this->assertDatabaseHas('tourists', [
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);
    }

    public function testDoctorCanRegister()
    {
        $response = $this->postJson('/api/doctors', [
            'email' => '411111@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'first_name' => 'Jaffar',
            'last_name' => 'Doe',
            'description' => 'Example description',
            'latitude' => '40.73',
            'longitude' => '-73.93',
            'expertise' => 'Medicine',
            'address' => '123 Example Street, New York, NY 10001',
            'visit_price' => 100,
        ]);
    
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => '411111@gmail.com',
        ]);
        $this->assertDatabaseHas('doctors', [
            'first_name' => 'Jaffar',
            'last_name' => 'Doe',
            'description' => 'Example description',
            'latitude' => '40.73',
            'longitude' => '-73.93',
            'expertise' => 'Medicine',
            'address' => '123 Example Street, New York, NY 10001',
            'visit_price' => 100,
        ]);
    }

    public function testHotelCanRegister()
    {
        $response = $this->postJson('/api/hotels', [
            'email' => 'hotel@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'name' => 'Luxury Hotel',
            'stars' => '5',
            'description' => 'A luxurious hotel experience.',
            'latitude' => '40.73',
            'longitude' => '-73.93',
            'address' => '123 Example Street, New York, NY 10001',
        ]);
    
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'hotel@example.com',
        ]);
        $this->assertDatabaseHas('hotels', [
            'name' => 'Luxury Hotel',
            'stars' => '5',
            'description' => 'A luxurious hotel experience.',
            'latitude' => '40.73',
            'longitude' => '-73.93',
            'address' => '123 Example Street, New York, NY 10001',
        ]);
    }
}