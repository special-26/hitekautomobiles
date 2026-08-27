<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\JobCard;
use App\Models\ServiceBooking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $fillable = [
        'customer_id',
        'registration_number',
        'make',
        'model',
        'variant',
        'fuel_type',
        'manufacturing_year',
        'color',
        'vin',
        'engine_number',
        'current_odometer',
        'is_active',
    ];

    protected $casts = [
        'manufacturing_year' => 'integer',
        'current_odometer' => 'integer',
        'is_active' => 'boolean',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(
            Customer::class
        );
    }

    public function serviceBookings(): HasMany
    {
        return $this->hasMany(ServiceBooking::class);
    }

    public function jobCards(): HasMany
    {
        return $this->hasMany(JobCard::class);
    }
}
