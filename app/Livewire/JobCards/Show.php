<?php

namespace App\Livewire\JobCards;

use App\Models\JobCard;
use Livewire\Component;

class Show extends Component
{
    public $jobCard;

    public function mount($jobCard)
    {
        $this->loadJobCard($jobCard);
    }

    protected function loadJobCard($jobCardId)
    {
        $jobCard = JobCard::query()
            ->with([
                'customer',
                'vehicle',
                'insurance',
            ])
            ->findOrFail($jobCardId);

        $this->jobCard = [
            'id' => $jobCard->id,

            'job_card_number' => $jobCard->job_card_number,

            'vehicle_no' => $jobCard->vehicle->registration_number,

            'vehicle' => trim(
                $jobCard->vehicle->make . ' ' .
                    $jobCard->vehicle->model
            ),

            'customer' => $jobCard->customer->name,

            'phone' => $jobCard->customer->phone,

            /*
             * Employees module is not implemented yet,
             * so advisor_id is currently null.
             */
            'advisor' => 'Not Assigned',

            'created_at' => $jobCard->created_at
                ? $jobCard->created_at->format('d M Y · h:i A')
                : 'Not Available',

            'status' => $this->formatStatus($jobCard->status),

            'km' => $jobCard->odometer
                ? number_format($jobCard->odometer)
                : 'Not Available',

            'arrival_date' => $jobCard->arrived_at
                ? $jobCard->arrived_at->format('d M Y')
                : 'Not Available',

            'delivery_date' => $jobCard->estimated_completion_at
                ? $jobCard->estimated_completion_at->format('d M Y')
                : 'Not Available',

            /*
             * Billing will be connected when the Billing
             * module is connected to the real database.
             */
            'estimate' => 'Not Available',
            'paid' => 'Not Available',
            'due' => 'Not Available',

            'customer_source' => $jobCard->customer_source
                ?? 'Not Available',

            'insurance' => $jobCard->insurance?->insurance_company
                ?? 'No Insurance',

            'insurance_claim_status' => $jobCard->insurance?->claim_status,

            'insurance_policy_number' => $jobCard->insurance?->policy_number,

        ];
    }

    protected function formatStatus(?string $status): string
    {
        return match ($status) {
            'draft' => 'Draft',
            'pending' => 'Pending',
            'in_progress' => 'Under Service',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            default => $status
                ? ucwords(str_replace('_', ' ', $status))
                : 'Unknown',
        };
    }

    public function render()
    {
        return view('livewire.job-cards.show')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['job_card_number'],
            ]);
    }
}
