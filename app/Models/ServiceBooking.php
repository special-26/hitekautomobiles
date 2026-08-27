<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceBooking extends Model
{
    protected $fillable = [
        'customer_id',
        'vehicle_id',
        'service_date',
        'slot_key',
        'service_type',
        'notes',
        'status',
    ];

    protected $casts = [
        'service_date' => 'date',
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
