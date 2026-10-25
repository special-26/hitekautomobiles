<?php

namespace App\Models;

use App\Models\JobCardInsurance;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobCardInsuranceActivity extends Model
{
    protected $fillable = [
        'job_card_insurance_id',
        'activity_type',
        'description',
        'old_status',
        'new_status',
        'created_by',
    ];

    public function insurance(): BelongsTo
    {
        return $this->belongsTo(
            JobCardInsurance::class,
            'job_card_insurance_id'
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
}
