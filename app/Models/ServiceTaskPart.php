<?php

namespace App\Models;

use App\Models\Part;
use App\Models\ServiceTask;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceTaskPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_task_id',
        'part_id',
        'default_quantity',
        'is_required',
    ];

    protected $casts = [
        'default_quantity' => 'integer',
        'is_required' => 'boolean',
    ];

    /**
     * Predefined service task.
     */
    public function serviceTask(): BelongsTo
    {
        return $this->belongsTo(
            ServiceTask::class,
            'service_task_id'
        );
    }

    /**
     * Suggested part.
     */
    public function part(): BelongsTo
    {
        return $this->belongsTo(
            Part::class,
            'part_id'
        );
    }
}
