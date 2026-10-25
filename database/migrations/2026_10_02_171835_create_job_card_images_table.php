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
        Schema::create('job_card_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_card_id')
                ->constrained('job_cards')
                ->cascadeOnDelete();

            $table->string('file_name');
            $table->string('file_path');

            $table->string('category', 50)->default('Other');

            $table->uuid('uploaded_by')
                ->nullable();

            $table->foreign('uploaded_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->index(['job_card_id', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_card_images');
    }
};
