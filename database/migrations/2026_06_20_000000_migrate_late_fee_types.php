<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update invoice_settings table
        DB::table('invoice_settings')
            ->where('default_late_fee_type', 'percentage')
            ->update(['default_late_fee_type' => 'percent']);

        DB::table('invoice_settings')
            ->where('default_late_fee_type', 'fixed')
            ->update(['default_late_fee_type' => 'amount']);

        // 2. Update metadata in invoices table
        $invoices = DB::table('invoices')->whereNotNull('metadata')->get();
        foreach ($invoices as $invoice) {
            $metadata = json_decode($invoice->metadata, true);
            if (is_array($metadata) && isset($metadata['late_fee_type'])) {
                $changed = false;
                if ($metadata['late_fee_type'] === 'percentage') {
                    $metadata['late_fee_type'] = 'percent';
                    $changed = true;
                } elseif ($metadata['late_fee_type'] === 'fixed') {
                    $metadata['late_fee_type'] = 'amount';
                    $changed = true;
                }
                
                if ($changed) {
                    DB::table('invoices')
                        ->where('id', $invoice->id)
                        ->update(['metadata' => json_encode($metadata)]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Revert invoice_settings table
        DB::table('invoice_settings')
            ->where('default_late_fee_type', 'percent')
            ->update(['default_late_fee_type' => 'percentage']);

        DB::table('invoice_settings')
            ->where('default_late_fee_type', 'amount')
            ->update(['default_late_fee_type' => 'fixed']);

        // 2. Revert metadata in invoices table
        $invoices = DB::table('invoices')->whereNotNull('metadata')->get();
        foreach ($invoices as $invoice) {
            $metadata = json_decode($invoice->metadata, true);
            if (is_array($metadata) && isset($metadata['late_fee_type'])) {
                $changed = false;
                if ($metadata['late_fee_type'] === 'percent') {
                    $metadata['late_fee_type'] = 'percentage';
                    $changed = true;
                } elseif ($metadata['late_fee_type'] === 'amount') {
                    $metadata['late_fee_type'] = 'fixed';
                    $changed = true;
                }
                
                if ($changed) {
                    DB::table('invoices')
                        ->where('id', $invoice->id)
                        ->update(['metadata' => json_encode($metadata)]);
                }
            }
        }
    }
};
