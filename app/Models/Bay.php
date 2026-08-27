<?php

namespace App\Models;

use App\Models\Department;
use App\Models\JobCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bay extends Model
{
    protected $fillable = [
        'name',
        'code',
        'department_id',
        'type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(
            Department::class
        );
    }

    public function jobCards(): HasMany
    {
        return $this->hasMany(JobCard::class);
    }
}
