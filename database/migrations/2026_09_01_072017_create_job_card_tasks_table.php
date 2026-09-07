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
        Schema::create('job_card_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_card_id')
                ->constrained('job_cards')
                ->cascadeOnDelete();

            $table->foreignId('department_id')
                ->constrained('departments')
                ->restrictOnDelete();

            $table->foreignId('bay_id')
                ->nullable()
                ->constrained('bays')
                ->nullOnDelete();

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('employees')
                ->nullOnDelete();

            $table->string('title', 150);

            $table->text('description')
                ->nullable();

            $table->string('status', 30)
                ->default('pending');

            $table->unsignedInteger('estimated_minutes')
                ->nullable();

            $table->unsignedInteger('actual_minutes')
                ->nullable();

            $table->decimal('labour_cost', 12, 2)
                ->nullable();

            $table->timestamp('started_at')
                ->nullable();

            $table->timestamp('completed_at')
                ->nullable();

            $table->text('notes')
                ->nullable();

            $table->timestamps();

            $table->index('job_card_id');
            $table->index('department_id');
            $table->index('assigned_to');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_card_tasks');
    }
};
