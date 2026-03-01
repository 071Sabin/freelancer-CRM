<?php

namespace App\Livewire\Forms;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProjectForm extends Form
{
    use AuthorizesRequests;
    public ?Project $project = null;

    public $name = '', $value = '', $description = '', $client_id = '', $status = 'active';
    public $currency_id = '', $hourly_rate = '', $deadline = '';

    public function setProject(Project $project)
    {
        $this->project = $project;
        $this->name = $project->name;
        $this->value = $project->value;
        $this->description = $project->description;
        $this->client_id = $project->client_id;
        $this->status = $project->status;
        $this->currency_id = $project->currency_id;
        $this->hourly_rate = $project->hourly_rate;
        $this->deadline = $project->deadline;
    }

    public function updatedClientId($value)
    {
        // dd('fired', $value);
        $client = Client::findOrFail($value);
        $this->currency_id = $client->currency_id;
        $this->hourly_rate = $client->hourly_rate;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'value' => 'required|numeric|min:0',
            'client_id' => 'required|exists:clients,id',
            'status' => 'required|string|max:100',
            'currency_id' => 'required|exists:currencies,id',
            'hourly_rate' => 'required|numeric|min:0',
            'deadline' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            // Project Name
            'name.required' => 'Please provide a name for this project.',
            'name.max'      => 'The project name is too long (maximum is 255 characters).',

            // Description
            'description.string' => 'The description must be valid text.',

            // Project Value
            'value.required' => 'Please enter an estimated value for this project.',
            'value.numeric'  => 'The project value must be a valid number.',
            'value.min'      => 'The project value cannot be negative.',

            // Client
            'client_id.required' => 'You must assign this project to a client.',
            'client_id.exists'   => 'The selected client could not be found in the system.',

            // Status
            'status.required' => 'Please select a current status for this project.',
            'status.string'   => 'The project status must be valid text.',
            'status.max'      => 'The project status is too long (maximum is 100 characters).',

            // Currency
            'currency_id.required' => 'Please select a billing currency.',
            'currency_id.exists'   => 'The selected currency could not be found in the system.',

            // Hourly Rate
            'hourly_rate.required' => 'Please set an hourly billing rate.',
            'hourly_rate.numeric'  => 'The hourly rate must be a valid number.',
            'hourly_rate.min'      => 'The hourly rate cannot be negative.',

            // Deadline
            'deadline.required' => 'A deadline is required to keep the project on track.',
            'deadline.date'     => 'Please provide a valid calendar date for the deadline.',
        ];
    }

    public function storeOrUpdate()
    {
        $this->validate();
        
        if($this->project){
            $this->authorize('update', $this->project);
        }

        $prjData = [
            'name' => strtolower($this->name),
            'description' => strtolower($this->description),
            'value' => $this->value,
            'client_id' => $this->client_id,
            'status' => strtolower($this->status),
            'currency_id' => $this->currency_id,
            'hourly_rate' => $this->hourly_rate,
            'deadline' => $this->deadline,
            'user_id' => auth()->id(),
        ];
        if ($this->project) {
            $this->project->update($prjData);
        } else {
            Project::create($prjData);
        }

        // Reset form fields
        $this->reset();
    }
}
