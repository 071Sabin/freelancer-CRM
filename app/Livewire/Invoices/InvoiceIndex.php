<?php

namespace App\Livewire\Invoices;

use App\Models\AggregateStat;
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
    public $overdueInvoices;  

    public function mount()
    {
        $userId = Auth::id();

        // 1. Fetch all pre-calculated stats (Instant O(1) lookup)
        $allStats = AggregateStat::where('user_id', $userId)->pluck('value', 'key');

        // 2. Assign the total from memory
        $this->total_invoices = $allStats['total_invoices'] ?? 0;

        // 3. The Optimized Time-Based Query
        // We avoid whereDate() and use a strict date string to utilize the B-Tree index.
        // We also MUST filter out 'paid' invoices, or they will show as overdue forever.
        $this->overdueInvoices = $allStats['overdue_invoices'] ?? 0;
    }

    public function render()
    {
        return view('livewire.invoices.invoice');
    }
}
