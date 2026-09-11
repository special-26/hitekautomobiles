<?php

namespace App\Models;

use App\Models\JobCardInvoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobCardInvoiceItem extends Model
{
    protected $fillable = [
        'job_card_invoice_id',
        'item_type',
        'description',
        'quantity',
        'unit_price',
        'discount',
        'total',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(
            JobCardInvoice::class,
            'job_card_invoice_id'
        );
    }
}
