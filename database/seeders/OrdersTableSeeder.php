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
            '550e8400-e29b-41d4-a716-446655440015',
            '550e8400-e29b-41d4-a716-446655440016',
            'cbb08457-bd35-4594-bdf2-f4368d022f08',
            'fec544fe-35ac-4272-88d7-9b0dc7fd204a',
            'd14efe6d-dd01-4b28-990c-453442ca3621',
            'ba032b5a-1120-431e-8cc2-f9c4fe19e2cf',
            'de2a6af3-a1c3-43e9-86fa-7130ba125f36'
        ];

        $paymentUuids = [
            '550e8400-e29b-41d4-a716-446655440050',
            '550e8400-e29b-41d4-a716-446655440051',
            '550e8400-e29b-41d4-a716-446655440052',
            '550e8400-e29b-41d4-a716-446655440053',
            '550e8400-e29b-41d4-a716-446655440054',
            '807553a0-f003-4c41-a2ca-8d882b2132c0 ',
            '89274b3e-e5a4-4eca-b0c0-66e24c3d84ef ',
            '865f2586-4d74-42e9-ac33-be1b566280c9',
            'b0cba274-0ccb-4867-82d3-3db9d45e50f9 ',
            '87296827-b61c-4d33-893f-ac003863473b ',
            '21536716-811b-43b8-98cb-bf79d8f43cea ',
            '0b8f517e-bc84-4b77-a2da-5fe465f63f01 ',
            'a8cf3bd5-0039-4f3a-9b52-a1f25214438a ',
            '90aec9fc-80b1-4feb-854d-a0010bb90746 ',
            'c9980157-f2ad-4d91-86ec-d8a7469f5957 ',
            '7b24c846-846a-49c3-9738-1ede0109f477 ',
            'd2f2e062-93fd-4bcb-895b-fd7d7a15b64f ',
            'bccc4bc0-203c-467f-b0f3-fb46cf889dae ',
            '618150e0-9d62-426a-ac5e-92964f146a47 ',
            '0a88af15-1492-4b1b-bdd6-83657ddfe65e ',
            '36e0f44d-4540-4158-9e39-9f26ab925e20 ',
            '44cd64bc-0e19-4153-8f3d-bf9a8e8a8560 ',
            'ff685af6-e40f-4b0f-9029-a4f93716b696 ',
            'da45c2ea-c228-4a9f-a6af-740cc5d123ca ',
            'ffcd58fd-eda3-4134-a0b9-6b886df51b2c ',
            '966d88fe-11b0-4498-bb33-f3c456b6d37a ',
            'aeaf2e83-366e-475f-ae0f-7ac07bc16ef3 ',
            'a9bff7c3-2859-4f3f-bcc4-4fe4415b2931 ',
            '930d3173-f974-4a14-bd60-4cd228365010 ',
            'c9bb9c50-0f4c-469c-a43a-ef5301d30532 ',
            '9db14fdb-f8c7-496f-b47d-e6ee93b51b01 ',
            'ddd58799-190e-4372-a3c9-29d2ee8b2163 ',
            'f9d15b1a-9418-4ee8-bb85-c39eec089252 ',
            'cdc76995-7167-4fd6-a059-6b68212d7aed ',
            '2816d249-6932-4db7-bc1f-760152ce37c9 ',
            '34238347-a555-4f22-bbfe-fd4a74573743 ',
            '6c06f96a-9c06-4e39-839d-cd9a2d015325 ',
            'eb99075b-134a-47e7-8172-9ae2475183c3 ',
            '1595fc87-0862-4117-8663-96aeb0891842 ',
            '9d29fe89-4764-4f34-8c93-46b5a9b7d3ee ',
            'f8f42d8e-32e2-4370-9b22-b026b5be599a ',
            '847c8344-ba34-4ab6-b39d-dae74d999f4f ',
            'e53d94b4-6454-492d-83d6-8b4537bff698 ',
            'c88f3645-848d-4c41-8a50-aa5d834308a0 ',
            '2920ee04-a0a5-4628-969e-e01275b1d5f5',
            '7a1864ea-5592-410c-b0d7-917d0d2b3556 ',
            '24924630-0289-4f51-99f1-918a6f1fea99 ',
            'fe9d1c16-39d5-4225-9175-beb223bcb785 ',
            '3cbb1f2f-9560-4ac9-97ef-f4e7830cdc01',
            'bffbf6b1-54b2-4afd-8558-9c326b77d36e',
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

        for ($i = 0; $i < 50; $i++) {
            $shippedAtStatus = '09c5c1e1-b461-489b-b593-106afd0c0274';

            $orderAttributes = [
                'user_uuid' => $userUuids[array_rand($userUuids)],
                'order_status_uuid' => $orderStatusUuids[array_rand($orderStatusUuids)],
                'payment_uuid' => $paymentUuids[$i],
                'uuid' => '550e8400-e29b-41d4-a716-4466554400' . (60 + $i),
                'products' => json_encode([
                    [
                        'product' => $productUuids[array_rand($productUuids)],
                        'quantity' => random_int(1, 5),
                    ],
                ]),
                'shipped_at' => $shippedAtStatus === '09c5c1e1-b461-489b-b593-106afd0c0274' ? now() : null,
            ];

            Order::factory()->create($orderAttributes);
        }
    }
}
