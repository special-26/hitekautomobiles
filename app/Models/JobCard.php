<?php

namespace App\Models;

use App\Models\Bay;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\JobCardTask;
use App\Models\ServiceBooking;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCard extends Model
{
    protected $fillable = [
        'job_card_number',
        'customer_id',
        'vehicle_id',
        'department_id',
        'bay_id',
        'advisor_id',
        'complaint',
        'customer_notes',
        'estimated_cost',
        'estimated_completion_at',
        'status',
        'is_active',
    ];

    protected $casts = [
        'estimated_cost' => 'decimal:2',
        'estimated_completion_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function customer(): BelongsTo
    {
        return $this->belongsTo(
            Customer::class
        );
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(
            Vehicle::class
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

    public function advisor(): BelongsTo
    {
        return $this->belongsTo(
            Employee::class,
            'advisor_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Future Relationships
    |--------------------------------------------------------------------------
    |
    | These tables will be created later.
    |
    */

    public function tasks(): HasMany
    {
        return $this->hasMany(
            JobCardTask::class
        );
    }

    // public function assignments(): HasMany
    // {
    //     return $this->hasMany(JobCardAssignment::class);
    // }

    // public function parts(): HasMany
    // {
    //     return $this->hasMany(JobCardPart::class);
    // }

    // public function photos(): HasMany
    // {
    //     return $this->hasMany(JobCardPhoto::class);
    // }

    // public function statusHistory(): HasMany
    // {
    //     return $this->hasMany(JobCardStatusHistory::class);
    // }
}
