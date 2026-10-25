<?php

namespace App\Livewire\JobCards;

use App\Models\JobCard;
use Livewire\Component;

class History extends Component
{
    public $jobCard;

    public $history = [];

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
                'activities.creator',
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

        $this->history = $jobCard->activities
            ->sortByDesc('created_at')
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'type' => $activity->type,
                    'action' => $activity->action,
                    'description' => $activity->description,
                    'user' => $activity->creator?->name ?? 'System',
                    'role' => $activity->creator?->roles?->first()?->name ?? 'System',
                    'date' => $activity->created_at?->format('d M Y'),
                    'time' => $activity->created_at?->format('h:i A'),
                    'metadata' => $activity->metadata,
                ];
            })
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.job-cards.history')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['job_card_number'] . ' - History',
            ]);
    }
}
