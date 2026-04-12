<?php

namespace App\Livewire\Dashboard;

use App\Models\admins;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceSetting;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Client Pivot | Dashboard')]

class Dashboard extends Component
{
    public $recentProjects=null;

    public function mount()
    {
        $userId = auth()->id();

        // dd(Auth::user()->subscription->trial_ends_at);
        // Existing Stats
        // $this->totalClients = Client::where('user_id', $userId)->count();
        // $this->progressProjects = Project::where(['user_id' => $userId, 'status' => 'in_progress'])->count();
        // $this->activeProjects = Project::where(['user_id' => $userId, 'status' => 'active'])->count();
        // $this->recentProjects = Project::with('client')->where('user_id', $userId)->latest()->take(3)->get();

        // // // 1. Total Revenue (Sum of 'Paid' invoices only)
        // $this->totalRevenue = Invoice::where('user_id', $userId)
        //     ->where('invoice_status', 'paid')
        //     ->sum('paid_total');

        // // 2. Pending Invoices (Those are not 'paid' yet)
        // $this->pendingInvoices = Invoice::where('user_id', $userId)
        //     ->where('invoice_status', '!=', 'paid')
        //     ->count();

        // // 2. Pending Invoices (Only draft status)
        // // $this->pendingInvoices = Invoice::where('user_id', $userId)
        // //     ->where('invoice_status', 'draft')
        // //     ->count();

        // // 3. Overdue Invoices (Invoices paid but due date is overdue)
        // $this->overdueInvoices = Invoice::where('user_id', $userId)
        //     ->where('invoice_status', '!=', 'paid')
        //     ->whereDate('due_date', '<', now())
        //     ->count();


        // set_time_limit(120);
        $cacheTime = 300;
        $userKey = "dashboard_stats_user_{$userId}";

        // 3. Recent Projects (Usually cached for a shorter time, e.g., 5 mins)
        $this->recentProjects = Cache::remember("{$userKey}_recent_projects", $cacheTime, function () use ($userId) {
            return Project::with('client:id,client_name')
                ->where('user_id', $userId)
                ->latest()
                ->take(3)
                ->get();
        });
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
