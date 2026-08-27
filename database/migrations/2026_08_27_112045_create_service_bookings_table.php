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
        Schema::create('service_bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnDelete();

            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->cascadeOnDelete();

            $table->date('service_date');

            $table->string('slot_key');

            $table->string('service_type')->nullable();

            $table->text('notes')->nullable();

            $table->string('status')
                ->default('confirmed');

            $table->timestamps();

            $table->unique(
                ['service_date', 'slot_key'],
                'uniq_service_date_slot'
            );

            $table->index(['service_date', 'status']);
            $table->index('customer_id');
            $table->index('vehicle_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_bookings');
    }
};
