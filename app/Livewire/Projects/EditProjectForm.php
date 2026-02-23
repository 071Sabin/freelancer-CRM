<?php

namespace App\Livewire\Projects;

use App\Models\Client;
use App\Models\Project;
use Livewire\Attributes\On;
use Livewire\Component;

class EditProjectForm extends Component
{
    public bool $open = false;
    public bool $showDetails = false;
    public array $editProject = [];
    public array $viewProject = [];
    public $clients, $hourly_rate;
    
    // #[On('edit-project')]
    // public function openEdit(int $projectId): void
    // {
    //     // dd($clientId);
    //     $project = Project::findOrFail($projectId);
    //     $this->clients=Client::all();
    //     $this->editProject = $project->toArray();
    //     $this->open = true;
    // }

    // #[On('view-project')]
    // public function viewProjectPopup($projectId)
    // {
    //     $project = Project::findOrFail($projectId);
    //     $this->viewProject = $project->toArray();
    //     $this->showDetails = true;
    // }

    // public function closeView()
    // {
    //     $this->reset(['showDetails', 'viewProject']);
    // }

    // public function closeEdit(): void
    // {
    //     $this->reset(['open', 'editProject']);
    // }

    public function saveProjectEdit()
    {
        $project = Project::findOrFail($this->editProject['id']);

        $this->validate([
            'editProject.name'        => 'required|string|max:255',
            'editProject.description' => 'nullable|string',
            'editProject.value'       => 'required|numeric|min:0',
            'editProject.client_id'   => 'required|exists:clients,id',
            'editProject.status'      => 'required|string|max:50',
            
        ]);

        $project->name = strtolower($this->editProject['name']);

        $project->description = $this->editProject['description']
            ? strtolower($this->editProject['description'])
            : null;

        $project->value = $this->editProject['value']; // decimal(14,2)

        $project->client_id = $this->editProject['client_id'];

        $project->status = strtolower($this->editProject['status']);
        $project->hourly_rate = $this->editProject['hourly_rate'];

        $project->save();

        $this->dispatch('refreshDatatable');

        // $this->closeEdit();

        return back()->with('success', 'Project updated successfully!');
    }



    public function render()
    {
        return view('livewire.projects.edit-project-form');
    }
}
