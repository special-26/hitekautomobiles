<?php

namespace App\Models;

use App\Models\JobCard;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobCardActivity extends Model
{
    protected $fillable = [
        'job_card_id',
        'type',
        'action',
        'description',
        'created_by',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function jobCard(): BelongsTo
    {
        return $this->belongsTo(JobCard::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
