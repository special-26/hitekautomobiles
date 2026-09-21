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
        Schema::create('job_card_invoice_share_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_card_invoice_id')
                ->constrained('job_card_invoices')
                ->cascadeOnDelete();

            $table->uuid('shared_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('share_type');
            // estimate / final

            $table->string('channel')->default('whatsapp');

            $table->boolean('payment_link_included')
                ->default(false);

            $table->timestamp('shared_at');

            $table->timestamps();

            $table->index('job_card_invoice_id');
            $table->index('shared_by');
            $table->index('share_type');
            $table->index('shared_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_card_invoice_share_activities');
    }
};
