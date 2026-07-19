<?php

namespace App\Livewire\Dashboard;

use App\Models\AggregateStat;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use App\Services\DodoPaymentService;
use App\Models\Subscription;
use App\Models\Plan;
use App\Models\User;

#[Title('Client Pivot | Dashboard')]

class Dashboard extends Component
{
    #[Url]
    public $subscription_id = '';
    
    #[Url]
    public $status = '';
    // public $totalClients = 0;
    // public $progressProjects = 0;
    // public $activeProjects = 0;
    // public $recentProjects;
    // public $totalRevenue = 0;
    // public $pendingInvoices = 0;
    // public $overdueInvoices = 0;

    public function mount(DodoPaymentService $dodoService)
    {
        // 1. Fallback Activation Logic (For local testing without Webhooks)
        if ($this->subscription_id && $this->status === 'active') {
            $user = auth()->user();
            
            // Check if this subscription is already active in our db
            $existingSub = Subscription::where('dodo_subscription_id', $this->subscription_id)->first();
            
            if (!$existingSub) {
                // Fetch details from Dodo
                $dodoSub = $dodoService->getSubscription($this->subscription_id);
                
                if ($dodoSub && isset($dodoSub['metadata']) && $dodoSub['status'] === 'active') {
                    $metadata = $dodoSub['metadata'];
                    $plan = Plan::find($metadata['plan_id']);
                    $planSlug = $plan ? $plan->slug : 'pro';

                    Subscription::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'plan_id' => $metadata['plan_id'],
                            'dodo_subscription_id' => $this->subscription_id,
                            'dodo_customer_id' => $dodoSub['customer']['customer_id'] ?? null,
                            'billing_cycle' => $metadata['billing_cycle'] ?? 'monthly',
                            'status' => 'active',
                            'current_period_start' => now(),
                            'trial_ends_at' => null,
                            'current_period_end' => ($metadata['billing_cycle'] ?? 'monthly') === 'yearly' 
                                ? now()->addYear() 
                                : now()->addMonth(),
                        ]
                    );

                    User::where('id', $user->id)->update([
                        'subscription_plan' => $planSlug,
                        'subscription_status' => 'active'
                    ]);
                    
                    // Clear the URL params so it doesn't re-run
                    $this->subscription_id = '';
                    $this->status = '';
                    
                    // Optional: redirect to clear URL in browser completely
                    return redirect()->route('dashboard')->with('success', 'Subscription activated successfully!');
                }
            }
        }
        
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
