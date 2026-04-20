<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $supportsFullText = in_array(Schema::getConnection()->getDriverName(), ['mysql', 'pgsql'], true);

        Schema::create('clients', function (Blueprint $table) use ($supportsFullText) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('company_name');
            $table->string('company_email')->nullable();
            $table->string('company_website')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('billing_address');
            $table->string('hourly_rate')->default('0.00');
            $table->foreignId('currency_id')->nullable(); //this is related to the currencies table where all the currencies are stored.
            $table->string('status', 20)->default('active');
            $table->string('private_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // 1. Ownership + Status (Perfect for Dashboard Counts)
            // $table->index(['user_id', 'deleted_at'], 'idx_clients_user_deleted');
            $table->index(['user_id', 'status']);
            if ($supportsFullText) {
                $table->fullText(['client_name', 'client_email', 'company_name']);
            }

            $table->index(['user_id', 'deleted_at', 'client_name', 'id'], 'idx_clients_user_deleted_name_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
