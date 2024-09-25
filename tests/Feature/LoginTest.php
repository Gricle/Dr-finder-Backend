<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testUserCanLoginSuccessfully()
    {  
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('token', $response->json());
        $this->assertAuthenticatedAs($user);
    }

    public function testUserCannotLoginWithInvalidCredentials()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ]);
    
        $response->assertStatus(401);
        $response->assertJson([
            'status' => false,
            'message' => 'Invalid credentials'
        ]);
    }
}