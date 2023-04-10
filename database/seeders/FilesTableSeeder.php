<?php

namespace Database\Seeders;

use App\Models\File;
use Illuminate\Database\Seeder;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        File::insert([
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440000',
                'name' => '1.jpeg',
                'path' => 'storage/images/avatars/1.jpeg',
                'size' => 5120,
                'type' => 'image/jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440001',
                'name' => '2.jpeg',
                'path' => 'storage/images/avatars/2.jpeg',
                'size' => 5120,
                'type' => 'image/jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440002',
                'name' => '3.jpeg',
                'path' => 'storage/images/avatars/3.jpeg',
                'size' => 6144,
                'type' => 'image/jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440003',
                'name' => '4.jpeg',
                'path' => 'storage/images/avatars/4.jpeg',
                'size' => 4096,
                'type' => 'image/jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440004',
                'name' => '5.jpeg',
                'path' => 'storage/images/avatars/5.jpeg',
                'size' => 5120,
                'type' => 'image/jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440005',
                'name' => '1.png',
                'path' => 'storage/images/products/1.png',
                'size' => 736128,
                'type' => 'image/png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440006',
                'name' => '2.png',
                'path' => 'storage/images/products/2.png',
                'size' => 76800,
                'type' => 'image/png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440007',
                'name' => '3.png',
                'path' => 'storage/images/products/3.png',
                'size' => 51200,
                'type' => 'image/png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440008',
                'name' => '4.png',
                'path' => 'storage/images/products/4.png',
                'size' => 99216,
                'type' => 'image/png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440009',
                'name' => '5.png',
                'path' => 'storage/images/products/5.png',
                'size' => 78816,
                'type' => 'image/png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
