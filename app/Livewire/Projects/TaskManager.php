<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TaskManager extends Component
{
    public Project $project;

    public $newTaskTitle = '';
    public $newTaskDesc = '';

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function addTask()
    {
        $this->validate([
            'newTaskTitle' => 'required|string|max:255',
            'newTaskDesc' => 'nullable|string',
        ]);

        // New task position finding with last task + 1 
        $lastPosition = $this->project->tasks()->max('position') ?? 0;

        $this->project->tasks()->create([
            'title' => $this->newTaskTitle,
            'description' => $this->newTaskDesc ?? '',
            'position' => $lastPosition + 1,
            'is_completed' => false,
        ]);

        $this->reset();
        session()->flash('success', 'Task added successfully!');
    }

    public function toggleTask($taskId)
    {
        $task = $this->project->tasks()->findOrFail($taskId);
        $task->update([
            'is_completed' => !$task->is_completed
        ]);
    }

    public function deleteTask($taskId)
    {
        $this->project->tasks()->findOrFail($taskId)->delete();
        $this->dispatch('notify', ['message' => 'Task removed.', 'type' => 'success']);
    }

    public function render()
    {
        return view('livewire.projects.task-manager', [
            'tasks' => $this->project->tasks
        ]);
    }
}
