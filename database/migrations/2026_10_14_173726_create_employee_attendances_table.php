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
        Schema::create('employee_attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnDelete();

            $table->date('attendance_date');

            // Team A: 06:00–14:00; Team B: 14:00–22:00
            $table->string('shift', 20)->nullable();

            $table->timestampTz('check_in_at')->nullable();
            $table->timestampTz('check_out_at')->nullable();

            $table->string('status', 20)->default('present');

            $table->boolean('is_late')->default(false);
            $table->boolean('left_early')->default(false);

            $table->text('notes')->nullable();

            // User who recorded or last manually corrected attendance
            $table->uuid('recorded_by')->nullable();

            $table->timestamps();

            // One attendance record per employee per working date
            $table->unique(
                ['employee_id', 'attendance_date'],
                'employee_attendance_employee_date_unique'
            );

            $table->index(['attendance_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_attendances');
    }
};
