<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyHoliday extends Model
{
    protected $fillable = [
        'name',
        'holiday_date',
        'is_paid',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'holiday_date' => 'date',
            'is_paid' => 'boolean',
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
