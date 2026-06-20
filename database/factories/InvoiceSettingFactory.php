<?php

namespace Database\Factories;

use App\Models\InvoiceSetting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends Factory<InvoiceSetting>
 */
class InvoiceSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = InvoiceSetting::class;
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'prefix' => 'INV',
            'next_number' => 1,
            'default_currency' => 1,
            'number_format' => '{PREFIX}{NUMBER}',
            'locale' => 'en',
            'timezone' => 'UTC',
            'company_address' => [
                'line1' => $this->faker->streetAddress(),
                'line2' => $this->faker->secondaryAddress(),
                'city' => $this->faker->city(),
                'state' => $this->faker->state(),
                'postal_code' => $this->faker->postcode(),
                'country' => $this->faker->country()
            ],
            'default_footer' => 'THIS IS SYSTEM GENERATED INVOICE.',
            // Optional fields (set to null by default, or use $this->faker to generate fake data)
            'company_name' => $this->faker->company(),
            'company_email' => $this->faker->safeEmail(),
            'company_phone' => $this->faker->phoneNumber(),
            'company_website' => $this->faker->url(),
            'tax_id' => $this->faker->numerify('#########'),
        ];
    }
}
