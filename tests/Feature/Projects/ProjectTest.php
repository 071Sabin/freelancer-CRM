<?php

namespace Tests\Feature\Projects;

use App\Livewire\Projects\ProjectFormModal;
use App\Livewire\Projects\Projects;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

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

    public function test_authenticated_user_can_open_add_project_modal()
    {
        $user = User::factory()->create();
        Livewire::actingAs($user)->test(ProjectFormModal::class)
            ->call('addOrEditProjectModal')
            ->assertStatus(200)
            ->assertSet('project_form.name', null);
    }

    public function test_authenticated_user_can_add_projects()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $currency = Currency::first();
        Livewire::actingAs($user)->test(ProjectFormModal::class)
            ->set('project_form.name', 'testproject')
            ->set('project_form.description', 'testprojectdescription')
            ->set('project_form.value', 100)
            ->set('project_form.client_id', $client->id)
            ->set('project_form.status', 'active')
            ->set('project_form.currency_id', $currency->id)
            ->set('project_form.hourly_rate', 100)
            ->set('project_form.deadline', now()->addDays(30))
            ->set('notify_client', false)
            ->call('createProject')
            ->assertHasNoErrors();
    }

    public function test_authenticated_user_can_see_and_open_update_project_modal()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create(['user_id' => $user->id, 'client_id' => $client->id]);

        Livewire::actingAs($user)->test(ProjectFormModal::class)
            ->call('addOrEditProjectModal', $project->id)
            ->assertStatus(200)
            ->assertSet('project_form.name', $project->name)
            ->assertSet('project_form.description', $project->description)
            ->assertSet('project_form.value', $project->value)
            ->assertSet('project_form.client_id', $project->client_id)
            ->assertSet('project_form.status', $project->status)
            ->assertSet('project_form.currency_id', $project->currency_id)
            ->assertSet('project_form.hourly_rate', $project->hourly_rate)
            ->assertSet('project_form.deadline', $project->deadline)
            ->assertSet('notify_client', false);
    }

    public function test_authenticated_user_can_update_projects()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $currency = Currency::first();
        $project = Project::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'name' => 'Old Boring Name'
        ]);

        Livewire::actingAs($user)->test(ProjectFormModal::class)
            ->call('addOrEditProjectModal', $project->id)
            ->set('project_form.name', 'Super Awesome Updated Name')
            ->set('project_form.description', 'testprojectdescription')
            ->set('project_form.value', 100)
            ->set('project_form.client_id', $client->id)
            ->set('project_form.status', 'active')
            ->set('project_form.currency_id', $currency->id)
            ->set('project_form.hourly_rate', 100)
            ->set('project_form.deadline', now()->addDays(23))
            ->set('notify_client', false)
            ->call('update')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'super awesome updated name',
            'description' => 'testprojectdescription',
            'value' => 100,
            'client_id' => $client->id,
            'status' => 'active',
            'currency_id' => $currency->id,
            'hourly_rate' => 100
        ]);
    }
}
