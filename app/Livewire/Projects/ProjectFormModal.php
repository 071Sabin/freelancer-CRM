<?php

namespace App\Livewire\Projects;

use App\Livewire\Forms\ProjectForm;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Project;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Auth;
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
                dd(session()->all());
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

    public function getClientsProperty()
    {
        $search = trim($this->search);

        if (strlen($search) < self::CLIENT_SEARCH_MIN_LENGTH) {
            return collect();
        }

        $booleanSearch = $this->toBooleanSearch($search);

        if ($booleanSearch === '') {
            return collect();
        }

        return Client::query()
            ->select(['id', 'client_name'])
            ->where('user_id', Auth::id())
            ->whereRaw(
                'MATCH(client_name, client_email, company_name) AGAINST(? IN BOOLEAN MODE)',
                [$booleanSearch]
            )
            ->orderByRaw(
                'MATCH(client_name, client_email, company_name) AGAINST(? IN BOOLEAN MODE) DESC',
                [$booleanSearch]
            )
            ->limit(self::CLIENT_SEARCH_LIMIT)
            ->get();
    }

    private function toBooleanSearch(string $search): string
    {
        $search = preg_replace('/[^\pL\pN]+/u', ' ', $search) ?? '';

        return collect(preg_split('/\s+/', $search, -1, PREG_SPLIT_NO_EMPTY))
            ->filter()
            ->map(fn (string $term) => '+' . $term . '*')
            ->implode(' ');
    }

    public function render()
    {
        return view('livewire.projects.project-form-modal');
    }
}
