<?php

namespace App\Livewire\Projects;

use App\Models\Client;
use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Client Pivot | Projects')]

class Projects extends Component
{
    public $clients, $allProjects;
    public $showAddProjects = false;
    public $name, $value, $description, $client_id, $status;

    public function createProject()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'value' => 'required|numeric|min:0',
            'client_id' => 'required|exists:clients,id',
            'status' => 'required|string|max:100',
        ]);

        $p = new Project();
        $p->name = $this->name;
        $p->description = $this->description;
        $p->value = $this->value;
        $p->client_id = $this->client_id;
        $p->status = $this->status;
        
        $p->save();

        // Reset form fields
        $this->reset(['name', 'description', 'value', 'client_id', 'status']);
        return back()->with('success', 'Project created successfully!');
    }


    public function mount()
    {
        $this->clients = Client::all();
        $this->allProjects = Project::all();
    }


    public function showAddProjectsForm()
    {
        if ($this->showAddProjects) {
            $this->showAddProjects = false;
            return;
        }
        $this->showAddProjects = true;
    }


    public function render()
    {
        return view('livewire.projects.projects');
    }
}
