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
        Schema::create('payroll_settings', function (Blueprint $table) {
            $table->id();

            // Weekly offs: Carbon day numbers (0 = Sunday, 6 = Saturday)
            $table->json('weekly_off_days')->default('[0]');

            // Salary calculation rules
            $table->string('proration_method')->default('actual_working_days');
            $table->decimal('half_day_deduction_fraction', 4, 2)->default(0.50);

            // Deduction policies
            $table->boolean('deduct_absent_days')->default(true);
            $table->boolean('deduct_half_days')->default(true);
            $table->boolean('late_deduction_enabled')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_settings');
    }
};
