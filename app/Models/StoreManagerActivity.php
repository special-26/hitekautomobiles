<?php

namespace App\Models;

use App\Models\JobCardPart;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreManagerActivity extends Model
{
    protected $fillable = [
        'job_card_part_id',
        'user_id',
        'action',
        'description',
    ];

    public function jobCardPart(): BelongsTo
    {
        return $this->belongsTo(JobCardPart::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
