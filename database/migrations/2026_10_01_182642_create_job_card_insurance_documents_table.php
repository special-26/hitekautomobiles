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
        Schema::create('job_card_insurance_documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_card_insurance_id')
                ->constrained('job_card_insurances')
                ->cascadeOnDelete();

            $table->string('document_type');

            $table->string('file_name');

            $table->string('file_path');

            $table->uuid('uploaded_by')->nullable();

            $table->foreign('uploaded_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->index('document_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_card_insurance_documents');
    }
};
