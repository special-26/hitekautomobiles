<?php

namespace App\Models;

use App\Models\Bay;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\JobCardActivity;
use App\Models\JobCardEstimate;
use App\Models\JobCardImage;
use App\Models\JobCardInsurance;
use App\Models\JobCardInvoice;
use App\Models\JobCardTask;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'customer_source',
        'odometer',
        'fuel_level',
        'arrived_at',
        'estimated_cost',
        'estimated_completion_at',
        'status',
        'is_active',
    ];

    protected $casts = [
        'odometer' => 'integer',
        'estimated_cost' => 'decimal:2',
        'arrived_at' => 'datetime',
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

    public function parts(): HasMany
    {
        return $this->hasMany(JobCardPart::class);
    }

    public function estimates(): HasMany
    {
        return $this->hasMany(JobCardEstimate::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(JobCardInvoice::class);
    }

    public function insurance(): HasOne
    {
        return $this->hasOne(JobCardInsurance::class);
    }

    public function images()
    {
        return $this->hasMany(JobCardImage::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(JobCardActivity::class);
    }
}
