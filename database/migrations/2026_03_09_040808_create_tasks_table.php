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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            // 🚨 STRICT CONSTRAINT: cascadeOnDelete ensures that if a Project
            // is deleted in the future, all its related tasks are automatically
            // deleted from the database as well.
            // No orphaned data allowed!
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();

            $table->string('title');
            $table->string('description')->nullable();
            $table->boolean('is_visible_to_client')->default(false);

            // Default false, because task is not completed as soon as it's created.
            $table->boolean('is_completed')->default(false);

            // Default 0, for sorting tasks within a project. New tasks will appear at the end of the list.
            $table->integer('position')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
