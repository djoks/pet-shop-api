<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'delivery_fee' => $this->faker->randomFloat(2, 1, 10),
            'amount' => $this->faker->randomFloat(2, 50, 1000),
            'address' => json_encode([
                'billing' => $this->faker->address,
                'shipping' => $this->faker->address
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
