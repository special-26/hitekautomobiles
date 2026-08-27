<?php

namespace App\Models;

use App\Models\Department;
use App\Models\JobCard;
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
        'phone',
        'designation',
        'joining_date',
        'status',
    ];

    protected $casts = [
        'joining_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
}
