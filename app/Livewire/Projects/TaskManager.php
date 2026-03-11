<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class TaskManager extends Component
{
    public Project $project;

    public $newTaskVisible=false;

    public $newTaskTitle = '';
    public $newTaskDesc = '';

    public function mount(Project $project)
    {
        $this->project = $project;
    }

public function toggleVisibility($taskId)
{
    $task = $this->project->tasks()->findOrFail($taskId);
    
    $task->update(['is_visible_to_client' => !$task->is_visible_to_client]);
    // dd($this->is_visible_to_client);
}

    public function addTask()
    {
        $this->validate([
            'newTaskTitle' => 'required|string|max:255',
            'newTaskDesc' => 'nullable|string|max:255',
        ]);

        // New task position finding with last task + 1
        $lastPosition = $this->project->tasks()->max('position') ?? 0;

        $this->project->tasks()->create([
            'project_id' => $this->project->id,
            'title' => $this->newTaskTitle,
            'description' => $this->newTaskDesc,
            'is_visible_to_client' => $this->newTaskVisible,
            'position' => $lastPosition + 1,
            'is_completed' => false,
        ]);

        $this->reset(['newTaskTitle', 'newTaskDesc']);
        session()->flash('success', 'Task added successfully!');
    }

    public function toggleTask($taskId)
    {
        $task = $this->project->tasks()->findOrFail($taskId);
        $task->update([
            'is_completed' => ! $task->is_completed,
        ]);
    }

    public function deleteTask($taskId)
    {
        $this->project->tasks()->findOrFail($taskId)->delete();
        session()->flash('success', 'Task removed.');
    }

    public function render()
    {
        return view('livewire.projects.task-manager', [
            'tasks' => $this->project->tasks()->orderBy('position')->get(),
        ]);
    }
}
