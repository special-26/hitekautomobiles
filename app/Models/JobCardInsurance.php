<?php

namespace App\Models;

use App\Models\JobCard;
use App\Models\JobCardInsuranceActivity;
use App\Models\JobCardInsuranceDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCardInsurance extends Model
{
    protected $fillable = [
        'job_card_id',
        'insurance_company',
        'policy_number',
        'policy_type',
        'policy_start_date',
        'policy_end_date',
        'insured_name',
        'claim_number',
        'claim_date',
        'claim_type',
        'surveyor_name',
        'surveyor_phone',
        'claim_status',
        'cashless',
        'estimated_claim_amount',
        'approved_amount',
        'customer_contribution',
        'deductible',
        'remarks',
    ];

    protected $casts = [
        'policy_start_date' => 'date',
        'policy_end_date' => 'date',
        'claim_date' => 'date',
        'cashless' => 'boolean',
        'estimated_claim_amount' => 'decimal:2',
        'approved_amount' => 'decimal:2',
        'customer_contribution' => 'decimal:2',
        'deductible' => 'decimal:2',
    ];

    public function jobCard(): BelongsTo
    {
        return $this->belongsTo(JobCard::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(JobCardInsuranceDocument::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(JobCardInsuranceActivity::class);
    }
}
