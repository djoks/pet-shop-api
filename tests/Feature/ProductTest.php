<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function all_users_can_view_products(): void
    {
        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'uuid',
                        'title',
                        'category',
                        'description',
                        'price',
                        'metadata' => [
                            'image'
                        ]
                    ]
                ],
                'page',
                'limit',
                'total',
                'sort_by',
                'desc'
            ]);
    }
}
