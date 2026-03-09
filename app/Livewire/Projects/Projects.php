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
    public $currency_id, $hourly_rate, $project_to_delete, $deleteProjectName, $deleteClientName;

    // these are dispatched from the ProjectsTable
    protected $listeners = [
        // dispatched message from frontend => function_name
        'confirm-delete' => 'prepDelete',
    ];

    // display the delete modal popup after clicking delete on each row, not bulk delete but one at a time
    public function prepDelete($id)
    {
        $project = Project::findOrFail($id);
        $this->project_to_delete = $id;
        $this->deleteProjectName = $project->name;
        $this->deleteClientName = $project->client->client_name;
        $this->modal('delete-project-modal')->show();
    }

    // this function to delete the specific project from the extra menu list in data table delete button on each row
    public function delete()
    {
        if (!$this->project_to_delete) return;
        $project = Project::findOrFail($this->project_to_delete);
        // Authorization policy check
        $this->authorize('delete', $project);

        $project->delete();
        // reset the variables while past id might be there
        $this->reset(['project_to_delete', 'deleteProjectName', 'deleteClientName']);
        $this->dispatch('refreshDatatable');
        $this->modal('delete-project-modal')->close();
        session()->flash('success', 'Project deleted.');
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
