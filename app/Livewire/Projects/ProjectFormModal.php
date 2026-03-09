<?php

namespace App\Livewire\Projects;

use App\Livewire\Forms\ProjectForm;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Project;
use App\Services\WhatsAppService;
use Livewire\Attributes\On;
use Livewire\Component;

class ProjectFormModal extends Component
{
    public $notify_client;
    public ProjectForm $project_form;
    
    #[On('open-project-modal')]
    public function addOrEditProjectModal($id = 0)
    {
        $this->resetForm();
        if ($id) {
            $project = Project::with('client', 'currency')->findOrFail($id);
            $this->authorize('update', $project);
            $this->project_form->setProject($project);
        } else {
            // CREATE MODE - clearing the old data in form
            $this->project_form->reset();
        }
        $this->modal('addEdit-project-modal')->show();
    }


    // this is the post request form triggered by the modal
    public function createProject()
    {
        try {
            // this function below contains the creation + update + whatsapp message sent logic + either to send whatsapp message to client or not
            $this->project_form->storeOrUpdate($this->notify_client);
            $this->modal('addEdit-project-modal')->close();
            $this->dispatch('refreshDatatable');
        } catch (\Exception $e) {
            $this->dispatch('scroll-to-error');
            throw $e;
        }
    }


    // this is the post request form triggered by the modal
    public function update()
    {
        try {
            // this function below contains the creation + update + whatsapp message sent logic
            $this->project_form->storeOrUpdate($this->notify_client);
            $this->modal('addEdit-project-modal')->close();
            $this->dispatch('refreshDatatable');
            // session()->flash('success', 'Project updated successfully.');
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

    #[On('send-whatsapp-to-client')]
    // this function resends the whatsapp message clicked from projects data tables
    public function resendWhatsapp($id)
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

    public function render()
    {
        // Data yahi fetch kar taaki parent se pass na karna pade
        return view('livewire.projects.project-form-modal', [
            'clients' => Client::all(),
            'currencies' => Currency::all(),
        ]);
    }
}
