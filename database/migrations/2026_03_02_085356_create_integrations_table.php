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
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
            // User se link karne ke liye. Agar delete hua to ye bhi delete.
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // AI BYOK (Gemini / OpenAI)
            $table->string('ai_provider')->nullable();
            $table->text('ai_api_key')->nullable();

            // WhatsApp Cloud API
            $table->text('wa_access_token')->nullable();
            $table->string('wa_phone_number_id')->nullable();
            $table->string('wa_business_account_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integrations');
    }
};
