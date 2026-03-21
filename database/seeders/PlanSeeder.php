<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'dodo_price_id_monthly' => 'pdt_0NaqQxanGnYcfkqs3hDHt', // Replace with Dodo Product ID
                'dodo_price_id_yearly'  => 'pdt_0NaxtfAf3Al2N4XmjXftd',  // Replace with Dodo Product ID
                'price_monthly' => 19.99,
                'price_yearly'  => 190,
                'invoice_limit' => 6,
                'client_limit'  => 3,
                'has_whatsapp'  => false,
                'has_custom_branding' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'dodo_price_id_monthly' => 'pdt_0Nav8ku6tmy9FmwumGPa1',
                'dodo_price_id_yearly'  => 'pdt_0NaxtZWhtmHUQA4RkVZCw',
                'price_monthly' => 39.99,
                'price_yearly'  => 390,
                'invoice_limit' => -1, // -1 represents Unlimited
                'client_limit'  => -1,
                'has_whatsapp'  => true,
                'has_custom_branding' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Agency',
                'slug' => 'agency',
                'dodo_price_id_monthly' => 'pdt_0Nav90xRXLjG0N0Wq112n',
                'dodo_price_id_yearly'  => 'pdt_0NaxtVfDs0RlFu5WKHNLd',
                'price_monthly' => 59.99,
                'price_yearly'  => 590,
                'invoice_limit' => -1,
                'client_limit'  => -1,
                'has_whatsapp'  => true,
                'has_custom_branding' => true,
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            // Update if slug exists, otherwise create new
            Plan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
