<?php

namespace App\Models;

use App\Models\JobCardInvoice;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobCardInvoiceShareActivity extends Model
{
    protected $fillable = [
        'job_card_invoice_id',
        'shared_by',
        'share_type',
        'channel',
        'payment_link_included',
        'shared_at',
    ];

    protected $casts = [
        'payment_link_included' => 'boolean',
        'shared_at' => 'datetime',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(
            JobCardInvoice::class,
            'job_card_invoice_id'
        );
    }

    public function sharedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'shared_by'
        );
    }
}
