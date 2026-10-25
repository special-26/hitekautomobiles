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
        Schema::create('job_card_insurance_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_card_insurance_id')
                ->constrained('job_card_insurances')
                ->cascadeOnDelete();

            $table->string('activity_type');

            $table->text('description');

            $table->string('old_status')->nullable();

            $table->string('new_status')->nullable();

            $table->uuid('created_by')->nullable();

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();


            $table->timestamps();

            $table->index('activity_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_card_insurance_activities');
    }
};
