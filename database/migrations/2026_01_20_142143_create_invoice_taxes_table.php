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
        Schema::create('invoice_taxes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('invoice_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');          // GST, VAT, etc.
            $table->string('tax_code')->nullable();
            $table->string('type')->default('percentage'); // percentage, fixed
            $table->string('scope')->default('invoice');   // invoice, item
            $table->decimal('rate', 5, 2)->nullable();     // percentage
            $table->decimal('amount', 12, 2);
            $table->boolean('is_inclusive')->default(false);
            $table->boolean('is_compound')->default(false);
            $table->string('jurisdiction')->nullable();
            $table->unsignedInteger('priority')->default(0);
            $table->json('metadata')->nullable();

            $table->timestamps();

            $table->index(['invoice_id', 'scope']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_taxes');
    }
};
