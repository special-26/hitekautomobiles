<?php

namespace App\Models;

use App\Models\JobCard;
use App\Models\ServiceBooking;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'user_id',
        'customer_code',
        'public_token',
        'name',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'pincode',
        'date_of_birth',
        'is_active',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(
            Vehicle::class
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
