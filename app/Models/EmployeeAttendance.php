<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeAttendance extends Model
{
    protected $fillable = [
        'employee_id',
        'shift_id',
        'attendance_date',
        'shift',
        'check_in_at',
        'check_out_at',
        'status',
        'is_late',
        'left_early',
        'notes',
        'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'attendance_date' => 'date',
            'check_in_at' => 'datetime',
            'check_out_at' => 'datetime',
            'is_late' => 'boolean',
            'left_early' => 'boolean',
        ];
    }

    public function shiftRelation(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function getWorkingMinutesAttribute(): ?int
    {
        if (!$this->check_in_at || !$this->check_out_at) {
            return null;
        }

        return max(
            0,
            (int) $this->check_in_at->diffInMinutes($this->check_out_at, false)
        );
    }

    public function getWorkingHoursFormattedAttribute(): string
    {
        $minutes = $this->working_minutes;

        if ($minutes === null) {
            return '—';
        }

        $hours = intdiv($minutes, 60);
        $remainingMinutes = $minutes % 60;

        return sprintf('%d h %02d min', $hours, $remainingMinutes);
    }
}
