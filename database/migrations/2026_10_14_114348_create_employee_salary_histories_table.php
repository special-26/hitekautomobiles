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
        Schema::create('employee_salary_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnDelete();

            // Salary components (monthly amounts in INR)
            $table->decimal('basic_salary', 12, 2)->default(0);
            $table->decimal('hra', 12, 2)->default(0);
            $table->decimal('transport_allowance', 12, 2)->default(0);
            $table->decimal('other_allowances', 12, 2)->default(0);

            // Recurring deductions, if applicable
            $table->decimal('other_deductions', 12, 2)->default(0);

            // Effective period
            $table->date('effective_from');
            $table->date('effective_to')->nullable();

            $table->text('notes')->nullable();

            // Who created this salary record
            $table->uuid('created_by')->nullable();

            $table->timestamps();

            $table->index(['employee_id', 'effective_from']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_salary_histories');
    }
};
