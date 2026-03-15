<?php

namespace Tests\Feature\Projects;

use App\Livewire\Projects\TaskManager;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class TaskManagerTest extends TestCase
{
    use refreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_authenticated_user_can_see_taskmanager_form_inside_project_workspace()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create(['user_id' => $user->id, 'client_id' => $client->id]);

        Livewire::actingAs($user)
            ->test(TaskManager::class, ['project' => $project]) // Pass whatever props it needs        ->assertStatus(200)
            ->assertStatus(200)
            ->assertSee('Project Tasks & Milestones', false);
    }

    public function test_task_manager_creates_task_successfully()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create(['user_id' => $user->id, 'client_id' => $client->id]);

        // passing the project because the workspace as parent element passes the current project to this compomnent to create tasks
        Livewire::actingAs($user)->test(TaskManager::class, ['project' => $project])
            ->set('newTaskTitle', 'Test Task')
            ->set('newTaskDesc', 'Test Task Description')
            ->set('newTaskVisible', true)
            ->call('addTask')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'title' => 'test task',
            'description' => 'test task description',
            'is_visible_to_client' => true,
            'is_completed' => false,
        ]);
    }

    public function test_edit_task_modal_shown_after_clicking_edit_button()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create(['user_id' => $user->id, 'client_id' => $client->id]);
        $task = Task::factory()->create(['project_id' => $project->id]);

        Livewire::actingAs($user)->test(TaskManager::class, ['project' => $project])
            ->call('editTask', $task->id)
            ->assertStatus(200)
            ->assertSet('editingTaskId', $task->id)
            ->assertSet('editTaskTitle', $task->title)
            ->assertSet('editTaskDesc', $task->description)
            ->assertSet('editTaskVisible', $task->is_visible_to_client)
            ->assertSee('Edit Task');
    }

    public function test_auth_users_can_edit_tasks()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create(['user_id' => $user->id, 'client_id' => $client->id]);
        $task = Task::factory()->create(['project_id' => $project->id]);

        Livewire::actingAs($user)->test(TaskManager::class, ['project' => $project])
            ->set('editingTaskId', $task->id)
            ->set('editTaskTitle', 'Edited Task')
            ->set('editTaskDesc', 'Edited Task Description')
            ->set('editTaskVisible', true)
            ->call('updateTask')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'title' => 'edited task',
            'description' => 'edited task description',
            'is_visible_to_client' => true,
            'is_completed' => false,
        ]);
    }

    public function test_auth_users_can_delete_tasks()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create(['user_id' => $user->id, 'client_id' => $client->id]);
        $task = Task::factory()->create(['project_id' => $project->id]);

        Livewire::actingAs($user)->test(TaskManager::class, ['project' => $project])
            ->call('deleteTask', $task->id)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('tasks', [
            'project_id' => $project->id,
            'title' => 'edited task',
            'description' => 'edited task description',
            'is_visible_to_client' => true,
            'is_completed' => false,
        ]);
    }

    public function test_auth_users_can_toggle_tasks_client_visibility()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create(['user_id' => $user->id, 'client_id' => $client->id]);
        $task = Task::factory()->create([
            'project_id' => $project->id,
            'is_visible_to_client' => true,
        ]);

        Livewire::actingAs($user)->test(TaskManager::class, ['project' => $project])
            ->call('toggleVisibility', $task->id)
            ->assertHasNoErrors();
        
            $this->assertDatabaseHas('tasks',[
                'is_visible_to_client' => false,
            ]);
    }

    public function test_auth_users_can_toggle_tasks_completion()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create(['user_id' => $user->id, 'client_id' => $client->id]);
        $task = Task::factory()->create([
            'project_id' => $project->id,
            'is_completed' => false,
        ]);

        Livewire::actingAs($user)->test(TaskManager::class, ['project' => $project])
            ->call('toggleTask', $task->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('tasks', [
            'is_completed' => true,
        ]);
    }
}
