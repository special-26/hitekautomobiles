<?php

namespace App\Models;

use App\Models\JobCardPart;
use App\Models\PartCategory;
use App\Models\ServiceTask;
use App\Models\StockMovement;
use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Part extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_number',
        'name',
        'part_category_id',
        'category',
        'brand',
        'unit',
        'cost_price',
        'selling_price',
        'current_stock',
        'minimum_stock',
        'is_active',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'current_stock' => 'decimal:2',
        'minimum_stock' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(PartCategory::class, 'part_category_id');
    }

    public function vehicleModels(): BelongsToMany
    {
        return $this->belongsToMany(
            VehicleModel::class,
            'model_parts',
            'part_id',
            'vehicle_model_id'
        )->withTimestamps();
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function jobCardParts()
    {
        return $this->hasMany(JobCardPart::class);
    }


    public function serviceTasks(): BelongsToMany
    {
        return $this->belongsToMany(
            ServiceTask::class,
            'service_task_parts',
            'part_id',
            'service_task_id'
        )->withPivot([
            'default_quantity',
            'is_required',
        ])->withTimestamps();
    }

    public function partCategory(): BelongsTo
    {
        return $this->belongsTo(
            PartCategory::class,
            'part_category_id'
        );
    }
}
