<?php

namespace App\Models;

use App\Models\Department;
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
        'department_id',
        'description',
        'instructions',
        'estimated_minutes',
        'is_active',
    ];

    protected $casts = [
        'estimated_minutes' => 'integer',
        'is_active' => 'boolean',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(
            Department::class
        );
    }

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
