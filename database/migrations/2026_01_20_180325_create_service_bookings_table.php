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

            $table->date('service_date');
            $table->string('slot_key'); // e.g. "10:00-11:00"

            $table->string('customer_name');
            $table->string('phone', 20);
            $table->string('email')->nullable();

            $table->string('car_make')->nullable();
            $table->string('car_model')->nullable();
            $table->string('car_number')->nullable();

            $table->string('service_type')->nullable();
            $table->text('notes')->nullable();

            $table->string('status')->default('confirmed'); // confirmed/cancelled/completed

            $table->timestamps();

            // Ensures a slot can't be booked twice on same date
            $table->unique(['service_date', 'slot_key'], 'uniq_service_date_slot');
            $table->index(['service_date', 'status']);
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
