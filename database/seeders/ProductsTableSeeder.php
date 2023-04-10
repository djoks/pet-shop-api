<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            '550e8400-e29b-41d4-a716-446655440005',
            '550e8400-e29b-41d4-a716-446655440006',
            '550e8400-e29b-41d4-a716-446655440007',
            '550e8400-e29b-41d4-a716-446655440008',
            '550e8400-e29b-41d4-a716-446655440009',
        ];

        $products = Product::factory(5)->create();

        for ($i = 0; $i < 5; $i++) {
            if ($products[$i] !== null) {
                $products[$i]->metadata = [
                    'image' => $images[$i],
                ];
                $products[$i]->save();
            }
        }
    }
}
