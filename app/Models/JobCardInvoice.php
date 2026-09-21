<?php

namespace App\Models;

use App\Models\JobCardInvoiceItem;
use App\Models\JobCardInvoiceShareActivity;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCardInvoice extends Model
{
    protected $fillable = [
        'job_card_id',
        'invoice_number',
        'subtotal',
        'discount',
        'tax',
        'total',
        'status',
        'created_by',

        'approval_status',
        'approved_at',
        'approved_by',

        // Razorpay payment fields
        'razorpay_payment_link_id',
        'razorpay_payment_link_url',
        'razorpay_payment_status',
        'razorpay_payment_link_created_at',
        'razorpay_paid_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',

        'approved_at' => 'datetime',

        'razorpay_payment_link_created_at' => 'datetime',
        'razorpay_paid_at' => 'datetime',
    ];

    public function jobCard(): BelongsTo
    {
        return $this->belongsTo(JobCard::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(JobCardInvoiceItem::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function shareActivities(): HasMany
    {
        return $this->hasMany(
            JobCardInvoiceShareActivity::class,
            'job_card_invoice_id'
        );
    }
}
