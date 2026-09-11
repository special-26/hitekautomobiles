<?php

namespace App\Models;

use App\Models\Bay;
use App\Models\Department;
use App\Models\Employee;
use App\Models\JobCard;
use App\Models\JobCardPart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobCardTask extends Model
{
    protected $fillable = [
        'job_card_id',
        'department_id',
        'bay_id',
        'assigned_to',
        'title',
        'description',
        'status',
        'estimated_minutes',
        'actual_minutes',
        'labour_cost',
        'started_at',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'estimated_minutes' => 'integer',
        'actual_minutes' => 'integer',
        'labour_cost' => 'decimal:2',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function jobCard(): BelongsTo
    {
        return $this->belongsTo(
            JobCard::class
        );
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(
            Department::class
        );
    }

    public function bay(): BelongsTo
    {
        return $this->belongsTo(
            Bay::class
        );
    }

    public function assignedEmployee(): BelongsTo
    {
        return $this->belongsTo(
            Employee::class,
            'assigned_to'
        );
    }
    public function parts()
    {
        return $this->hasMany(JobCardPart::class, 'job_card_task_id');
    }
}
