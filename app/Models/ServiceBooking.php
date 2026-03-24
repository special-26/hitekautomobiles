<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    protected $fillable = [
        'service_date','slot_key',
        'customer_name','phone','email',
        'car_make','car_model','car_number',
        'service_type','notes','status',
    ];

    protected $casts = [
        'service_date' => 'date',
    ];
}
