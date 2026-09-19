<?php

namespace App\Models;

use App\Models\JobCard;
use App\Models\JobCardPart;
use App\Models\JobCardTask;
use App\Models\Part;
use App\Models\StoreManagerActivity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCardPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_card_id',
        'part_id',
        'job_card_task_id',
        'quantity',
        'unit_price',
        'discount',
        'total',
        'status',
        'issued_by',
        'issued_at',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'issued_at' => 'datetime',
    ];

    public function jobCard()
    {
        return $this->belongsTo(JobCard::class);
    }

    public function part()
    {
        return $this->belongsTo(Part::class);
    }

    public function parts(): HasMany
    {
        return $this->hasMany(
            JobCardPart::class,
            'job_card_task_id'
        );
    }

    public function task()
    {
        return $this->belongsTo(
            JobCardTask::class,
            'job_card_task_id'
        );
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(StoreManagerActivity::class);
    }
}
