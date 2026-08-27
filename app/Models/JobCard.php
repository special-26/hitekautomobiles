<?php

namespace App\Models;

use App\Models\Bay;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\ServiceBooking;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobCard extends Model
{
    protected $fillable = [
        'job_card_number',
        'customer_id',
        'vehicle_id',
        'service_booking_id',
        'advisor_id',
        'bay_id',
        'complaint',
        'work_description',
        'estimated_cost',
        'estimated_completion_at',
        'status',
        'priority',
    ];

    protected $casts = [
        'estimated_cost' => 'decimal:2',
        'estimated_completion_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function serviceBooking(): BelongsTo
    {
        return $this->belongsTo(ServiceBooking::class);
    }

    public function advisor(): BelongsTo
    {
        return $this->belongsTo(
            Employee::class,
            'advisor_id'
        );
    }

    public function bay(): BelongsTo
    {
        return $this->belongsTo(Bay::class);
    }
}
