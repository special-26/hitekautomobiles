<?php

namespace App\Models;

use App\Models\EmployeeAttendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shift extends Model
{
    protected $fillable =
    [
        'name',
        'code',
        'start_time',
        'end_time',
        'is_active',
    ];

    protected function casts(): array
    {
        return
            ['is_active' => 'boolean',];
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(EmployeeAttendance::class);
    }
}
