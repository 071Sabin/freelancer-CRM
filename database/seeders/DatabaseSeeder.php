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
    // public function run(): void
    // {

    //     $this->call([
    //         CurrencySeeder::class,
    //         PlanSeeder::class,
    //     ]);

    //     $user = User::factory()->create([
    //         'name' => 'sabin',
    //         'email' => 'sabin@gmail.com',
    //         'password' => bcrypt('sabin123'),
    //     ]);

    //     // $user = User::factory()->create();

    //     // get a plan (or create default one if needed)
    //     $plan = Plan::first(); // or Plan::inRandomOrder()->first();

    //     $startDate = Carbon::now();
    //     $billingCycle = 'monthly';

    //     $endDate = $billingCycle === 'monthly'
    //         ? (clone $startDate)->addMonth()
    //         : (clone $startDate)->addYear();

    //     Subscription::create([
    //         'user_id' => $user->id,
    //         'plan_id' => $plan->id,

    //         'dodo_subscription_id' => 'sub_' . Str::random(10),
    //         'dodo_customer_id' => 'cust_' . Str::random(10),

    //         'billing_cycle' => $billingCycle,
    //         'status' => 'active',
    //         'trial_ends_at' => now()->addDays(14),

    //         'current_period_start' => $startDate,
    //         'current_period_end' => $endDate,
    //     ]);

    //     $client = Client::factory()->create(['user_id' => $user->id]);
    //     $inSetting =InvoiceSetting::factory()->create(['user_id' => $user->id]);
    //     $chunkSize = 10;
    //     $totalProjects = 20;

    //     for ($i = 0; $i < $totalProjects / $chunkSize; $i++) {

    //         $projects = Project::factory()
    //             ->count($chunkSize)
    //             ->create([
    //                 'user_id' => $user->id,
    //                 'client_id' => $client->id
    //             ]);

    //         foreach ($projects as $project) {

    //             Task::factory()->create([
    //                 'project_id' => $project->id
    //             ]);

    //             Invoice::factory()->draft()->create([
    //                 'user_id' => $user->id,
    //                 'client_id' => $client->id,
    //                 'project_id' => $project->id,
    //                 'default_footer' => $inSetting->default_footer,
    //                 'client_snapshot' => [
    //                     'client_name' => $client->client_name,
    //                     'client_email' => $client->client_email,
    //                     'company_name' => $client->company_name,
    //                     'company_email'   => $client->company_email,
    //                     'company_phone'   => $client->company_phone,
    //                     'company_website' => $client->company_website,
    //                 ],
    //                 'company_snapshot' => [
    //                     'company_name' => $inSetting->company_name,
    //                     'company_email' => $inSetting->company_email,
    //                     'company_phone' => $inSetting->company_phone,
    //                     'company_website' => $inSetting->company_website,
    //                     'company_address' => $inSetting->company_address,
    //                     'tax_id' => $inSetting->tax_id,
    //                     'payment_methods' => $inSetting->payment_methods,
    //                     'bank_details' => $inSetting->bank_details,
    //                 ],
    //                 'billing_address' => $client->billing_address,
    //                 'company_address' => $client->company_address,
    //             ]);
    //         }

    //         unset($projects); // free memory
    //     }
    // }


    public function run(): void
    {
        // 1. Performance environment setup
        DB::connection()->disableQueryLog();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('clients')->truncate();
        DB::table('projects')->truncate();
        DB::table('tasks')->truncate();
        DB::table('invoices')->truncate();

        $this->call([CurrencySeeder::class, PlanSeeder::class]);

        // Create base owner
        $userId = DB::table('users')->insertGetId([
            'name' => 'sabin',
            'email' => 'sabin@gmail.com',
            'password' => bcrypt('sabin123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $now = now()->toDateTimeString();
        $total = 1000000;
        $chunkSize = 2000;

        // Pre-set snapshots to avoid repeating logic in loop
        $emptyJson = json_encode([]);
        $this->command->info("Seeding 1M records: Blazing Fast Mode...");

        for ($i = 0; $i < ($total / $chunkSize); $i++) {
            $clientsBatch = [];
            $projectsBatch = [];
            $tasksBatch = [];
            $invoicesBatch = [];

            $startId = ($i * $chunkSize) + 1;

            for ($j = 0; $j < $chunkSize; $j++) {
                $cId = $startId + $j;

                // 1. Client Array
                $clientsBatch[] = [
                    'id' => $cId,
                    'user_id' => $userId,
                    'client_name' => "Client $cId",
                    'client_email' => "client$cId@example.com",
                    'company_name' => "Company $cId",
                    'billing_address' => "Address $cId",
                    'hourly_rate' => '50.00',
                    'currency_id' => 1,
                    'status' => 'active',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                // 2. Project Array
                $projectsBatch[] = [
                    'id' => $cId,
                    'uuid' => (string) Str::uuid(),
                    'user_id' => $userId,
                    'client_id' => $cId,
                    'name' => "Project $cId",
                    'status' => 'active',
                    'value' => 100.00,
                    'currency_id' => 1,
                    'hourly_rate' => 50.00,
                    'deadline' => Carbon::now()->addDays(30),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                // 3. Task Array
                $tasksBatch[] = [
                    'project_id' => $cId,
                    'title' => "Task for $cId",
                    'is_completed' => false,
                    'position' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                // 4. Invoice Array (Handling all unique constraints)
                $invoicesBatch[] = [
                    'uuid' => (string) Str::uuid(),
                    'user_id' => $userId,
                    'client_id' => $cId,
                    'project_id' => $cId,
                    'invoice_number' => "INV-" . str_pad($cId, 8, '0', STR_PAD_LEFT),
                    'type' => 'invoice',
                    'invoice_status' => 'draft',
                    'public_token' => Str::random(40) . $cId, // Guaranteed unique 64-char string
                    'issue_date' => $now,
                    'due_date' => Carbon::now()->addDays(14),
                    'bill_currency_id' => 1,
                    'subtotal' => 100.00,
                    'total' => 100.00,
                    'balance_due' => 100.00,
                    'client_snapshot' => $emptyJson,
                    'company_snapshot' => $emptyJson,
                    'billing_address' => $emptyJson,
                    'company_address' => $emptyJson,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // High-speed Bulk Inserts
            DB::table('clients')->insert($clientsBatch);
            DB::table('projects')->insert($projectsBatch);
            DB::table('tasks')->insert($tasksBatch);
            DB::table('invoices')->insert($invoicesBatch);

            if ($i % 25 === 0) {
                $this->command->comment("Seeded " . ($i * $chunkSize + $chunkSize) . " / 1,000,000");
            }

            // Wipe memory for next chunk
            unset($clientsBatch, $projectsBatch, $tasksBatch, $invoicesBatch);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->command->info("1 Million Records Seeded in record time!");
    }
}
