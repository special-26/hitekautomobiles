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
        Schema::create('job_card_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_card_id')
                ->constrained('job_cards')
                ->cascadeOnDelete();

            $table->string('type', 50);

            $table->string('action');

            $table->text('description')->nullable();

            $table->uuid('created_by')->nullable();

            $table->json('metadata')->nullable();

            $table->timestamps();

            $table->index(['job_card_id', 'created_at']);
            $table->index('type');

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_card_activities');
    }
};
