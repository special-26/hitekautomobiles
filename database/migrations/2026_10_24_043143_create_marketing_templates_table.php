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
        Schema::create('marketing_templates', function (Blueprint $table) {
            $table->id();

            // Template identification
            $table->string('name');
            $table->string('slug')->unique();

            // Gallery filters
            $table->string('category', 50);
            $table->string('format', 20);
            $table->text('description')->nullable();
            $table->string('occasion')->nullable();

            // Canvas dimensions
            $table->unsignedSmallInteger('width')->default(1080);
            $table->unsignedSmallInteger('height')->default(1080);

            // Artwork and editable design
            $table->string('preview_path')->nullable();
            $table->jsonb('design')->default('{}');

            // Publication status
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
            $table->index(['category', 'format']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_templates');
    }
};
