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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnDelete();

            // Payroll period
            $table->unsignedTinyInteger('month');
            $table->unsignedSmallInteger('year');

            // Salary snapshot at calculation time
            $table->decimal('basic_salary', 12, 2)->default(0);
            $table->decimal('hra', 12, 2)->default(0);
            $table->decimal('transport_allowance', 12, 2)->default(0);
            $table->decimal('other_allowances', 12, 2)->default(0);
            $table->decimal('other_deductions', 12, 2)->default(0);
            $table->decimal('gross_salary', 12, 2)->default(0);

            // Attendance and salary calculation snapshot
            $table->unsignedSmallInteger('working_days')->default(0);
            $table->decimal('present_days', 6, 2)->default(0);
            $table->decimal('absent_days', 6, 2)->default(0);
            $table->decimal('half_days', 6, 2)->default(0);
            $table->decimal('paid_leave_days', 6, 2)->default(0);
            $table->decimal('unpaid_leave_days', 6, 2)->default(0);

            $table->decimal('per_day_salary', 12, 2)->default(0);
            $table->decimal('absence_deduction', 12, 2)->default(0);
            $table->decimal('half_day_deduction', 12, 2)->default(0);
            $table->decimal('leave_deduction', 12, 2)->default(0);
            $table->decimal('total_deductions', 12, 2)->default(0);
            $table->decimal('net_salary', 12, 2)->default(0);

            // Workflow
            $table->string('status')->default('draft');
            $table->foreignUuid('calculated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignUuid('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('calculated_at')->nullable();
            $table->timestamp('approved_at')->nullable();

            // Payment tracking
            $table->string('payment_status')->default('unpaid');
            $table->timestamp('paid_at')->nullable();
            $table->string('payment_reference')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(
                ['employee_id', 'month', 'year'],
                'payroll_employee_period_unique'
            );

            $table->index(['year', 'month', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
