<?php

namespace App\Services;

use App\Models\JobCardInvoice;
use Razorpay\Api\Api;
use RuntimeException;

class RazorpayPaymentService
{
    protected Api $razorpay;

    public function __construct()
    {
        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');

        if (!$key || !$secret) {
            throw new RuntimeException(
                'Razorpay credentials are not configured.'
            );
        }

        $this->razorpay = new Api($key, $secret);
    }

    /**
     * Create a Razorpay Payment Link.
     */
    public function createPaymentLink(
        float $amount,
        string $customerName,
        ?string $customerPhone = null,
        ?string $customerEmail = null,
        ?string $referenceId = null,
        ?string $description = null
    ): array {
        if ($amount <= 0) {
            throw new RuntimeException(
                'Payment amount must be greater than zero.'
            );
        }

        $paymentLinkData = [
            'amount' => (int) round($amount * 100),
            'currency' => 'INR',
            'accept_partial' => false,
            'description' => $description
                ?? 'Hitek Automobiles Final Bill',
            'reference_id' => $referenceId
                ?? uniqid('hitek_'),
            'customer' => [
                'name' => $customerName,
            ],
            'notify' => [
                'sms' => false,
                'email' => false,
            ],
            'reminder_enable' => false,
        ];

        if ($customerPhone) {
            $paymentLinkData['customer']['contact'] =
                $customerPhone;
        }

        if ($customerEmail) {
            $paymentLinkData['customer']['email'] =
                $customerEmail;
        }

        $paymentLink = $this->razorpay
            ->paymentLink
            ->create($paymentLinkData);

        return [
            'id' => $paymentLink['id'],
            'short_url' => $paymentLink['short_url'],
            'status' => $paymentLink['status'],
            'amount' => $paymentLink['amount'],
            'amount_in_rupees' => $paymentLink['amount'] / 100,
        ];
    }

    /**
     * Create or retrieve a payment link for an invoice.
     */
    public function getOrCreateInvoicePaymentLink(
        JobCardInvoice $invoice
    ): string {
        // Reuse an existing payment link if available
        if (
            $invoice->razorpay_payment_link_id &&
            $invoice->razorpay_payment_link_url &&
            $invoice->razorpay_payment_status !== 'paid'
        ) {
            return $invoice->razorpay_payment_link_url;
        }

        $jobCard = $invoice->jobCard;

        $customer = $jobCard?->customer;

        $customerName = $customer?->name ?? 'Customer';

        $customerPhone = $customer?->phone;

        $customerEmail = $customer?->email;

        $jobCardNumber = $jobCard?->job_card_number
            ?? $jobCard?->id
            ?? $invoice->job_card_id;

        $referenceId = 'INV-' . $invoice->id . '-' . time();

        $result = $this->createPaymentLink(
            amount: (float) $invoice->total,
            customerName: $customerName,
            customerPhone: $customerPhone,
            customerEmail: $customerEmail,
            referenceId: $referenceId,
            description: 'Hitek Automobiles Final Bill '
                . $jobCardNumber
        );

        $invoice->update([
            'razorpay_payment_link_id' => $result['id'],
            'razorpay_payment_link_url' => $result['short_url'],
            'razorpay_payment_status' => $result['status'],
            'razorpay_payment_link_created_at' => now(),
        ]);

        return $result['short_url'];
    }
}
