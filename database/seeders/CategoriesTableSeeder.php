<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440010',
                'title' => 'Toys',
                'slug' => 'toys',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440020',
                'title' => 'Grooming',
                'slug' => 'grooming',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440030',
                'title' => 'Leashes',
                'slug' => 'leashes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440040',
                'title' => 'Food',
                'slug' => 'food',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
