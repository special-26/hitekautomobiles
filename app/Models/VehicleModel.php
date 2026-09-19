<?php

namespace App\Models;

use App\Models\Part;
use App\Models\VehicleBrand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VehicleModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_brand_id',
        'name',
        'slug',
        'image',
        'fuel_types',
        'is_active',
    ];

    protected $casts = [
        'fuel_types' => 'array',
        'is_active' => 'boolean',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(VehicleBrand::class, 'vehicle_brand_id');
    }

    public function parts(): BelongsToMany
    {
        return $this->belongsToMany(
            Part::class,
            'model_parts',
            'vehicle_model_id',
            'part_id'
        )->withTimestamps();
    }
}
