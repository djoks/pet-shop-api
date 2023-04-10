<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $uuids = [
            '550e8400-e29b-41d4-a716-446655440050',
            '550e8400-e29b-41d4-a716-446655440051',
            '550e8400-e29b-41d4-a716-446655440052',
            '550e8400-e29b-41d4-a716-446655440053',
            '550e8400-e29b-41d4-a716-446655440054'
        ];

        for ($i = 0; $i < 5; $i++) {
            Payment::factory()->create([
                'uuid' => $uuids[$i],
            ]);
        }
    }
}
