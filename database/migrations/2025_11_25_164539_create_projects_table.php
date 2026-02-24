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
        Schema::create('projects', function (Blueprint $table) {
            // Primary key
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Essential fields
            $table->string('name');               // Project Name
            $table->text('description')->nullable(); // Project Description (optional)
            // Monetary value: supports big values and two decimals
            $table->decimal('value', 14, 2)->default(0.00); // Project Value (e.g. 1500.00)
            $table->foreignId('currency_id')->nullable(); //this is related to the currencies table where all the currencies are stored.
            $table->decimal('hourly_rate', 14, 2)->default(0.00); // Hourly Rate (e.g. 50.00)

            // Relationship to clients table
            $table->unsignedBigInteger('client_id')->index();
            $table->string('status');
            $table->timestamp('deadline')->default(now()); //this is deadline for project
            // Useful meta
            $table->timestamps();
            $table->softDeletes(); // optional but recommended for CRUD safety
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
