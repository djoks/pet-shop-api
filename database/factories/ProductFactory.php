<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            '550e8400-e29b-41d4-a716-446655440010',
            '550e8400-e29b-41d4-a716-446655440020',
            '550e8400-e29b-41d4-a716-446655440030',
            '550e8400-e29b-41d4-a716-446655440040',
        ];

        return [
            'category_uuid' => $this->faker->randomElement($categories),
            'uuid' => $this->faker->unique()->uuid,
            'title' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'description' => $this->faker->text,
            'metadata' => [
                'image' => null,
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
