<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $uuids = [
            '550e8400-e29b-41d4-a716-446655440010',
            '550e8400-e29b-41d4-a716-446655440011',
            '550e8400-e29b-41d4-a716-446655440012',
            '550e8400-e29b-41d4-a716-446655440013',
            '550e8400-e29b-41d4-a716-446655440014',
            '550e8400-e29b-41d4-a716-446655440015',
            '550e8400-e29b-41d4-a716-446655440016',
        ];

        $avatars = [
            '550e8400-e29b-41d4-a716-446655440000',
            '550e8400-e29b-41d4-a716-446655440001',
            '550e8400-e29b-41d4-a716-446655440003',
            '550e8400-e29b-41d4-a716-446655440004',
            '550e8400-e29b-41d4-a716-446655440005',
        ];

        for ($i = 0; $i < 7; $i++) {
            $userAttributes = [
                'uuid' => $uuids[$i],
            ];

            if ($i < 5) {
                $userAttributes['avatar'] = $avatars[$i];
            }

            if ($i == 5) {
                $userAttributes['email'] = 'admin@buckhill.co.uk';
                $userAttributes['password'] = Hash::make('admin');
                $userAttributes['is_admin'] = true;
            }

            if ($i == 6) {
                $userAttributes['is_marketing'] = true;
            }

            User::factory()->create($userAttributes);
        }
    }
}
