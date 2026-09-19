<?php

namespace App\Models;

use App\Models\Part;
use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModelPart extends Model
{
    use HasFactory;

    protected $table = 'model_parts';

    protected $fillable = [
        'vehicle_model_id',
        'part_id',
    ];

    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, 'vehicle_model_id');
    }

    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }
}
