<?php

namespace App\Livewire\Projects;

use App\Livewire\Forms\ProjectForm;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Client Pivot | Projects')]
class Projects extends Component
{
    public ProjectForm $project_form;
    public $clients, $allProjects, $projectCount, $progressProjects, $thisMonthProjects, $currencies;
    // public $name, $value, $description, $client_id='', $status = 'active';
    // public $currency_id, $hourly_rate, $deadline;
    public $currency_id, $hourly_rate;
    public array $editingProject = [];
    public array $viewingProject = [];

    protected $listeners = [
        'edit-project' => 'edit',
        'view-project' => 'view',
    ];

    public function view($id)
    {
        $project = Project::with('client', 'currency')->findOrFail($id);
        $this->authorize('view', $project);
        $this->viewingProject = $project->toArray();
    }

    public function edit($id)
    {
        $this->resetForm();
        $project = Project::with('client', 'currency')->findOrFail($id);
        $this->authorize('update', $project);
        $this->project_form->setProject($project);
    }

    public function createProject()
    {
        try{
            $this->project_form->storeOrUpdate();

            $this->modal('add-project-modal')->close();
            $this->dispatch('refreshDatatable');
            session()->flash('success', 'Project added successfully.');
        } catch (\Exception $e) {
            $this->dispatch('scroll-to-error');
            throw $e;
        }
    }

    public function update()
    {
        // dd($this->project_form->project);
        try {
            $this->project_form->storeOrUpdate();
            $this->modal('edit-project-modal')->close();
            $this->dispatch('refreshDatatable');
            session()->flash('success', 'Project updated successfully.');
        } catch (\Exception $e) {
            $this->dispatch('scroll-to-error');
            throw $e;
        }
    }

    public function resetForm()
    {
        $this->project_form->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function mount()
    {
        $currentUser = auth()->id();

        $this->projectCount = Project::where('projects.user_id', $currentUser)->count();
        $this->progressProjects = Project::where(['projects.user_id' => $currentUser, 'status' => 'in_progress'])->count();
        $this->clients = Client::where('clients.user_id', $currentUser)->orderBy('client_name', 'asc')->get();
        $this->currencies = Currency::orderBy('code', 'asc')->get();
        // $this->allProjects = Project::all();
        $this->thisMonthProjects = Project::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('projects.user_id', $currentUser)
            ->count();
    }

    public function render()
    {
        return view('livewire.projects.projects');
    }
}
