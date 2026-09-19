<?php

namespace App\Models;

use App\Models\JobCardTask;
use App\Models\Part;
use App\Models\PartCategory;
use App\Models\ServiceTaskPart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'part_category_id',
        'description',
        'instructions',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Primary category of the service task.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(
            PartCategory::class,
            'part_category_id'
        );
    }

    /**
     * Suggested parts configured by Admin.
     */
    public function taskParts(): HasMany
    {
        return $this->hasMany(
            ServiceTaskPart::class,
            'service_task_id'
        );
    }

    /**
     * Parts suggested for this task.
     */
    public function parts(): BelongsToMany
    {
        return $this->belongsToMany(
            Part::class,
            'service_task_parts',
            'service_task_id',
            'part_id'
        )->withPivot([
            'default_quantity',
            'is_required',
        ])->withTimestamps();
    }

    /**
     * Customer job card tasks created from this template.
     */
    public function jobCardTasks(): HasMany
    {
        return $this->hasMany(
            JobCardTask::class,
            'service_task_id'
        );
    }
}
