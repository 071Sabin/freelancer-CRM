<?php

namespace App\Livewire\Projects;

use App\Livewire\Forms\ProjectForm;
use App\Models\Project;
use Livewire\Component;

class Workspace extends Component
{
    public Project $project;
    public ProjectForm $project_form;
    public $notify_client=false;

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
