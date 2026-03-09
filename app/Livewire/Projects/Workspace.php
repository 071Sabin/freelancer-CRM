<?php

namespace App\Livewire\Projects;

use App\Livewire\Forms\ProjectForm;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Project;
use App\Services\WhatsAppService;
use Livewire\Component;

class Workspace extends Component
{
    public Project $project;
    public ProjectForm $project_form;
    public $notify_client, $clients, $currencies;

    protected $listeners = [
        'edit-project' => 'editModal',
    ];


    public function mount($uuid)
    {
        // 🚨 STRICT SCOPING: User can only see THEIR own projects
        $this->project = Project::with('client')
            ->where('uuid', $uuid)
            ->firstOrFail();
        $this->authorize('view', $this->project);

        $currentUser = auth()->id();
        $this->currencies = Currency::orderBy('code', 'asc')->get();
        $this->clients = Client::where('clients.user_id', $currentUser)->orderBy('client_name', 'asc')->get();
    }

    public function editModal()
    {
        $this->resetForm();
        // $project = Project::with('client', 'currency')->findOrFail($id);
        $this->authorize('update', $this->project);
        $this->project_form->setProject($this->project);
        $this->modal('edit-project-modal')->show();
        // $this->resetForm();
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

    public function sendWhatsappMessage($id)
    {
        $project = Project::findOrFail($id);
        
        if ($project) {
            $this->authorize('update', $project);

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

    public function render()
    {
        return view('livewire.projects.workspace');
    }
}
