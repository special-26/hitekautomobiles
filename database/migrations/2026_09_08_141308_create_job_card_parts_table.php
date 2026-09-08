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
        Schema::create('job_card_parts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_card_id')
                ->constrained('job_cards')
                ->cascadeOnDelete();

            $table->foreignId('part_id')
                ->constrained('parts')
                ->restrictOnDelete();

            $table->foreignId('job_card_task_id')
                ->nullable()
                ->constrained('job_card_tasks')
                ->nullOnDelete();

            $table->decimal('quantity', 12, 2);

            $table->decimal('unit_price', 12, 2);

            $table->decimal('discount', 12, 2)
                ->default(0);

            $table->decimal('total', 12, 2);

            $table->enum('status', [
                'pending',
                'issued',
                'returned',
                'cancelled',
            ])->default('pending');

            $table->foreignUuid('issued_by')
                ->nullable()
                ->constrained('users', 'id')
                ->nullOnDelete();

            $table->timestamp('issued_at')
                ->nullable();

            $table->text('notes')
                ->nullable();

            $table->timestamps();

            $table->index('job_card_id');
            $table->index('part_id');
            $table->index('job_card_task_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_card_parts');
    }
};
