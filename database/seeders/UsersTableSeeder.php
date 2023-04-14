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
            'cbb08457-bd35-4594-bdf2-f4368d022f08',
            'fec544fe-35ac-4272-88d7-9b0dc7fd204a',
            'd14efe6d-dd01-4b28-990c-453442ca3621',
            'ba032b5a-1120-431e-8cc2-f9c4fe19e2cf',
            'de2a6af3-a1c3-43e9-86fa-7130ba125f36'
        ];

        $avatars = [
            '550e8400-e29b-41d4-a716-446655440000',
            '550e8400-e29b-41d4-a716-446655440001',
            '550e8400-e29b-41d4-a716-446655440003',
            '550e8400-e29b-41d4-a716-446655440004',
            '550e8400-e29b-41d4-a716-446655440005',
            '550e8400-e29b-41d4-a716-446655440000',
            '550e8400-e29b-41d4-a716-446655440001',
            '550e8400-e29b-41d4-a716-446655440003',
            '550e8400-e29b-41d4-a716-446655440004',
            '550e8400-e29b-41d4-a716-446655440005',
        ];

        for ($i = 0; $i < 12; $i++) {
            $userAttributes = [
                'uuid' => $uuids[$i],
            ];

            if ($i < 9) {
                $userAttributes['avatar'] = $avatars[$i];
            }

            if ($i == 10) {
                $userAttributes['email'] = 'admin@buckhill.co.uk';
                $userAttributes['password'] = Hash::make('admin');
                $userAttributes['is_admin'] = true;
            }

            if ($i == 611) {
                $userAttributes['is_marketing'] = true;
            }

            User::factory()->create($userAttributes);
        }
    }
}
