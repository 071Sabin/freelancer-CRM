<?php

namespace App\Livewire;

use App\Models\Plan;
use Livewire\Component;
use App\Services\DodoPaymentService;
use Illuminate\Support\Facades\Log;

class Pricing extends Component
{
    public $isYearly = false;

    // We will load plans from DB and store them here
    public $starterPrice, $proPrice, $agencyPrice;

    public function mount()
    {
        $this->updatePrices(); // Load initial monthly prices
    }

    public function setMonthly()
    {
        $this->isYearly = false;
        $this->updatePrices();
    }

    public function setYearly()
    {
        $this->isYearly = true;
        $this->updatePrices();
    }

    private function updatePrices()
    {
        // Fetch plans from Database
        $plans = Plan::where('is_active', true)->get()->keyBy('slug');

        // Assign prices dynamically based on toggle state
        $this->starterPrice = $this->isYearly ? $plans['starter']->price_yearly : $plans['starter']->price_monthly;
        $this->proPrice     = $this->isYearly ? $plans['pro']->price_yearly     : $plans['pro']->price_monthly;
        $this->agencyPrice  = $this->isYearly ? $plans['agency']->price_yearly  : $plans['agency']->price_monthly;
    }

    public function subscribeToPlan($planSlug, DodoPaymentService $dodoService)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to subscribe.');
        }

        try {
            // Find the exact plan from DB
            $plan = Plan::where('slug', $planSlug)->firstOrFail();

            // Call our updated secure method
            $paymentUrl = $dodoService->createSubscriptionLink(auth()->user(), $plan, $this->isYearly);
            // dd($paymentUrl);
            return redirect()->away($paymentUrl);
            
        } catch (\Exception $e) {
            Log::error('Subscription Error: ' . $e->getMessage());
            session()->flash('error', 'Something went wrong. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.pricing');
    }
}
