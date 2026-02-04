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
        Schema::create('invoice_settings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete()
                ->unique();

            $table->string('prefix')->default('INV');
            $table->unsignedBigInteger('next_number')->default(1);
            $table->string('number_format')->default('{PREFIX}{NUMBER}');

            $table->string('default_currency', 3)->default('USD');
            $table->decimal('default_tax_rate', 5, 2)->nullable();
            $table->boolean('default_tax_inclusive')->default(false);
            $table->unsignedInteger('default_due_days')->default(14);
            $table->string('default_payment_terms')->nullable();
            $table->decimal('default_discount_rate', 5, 2)->nullable();
            $table->decimal('default_late_fee_rate', 5, 2)->nullable();
            $table->decimal('default_late_fee_amount', 12, 2)->nullable();
            $table->string('default_late_fee_type')->nullable(); // percentage, fixed
            $table->boolean('allow_partial_payments')->default(false);

            $table->text('default_terms')->nullable();
            $table->text('default_notes')->nullable();
            $table->text('default_footer')->nullable();

            $table->string('company_name')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_website')->nullable();
            $table->string('tax_id')->nullable();
            $table->json('company_address')->nullable();
            $table->json('bank_details')->nullable();
            $table->json('payment_methods')->nullable();

            $table->string('locale')->default('en');
            $table->string('timezone')->default('UTC');
            $table->string('logo_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_settings');
    }
};
