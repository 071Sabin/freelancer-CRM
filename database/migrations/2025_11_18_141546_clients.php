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
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_name');
            $table->string('client_email');
            $table->string('company_name');
            $table->string('company_email')->nullable();
            $table->string('company_website')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('billing_address');
            $table->string('hourly_rate')->default('0.00');
            $table->string('currency');
            $table->enum('status', ['active', 'inactive', 'lead'])
                ->default('active');
            $table->string('private_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};