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
        // User::factory(10)->create();
        // Client::factory(10)->create();
        // DB::table('users')->insert([
        //     [
        //         'name' => 'John Doe',
        //         'email' => 'john@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'Sabin Panthi',
        //         'email' => 'sabin@gmail.com',
        //         'password' => bcrypt('sabin123'),
        //     ],
        //     [
        //         'name' => 'Robert Brown',
        //         'email' => 'robert@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'Emily Johnson',
        //         'email' => 'emily@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'Michael Lee',
        //         'email' => 'michael@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'Sarah Parker',
        //         'email' => 'sarah@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'Daniel Carter',
        //         'email' => 'daniel@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'Laura Wilson',
        //         'email' => 'laura@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'Chris Martin',
        //         'email' => 'chris@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'Olivia Davis',
        //         'email' => 'olivia@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'Henry Cooper',
        //         'email' => 'henry@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'Sophia Turner',
        //         'email' => 'sophia@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'Ethan Walker',
        //         'email' => 'ethan@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'Ava Scott',
        //         'email' => 'ava@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'Noah Adams',
        //         'email' => 'noah@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'Mia Roberts',
        //         'email' => 'mia@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'Liam Evans',
        //         'email' => 'liam@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'Isabella Green',
        //         'email' => 'isabella@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'James Hill',
        //         'email' => 'james@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        //     [
        //         'name' => 'Chloe Baker',
        //         'email' => 'chloe@eg.com',
        //         'password' => bcrypt('password'),
        //     ],
        // ]);

        DB::table('clients')->insert([
            [
                'client_name'     => 'John Doe',
                'client_email'    => 'john@example.com',
                'company_name'    => 'Doe Pvt Ltd',
                'company_email'   => 'info@doe.com',
                'company_website' => 'https://doe.com',
                'company_phone'   => '+91 9876543210',
                'billing_address' => 'Mumbai, India',
                'hourly_rate'     => '25.00',
                'currency'        => 'INR',
                'status'          => 'active',
                'private_notes'   => 'Priority client',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'client_name'     => 'Jane Smith',
                'client_email'    => 'jane@example.com',
                'company_name'    => 'Smith Solutions',
                'company_email'   => 'contact@smith.com',
                'company_website' => null,
                'company_phone'   => null,
                'billing_address' => 'Delhi, India',
                'hourly_rate'     => '40.00',
                'currency'        => 'USD',
                'status'          => 'lead',
                'private_notes'   => null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);


        DB::table('projects')->insert([
            [
                'name'        => 'Website Redesign',
                'description' => 'Complete redesign of company website UI/UX.',
                'value'       => 1500.00,
                'client_id'   => 1,
                'status'      => 'active',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Mobile App Development',
                'description' => 'Build cross-platform mobile application.',
                'value'       => 3200.00,
                'client_id'   => 2,
                'status'      => 'pending',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'SEO Optimization',
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