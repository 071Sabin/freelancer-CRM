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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('invoice_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger('position')->default(0);
            $table->string('name')->nullable();
            $table->string('description');
            $table->string('sku')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('quantity', 8, 2);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('discount_rate', 5, 2)->nullable();
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->nullable();
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('line_total', 12, 2);
            $table->boolean('is_tax_inclusive')->default(false);
            $table->json('metadata')->nullable();

            $table->timestamps();

            $table->index(['invoice_id', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
