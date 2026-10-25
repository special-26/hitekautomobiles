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
        'hsn_sac',
        'taxable_amount',
        'cgst_rate',
        'cgst_amount',
        'sgst_rate',
        'sgst_amount',
        'igst_rate',
        'igst_amount',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'taxable_amount' => 'decimal:2',
        'cgst_rate' => 'decimal:2',
        'cgst_amount' => 'decimal:2',
        'sgst_rate' => 'decimal:2',
        'sgst_amount' => 'decimal:2',
        'igst_rate' => 'decimal:2',
        'igst_amount' => 'decimal:2',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(
            JobCardInvoice::class,
            'job_card_invoice_id'
        );
    }
}
