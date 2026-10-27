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

            $table->string('customer_name');
            $table->string('phone', 10);
            $table->string('email')->nullable();

            $table->boolean('pickup_drop_required')->default(false);
            $table->text('pickup_address')->nullable();
            $table->string('pickup_time')->nullable();

            $table->date('service_date');
            $table->string('slot_key');
            $table->string('service_type')->nullable();
            $table->string('booking_reference', 30)
                ->nullable()
                ->unique();
            $table->text('notes')->nullable();
            $table->string('status')
                ->default('pending');

            $table->timestamps();

            $table->unique(
                ['service_date', 'slot_key'],
                'uniq_service_date_slot'
            );

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
