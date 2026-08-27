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

            $table->string('job_card_number')->unique();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnDelete();

            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->cascadeOnDelete();

            $table->foreignId('service_booking_id')
                ->nullable()
                ->constrained('service_bookings')
                ->nullOnDelete();

            $table->foreignId('advisor_id')
                ->nullable()
                ->constrained('employees')
                ->nullOnDelete();

            $table->foreignId('bay_id')
                ->nullable()
                ->constrained('bays')
                ->nullOnDelete();

            $table->text('complaint')->nullable();

            $table->text('work_description')->nullable();

            $table->decimal('estimated_cost', 12, 2)
                ->nullable();

            $table->timestamp('estimated_completion_at')
                ->nullable();

            $table->string('status')
                ->default('open');

            $table->string('priority')
                ->default('normal');

            $table->timestamps();

            $table->index(['customer_id', 'vehicle_id']);
            $table->index('service_booking_id');
            $table->index('advisor_id');
            $table->index('bay_id');
            $table->index(['status', 'priority']);
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
