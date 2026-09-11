<?php

namespace App\Models;

use App\Models\JobCard;
use App\Models\JobCardEstimateItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCardEstimate extends Model
{
    protected $fillable = [
        'job_card_id',
        'estimate_number',
        'subtotal',
        'discount',
        'tax',
        'total',
        'status',
        'created_by',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function jobCard(): BelongsTo
    {
        return $this->belongsTo(JobCard::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(JobCardEstimateItem::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
