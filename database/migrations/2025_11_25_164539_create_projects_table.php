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

            // Essential fields
            $table->string('name');               // Project Name
            $table->text('description')->nullable(); // Project Description (optional)
            // Monetary value: supports big values and two decimals
            $table->decimal('value', 14, 2)->default(0.00); // Project Value (e.g. 1500.00)
            $table->string('project_currency')->default('USD'); // Client Currency Value (e.g. 1500.00)
            $table->decimal('hourly_rate', 14, 2)->default(0.00); // Hourly Rate (e.g. 50.00)

            // Relationship to clients table
            $table->unsignedBigInteger('client_id')->index();
            $table->string('status');
            $table->date('deadline')->default(now()); //this is deadline for project
            // Useful meta
            $table->timestamps();
            $table->softDeletes(); // optional but recommended for CRUD safety
          
            // Foreign key constraint (adjust onDelete behaviour if you prefer)
            // $table->foreign('client_id')
            //       ->references('id')->on('clients')
            //       ->onDelete('cascade')
            //       ->onUpdate('cascade');
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
