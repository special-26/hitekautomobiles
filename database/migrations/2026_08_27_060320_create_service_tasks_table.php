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
        Schema::create('service_tasks', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();

            $table->foreignId('part_category_id')
                ->nullable()
                ->constrained('part_categories')
                ->nullOnDelete();

            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();

            $table->text('description')->nullable();
            $table->text('instructions')->nullable();

            $table->unsignedInteger('estimated_minutes')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['is_active', 'part_category_id']);
            $table->index(['is_active', 'department_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_tasks');
    }
};
