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

            // Ownership / relationships
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();

            // Identity
            $table->string('invoice_number')->index();
            $table->string('status')->index();

            // Dates
            $table->date('issue_date');
            $table->date('due_date');

            // Money (snapshot values)
            $table->string('currency', 3);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax_total', 12, 2)->default(0);
            $table->decimal('discount_total', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            // Optional text
            $table->text('notes')->nullable();
            $table->text('terms')->nullable();

            // Lifecycle
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            // Prevent duplicate invoice numbers per user
            $table->unique(['user_id', 'invoice_number']);
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
