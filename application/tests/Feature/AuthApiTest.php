<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Victor',
            'email' => 'victor@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['token', 'user' => ['id', 'name', 'email']]);
    }

    /** @test */
    public function user_can_login_and_logout()
    {
        $user = User::factory()->create([
            'password' => bcrypt('secret123')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'secret123',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['token']);

        $token = $response->json('token');

        $logoutResponse = $this->withHeader('Authorization', "Bearer $token")
                               ->postJson('/api/logout');

        $logoutResponse->assertStatus(200);
    }

    /** @test */
    public function unauthorized_user_cannot_access_protected_routes()
    {
        $response = $this->getJson('/api/user');
        $response->assertStatus(401);
    }
}
