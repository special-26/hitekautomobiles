<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceBooking extends Model
{
    protected $fillable = [
        'customer_name',
        'phone',
        'email',
        'service_date',
        'slot_key',
        'service_type',
        'notes',
        'status',
        'pickup_drop_required',
        'pickup_address',
        'pickup_time',
    ];

    protected $casts = [
        'service_date' => 'date',
        'pickup_drop_required' => 'boolean',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
