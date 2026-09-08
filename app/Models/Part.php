<?php

namespace App\Models;

use App\Models\JobCardPart;
use App\Models\StockMovement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_number',
        'name',
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

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function jobCardParts()
    {
        return $this->hasMany(JobCardPart::class);
    }
}
