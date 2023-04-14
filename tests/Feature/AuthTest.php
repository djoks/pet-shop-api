<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Services\TokenService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected TokenService $tokenService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tokenService = app(TokenService::class);
    }

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
            'is_admin' => true,
            'email' => 'admin@buckhill.co.uk',
            'password' => Hash::make('admin'),
        ]);

        $response = $this->postJson('/api/v1/admin/login', [
            'email' => $admin->email,
            'password' => 'notadmin',
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

    /** @test */
    public function admin_can_logout()
    {
        $admin = User::factory()->create([
            'uuid' => Str::uuid(),
            'is_admin' => true,
            'email' => 'admin@buckhill.co.uk',
            'password' => Hash::make('admin'),
        ]);

        $token = $this->tokenService->generate(user: $admin);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])
            ->getJson('/api/v1/admin/logout');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message'
            ]);
    }

    /** @test */
    public function user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'uuid' => Str::uuid(),
            'is_admin' => false
        ]);

        $response = $this->postJson('/api/v1/user/login', [
            'email' => $user->email,
            'password' => 'userpassword'
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
    public function user_cannot_login_with_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'uuid' => Str::uuid(),
            'is_admin' => false,
        ]);

        $response = $this->postJson('/api/v1/user/login', [
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message'
            ]);
    }

    /** @test */
    public function user_cannot_login_with_missing_credentials(): void
    {
        $response = $this->postJson('/api/v1/user/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }

    /** @test */
    public function user_can_logout()
    {
        $user = User::factory()->create([
            'uuid' => Str::uuid(),
            'is_admin' => false
        ]);

        $token = $this->tokenService->generate(user: $user);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])
            ->getJson('/api/v1/user/logout');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message'
            ]);
    }
}
