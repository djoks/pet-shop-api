<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Str;
use App\Services\TokenService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected TokenService $tokenService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tokenService = app(TokenService::class);
    }

    /** @test */
    public function admin_can_view_orders(): void
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
        ])->getJson('/api/v1/orders');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'uuid',
                        'customer',
                        'status',
                        'products',
                        'amount',
                        'delivery_fee'
                    ]
                ],
                'page',
                'limit',
                'total',
                'sort_by',
                'desc'
            ]);
    }

    /** @test */
    public function admin_can_update_order_status(): void
    {
        $admin = User::factory()->create([
            'uuid' => Str::uuid(),
            'is_admin' => true,
            'email' => 'admin@buckhill.co.uk',
            'password' => Hash::make('admin'),
        ]);

        $token = $this->tokenService->generate(user: $admin);

        $status = OrderStatus::create([
            'uuid' => Str::uuid(),
            'title' => 'Test'
        ]);

        $order = Order::create([
            'uuid' => Str::uuid(),
            'payment_uuid' => Str::uuid(),
            'user_uuid' => $admin->uuid,
            'order_status_uuid' => $status->uuid,
            'amount' => 100,
            'delivery_fee' => 10,
            'products' => [],
            'address' => []
        ]);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->patchJson("/api/v1/order/$order->uuid", [
            'order_status_uuid' => $status->uuid
        ]);

        $response->assertStatus(200);
    }
}
