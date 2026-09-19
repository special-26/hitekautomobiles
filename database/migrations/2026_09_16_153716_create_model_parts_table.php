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
        Schema::create('model_parts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vehicle_model_id')
                ->constrained('vehicle_models')
                ->cascadeOnDelete();

            $table->foreignId('part_id')
                ->constrained('parts')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'vehicle_model_id',
                'part_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_parts');
    }
};
