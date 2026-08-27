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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnDelete();

            $table->string('registration_number')
                ->unique();

            $table->string('make');

            $table->string('model');

            $table->string('variant')
                ->nullable();

            $table->string('fuel_type')
                ->nullable();

            $table->unsignedSmallInteger('manufacturing_year')
                ->nullable();

            $table->string('color')
                ->nullable();

            $table->string('vin')
                ->nullable()
                ->unique();

            $table->string('engine_number')
                ->nullable()
                ->unique();

            $table->unsignedInteger('current_odometer')
                ->nullable();

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
