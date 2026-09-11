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
        Schema::create('store_manager_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_card_part_id')
                ->constrained('job_card_parts')
                ->cascadeOnDelete();

            $table->foreignUuid('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('action');
            $table->text('description')->nullable();

            $table->timestamps();

            $table->index(['job_card_part_id', 'action']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_manager_activities');
    }
};
