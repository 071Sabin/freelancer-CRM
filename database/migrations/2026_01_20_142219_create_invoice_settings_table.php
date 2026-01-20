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

            $table->string('default_currency', 3)->default('USD');
            $table->decimal('default_tax_rate', 5, 2)->nullable();

            $table->text('default_terms')->nullable();
            $table->text('default_notes')->nullable();

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
