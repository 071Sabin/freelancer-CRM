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
                'line1' => '',
                'line2' => '',
                'city' => '',
                'state' => '',
                'postal_code' => '',
                'country' => ''
            ],
            'default_footer' => 'THIS IS SYSTEM GENERATED INVOICE.',
            // Optional fields (set to null by default, or use $this->faker to generate fake data)
            'company_name' => null,
            'company_email' => null,
            'company_phone' => null,
            'company_website' => null,
            'tax_id' => null,
        ];
    }
}
