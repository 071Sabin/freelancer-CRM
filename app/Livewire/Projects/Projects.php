<?php

namespace App\Livewire\Projects;

use App\Models\Client;
use App\Models\Currency;
use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Client Pivot | Projects')]

class Projects extends Component
{
    public $clients, $allProjects, $projectCount, $progressProjects, $thisMonthProjects;
    public $name, $value, $description, $client_id, $status = 'active';
    public $currencies, $currency_id, $hourly_rate, $deadline;
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
            'currency_id' => 'required|exists:currencies,id',
            'hourly_rate' => 'required|numeric|min:0',
            'deadline' => 'required|date',
        ]);

        $p = new Project();
        $p->name = strtolower($this->name);
        $p->user_id = auth()->id();
        $p->description = strtolower($this->description);
        $p->value = $this->value;
        $p->client_id = $this->client_id;
        $p->status = $this->status;
        $p->currency_id = $this->currency_id;
        $p->hourly_rate = $this->hourly_rate;
        $p->deadline = $this->deadline;

        $p->save();
        $this->dispatch('refreshDatatable');

        // Reset form fields
        $this->reset(['name', 'description', 'value', 'client_id', 'status', 'currency_id', 'hourly_rate']);
        return back()->with('success', 'Project created successfully!');
    }

    public function edit($id)
    {
        $this->editingProject = Project::with('client','currency')->findOrFail($id)->toArray();
    }

    public function view($id)
    {
        $this->viewingProject = Project::with('client','currency')->findOrFail($id)->toArray();
    }

    public function update()
    {
        $this->validate([
            'editingProject.name' => 'required|string|max:255',
            'editingProject.description' => 'nullable|string',
            'editingProject.value' => 'required|numeric|min:0',
            'editingProject.client_id' => 'required|exists:clients,id',
            'editingProject.status' => 'required|string|max:100',
            'editingProject.hourly_rate' => 'required|numeric|min:0',
            'editingProject.currency_id' => 'required|exists:currencies,id',
            'editingProject.deadline' => 'required|date',
        ], [
            // Project Name
            'editingProject.name.required' => 'Please provide a name for this project.',
            'editingProject.name.max'      => 'The project name is too long (maximum is 255 characters).',
            // Project Value
            'editingProject.value.required' => 'Please enter an estimated value for this project.',
            'editingProject.value.numeric'  => 'The project value must be a valid number.',
            'editingProject.value.min'      => 'The project value cannot be negative.',
            // Client
            'editingProject.client_id.required' => 'You must assign this project to a client.',
            'editingProject.client_id.exists'   => 'The selected client could not be found in the system.',
            // Status
            'editingProject.status.required' => 'Please select a current status for this project.',
            // Hourly Rate
            'editingProject.hourly_rate.required' => 'Please set an hourly billing rate.',
            'editingProject.hourly_rate.numeric'  => 'The hourly rate must be a valid number.',
            'editingProject.hourly_rate.min'      => 'The hourly rate cannot be negative.',
            // Currency
            'editingProject.currency_id.required' => 'Please select a billing currency.',
            // Deadline
            'editingProject.deadline.required' => 'A deadline is required to keep the project on track.',
            'editingProject.deadline.date'     => 'Please provide a valid calendar date for the deadline.',
        ]);

        $project = Project::findOrFail($this->editingProject['id']);

        $project->update([
            'name' => strtolower($this->editingProject['name']),
            'description' => strtolower($this->editingProject['description']),
            'value' => $this->editingProject['value'],
            'client_id' => $this->editingProject['client_id'],
            'status' => $this->editingProject['status'],
            'hourly_rate' => $this->editingProject['hourly_rate'],
            'currency_id' => $this->editingProject['currency_id'],
            'deadline' => $this->editingProject['deadline'],
        ]);

        $this->dispatch('close-modal', 'edit-project-modal');
        $this->dispatch('refreshDatatable');
        session()->flash('success', 'Project updated successfully!');
    }

    public function updatedClientId($value)
    {
        // dd($value);
        $this->currency_id = Client::findorFail($value)->currency_id;
        $this->hourly_rate = Client::findorFail($value)->hourly_rate;
        // dd($this->clientCurrency);
    }

    public function mount()
    {
        $this->projectCount = Project::where('user_id', auth()->id())->count();
        $this->progressProjects = Project::where(['user_id' => auth()->id(), 'status' => 'in_progress'])->count();
        $this->clients = Client::where('user_id', auth()->id())->orderBy('client_name', 'asc')->get();
        $this->currencies = Currency::orderBy('code','asc')->get();
        // $this->allProjects = Project::all();
        $this->thisMonthProjects = Project::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('user_id', auth()->id())
            ->count();
    }

    public function render()
    {
        return view('livewire.projects.projects');
    }
}
