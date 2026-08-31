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
        Schema::create('job_cards', function (Blueprint $table) {
            $table->id();

            $table->string('job_card_number')
                ->unique();

            // Customer
            $table->foreignId('customer_id')
                ->constrained('customers')
                ->restrictOnDelete();

            // Vehicle
            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->restrictOnDelete();

            // Department
            $table->foreignId('department_id')
                ->constrained('departments')
                ->restrictOnDelete();

            // Bay
            $table->foreignId('bay_id')
                ->nullable()
                ->constrained('bays')
                ->nullOnDelete();

            // Advisor
            $table->foreignId('advisor_id')
                ->nullable()
                ->constrained('employees')
                ->nullOnDelete();

            // Customer complaint / requested work
            $table->text('complaint');

            $table->text('customer_notes')
                ->nullable();

            // Estimated cost
            $table->decimal('estimated_cost', 12, 2)
                ->nullable();

            // Estimated completion
            $table->timestamp('estimated_completion_at')
                ->nullable();

            // Job Card status
            $table->string('status')
                ->default('pending');

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            // Frequently queried columns
            $table->index('customer_id');
            $table->index('vehicle_id');
            $table->index('department_id');
            $table->index('bay_id');
            $table->index('advisor_id');
            $table->index('status');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_cards');
    }
};
