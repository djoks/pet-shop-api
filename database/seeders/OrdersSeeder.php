<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userUuids = [
            '550e8400-e29b-41d4-a716-446655440010',
            '550e8400-e29b-41d4-a716-446655440011',
            '550e8400-e29b-41d4-a716-446655440012',
            '550e8400-e29b-41d4-a716-446655440013',
            '550e8400-e29b-41d4-a716-446655440014',
        ];

        $paymentUuids = [
            '550e8400-e29b-41d4-a716-446655440050',
            '550e8400-e29b-41d4-a716-446655440051',
            '550e8400-e29b-41d4-a716-446655440052',
            '550e8400-e29b-41d4-a716-446655440053',
            '550e8400-e29b-41d4-a716-446655440054',
        ];

        $orderStatusUuids = [
            '8e1e93b3-fb9f-4538-a313-19d6c438280b',
            '477b708d-9b93-445c-ac3d-ee97e0d25004',
            '09c5c1e1-b461-489b-b593-106afd0c0274',
            '2609bdaa-cece-42b6-9b09-454fe386aa99',
            '1dbe17ca-6028-43f0-a20d-e32e005c5700',
        ];

        $productUuids = [
            '550e8400-e29b-41d4-a716-446655440005',
            '550e8400-e29b-41d4-a716-446655440006',
            '550e8400-e29b-41d4-a716-446655440007',
            '550e8400-e29b-41d4-a716-446655440008',
            '550e8400-e29b-41d4-a716-446655440009',
        ];

        for ($i = 0; $i < 5; $i++) {
            $orderAttributes = [
                'user_uuid' => $userUuids[$i],
                'order_status_uuid' => $orderStatusUuids[$i],
                'payment_uuid' => $paymentUuids[$i],
                'uuid' => '550e8400-e29b-41d4-a716-4466554400' . (60 + $i),
                'products' => json_encode([
                    [
                        'product' => $productUuids[$i],
                        'quantity' => random_int(1, 5),
                    ],
                ]),
            ];

            Order::factory()->create($orderAttributes);
        }
    }
}
