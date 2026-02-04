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
        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('invoice_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('provider')->nullable(); // stripe, paypal, manual
            $table->string('method')->nullable();   // card, bank_transfer, cash
            $table->string('reference')->nullable();

            $table->decimal('amount', 12, 2);
            $table->string('currency', 3);
            $table->decimal('exchange_rate', 18, 6)->nullable();
            $table->decimal('fee_amount', 12, 2)->default(0);

            $table->string('status')->default('completed'); // pending, completed, failed, refunded
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();

            $table->index(['invoice_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_payments');
    }
};
