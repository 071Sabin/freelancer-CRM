<?php

namespace App\Livewire\Projects;

use App\Livewire\Forms\ProjectForm;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\Project;
use App\Services\WhatsAppService;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('ClientPivot | workspace')]
class Workspace extends Component
{
    public Project $project;
    public ProjectForm $project_form;
    public $clients, $currencies;
    
    protected $listeners = [
        'edit-project' => 'editModal',
    ];

    // sending whatsapp messaeg from single button in workspace is handled by project-form-modal component, it's dispatched to that component
    // with the respective project id.

    public function mount($uuid)
    {
        // STRICT SCOPING: User can only see THEIR own projects
        $this->project = Project::with('client')
            ->where('uuid', $uuid)
            ->firstOrFail();
        $this->authorize('view', $this->project);

        $currentUser = auth()->id();
        // dd($this->invoices);
        $this->currencies = Currency::orderBy('code', 'asc')->get();
        $this->clients = Client::where('clients.user_id', $currentUser)->orderBy('client_name', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.projects.workspace');
    }
}
