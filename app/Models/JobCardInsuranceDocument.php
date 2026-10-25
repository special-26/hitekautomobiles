<?php

namespace App\Models;

use App\Models\JobCardInsurance;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobCardInsuranceDocument extends Model
{
    protected $fillable = [
        'job_card_insurance_id',
        'document_type',
        'file_name',
        'file_path',
        'uploaded_by',
        'remarks',
    ];

    public function insurance(): BelongsTo
    {
        return $this->belongsTo(
            JobCardInsurance::class,
            'job_card_insurance_id'
        );
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'uploaded_by'
        );
    }
}
