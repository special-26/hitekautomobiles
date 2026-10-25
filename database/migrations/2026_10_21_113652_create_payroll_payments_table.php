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
        Schema::create('payroll_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id')
                ->constrained('payrolls')
                ->restrictOnDelete();

            $table->decimal('amount', 12, 2);

            $table->date('payment_date');

            // advance, installment, final_settlement
            $table->string('payment_type')->default('installment');

            // cash, bank_transfer, upi, cheque, other
            $table->string('payment_method');

            $table->string('payment_reference')->nullable();
            $table->text('notes')->nullable();

            $table->foreignUuid('recorded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['payroll_id', 'payment_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_payments');
    }
};
