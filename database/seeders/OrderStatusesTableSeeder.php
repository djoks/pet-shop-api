<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::insert([
            [
                'uuid' => '8e1e93b3-fb9f-4538-a313-19d6c438280b',
                'title' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '477b708d-9b93-445c-ac3d-ee97e0d25004',
                'title' => 'Processing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '09c5c1e1-b461-489b-b593-106afd0c0274',
                'title' => 'Shipped',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '2609bdaa-cece-42b6-9b09-454fe386aa99',
                'title' => 'Delivered',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '1dbe17ca-6028-43f0-a20d-e32e005c5700',
                'title' => 'Cancelled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '5f5364cb-03f5-479c-9092-8e05b6e47d49',
                'title' => 'Returned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => '3342ee5e-6816-44f2-b31e-62ba8973f334',
                'title' => 'Refunded',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
