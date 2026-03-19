<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     * Update this to CurrenciesFactory::class if you kept your old naming convention!
     */
    protected $model = Currency::class;

    public function definition(): array
    {
        $currencies = [
            ['code' => 'USD', 'symbol' => '$', 'name' => 'US Dollar', 'precision' => 2],
            ['code' => 'NPR', 'symbol' => 'रु', 'name' => 'Nepalese Rupee', 'precision' => 2],
            ['code' => 'EUR', 'symbol' => '€', 'name' => 'Euro', 'precision' => 2],
            ['code' => 'GBP', 'symbol' => '£', 'name' => 'British Pound', 'precision' => 2],
            ['code' => 'JPY', 'symbol' => '¥', 'name' => 'Japanese Yen', 'precision' => 0],
            ['code' => 'CHF', 'symbol' => 'CHF', 'name' => 'Swiss Franc', 'precision' => 2],
            ['code' => 'CAD', 'symbol' => '$', 'name' => 'Canadian Dollar', 'precision' => 2],
            ['code' => 'AUD', 'symbol' => '$', 'name' => 'Australian Dollar', 'precision' => 2],
            ['code' => 'CNY', 'symbol' => '¥', 'name' => 'Chinese Yuan', 'precision' => 2],
            ['code' => 'INR', 'symbol' => '₹', 'name' => 'Indian Rupee', 'precision' => 2],
            ['code' => 'AED', 'symbol' => 'د.إ', 'name' => 'UAE Dirham', 'precision' => 2],
            ['code' => 'SGD', 'symbol' => '$', 'name' => 'Singapore Dollar', 'precision' => 2],
            ['code' => 'BRL', 'symbol' => 'R$', 'name' => 'Brazilian Real', 'precision' => 2],
            ['code' => 'ZAR', 'symbol' => 'R', 'name' => 'South African Rand', 'precision' => 2],
            ['code' => 'RUB', 'symbol' => '₽', 'name' => 'Russian Ruble', 'precision' => 2],
            ['code' => 'KRW', 'symbol' => '₩', 'name' => 'South Korean Won', 'precision' => 0],
            ['code' => 'MXN', 'symbol' => '$', 'name' => 'Mexican Peso', 'precision' => 2],
            ['code' => 'NZD', 'symbol' => '$', 'name' => 'New Zealand Dollar', 'precision' => 2],
            ['code' => 'SAR', 'symbol' => 'ر.س', 'name' => 'Saudi Riyal', 'precision' => 2],
            ['code' => 'TRY', 'symbol' => '₺', 'name' => 'Turkish Lira', 'precision' => 2],
        ];

        // Grab a unique, random currency array from the list above
        $currency = $this->faker->unique()->randomElement($currencies);

        // Map the array to the model's database columns
        return [
            'code'      => $currency['code'],
            'symbol'    => $currency['symbol'],
            'name'      => $currency['name'],
            'precision' => $currency['precision'],
        ];
    }

    /**
     * Optional: A state to quickly force USD when testing specific currency formatting
     */
    public function usd(): static
    {
        return $this->state(fn (array $attributes) => [
            'code'      => 'USD',
            'symbol'    => '$',
            'name'      => 'US Dollar',
            'precision' => 2,
        ]);
    }
}
