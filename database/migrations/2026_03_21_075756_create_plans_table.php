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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Starter, Pro, Agency
            $table->string('slug')->unique(); // starter, pro, agency

            // Dodo Product IDs (Seeding directly from Dodo Dashboard)
            $table->string('dodo_price_id_monthly');
            $table->string('dodo_price_id_yearly');

            // Display Prices
            $table->decimal('price_monthly', 8, 2)->nullable();
            $table->decimal('price_yearly', 8, 2)->nullable();

            // Feature Limits (The real power of DB approach)
            $table->integer('invoice_limit')->default(5);
            $table->integer('client_limit')->default(5);
            $table->boolean('has_whatsapp')->default(false);
            $table->boolean('has_custom_branding')->default(false);

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
