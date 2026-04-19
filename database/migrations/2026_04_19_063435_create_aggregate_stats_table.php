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
        Schema::create('aggregate_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // The specific stat being tracked (e.g., 'total_clients', 'clients_2026_04', 'active_clients')
            $table->string('key');

            // Decimal allows us to use this exact same table for Revenue later (e.g., 10500.50)
            $table->decimal('value', 15, 2)->default(0);

            // ⚡ THE BINSTELLAR INDEX: Makes `updateOrInsert` and dashboard lookups instantaneous
            $table->unique(['user_id', 'key'], 'idx_user_key_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aggregate_stats');
    }
};
