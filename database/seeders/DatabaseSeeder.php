<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceSetting;
use App\Models\Plan;
use App\Models\Project;
use App\Models\Subscription;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            CurrencySeeder::class,
            PlanSeeder::class,
        ]);

        $user = User::factory()->create([
            'name' => 'sabin',
            'email' => 'sabin@gmail.com',
            'password' => bcrypt('sabin123'),
        ]);

        // $user = User::factory()->create();

        // get a plan (or create default one if needed)
        $plan = Plan::first(); // or Plan::inRandomOrder()->first();

        $startDate = Carbon::now();
        $billingCycle = 'monthly';

        $endDate = $billingCycle === 'monthly'
            ? (clone $startDate)->addMonth()
            : (clone $startDate)->addYear();

        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,

            'dodo_subscription_id' => 'sub_' . Str::random(10),
            'dodo_customer_id' => 'cust_' . Str::random(10),

            'billing_cycle' => $billingCycle,
            'status' => 'active',
            'trial_ends_at' => now()->addDays(14),

            'current_period_start' => $startDate,
            'current_period_end' => $endDate,
        ]);

        $client = Client::factory()->create(['user_id' => $user->id]);
        $inSetting =InvoiceSetting::factory()->create(['user_id' => $user->id]);
        $chunkSize = 1000;
        $totalProjects = 230000;

        for ($i = 0; $i < $totalProjects / $chunkSize; $i++) {

            $projects = Project::factory()
                ->count($chunkSize)
                ->create([
                    'user_id' => $user->id,
                    'client_id' => $client->id
                ]);

            foreach ($projects as $project) {

                Task::factory()->create([
                    'project_id' => $project->id
                ]);

                Invoice::factory()->draft()->create([
                    'user_id' => $user->id,
                    'client_id' => $client->id,
                    'project_id' => $project->id,
                    'default_footer' => $inSetting->default_footer,
                    'client_snapshot' => [
                        'client_name' => $client->client_name,
                        'client_email' => $client->client_email,
                        'company_name' => $client->company_name,
                        'company_email'   => $client->company_email,
                        'company_phone'   => $client->company_phone,
                        'company_website' => $client->company_website,
                    ],
                    'company_snapshot' => [
                        'company_name' => $inSetting->company_name,
                        'company_email' => $inSetting->company_email,
                        'company_phone' => $inSetting->company_phone,
                        'company_website' => $inSetting->company_website,
                        'company_address' => $inSetting->company_address,
                        'tax_id' => $inSetting->tax_id,
                        'payment_methods' => $inSetting->payment_methods,
                        'bank_details' => $inSetting->bank_details,
                    ],
                    'billing_address' => $client->billing_address,
                    'company_address' => $client->company_address,
                ]);
            }

            unset($projects); // free memory
        }
    }
}
