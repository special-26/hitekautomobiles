<?php

namespace App\Models;

use App\Models\JobCard;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobCardImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_card_id',
        'file_name',
        'file_path',
        'category',
        'uploaded_by',
        'remarks',
    ];

    public function jobCard(): BelongsTo
    {
        return $this->belongsTo(JobCard::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
