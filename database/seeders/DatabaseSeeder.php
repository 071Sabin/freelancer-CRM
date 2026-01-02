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
        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                'email' => 'john@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Sabin Panthi',
                'email' => 'sabin@gmail.com',
                'password' => bcrypt('sabin123'),
            ],
            [
                'name' => 'Robert Brown',
                'email' => 'robert@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Emily Johnson',
                'email' => 'emily@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Michael Lee',
                'email' => 'michael@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Sarah Parker',
                'email' => 'sarah@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Daniel Carter',
                'email' => 'daniel@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Laura Wilson',
                'email' => 'laura@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Chris Martin',
                'email' => 'chris@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Olivia Davis',
                'email' => 'olivia@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Henry Cooper',
                'email' => 'henry@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Sophia Turner',
                'email' => 'sophia@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Ethan Walker',
                'email' => 'ethan@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Ava Scott',
                'email' => 'ava@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Noah Adams',
                'email' => 'noah@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Mia Roberts',
                'email' => 'mia@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Liam Evans',
                'email' => 'liam@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Isabella Green',
                'email' => 'isabella@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'James Hill',
                'email' => 'james@eg.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Chloe Baker',
                'email' => 'chloe@eg.com',
                'password' => bcrypt('password'),
            ],
        ]);

    }
}