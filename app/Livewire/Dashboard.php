<?php

namespace App\Livewire;

use App\Models\admins;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Client Pivot | Dashboard')]

class Dashboard extends Component
{
    public $admins, $totalClients, $progressProjects, $activeProjects, $recentProjects;
    public $totalRevenue = 0;
    public $pendingInvoices = 0;
    public $overdueInvoices = 0;

    public function mount()
    {
        $userId = auth()->id();

        // Existing Stats
        $this->totalClients = Client::where('user_id', $userId)->count();
        $this->progressProjects = Project::where(['user_id' => $userId, 'status' => 'in_progress'])->count();
        $this->activeProjects = Project::where(['user_id' => $userId, 'status' => 'active'])->count();
        $this->recentProjects = Project::with('client')->where('user_id', $userId)->latest()->take(3)->get();

        
        // 1. Total Revenue (Sum of 'Paid' invoices only)
        $this->totalRevenue = Invoice::where('user_id', $userId)
            ->where('invoice_status', 'paid')
            ->sum('paid_total');

        // 2. Pending Invoices (Those are not 'paid' yet)
        $this->pendingInvoices = Invoice::where('user_id', $userId)
            ->where('invoice_status', '!=', 'paid')
            ->count();


        // 3. Overdue Invoices (Invoices paid but due date is overdue)
        $this->overdueInvoices = Invoice::where('user_id', $userId)
            ->where('invoice_status', '!=', 'paid')
            ->whereDate('due_date', '<', now())
            ->count();
    }
    
    public function render()
    {
        return view('livewire.dashboard');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}
