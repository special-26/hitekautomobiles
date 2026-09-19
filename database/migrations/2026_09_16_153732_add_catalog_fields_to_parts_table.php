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
        Schema::table('parts', function (Blueprint $table) {
            $table->foreignId('part_category_id')
                ->nullable()
                ->after('category')
                ->constrained('part_categories')
                ->nullOnDelete();

            $table->string('image')
                ->nullable()
                ->after('brand');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parts', function (Blueprint $table) {
            $table->dropForeign(['part_category_id']);
            $table->dropColumn([
                'part_category_id',
                'image',
            ]);
        });
    }
};
