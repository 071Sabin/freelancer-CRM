<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        DB::table('users')->insert([
            [
                'name' => 'Sabin Panthi',
                'email' => 'sabin@gmail.com',
                'password' => bcrypt('sabin123'),
            ],
        ]);

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


        DB::table('projects')->insert([
            [
                'name'        => 'Website Redesign',
                'user_id'     => 1,
                'description' => 'Complete redesign of company website UI/UX.',
                'value'       => 1500.00,
                'client_id'   => 1,
                'status'      => 'active',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Mobile App Development',
                'user_id'     => 1,
                'description' => 'Build cross-platform mobile application.',
                'value'       => 3200.00,
                'client_id'   => 2,
                'status'      => 'in_progress',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'SEO Optimization',
                'user_id'     => 1,
                'description' => null,
                'value'       => 800.00,
                'client_id'   => 1,
                'status'      => 'completed',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}