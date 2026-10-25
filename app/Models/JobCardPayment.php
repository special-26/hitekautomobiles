<?php

namespace App\Models;

use App\Models\JobCardInvoice;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobCardPayment extends Model
{
    protected $fillable = [
        'job_card_invoice_id',
        'receipt_number',
        'amount',
        'payment_method',
        'reference',
        'payment_date',
        'status',
        'received_by',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(JobCardInvoice::class, 'job_card_invoice_id');
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}
