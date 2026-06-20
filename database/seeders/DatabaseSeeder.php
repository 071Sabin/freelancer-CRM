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
        $chunkSize = 10;
        $totalProjects = 20;

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


    // public function run(): void
    // {

    //         $this->call([
    //             CurrencySeeder::class,
    //             PlanSeeder::class,
    //         ]);

    //     // 1. Performance environment setup
    //     DB::connection()->disableQueryLog();
    //     DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    //     DB::table('aggregate_stats')->truncate(); // Wipe the stats table too
    //     DB::table('clients')->truncate();
    //     DB::table('projects')->truncate();
    //     DB::table('tasks')->truncate();
    //     DB::table('invoices')->truncate();

    //     $this->call([CurrencySeeder::class, PlanSeeder::class]);

    //     // Create base owner
    //     $userId = DB::table('users')->insertGetId([
    //         'name' => 'sabin',
    //         'email' => 'sabin@gmail.com',
    //         'password' => bcrypt('sabin123'),
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);

    //     $total = 1000000;
    //     $chunkSize = 2000;
    //     $emptyJson = json_encode([]);

    //     // 🧠 PRO-TIP: Pre-calculate random pools outside the loop so PHP doesn't choke
    //     $clientStatuses = ['active', 'active', 'inactive']; // 66% chance of active
    //     $projectStatuses = ['active', 'in_progress', 'completed', 'cancelled'];
    //     $invoiceStatuses = ['draft', 'sent', 'paid', 'paid', 'overdue'];

    //     $datePool = [];
    //     for ($d = 0; $d < 300; $d++) {
    //         // Generate 300 random dates from the last 12 months
    //         $datePool[] = Carbon::now()->subDays(rand(1, 365))->toDateTimeString();
    //     }

    //     $this->command->info("Seeding 1M records with Randomized Data...");

    //     for ($i = 0; $i < ($total / $chunkSize); $i++) {
    //         $clientsBatch = [];
    //         $projectsBatch = [];
    //         $tasksBatch = [];
    //         $invoicesBatch = [];

    //         $startId = ($i * $chunkSize) + 1;

    //         for ($j = 0; $j < $chunkSize; $j++) {
    //             $cId = $startId + $j;

    //             // Pick random elements from our pools
    //             $randomDate = $datePool[array_rand($datePool)];
    //             $cStatus = $clientStatuses[array_rand($clientStatuses)];
    //             $pStatus = $projectStatuses[array_rand($projectStatuses)];
    //             $iStatus = $invoiceStatuses[array_rand($invoiceStatuses)];

    //             $clientsBatch[] = [
    //                 'id' => $cId,
    //                 'user_id' => $userId,
    //                 'client_name' => "Client $cId",
    //                 'client_email' => "client$cId@example.com",
    //                 'company_name' => "Company $cId",
    //                 'billing_address' => "Address $cId",
    //                 'hourly_rate' => '50.00',
    //                 'currency_id' => 1,
    //                 'status' => $cStatus,
    //                 'created_at' => $randomDate,
    //                 'updated_at' => $randomDate,
    //             ];

    //             $projectsBatch[] = [
    //                 'id' => $cId,
    //                 'uuid' => (string) Str::uuid(),
    //                 'user_id' => $userId,
    //                 'client_id' => $cId,
    //                 'name' => "Project $cId",
    //                 'status' => $pStatus,
    //                 'value' => rand(100, 5000), // Randomize money
    //                 'currency_id' => 1,
    //                 'hourly_rate' => 50.00,
    //                 'deadline' => Carbon::parse($randomDate)->addDays(rand(10, 60)),
    //                 'created_at' => $randomDate,
    //                 'updated_at' => $randomDate,
    //             ];

    //             $tasksBatch[] = [
    //                 'project_id' => $cId,
    //                 'title' => "Task for $cId",
    //                 'is_completed' => rand(0, 1),
    //                 'position' => 0,
    //                 'created_at' => $randomDate,
    //                 'updated_at' => $randomDate,
    //             ];

    //             $invoicesBatch[] = [
    //                 'uuid' => (string) Str::uuid(),
    //                 'user_id' => $userId,
    //                 'client_id' => $cId,
    //                 'project_id' => $cId,
    //                 'invoice_number' => "INV-" . str_pad($cId, 8, '0', STR_PAD_LEFT),
    //                 'type' => 'invoice',
    //                 'invoice_status' => $iStatus,
    //                 'public_token' => Str::random(40) . $cId,
    //                 'issue_date' => $randomDate,
    //                 'due_date' => Carbon::parse($randomDate)->addDays(14),
    //                 'bill_currency_id' => 1,
    //                 'subtotal' => 100.00,
    //                 'total' => 100.00,
    //                 'balance_due' => ($iStatus === 'paid') ? 0 : 100.00,
    //                 'client_snapshot' => $emptyJson,
    //                 'company_snapshot' => $emptyJson,
    //                 'billing_address' => $emptyJson,
    //                 'company_address' => $emptyJson,
    //                 'created_at' => $randomDate,
    //                 'updated_at' => $randomDate,
    //             ];
    //         }

    //         DB::table('clients')->insert($clientsBatch);
    //         DB::table('projects')->insert($projectsBatch);
    //         DB::table('tasks')->insert($tasksBatch);
    //         DB::table('invoices')->insert($invoicesBatch);

    //         if ($i % 25 === 0) {
    //             $this->command->comment("Seeded " . ($i * $chunkSize + $chunkSize) . " / 1,000,000");
    //         }
    //     }

    //     // ⚡ THE ARCHITECT BACKFILL: Calculate all stats instantly via SQL
    //     $this->command->info("Recalculating Aggregate Stats...");
    //     $this->runStatsBackfill();

    //     DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    //     $this->command->info("1 Million Records & Stats Seeded!");
    // }

    // private function runStatsBackfill()
    // {
    //     // 1. Total Clients & Active Clients
    //     DB::statement("
    //         INSERT INTO aggregate_stats (user_id, `key`, value, created_at, updated_at)
    //         SELECT user_id, 'total_clients', COUNT(*), NOW(), NOW() FROM clients GROUP BY user_id
    //     ");
    //     DB::statement("
    //         INSERT INTO aggregate_stats (user_id, `key`, value, created_at, updated_at)
    //         SELECT user_id, 'active_clients', COUNT(*), NOW(), NOW() FROM clients WHERE status = 'active' GROUP BY user_id
    //     ");

    //     // 2. Clients grouped by Month (e.g., clients_2025_08)
    //     DB::statement("
    //         INSERT INTO aggregate_stats (user_id, `key`, value, created_at, updated_at)
    //         SELECT user_id, CONCAT('clients_', DATE_FORMAT(created_at, '%Y_%m')), COUNT(*), NOW(), NOW()
    //         FROM clients 
    //         GROUP BY user_id, CONCAT('clients_', DATE_FORMAT(created_at, '%Y_%m'))
    //     ");

    //     // 3. Projects Status
    //     DB::statement("
    //         INSERT INTO aggregate_stats (user_id, `key`, value, created_at, updated_at)
    //         SELECT user_id, 'active_projects', COUNT(*), NOW(), NOW() FROM projects WHERE status = 'active' GROUP BY user_id
    //     ");
    //     DB::statement("
    //         INSERT INTO aggregate_stats (user_id, `key`, value, created_at, updated_at)
    //         SELECT user_id, 'in_progress_projects', COUNT(*), NOW(), NOW() FROM projects WHERE status = 'in_progress' GROUP BY user_id
    //     ");

    //     // 1. Total Projects
    //     DB::statement("
    //         INSERT INTO aggregate_stats (user_id, `key`, value, created_at, updated_at)
    //         SELECT user_id, 'total_projects', COUNT(*), NOW(), NOW() FROM projects GROUP BY user_id
    //     ");

    //     // 2. Completed Projects
    //     DB::statement("
    //         INSERT INTO aggregate_stats (user_id, `key`, value, created_at, updated_at)
    //         SELECT user_id, 'completed_projects', COUNT(*), NOW(), NOW() FROM projects WHERE status = 'completed' GROUP BY user_id
    //     ");

    //     // 3. Time-Series Projects (projects_2026_04)
    //     DB::statement("
    //         INSERT INTO aggregate_stats (user_id, `key`, value, created_at, updated_at)
    //         SELECT user_id, CONCAT('projects_', DATE_FORMAT(created_at, '%Y_%m')), COUNT(*), NOW(), NOW()
    //         FROM projects 
    //         GROUP BY user_id, CONCAT('projects_', DATE_FORMAT(created_at, '%Y_%m'))
    //     ");

    //     // 4. Invoices & Revenue
    //     DB::statement("
    //         INSERT INTO aggregate_stats (user_id, `key`, value, created_at, updated_at)
    //         SELECT user_id, 'total_invoices', COUNT(*), NOW(), NOW() FROM invoices GROUP BY user_id
    //     ");
    //     DB::statement("
    //         INSERT INTO aggregate_stats (user_id, `key`, value, created_at, updated_at)
    //         SELECT user_id, 'pending_invoices', COUNT(*), NOW(), NOW() FROM invoices WHERE invoice_status IN ('draft', 'sent') GROUP BY user_id
    //     ");
    //     DB::statement("
    //         INSERT INTO aggregate_stats (user_id, `key`, value, created_at, updated_at)
    //         SELECT user_id, 'total_revenue', COALESCE(SUM(total), 0), NOW(), NOW() FROM invoices WHERE invoice_status = 'paid' GROUP BY user_id
    //     ");

    //     // 5. Paid Invoices Count
    //     DB::statement("
    //         INSERT INTO aggregate_stats (user_id, `key`, value, created_at, updated_at)
    //         SELECT user_id, 'paid_invoices', COUNT(*), NOW(), NOW() FROM invoices WHERE invoice_status = 'paid' GROUP BY user_id
    //     ");

    //     // 6. Overdue Invoices Count (⚠️ Requires Nightly Cron Job to stay accurate)
    //     DB::statement("
    //         INSERT INTO aggregate_stats (user_id, `key`, value, created_at, updated_at)
    //         SELECT user_id, 'overdue_invoices', COUNT(*), NOW(), NOW() FROM invoices WHERE invoice_status IN ('draft', 'sent') AND due_date < CURDATE() GROUP BY user_id
    //     ");

    //     // 7. Outstanding Revenue (Money you are waiting to collect)
    //     DB::statement("
    //         INSERT INTO aggregate_stats (user_id, `key`, value, created_at, updated_at)
    //         SELECT user_id, 'outstanding_revenue', COALESCE(SUM(balance_due), 0), NOW(), NOW() FROM invoices WHERE invoice_status IN ('draft', 'sent') GROUP BY user_id
    //     ");
    // }
}
