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
        Schema::create('service_task_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_task_id')
                ->constrained('service_tasks')
                ->cascadeOnDelete();

            $table->foreignId('part_id')
                ->constrained('parts')
                ->restrictOnDelete();

            $table->unsignedInteger('default_quantity')->default(1);

            $table->boolean('is_required')->default(false);

            $table->timestamps();

            $table->unique(
                ['service_task_id', 'part_id'],
                'service_task_parts_task_part_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_task_parts');
    }
};
