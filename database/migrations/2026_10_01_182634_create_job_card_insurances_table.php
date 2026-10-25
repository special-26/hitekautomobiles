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
        Schema::create('job_card_insurances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_card_id')
                ->unique()
                ->constrained('job_cards')
                ->cascadeOnDelete();

            // Policy
            $table->string('insurance_company')->nullable();
            $table->string('policy_number')->nullable();
            $table->string('policy_type')->nullable();
            $table->date('policy_start_date')->nullable();
            $table->date('policy_end_date')->nullable();
            $table->string('insured_name')->nullable();

            // Claim
            $table->string('claim_number')->nullable();
            $table->date('claim_date')->nullable();
            $table->string('claim_type')->nullable();

            // Surveyor
            $table->string('surveyor_name')->nullable();
            $table->string('surveyor_phone')->nullable();

            // Claim / assessment
            $table->string('claim_status')->default('pending');
            $table->boolean('cashless')->default(false);

            $table->decimal('estimated_claim_amount', 12, 2)->nullable();
            $table->decimal('approved_amount', 12, 2)->nullable();
            $table->decimal('customer_contribution', 12, 2)->nullable();
            $table->decimal('deductible', 12, 2)->nullable();

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->index('insurance_company');
            $table->index('policy_number');
            $table->index('claim_number');
            $table->index('claim_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_card_insurances');
    }
};
