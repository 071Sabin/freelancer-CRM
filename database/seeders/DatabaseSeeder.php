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
            CurrencySeeder::class,
        ]);

        $user = User::factory()->create([
            'name' => 'sabin',
            'email' => 'sabin@gmail.com',
            'password' => bcrypt('sabin123'),
        ]);

        $client = Client::factory()->create(['user_id' => $user->id]);

        Project::factory(10)->create(['user_id' => $user->id, 'client_id' => $client->id]);
    }
}
