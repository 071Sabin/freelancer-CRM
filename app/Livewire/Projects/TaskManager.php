<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class TaskManager extends Component
{
    public Project $project;

    public $newTaskVisible = false;
    public $newTaskTitle = '';
    public $newTaskDesc = '';

    // New Variables  for Edit
    public $editingTaskId = null;
    public $editTaskTitle = '';
    public $editTaskDesc = '';
    public $editTaskVisible;

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

    // lodas data and opens the modal
    public function editTask($taskId)
    {
        $task = $this->project->tasks()->findOrFail($taskId);

        $this->editingTaskId = $task->id;
        $this->editTaskTitle = $task->title;
        $this->editTaskDesc = $task->description;
        $this->editTaskVisible = $task->is_visible_to_client;
        // dd($this->editTaskVisible);

        // Flux ka tarika backend se modal kholne ka
        $this->modal('edit-task-modal')->show();
    }

    // 2. saves data and closes the modal
    public function updateTask()
    {
        $this->validate([
            'editTaskTitle' => 'required|string|max:255',
            'editTaskDesc' => 'nullable|string|max:255',
        ]);

        if ($this->editingTaskId) {
            $task = $this->project->tasks()->findOrFail($this->editingTaskId);
            $task->update([
                'title' => $this->editTaskTitle,
                'description' => $this->editTaskDesc,
                'is_visible_to_client' => $this->editTaskVisible,
            ]);

            $this->modal('edit-task-modal')->close();
            $this->reset(['editingTaskId', 'editTaskTitle', 'editTaskDesc', 'editTaskVisible']);
            session()->flash('success', 'Task updated successfully!');
        }
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
