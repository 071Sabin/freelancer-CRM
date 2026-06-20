<?php

namespace App\Livewire\Projects;

use App\Livewire\Forms\ProjectForm;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Project;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class ProjectFormModal extends Component
{
    private const CLIENT_SEARCH_MIN_LENGTH = 3;
    private const CLIENT_SEARCH_LIMIT = 10;

    public $notify_client, $currencies;
    public ProjectForm $project_form;
    public $search = '';
    public $selectedClientName = '';
    /**
     * Triggers:
     * 1. projects/workspace.blade.php -> triggers to open the edit modal
     * 2. normally modal call from projects.blade.php to open to add and from projectTable actions column to edit the project
     */
    #[On('open-project-modal')]
    public function addOrEditProjectModal($id = 0)
    {
        $this->resetForm();
        if ($id) {
            $project = Project::with('client', 'currency')->findOrFail($id);
            $this->authorize('update', $project);
            $this->project_form->setProject($project);
            $this->selectedClientName = $project->client?->client_name ?? '';
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
        $this->search = '';
        $this->selectedClientName = '';
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function selectClient($clientId)
    {
        $client = Client::query()
            ->select(['id', 'client_name', 'currency_id', 'hourly_rate'])
            ->where('user_id', Auth::id())
            ->findOrFail($clientId);

        $this->project_form->client_id = $client->id;
        $this->project_form->currency_id = $client->currency_id;
        $this->project_form->hourly_rate = $client->hourly_rate;
        $this->selectedClientName = $client->client_name;
        $this->search = '';
    }

    /**
     * Triggers:
     * 1. from ProjectTable.php actions column, sending whatsapp to client
     * 2. from the project workspace.blade.php "send update" button
     */
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
                // dd(session()->all());
            } elseif ($waResponse['success']) {
                $statusMsg = $waResponse['simulated']
                    ? $waResponse['message']
                    : $waResponse['message'];
                session()->flash('success', $statusMsg);
            } else {
                session()->flash('warning', $waResponse['error']);
            }
        }
    }

    public function mount()
    {
        $this->currencies = Currency::all();
    }

    #[Computed]
    public function clients()
    {
        $search = trim($this->search);

        $query = Client::query()
            ->select(['id', 'client_name'])
            ->where('user_id', Auth::id())
            ->orderBy('id')
            ->limit(self::CLIENT_SEARCH_LIMIT);

        if ($search !== '') {
            $prefixSearch = $this->toPrefixSearch($search);
            $query->where('client_name', 'like', '%' . $prefixSearch . '%');
        }

        $clients = $query->get();

        if ($this->project_form->client_id && !$clients->contains('id', $this->project_form->client_id)) {
            $selected = Client::select(['id', 'client_name'])->find($this->project_form->client_id);
            if ($selected) {
                $clients->push($selected);
            }
        }

        return $clients;
    }

    private function toPrefixSearch(string $search): string
    {
        return addcslashes($search, '\%_');
    }

    public function render()
    {
        return view('livewire.projects.project-form-modal');
    }
}
