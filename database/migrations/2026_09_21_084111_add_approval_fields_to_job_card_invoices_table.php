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
        Schema::table('job_card_invoices', function (Blueprint $table) {
            $table->string('approval_status')
                ->default('pending')
                ->after('status');

            $table->timestamp('approved_at')
                ->nullable()
                ->after('approval_status');

            $table->uuid('approved_by')
                ->nullable()
                ->after('approved_at');

            $table->foreign('approved_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->index('approval_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_card_invoices', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropIndex(['approval_status']);

            $table->dropColumn([
                'approval_status',
                'approved_at',
                'approved_by',
            ]);
        });
    }
};
