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
}
