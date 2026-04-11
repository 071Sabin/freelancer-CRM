<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use App\Models\Currency;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Livewire\Forms\ClientForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

#[Title('Client Pivot | Clients')]
class Clients extends Component
{
    public ClientForm $form; // Inject the magic Form Object

    // Keep your display properties
    public $currencies, $activeClients, $clientCount, $thisMonthClients;
    public array $viewingClient = [];

    protected $listeners = [
        'edit-client' => 'edit',
        'view-client' => 'view',
    ];

    public function addClient()
    {
        try {
            $this->form->storeOrUpdate();

            // $add = 'add';
            $this->modal('add-client-modal')->close();
            $this->dispatch('refreshDatatable');
            session()->flash('success', 'Client added successfully!');
        } catch (ValidationException $e) {
            $this->dispatch('scroll-to-error');
            throw $e;
        }
    }

    public function edit($id)
    {
        // get the client with that id, then check if authorized to edit the client
        $client = Client::with('currency')->findOrFail($id);
        $this->authorize('update', $client);

        // $client = Client::where('user_id', Auth::id())->findOrFail($id);
        $this->form->setClient($client);
        $this->modal('edit-client-modal')->show();
    }

    // this function is used for both client creation and updating particular client
    public function update()
    {
        try {
            $this->form->storeOrUpdate();

            $this->modal('edit-client-modal')->close();
            $this->dispatch('refreshDatatable');
            session()->flash('success', 'Client updated successfully.');
        } catch (ValidationException $e) {
            $this->dispatch('scroll-to-error');
            throw $e;
        }
    }

    public function view($id)
    {
        $client = Client::with('currency')->findOrFail($id);
        $this->authorize('view', $client);
        $this->viewingClient = $client->toArray();
        $this->modal('view-client-modal')->show();
    }

    public function resetAddClientForm()
    {
        $this->form->reset(); // Built-in Livewire form reset
        $this->resetErrorBag();
        $this->resetValidation();
    }


    public function mount()
    {
        $userId = auth()->id();

        $this->currencies = Currency::orderBy('code', 'asc')->get();
        $userKey = Auth::user()->id;
        // $this->clientCount = Client::where('user_id', $userId)->count();
        $this->clientCount = Cache::remember("{$userKey}_client_count", 600, function () use ($userId) {
            return Client::where('user_id', $userId)->count();
        });
        $this->activeClients = Client::where('user_id', $userId)->where('status', 'active')->count();
        $this->thisMonthClients = Client::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('user_id', $userId)
            ->count();
    }

    public function render()
    {
        return view('livewire.clients.clients');
    }
}
