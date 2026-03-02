<?php

namespace App\Livewire\ClientPortal;

use App\Models\Project;
use Livewire\Component;

class Portal extends Component
{
    public $project;

    public function mount($uuid)
    {
                // searching project with UUID + client + invoices loading together
        $this->project = Project::with(['client', 'invoices'])->where('uuid', $uuid)->firstOrFail();
    }
    
    public function render()
    {
        return view('livewire.client-portal.portal');
    }
}
