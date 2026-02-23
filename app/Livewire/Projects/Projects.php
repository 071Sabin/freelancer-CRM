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
    public $project_currency, $hourly_rate, $deadline;
    public array $editingProject = [];
    public array $viewingProject = [];

    protected $listeners = [
        'edit-project' => 'edit',
        'view-project' => 'view',
    ];

    public function createProject()
    {
        // project currency is taken from the respective client's default currency
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'value' => 'required|numeric|min:0',
            'client_id' => 'required|exists:clients,id',
            'status' => 'required|string|max:100',
            'project_currency' => 'required|string|max:10',
            'hourly_rate' => 'required|numeric|min:0',
            'deadline' => 'required|date',
        ]);

        $p = new Project();
        $p->name = strtolower($this->name);
        $p->description = strtolower($this->description);
        $p->value = $this->value;
        $p->client_id = $this->client_id;
        $p->status = $this->status;
        $p->project_currency = $this->project_currency;
        $p->hourly_rate = $this->hourly_rate;
        $p->deadline = $this->deadline;

        $p->save();
        $this->dispatch('refreshDatatable');

        // Reset form fields
        $this->reset(['name', 'description', 'value', 'client_id', 'status']);
        return back()->with('success', 'Project created successfully!');
    }

    public function edit($id)
    {
        $this->editingProject = Project::with('client')->findOrFail($id)->toArray();
    }

    public function view($id)
    {
        $this->viewingProject = Project::with('client')->findOrFail($id)->toArray();
    }

    public function update()
    {
        $this->validate([
            'editingProject.name' => 'required|string|max:255',
            'editingProject.description' => 'nullable|string',
            'editingProject.value' => 'required|numeric|min:0',
            'editingProject.client_id' => 'required|exists:clients,id',
            'editingProject.status' => 'required|string|max:100',
            'editProject.hourly_rate' => 'required|numeric',
        ]);

        $project = Project::findOrFail($this->editingProject['id']);

        $project->update([
            'name' => strtolower($this->editingProject['name']),
            'description' => strtolower($this->editingProject['description']),
            'value' => $this->editingProject['value'],
            'client_id' => $this->editingProject['client_id'],
            'status' => $this->editingProject['status'],
            'hourly_rate' => $this->editingProject['hourly_rate'],
        ]);

        $this->dispatch('close-modal', 'edit-project-modal');
        $this->dispatch('refreshDatatable');
        session()->flash('success', 'Project updated successfully!');
    }

    public function updatedClientId($value)
    {
        $this->project_currency = Client::findorFail($value)->currency;
        $this->hourly_rate = Client::findorFail($value)->hourly_rate;
        // dd($this->clientCurrency);
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
