<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Services\TokenService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected TokenService $tokenService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tokenService = app(TokenService::class);
    }


    /** @test */
    public function admin_can_view_users(): void
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
            ->getJson('/api/v1/admin/user-listing');

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_create_user(): void
    {
        $admin = User::factory()->create([
            'uuid' => Str::uuid(),
            'is_admin' => true,
            'email' => 'admin@buckhill.co.uk',
            'password' => Hash::make('admin'),
        ]);

        $token = $this->tokenService->generate(user: $admin);

        $params = [
            'first_name' => 'Philip',
            'last_name' => 'Example',
            'uuid' => Str::uuid(),
            'email' => 'example.assessment@mail.com',
            'password' => 'userpassword',
            'password_confirmation' => 'userpassword',
            'is_admin' => false,
            'avatar' => null,
            'address' => 'Accra, Ghana',
            'phone_number' => '+233263257625',
            'is_marketing' => false
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])
            ->postJson('/api/v1/admin/create', $params);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message'
            ]);
    }

    /** @test */
    public function admin_cannot_create_user_with_validation_errors(): void
    {
        $admin = User::factory()->create([
            'uuid' => Str::uuid(),
            'is_admin' => true,
            'email' => 'admin@buckhill.co.uk',
            'password' => Hash::make('admin'),
        ]);

        $token = $this->tokenService->generate(user: $admin);

        $params = [
            'first_name' => 'Philip',
            'last_name' => 'Example',
            'uuid' => Str::uuid(),
            'email' => 'example.assessment@mail.com',
            'is_admin' => false,
            'avatar' => null,
            'address' => 'Accra, Ghana',
            'phone_number' => '+233263257625',
            'is_marketing' => false
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])
            ->postJson('/api/v1/admin/create', $params);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message'
            ]);
    }
}
