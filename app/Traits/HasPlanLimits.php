<?php

namespace App\Traits;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Plan;

trait HasPlanLimits
{
    /**
     * Get the active subscription's plan.
     */
    public function getActivePlan()
    {
        // Eager load subscription and plan if not loaded
        if ($this->subscription && $this->subscription->plan) {
            return $this->subscription->plan;
        }

        // Fallback to Starter plan if no active subscription exists
        return Plan::where('slug', 'starter')->first();
    }

    /**
     * Check if client limit is reached.
     */
    public function hasReachedClientLimit(): bool
    {
        $plan = $this->getActivePlan();
        if (!$plan) {
            return false;
        }

        if ($plan->client_limit === -1) {
            return false; // Unlimited
        }

        $clientCount = Client::where('user_id', $this->id)->count();

        return $clientCount >= $plan->client_limit;
    }

    /**
     * Check if invoice limit is reached (in current calendar month).
     */
    public function hasReachedInvoiceLimit(): bool
    {
        $plan = $this->getActivePlan();
        if (!$plan) {
            return false;
        }

        if ($plan->invoice_limit === -1) {
            return false; // Unlimited
        }

        $invoiceCount = Invoice::where('user_id', $this->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return $invoiceCount >= $plan->invoice_limit;
    }

    /**
     * Check if custom branding is allowed.
     */
    public function canUseCustomBranding(): bool
    {
        $plan = $this->getActivePlan();
        return $plan ? (bool)$plan->has_custom_branding : false;
    }

    /**
     * Check if WhatsApp is allowed.
     */
    public function canUseWhatsApp(): bool
    {
        if ($this->isPremium()) {
            return true;
        }
        $plan = $this->getActivePlan();
        return $plan ? (bool)$plan->has_whatsapp : false;
    }

    /**
     * Check if user is premium (Pro or Agency plan).
     */
    public function isPremium(): bool
    {
        $plan = $this->getActivePlan();
        return $plan ? ($plan->slug === 'pro' || $plan->slug === 'agency') : false;
    }
}
