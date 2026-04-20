<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\AggregateStat;

class InvoiceObserver
{
    private const PENDING_STATUSES = ['draft', 'sent', 'partially_paid', 'overdue'];

    public function created(Invoice $invoice)
    {
        $uid = $invoice->user_id;

        AggregateStat::adjust($uid, 'total_invoices', 1);

        if (in_array($invoice->invoice_status, self::PENDING_STATUSES, true)) {
            AggregateStat::adjust($uid, 'pending_invoices', 1);
            AggregateStat::adjust($uid, 'outstanding_revenue', $invoice->balance_due);
        } elseif ($invoice->invoice_status === 'paid') {
            AggregateStat::adjust($uid, 'paid_invoices', 1);
            AggregateStat::adjust($uid, 'total_revenue', $invoice->total);
        }

        if ($invoice->invoice_status === 'overdue') {
            AggregateStat::adjust($uid, 'overdue_invoices', 1);
        }
    }

    public function updated(Invoice $invoice)
    {
        $uid = $invoice->user_id;

        // ONLY fire if the status changed (e.g., from 'sent' to 'paid')
        if ($invoice->wasChanged('invoice_status')) {
            $oldStatus = $invoice->getOriginal('invoice_status');
            $newStatus = $invoice->invoice_status;

            // 1. Remove old status numbers
            if (in_array($oldStatus, self::PENDING_STATUSES, true)) {
                AggregateStat::adjust($uid, 'pending_invoices', -1);
                AggregateStat::adjust($uid, 'outstanding_revenue', -$invoice->getOriginal('balance_due'));
            } elseif ($oldStatus === 'paid') {
                AggregateStat::adjust($uid, 'paid_invoices', -1);
                AggregateStat::adjust($uid, 'total_revenue', -$invoice->getOriginal('total'));
            }

            // 2. Add new status numbers
            if ($oldStatus === 'overdue') {
                AggregateStat::adjust($uid, 'overdue_invoices', -1);
            }

            if (in_array($newStatus, self::PENDING_STATUSES, true)) {
                AggregateStat::adjust($uid, 'pending_invoices', 1);
                AggregateStat::adjust($uid, 'outstanding_revenue', $invoice->balance_due);
            } elseif ($newStatus === 'paid') {
                AggregateStat::adjust($uid, 'paid_invoices', 1);
                AggregateStat::adjust($uid, 'total_revenue', $invoice->total);
            }

            if ($newStatus === 'overdue') {
                AggregateStat::adjust($uid, 'overdue_invoices', 1);
            }
        }
    }

    public function deleted(Invoice $invoice)
    {
        $uid = $invoice->user_id;

        AggregateStat::adjust($uid, 'total_invoices', -1);

        if (in_array($invoice->invoice_status, self::PENDING_STATUSES, true)) {
            AggregateStat::adjust($uid, 'pending_invoices', -1);
            AggregateStat::adjust($uid, 'outstanding_revenue', -$invoice->balance_due);
        } elseif ($invoice->invoice_status === 'paid') {
            AggregateStat::adjust($uid, 'paid_invoices', -1);
            AggregateStat::adjust($uid, 'total_revenue', -$invoice->total);
        }

        if ($invoice->invoice_status === 'overdue') {
            AggregateStat::adjust($uid, 'overdue_invoices', -1);
        }
    }

    /**
     * Handle the Invoice "restored" event.
     */
    public function restored(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     */
    public function forceDeleted(Invoice $invoice): void
    {
        //
    }
}
