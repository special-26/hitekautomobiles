<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\PayrollPayment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'basic_salary',
        'hra',
        'transport_allowance',
        'other_allowances',
        'other_deductions',
        'gross_salary',
        'working_days',
        'present_days',
        'absent_days',
        'half_days',
        'paid_leave_days',
        'unpaid_leave_days',
        'unpaid_holiday_deduction',
        'per_day_salary',
        'absence_deduction',
        'half_day_deduction',
        'leave_deduction',
        'total_deductions',
        'net_salary',
        'status',
        'calculated_by',
        'approved_by',
        'calculated_at',
        'approved_at',
        'payment_status',
        'paid_at',
        'payment_reference',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'month' => 'integer',
            'year' => 'integer',
            'working_days' => 'integer',
            'basic_salary' => 'decimal:2',
            'hra' => 'decimal:2',
            'transport_allowance' => 'decimal:2',
            'other_allowances' => 'decimal:2',
            'other_deductions' => 'decimal:2',
            'gross_salary' => 'decimal:2',
            'present_days' => 'decimal:2',
            'absent_days' => 'decimal:2',
            'half_days' => 'decimal:2',
            'paid_leave_days' => 'decimal:2',
            'unpaid_leave_days' => 'decimal:2',
            'per_day_salary' => 'decimal:2',
            'absence_deduction' => 'decimal:2',
            'half_day_deduction' => 'decimal:2',
            'leave_deduction' => 'decimal:2',
            'total_deductions' => 'decimal:2',
            'net_salary' => 'decimal:2',
            'calculated_at' => 'datetime',
            'approved_at' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function calculatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'calculated_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(PayrollPayment::class);
    }

    public function getTotalPaidAttribute(): float
    {
        return (float) $this->payments()->sum('amount');
    }

    public function getRemainingBalanceAttribute(): float
    {
        return max(
            0,
            round(
                (float) $this->net_salary - $this->total_paid,
                2
            )
        );
    }
}
