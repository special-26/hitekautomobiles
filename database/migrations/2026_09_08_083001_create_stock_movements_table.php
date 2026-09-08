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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('part_id')
                ->constrained('parts')
                ->cascadeOnDelete();

            $table->enum('type', [
                'in',
                'out',
                'return',
                'adjustment',
            ]);

            $table->decimal('quantity', 12, 2);

            $table->decimal('previous_stock', 12, 2);
            $table->decimal('new_stock', 12, 2);

            $table->decimal('unit_cost', 12, 2)->nullable();

            $table->string('reference')->nullable();

            $table->text('notes')->nullable();

            $table->foreignUuid('created_by')
                ->nullable()
                ->constrained('users', 'id')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['part_id', 'type']);
            $table->index('created_by');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
