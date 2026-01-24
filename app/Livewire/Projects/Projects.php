<?php

namespace App\Livewire\Projects;

use App\Models\Client;
use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Client Pivot | Projects')]

class Projects extends Component
{
    public $clients, $allProjects, $projectCount, $progressProjects, $thisMonthProjects;
    public $name, $value, $description, $client_id, $status = 'active';

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
        $p->name = strtolower($this->name);
        $p->description = strtolower($this->description);
        $p->value = $this->value;
        $p->client_id = $this->client_id;
        $p->status = $this->status;

        $p->save();
        $this->dispatch('refreshDatatable');

        // Reset form fields
        $this->reset(['name', 'description', 'value', 'client_id', 'status']);
        return back()->with('success', 'Project created successfully!');
    }
    

    public function render()
    {
        $this->projectCount = Project::count();
        $this->progressProjects = Project::where('status', 'in-progress')->count();
        $this->clients = Client::all();
        $this->allProjects = Project::all();
        $this->thisMonthProjects = Project::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        return view('livewire.projects.projects');
    }
}
