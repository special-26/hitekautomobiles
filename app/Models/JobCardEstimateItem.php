<?php

namespace App\Models;

use App\Models\JobCardEstimate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobCardEstimateItem extends Model
{
    protected $fillable = [
        'job_card_estimate_id',
        'item_type',
        'description',
        'quantity',
        'unit_price',
        'discount',
        'total',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function estimate(): BelongsTo
    {
        return $this->belongsTo(
            JobCardEstimate::class,
            'job_card_estimate_id'
        );
    }
}
