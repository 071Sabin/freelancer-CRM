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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained();

            // Dodo Specifics
            $table->string('dodo_subscription_id')->unique()->nullable();
            $table->string('dodo_customer_id')->nullable();

            $table->enum('billing_cycle', ['monthly', 'yearly'])->nullable();
            $table->enum('status', ['active', 'cancelled', 'past_due', 'expired'])->default('active');

            $table->timestamp('current_period_start')->nullable();
            $table->timestamp('current_period_end')->nullable(); // Expiry Date
            $table->timestamp('trial_ends_at')->nullable(); // Expiry Date

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
