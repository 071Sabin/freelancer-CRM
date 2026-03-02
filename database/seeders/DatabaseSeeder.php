<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
            CurrencySeeder::class,]);
            
        // User::factory(10)->create();
        // Client::factory(10)->create();
        // DB::table('users')->insert([
        //     [
        //         'name' => 'Sabin Panthi',
        //         'email' => 'sabin@gmail.com',
        //         'password' => bcrypt('sabin123'),
        //     ],
        // ]);

        DB::table('clients')->insert([
            [
                'client_name'     => 'John Doe',
                'user_id'         => 1,
                'client_email'    => 'john@example.com',
                'company_name'    => 'Doe Pvt Ltd',
                'company_email'   => 'info@doe.com',
                'company_website' => 'https://doe.com',
                'company_phone'   => '+918400733698',
                'billing_address' => 'Mumbai, India',
                'hourly_rate'     => '25.00',
                'status'          => 'active',
                'private_notes'   => 'Priority client',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'client_name'     => 'Jane Smith',
                'user_id'         => 1,
                'client_email'    => 'jane@example.com',
                'company_name'    => 'Smith Solutions',
                'company_email'   => 'contact@smith.com',
                'company_website' => null,
                'company_phone'   => null,
                'billing_address' => 'Delhi, India',
                'hourly_rate'     => '40.00',
                'status'          => 'lead',
                'private_notes'   => null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);

        Project::create([
            'uuid' => Str::uuid(),
            'user_id' => 1,
            'name' => 'website redesign',
            'description' => 'complete ui/ux overhaul',
            'value' => 2500.00,
            'currency_id' => 1,
            'hourly_rate' => 50.00,
            'client_id' => 1,
            'status' => 'active',
            'deadline' => now()->addDays(30),
        ]);

        Project::create([
            'uuid' => Str::uuid(),
            'user_id' => 1,
            'name' => 'mobile app development',
            'description' => 'cross platform flutter app',
            'value' => 5000.00,
            'currency_id' => 1,
            'hourly_rate' => 65.00,
            'client_id' => 1,
            'status' => 'inactive',
            'deadline' => now()->addDays(45),
        ]);

        Project::create([
            'uuid' => Str::uuid(),
            'user_id' => 1,
            'name' => 'seo optimization',
            'description' => 'technical seo and content update',
            'value' => 1200.00,
            'currency_id' => 1,
            'hourly_rate' => 40.00,
            'client_id' => 1,
            'status' => 'lead',
            'deadline' => now()->addDays(20),
        ]);
    }
}