<?php

namespace App\Livewire\Dashboard;

use App\Models\AggregateStat;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Client Pivot | Dashboard')]

class Dashboard extends Component
{
    // public $totalClients = 0;
    // public $progressProjects = 0;
    // public $activeProjects = 0;
    // public $recentProjects;
    // public $totalRevenue = 0;
    // public $pendingInvoices = 0;
    // public $overdueInvoices = 0;

    public function mount()
    {
        // $userId = Auth::id();
        // $allStats = AggregateStat::where('user_id', $userId)
        //     ->pluck('value', 'key');

        // $this->totalClients = (int) ($allStats['total_clients'] ?? 0);
        // $this->progressProjects = (int) ($allStats['in_progress_projects'] ?? 0);
        // $this->activeProjects = (int) ($allStats['active_projects'] ?? 0);
        // $this->totalRevenue = (float) ($allStats['total_revenue'] ?? 0);
        // $this->pendingInvoices = (int) ($allStats['pending_invoices'] ?? 0);
        // $this->overdueInvoices = (int) ($allStats['overdue_invoices'] ?? 0);

        // $this->recentProjects = Project::with('client')
        //     ->where('user_id', $userId)
        //     ->latest()
        //     ->take(3)
        //     ->get();
    }
    
    public function render()
    {

        return view('livewire.dashboard.dashboard');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}
