<?php

namespace App\Services\WhatsApp;

use App\Models\JobCard;

class WhatsAppMessageService
{
    /**
     * Job Card Created
     */
    public function jobCardCreated(JobCard $jobCard): string
    {
        $customerName = $jobCard->customer?->name ?? 'Customer';

        $jobCardNumber = $jobCard->job_card_number
            ?? $jobCard->id;

        $vehicle = $jobCard->vehicle;

        $vehicleName = trim(
            ($vehicle?->make ?? '') . ' ' .
                ($vehicle?->model ?? '')
        );

        $registrationNumber =
            $vehicle?->registration_number ?? '';

        $vehicleText = trim(
            $vehicleName .
                ($registrationNumber
                    ? ' - ' . $registrationNumber
                    : '')
        );

        return "Hello {$customerName},

Your vehicle has been checked in at Hitek Automobiles.

Job Card: {$jobCardNumber}
Vehicle: {$vehicleText}

Our team has started working on your vehicle. We will keep you updated about the service.

Thank you,
Hitek Automobiles";
    }


    /**
     * Vehicle Ready
     */
    public function vehicleReady(JobCard $jobCard): string
    {
        $customerName = $jobCard->customer?->name ?? 'Customer';

        $jobCardNumber = $jobCard->job_card_number
            ?? $jobCard->id;

        $vehicle = $jobCard->vehicle;

        $vehicleName = trim(
            ($vehicle?->make ?? '') . ' ' .
                ($vehicle?->model ?? '')
        );

        return "Hello {$customerName},

Good news! Your vehicle {$vehicleName} is ready for delivery at Hitek Automobiles.

Job Card: {$jobCardNumber}

Thank you for choosing Hitek Automobiles.";
    }


    /**
     * Invoice Generated
     */
    public function invoiceGenerated(
        JobCard $jobCard,
        float $amount
    ): string {
        $customerName = $jobCard->customer?->name ?? 'Customer';

        $jobCardNumber = $jobCard->job_card_number
            ?? $jobCard->id;

        return "Hello {$customerName},

Your Hitek Automobiles invoice has been generated.

Job Card: {$jobCardNumber}
Amount: ₹" . number_format($amount, 2) . "

Thank you for choosing Hitek Automobiles.";
    }

/**
 * Estimate Bill
 */
public function estimateBill(JobCard $jobCard): string
{
    $customerName = $jobCard->customer?->name ?? 'Customer';

    $jobCardNumber = $jobCard->job_card_number
        ?? $jobCard->id;

    $vehicle = $jobCard->vehicle;

    $vehicleName = trim(
        ($vehicle?->make ?? '') . ' ' .
        ($vehicle?->model ?? '')
    );

    $registrationNumber =
        $vehicle?->registration_number ?? '';

    $estimate = $jobCard->estimates()
        ->latest()
        ->first();

    if (!$estimate) {
        return "Hello {$customerName},

Estimate is not available for Job Card {$jobCardNumber}.

Thank you,
Hitek Automobiles";
    }

    return "Hello {$customerName},

Here is the estimate for your vehicle from Hitek Automobiles.

Job Card: {$jobCardNumber}
Vehicle: {$vehicleName}
Registration: {$registrationNumber}

Estimate Number: {$estimate->estimate_number}
Subtotal: ₹" . number_format((float) $estimate->subtotal, 2) . "
Discount: ₹" . number_format((float) $estimate->discount, 2) . "
Tax: ₹" . number_format((float) $estimate->tax, 2) . "

Estimated Total: ₹" . number_format((float) $estimate->total, 2) . "

Please review the estimate and contact us if you have any questions.

Thank you,
Hitek Automobiles";
}


/**
 * Final Bill
 */
public function finalBill(JobCard $jobCard): string
{
    $customerName = $jobCard->customer?->name ?? 'Customer';

    $jobCardNumber = $jobCard->job_card_number
        ?? $jobCard->id;

    $vehicle = $jobCard->vehicle;

    $vehicleName = trim(
        ($vehicle?->make ?? '') . ' ' .
        ($vehicle?->model ?? '')
    );

    $registrationNumber =
        $vehicle?->registration_number ?? '';

    $invoice = $jobCard->invoices()
        ->latest()
        ->first();

    if (!$invoice) {
        return "Hello {$customerName},

Final bill is not available for Job Card {$jobCardNumber}.

Thank you,
Hitek Automobiles";
    }

    return "Hello {$customerName},

Your final bill from Hitek Automobiles is ready.

Job Card: {$jobCardNumber}
Vehicle: {$vehicleName}
Registration: {$registrationNumber}

Invoice Number: {$invoice->invoice_number}
Subtotal: ₹" . number_format((float) $invoice->subtotal, 2) . "
Discount: ₹" . number_format((float) $invoice->discount, 2) . "
Tax: ₹" . number_format((float) $invoice->tax, 2) . "

Final Total: ₹" . number_format((float) $invoice->total, 2) . "

Thank you for choosing Hitek Automobiles.";
}

}
