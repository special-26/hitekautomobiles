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
        Schema::create('job_card_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_card_id')
                ->constrained('job_cards')
                ->cascadeOnDelete();

            $table->string('invoice_number')->unique();

            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            $table->string('status')->default('draft');

            $table->string('approval_status')->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->uuid('approved_by')->nullable();
            $table->foreign('approved_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->string('razorpay_payment_link_id')->nullable();
            $table->text('razorpay_payment_link_url')->nullable();
            $table->string('razorpay_payment_status')->nullable();
            $table->timestamp('razorpay_payment_link_created_at')->nullable();
            $table->timestamp('razorpay_paid_at')->nullable();

            $table->uuid('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('job_card_id');
            $table->index('status');
            $table->index('razorpay_payment_link_id');
            $table->index('razorpay_payment_status');
            $table->index('approval_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_card_invoices');
    }
};
