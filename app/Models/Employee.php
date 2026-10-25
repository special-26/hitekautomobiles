<?php

namespace App\Models;

use App\Models\Department;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeBankAccount;
use App\Models\EmployeeDocument;
use App\Models\EmployeeLeaveRequest;
use App\Models\EmployeeSalaryHistory;
use App\Models\JobCard;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'employee_code',
        'shift_id',
        'phone',
        'designation',
        'joining_date',

        // HR Profile
        'date_of_birth',
        'gender',
        'address',
        'city',
        'state',
        'pincode',

        // Emergency Contact
        'emergency_contact_name',
        'emergency_contact_phone',

        'status',
    ];

    protected $casts = [
        'joining_date' => 'date',
        'date_of_birth' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(EmployeeLeaveRequest::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function jobCards(): HasMany
    {
        return $this->hasMany(
            JobCard::class,
            'advisor_id'
        );
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    public function bankAccounts(): HasMany
    {
        return $this->hasMany(EmployeeBankAccount::class);
    }

    public function salaryHistories(): HasMany
    {
        return $this->hasMany(EmployeeSalaryHistory::class)
            ->orderByDesc('effective_from');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(EmployeeAttendance::class)
            ->orderByDesc('attendance_date');
    }
}
