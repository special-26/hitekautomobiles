<?php

namespace App\Models;

use App\Models\Part;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_id',
        'type',
        'quantity',
        'previous_stock',
        'new_stock',
        'unit_cost',
        'reference',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'previous_stock' => 'decimal:2',
        'new_stock' => 'decimal:2',
        'unit_cost' => 'decimal:2',
    ];

    public function part()
    {
        return $this->belongsTo(Part::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
