<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingTemplate extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category',
        'format',
        'description',
        'occasion',
        'width',
        'height',
        'preview_path',
        'design',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'width' => 'integer',
            'height' => 'integer',
            'design' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
