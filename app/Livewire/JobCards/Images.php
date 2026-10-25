<?php

namespace App\Livewire\JobCards;

use App\Models\JobCard;
use App\Models\JobCardImage;
use Livewire\Component;

class Images extends Component
{
    public $jobCard;

    public $images = [];

    public function mount($jobCard)
    {
        $this->loadJobCard($jobCard);
    }

    protected function loadJobCard($jobCardId): void
    {
        $jobCard = JobCard::query()
            ->with(['customer', 'vehicle'])
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

        $this->loadImages($jobCard->id);
    }

    protected function loadImages($jobCardId): void
    {
        $this->images = JobCardImage::query()
            ->where('job_card_id', $jobCardId)
            ->with('uploader')
            ->latest('id')
            ->get()
            ->map(function ($image) {
                return [
                    'id' => $image->id,
                    'name' => $image->file_name,
                    'category' => $image->category,
                    'uploaded_by' => $image->uploader?->name ?? 'Not Available',
                    'uploaded_at' => $image->created_at
                        ? $image->created_at->format('d M Y, h:i A')
                        : 'Not Available',

                    // Temporary preview URL.
                    // Actual file upload/storage will be implemented later.
                    'url' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=900&q=80',

                    'remarks' => $image->remarks,
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.job-cards.images')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['job_card_number'] . ' - Images',
            ]);
    }
}
