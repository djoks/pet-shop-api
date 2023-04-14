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
            ->getJson('/api/v1/admin/user-listing', [
                'email' => $admin->email,
                'password' => 'admin'
            ]);

        $response->assertStatus(200);
    }
}
