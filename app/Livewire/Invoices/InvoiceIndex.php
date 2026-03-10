<?php

namespace App\Livewire\Invoices;

use App\Models\Invoice; // Model
use App\Models\InvoiceSetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

#[Title('ClientPivot | Invoices')]
class InvoiceIndex extends Component // Renamed to avoid conflict with Model
{

    public $total_invoices = '';
    public $invoices = '';    

    public function mount()
    {
        $currentUser = Auth::id();
        $this->total_invoices = Invoice::where('user_id', $currentUser)->count();
        $this->invoices = Invoice::where('user_id', $currentUser)->with(['client', 'project'])->latest()->get();
    }

    public function render()
    {
        return view('livewire.invoices.invoice');
    }
}
