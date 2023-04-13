<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_login_with_valid_credentials(): void
    {
        $admin = User::factory()->create([
            'uuid' => Str::uuid(),
            'is_admin' => true,
            'email' => 'admin@buckhill.co.uk',
            'password' => Hash::make('admin'),
        ]);

        $response = $this->postJson('/api/v1/admin/login', [
            'email' => $admin->email,
            'password' => 'admin'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'token',
                    'name',
                    'email',
                    'phone_number',
                    'address',
                    'marketing_preferences',
                    'avatar'
                ]
            ]);
    }

    /** @test */
    public function admin_cannot_login_with_invalid_credentials(): void
    {
        $admin = User::factory()->create([
            'uuid' => Str::uuid(),
            'password' => Hash::make('admin')
        ]);

        $response = $this->postJson('/api/v1/admin/login', [
            'email' => $admin->email,
            'password' => $admin->password,
        ]);

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message'
            ]);
    }

    /** @test */
    public function admin_cannot_login_with_missing_credentials(): void
    {
        $response = $this->postJson('/api/v1/admin/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }
}
