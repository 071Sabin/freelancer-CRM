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
            $table->uuid('uuid')->nullable()->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Essential fields
            $table->string('name')->index();               // Project Name
            $table->text('description')->nullable(); // Project Description (optional)
            // Monetary value: supports big values and two decimals
            $table->decimal('value', 14, 2)->default(0.00); // Project Value (e.g. 1500.00)
            $table->foreignId('currency_id')->nullable()->index(); //this is related to the currencies table where all the currencies are stored.
            $table->decimal('hourly_rate', 14, 2)->default(0.00); // Hourly Rate (e.g. 50.00)

            // Relationship to clients table
            $table->unsignedBigInteger('client_id')->index();
            $table->string('status')->index();
            $table->timestamp('deadline')->default(now())->index(); //this is deadline for project
            // Useful meta
            $table->timestamps();
            $table->softDeletes(); // optional but recommended for CRUD safety

            // 1. The "Main DataTable" Index
            // Covers: "Show all my projects, sort by newest"
            $table->index(['user_id', 'deleted_at', 'created_at'], 'idx_proj_user_del_created');
            $table->index(['user_id', 'deleted_at', 'name', 'id'], 'idx_proj_user_deleted_name_id');

            // 2. The "Client Detail Page" Index
            // Covers: "Show all projects for Client X"
            $table->index(['user_id', 'client_id', 'deleted_at'], 'idx_proj_user_client_del');

            // 3. The "Dashboard KPI" Index
            // Covers: "Show my active projects" OR "Show my active projects ending soon"
            // MySQL can use the first 3 parts of this for status, or all 4 for deadline tracking.
            $table->index(['user_id', 'status', 'deadline', 'deleted_at'], 'idx_proj_user_status_deadline');

            // 4. The "Lightning Search" Index
            // Replaces standard LIKE '%search%' for instant text matching
            $table->fullText('name', 'idx_proj_fulltext_name_desc');
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
