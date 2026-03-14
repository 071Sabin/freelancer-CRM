<?php

namespace Tests\Feature\Projects;

use App\Livewire\Projects\Projects;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    
    protected $seed=true;

    public function test_authenticated_user_can_see_project_page(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        Project::factory()->create(['user_id' => $user->id, 'client_id' => $client->id]);
        Project::factory()->count(2)->inProgress()->create(['user_id' => $user->id, 'client_id' => $client->id, 'created_at' => now()]);

        Livewire::actingAs($user)
            ->test(Projects::class)
            ->assertSet('projectCount', 3)
            ->assertSet('progressProjects', 2)
            ->assertSet('thisMonthProjects', 3)
            ->assertSee('Projects')
            ->assertSee('add project');
    }

    public function test_authenticated_user_can_open_add_project_modal(){
        
    }
}
