<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
