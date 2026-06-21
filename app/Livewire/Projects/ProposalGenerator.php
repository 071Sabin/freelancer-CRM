<?php

namespace App\Livewire\Projects;

use App\Models\Client;
use App\Models\Project;
use App\Models\Currency;
use App\Models\Integration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\On;

class ProposalGenerator extends Component
{
    public $clients = [];
    public $selectedClientId = '';
    public $projectConcept = '';
    public $estimatedValue = '';
    public $hourlyRate = '';
    public $currencyId = '';
    
    public $proposalMarkdown = '';
    public $isGenerating = false;

    #[On('open-proposal-modal')]
    public function openModal()
    {
        $this->clients = Client::where('user_id', Auth::id())->orderBy('client_name')->get();
        if ($this->clients->isNotEmpty()) {
            $this->selectedClientId = $this->clients->first()->id;
            $this->currencyId = $this->clients->first()->currency_id;
            $this->hourlyRate = $this->clients->first()->hourly_rate;
        }
        $this->proposalMarkdown = '';
        $this->isGenerating = false;
        
        $this->modal('ai-proposal-modal')->show();
    }

    public function updatedSelectedClientId($value)
    {
        $client = Client::find($value);
        if ($client) {
            $this->currencyId = $client->currency_id;
            $this->hourlyRate = $client->hourly_rate;
        }
    }

    public function generateProposal()
    {
        $this->validate([
            'selectedClientId' => 'required|exists:clients,id',
            'projectConcept' => 'required|string|min:10|max:1000',
            'estimatedValue' => 'required|numeric|min:0',
            'hourlyRate' => 'required|numeric|min:0',
        ]);

        $this->isGenerating = true;
        $this->proposalMarkdown = '';

        $client = Client::findOrFail($this->selectedClientId);
        $integration = Integration::where('user_id', Auth::id())->first();

        if (!$integration || empty($integration->ai_api_key)) {
            $clientCompany = $client->company_name ?: $client->client_name;
            $this->proposalMarkdown = "Simulation Mode Active: We propose implementing the concept of \"" . e(Str::limit($this->projectConcept, 80)) . "\" for {$clientCompany}. This custom solution will be delivered to fit your unique requirements, managed carefully within the project budget of " . number_format($this->estimatedValue, 2) . " at " . number_format($this->hourlyRate, 2) . " per hour, ensuring a robust, high-quality, and prompt launch.";
            $this->isGenerating = false;
            return;
        }

        try {
            $provider = $integration->ai_provider ?? 'openai';
            $apiKey = $integration->ai_api_key;

            $prompt = "You are an elite freelance contractor writing a professional client project description. 
            Client details: Contact: {$client->client_name}, Company: {$client->company_name}.
            Project Concept: {$this->projectConcept}.
            Budget: {$this->estimatedValue}.
            Hourly Rate: {$this->hourlyRate}.
            
            Write a professional, persuasive description summarizing the project concept for the client.
            CRITICAL INSTRUCTIONS:
            - Write in plain normal text ONLY. Do NOT use markdown formatting (no asterisks, hash signs, list items, or bold tags).
            - It MUST be exactly one single paragraph.
            - It MUST NOT exceed 300 to 400 characters. Keep it highly concise, under 400 characters maximum.
            - Maintain a professional, clean business tone.";

            if ($provider === 'openai') {
                $response = Http::withToken($apiKey)
                    ->timeout(30)
                    ->post('https://api.openai.com/v1/chat/completions', [
                        'model' => 'gpt-4o-mini',
                        'messages' => [
                            ['role' => 'system', 'content' => 'You are a professional proposal writer.'],
                            ['role' => 'user', 'content' => $prompt]
                        ],
                        'temperature' => 0.7,
                    ]);

                if ($response->successful()) {
                    $this->proposalMarkdown = $response->json('choices.0.message.content');
                } else {
                    throw new \Exception('OpenAI API Error: ' . $response->json('error.message', 'Unknown API Error'));
                }
            } else {
                // Gemini API
                $response = Http::timeout(30)
                    ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                        'contents' => [
                            ['parts' => [['text' => $prompt]]]
                        ]
                    ]);

                if ($response->successful()) {
                    $this->proposalMarkdown = $response->json('candidates.0.content.parts.0.text');
                } else {
                    throw new \Exception('Gemini API Error: ' . $response->body());
                }
            }
        } catch (\Exception $e) {
            Log::error('AI Proposal Generation Failed: ' . $e->getMessage());
            $this->proposalMarkdown = "Error Generating Proposal: Failed to call AI provider: " . $e->getMessage() . " Please check your integration key and network connectivity.";
        }

        $this->isGenerating = false;
    }

    public function createProjectFromProposal()
    {
        $this->validate([
            'selectedClientId' => 'required|exists:clients,id',
            'projectConcept' => 'required|string',
            'estimatedValue' => 'required|numeric',
            'hourlyRate' => 'required|numeric',
        ]);

        // Enforce project client checks
        $client = Client::findOrFail($this->selectedClientId);

        $project = Project::create([
            'user_id' => Auth::id(),
            'client_id' => $this->selectedClientId,
            'name' => strtolower(Str::limit($this->projectConcept, 50)),
            'description' => strtolower($this->proposalMarkdown ?: $this->projectConcept),
            'value' => $this->estimatedValue,
            'hourly_rate' => $this->hourlyRate,
            'currency_id' => $this->currencyId ?: $client->currency_id,
            'deadline' => now()->addDays(30)->format('Y-m-d'), // Default 30 day deadline
            'status' => 'active',
            'uuid' => (string) Str::uuid(),
        ]);

        $this->modal('ai-proposal-modal')->close();
        
        session()->flash('success', 'Project draft created successfully from proposal!');
        return redirect()->route('projects.workspace', ['uuid' => $project->uuid]);
    }

    public function render()
    {
        return view('livewire.projects.proposal-generator');
    }
}
