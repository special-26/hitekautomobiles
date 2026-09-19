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
        Schema::table('job_card_tasks', function (Blueprint $table) {
            $table->foreignId('service_task_id')
                ->nullable()
                ->after('job_card_id')
                ->constrained('service_tasks')
                ->nullOnDelete();

            $table->index('service_task_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_card_tasks', function (Blueprint $table) {
            $table->dropForeign(['service_task_id']);
            $table->dropIndex(['service_task_id']);
            $table->dropColumn('service_task_id');
        });
    }
};
