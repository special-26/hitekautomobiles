<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollSetting extends Model
{
    protected $fillable = [
        'weekly_off_days',
        'proration_method',
        'half_day_deduction_fraction',
        'deduct_absent_days',
        'deduct_half_days',
        'late_deduction_enabled',
    ];

    protected function casts(): array
    {
        return [
            'weekly_off_days' => 'array',
            'half_day_deduction_fraction' => 'decimal:2',
            'deduct_absent_days' => 'boolean',
            'deduct_half_days' => 'boolean',
            'late_deduction_enabled' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'weekly_off_days' => [0],
                'proration_method' => 'actual_working_days',
                'half_day_deduction_fraction' => 0.50,
                'deduct_absent_days' => true,
                'deduct_half_days' => true,
                'late_deduction_enabled' => false,
            ]
        );
    }
}
