<?php

namespace App\Livewire\Projects;

use App\Livewire\Forms\ProjectForm;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Auth;


#[Title('Client Pivot | Projects')]
class Projects extends Component
{
    public ProjectForm $project_form;
    public $notify_client=true;
    public $clients, $allProjects, $projectCount, $progressProjects, $thisMonthProjects, $currencies;
    public $currency_id, $hourly_rate, $project_to_delete, $deleteProjectName, $deleteClientName;
    public array $editingProject = [];
    public array $viewingProject = [];

    protected $listeners = [
        // dispatched message from frontend => function_name
        'edit-project' => 'edit',
        'view-project' => 'view',
        'confirm-delete' => 'prepDelete',
        'resend-whatsapp' => 'resendWhatsapp',
    ];

    public function view($id)
    {
        $project = Project::with('client', 'currency')->findOrFail($id);
        $this->authorize('view', $project);
        $this->viewingProject = $project->toArray();
        $this->modal('view-project-modal')->show();
    }

    public function edit($id)
    {
        $this->resetForm();
        $project = Project::with('client', 'currency')->findOrFail($id);
        $this->authorize('update', $project);
        $this->project_form->setProject($project);
        $this->modal('edit-project-modal')->show();
        // $this->resetForm();
    }

    public function prepDelete($id){
        $project = Project::findOrFail($id);
        $this->project_to_delete = $id;
        $this->deleteProjectName = $project->name;
        $this->deleteClientName = $project->client->client_name;
        $this->modal('delete-project-modal')->show();
    }

    public function delete(){
        if (! $this->project_to_delete) return;
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

    public function createProject()
    {
        try{
            // this function below contains the creation + update + whatsapp message sent logic + either to send whatsapp message to client or not
            $this->project_form->storeOrUpdate($this->notify_client);

            $this->modal('add-project-modal')->close();
            $this->dispatch('refreshDatatable');
            // session()->flash('success', 'Project added successfully.');
        } catch (\Exception $e) {
            $this->dispatch('scroll-to-error');
            throw $e;
        }
    }

    public function update()
    {
        // dd($this->project_form->project);
        try {
             // this function below contains the creation + update + whatsapp message sent logic
            $this->project_form->storeOrUpdate($this->notify_client);
            $this->modal('edit-project-modal')->close();
            $this->dispatch('refreshDatatable');
            // session()->flash('success', 'Project updated successfully.');
        } catch (\Exception $e) {
            $this->dispatch('scroll-to-error');
            throw $e;
        }
    }

    // this function resends the whatsapp message clicked from projects data tables
    public function resendWhatsapp($id)
    {
        $project = Project::findOrFail($id);

        if ($project) {
            $waResponse = app(WhatsAppService::class)->sendProjectPortal($project);

            if ($waResponse['skipped'] ?? false) {
                session()->flash('success', '(' . $waResponse['message'] . ')');
            } elseif ($waResponse['success']) {
                $statusMsg = $waResponse['simulated']
                    ? '(WhatsApp log simulated)'
                    : 'Project Details are sent in WhatsApp!';
                session()->flash('success', $statusMsg);
            } else {
                session()->flash('warning', 'WhatsApp failed: ' . $waResponse['error']);
            }
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
        $this->dispatch('notify-error', message: 'WhatsApp fail ho gaya!');
        return view('livewire.projects.projects');
    }
}
