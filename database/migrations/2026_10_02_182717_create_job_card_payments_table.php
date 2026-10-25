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
        Schema::create('job_card_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_card_invoice_id')
                ->constrained('job_card_invoices')
                ->cascadeOnDelete();

            $table->string('receipt_number')->unique();

            $table->decimal('amount', 12, 2);

            $table->string('payment_method', 30);

            $table->string('reference')->nullable();

            $table->timestamp('payment_date');

            $table->string('status', 30)->default('success');

            $table->uuid('received_by')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['job_card_invoice_id', 'payment_date']);
            $table->index('status');

            $table->foreign('received_by')
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
        Schema::dropIfExists('job_card_payments');
    }
};
