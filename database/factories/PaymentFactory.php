<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paymentTypes = [
            'credit_card',
            'cash_on_delivery',
            'bank_transfer',
        ];

        $type = $this->faker->randomElement($paymentTypes);

        switch ($type) {
            case 'credit_card':
                $details = [
                    'holder_name' => $this->faker->name,
                    'number' => $this->faker->creditCardNumber,
                    'ccv' => $this->faker->randomNumber(3),
                    'expire_date' => $this->faker->creditCardExpirationDateString,
                ];
                break;
            case 'cash_on_delivery':
                $details = [
                    'first_name' => $this->faker->firstName,
                    'last_name' => $this->faker->lastName,
                    'address' => $this->faker->address,
                ];
                break;
            case 'bank_transfer':
                $details = [
                    'swift' => $this->faker->swiftBicNumber,
                    'iban' => $this->faker->iban(null),
                    'name' => $this->faker->name,
                ];
                break;
            default:
                $details = [];
        }

        return [
            'uuid' => $this->faker->unique()->uuid,
            'type' => $type,
            'details' => $details,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
