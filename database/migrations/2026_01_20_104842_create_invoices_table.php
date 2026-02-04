<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // Ownership / relationships
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();

            // Identity
            $table->string('invoice_number')->index();
            $table->string('type')->default('invoice')->index(); // invoice, credit_note, proforma
            $table->string('status')->index(); // draft, sent, partially_paid, paid, overdue, void, canceled
            $table->string('reference')->nullable()->index(); // PO / external ref
            $table->string('public_token', 64)->unique();

            // Dates
            $table->date('issue_date');
            $table->date('due_date');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('voided_at')->nullable();

            // Money (snapshot values)
            $table->string('currency', 3);
            $table->string('base_currency', 3)->nullable();
            $table->decimal('exchange_rate', 18, 6)->nullable();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax_total', 12, 2)->default(0);
            $table->decimal('discount_total', 12, 2)->default(0);
            $table->decimal('shipping_total', 12, 2)->default(0);
            $table->decimal('adjustment_total', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('paid_total', 12, 2)->default(0);
            $table->decimal('balance_due', 12, 2)->default(0);
            $table->boolean('is_tax_inclusive')->default(false);

            // Optional text
            $table->text('notes')->nullable();
            $table->text('terms')->nullable();
            $table->string('payment_terms')->nullable();
            $table->unsignedInteger('due_days')->nullable();

            // Lifecycle
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('paid_at')->nullable();

            // Snapshots / compliance
            $table->json('client_snapshot')->nullable();
            $table->json('company_snapshot')->nullable();
            $table->json('billing_address')->nullable();
            $table->json('company_address')->nullable();
            $table->json('shipping_address')->nullable();
            $table->json('metadata')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // Prevent duplicate invoice numbers per user
            $table->unique(['user_id', 'invoice_number']);
            $table->index(['status', 'issue_date']);
            $table->index(['status', 'due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
