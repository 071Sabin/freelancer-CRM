<?php

namespace App\Livewire;

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
    public $admins, $totalClients, $progressProjects, $activeProjects, $recentProjects;
    public $totalRevenue = 0;
    public $pendingInvoices = 0;
    public $overdueInvoices = 0;
    public $invoices;

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


        set_time_limit(120);
        $cacheTime = 3600; // Cache for 1 hour (in seconds)
        $userKey = "dashboard_stats_user_{$userId}";

        // 1. Cache the Project & Client Counts
        $this->totalClients = Cache::remember("{$userKey}_total_clients", $cacheTime, function () use ($userId) {
            return Client::where('user_id', $userId)->count();
        });

        $projectStats = Cache::remember("{$userKey}_project_counts", $cacheTime, function () use ($userId) {
            return Project::where('user_id', $userId)
                ->selectRaw("
            SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress,
            SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active
        ")
                ->first();
        });

        $this->progressProjects = $projectStats->in_progress ?? 0;
        $this->activeProjects   = $projectStats->active ?? 0;

        // 2. Cache the Invoice Totals (Revenue, Pending, Overdue)
        $invoiceStats = Cache::remember("{$userKey}_invoice_stats", $cacheTime, function () use ($userId) {
            return Invoice::where('user_id', $userId)
                ->selectRaw("
            SUM(CASE WHEN invoice_status = 'paid' THEN paid_total ELSE 0 END) as revenue,
            COUNT(CASE WHEN invoice_status != 'paid' THEN 1 END) as pending,
            COUNT(CASE WHEN invoice_status != 'paid' AND due_date < ? THEN 1 END) as overdue
        ", [now()->toDateString()])
                ->first();
        });

        $this->totalRevenue    = $invoiceStats->revenue ?? 0;
        $this->pendingInvoices = $invoiceStats->pending ?? 0;
        $this->overdueInvoices = $invoiceStats->overdue ?? 0;

        // 3. Recent Projects (Usually cached for a shorter time, e.g., 5 mins)
        $this->recentProjects = Cache::remember("{$userKey}_recent_projects", 300, function () use ($userId) {
            return Project::with('client:id,client_name')
                ->where('user_id', $userId)
                ->latest()
                ->take(3)
                ->get();
        });
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
