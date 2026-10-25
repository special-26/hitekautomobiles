<?php

namespace App\Livewire\JobCards;

use App\Models\JobCard;
use Livewire\Component;

class Insurance extends Component
{
    public $jobCard;
    public $insurance;
    public $claim;

    public $documents = [];
    public $activities = [];

    public function mount($jobCard)
    {
        $this->loadJobCard($jobCard);
    }

    protected function loadJobCard($jobCardId): void
    {
        $jobCard = JobCard::query()
            ->with([
                'customer',
                'vehicle',
                'insurance.documents.uploader',
                'insurance.activities.creator',
            ])
            ->findOrFail($jobCardId);

        $this->jobCard = [
            'id' => $jobCard->id,
            'job_card_number' => $jobCard->job_card_number,
            'vehicle_no' => $jobCard->vehicle->registration_number,
            'vehicle' => trim(
                $jobCard->vehicle->make . ' ' . $jobCard->vehicle->model
            ),
            'customer' => $jobCard->customer->name,
        ];

        $this->loadInsurance($jobCard);
    }

    protected function loadInsurance(JobCard $jobCard): void
    {
        $insurance = $jobCard->insurance;

        if (! $insurance) {
            $this->insurance = null;
            $this->claim = null;
            $this->documents = [];
            $this->activities = [];

            return;
        }

        $this->insurance = [
            'company' => $insurance->insurance_company,
            'policy_number' => $insurance->policy_number,
            'policy_type' => $insurance->policy_type,
            'policy_start' => $insurance->policy_start_date?->format('d M Y'),
            'policy_expiry' => $insurance->policy_end_date?->format('d M Y'),
            'insured_declared_value' => $insurance->estimated_claim_amount,
            'customer_contribution' => $insurance->customer_contribution,
            'cashless' => $insurance->cashless,
        ];

        $this->claim = [
            'claim_number' => $insurance->claim_number,
            'status' => $insurance->claim_status,
            'intimation_date' => $insurance->claim_date?->format('d M Y'),
            'survey_date' => null,
            'approval_date' => null,
            'approved_amount' => $insurance->approved_amount,
            'surveyor_name' => $insurance->surveyor_name,
            'surveyor_phone' => $insurance->surveyor_phone,
            'remarks' => $insurance->remarks,
        ];

        $this->documents = $insurance->documents
            ->map(function ($document) {
                return [
                    'id' => $document->id,
                    'name' => $document->file_name,
                    'type' => strtoupper(
                        pathinfo($document->file_name, PATHINFO_EXTENSION)
                    ),
                    'uploaded_by' => $document->uploader?->name ?? 'Not Available',
                    'uploaded_at' => $document->created_at
                        ? $document->created_at->format('d M Y, h:i A')
                        : 'Not Available',
                    'status' => 'Uploaded',
                ];
            })
            ->toArray();

        $this->activities = $insurance->activities
            ->sortBy('created_at')
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'type' => $activity->activity_type,
                    'description' => $activity->description,
                    'old_status' => $activity->old_status,
                    'new_status' => $activity->new_status,
                    'created_by' => $activity->creator?->name ?? 'System',
                    'created_at' => $activity->created_at
                        ? $activity->created_at->format('d M Y, h:i A')
                        : 'Not Available',
                ];
            })
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.job-cards.insurance')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['job_card_number'] . ' - Insurance',
            ]);
    }
}
