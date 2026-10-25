<?php

namespace App\Livewire\JobCards;

use App\Models\JobCard;
use App\Models\JobCardPart;
use Livewire\Component;

class Parts extends Component
{
    public $jobCard;

    public $parts = [];

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
        ];

        $this->loadParts($jobCard->id);
    }

    protected function loadParts($jobCardId)
    {
        $this->parts = JobCardPart::query()
            ->where('job_card_id', $jobCardId)
            ->with([
                'part.category',
                'task',
                'issuedBy',
            ])
            ->orderBy('id')
            ->get()
            ->map(function ($jobCardPart) {
                return [
                    'id' => $jobCardPart->id,

                    'part_name' => $jobCardPart->part?->name
                        ?? 'Unknown Part',

                    'part_number' => $jobCardPart->part?->part_number
                        ?? 'Not Available',

                    'category' => $jobCardPart->part?->category?->name
                        ?? 'Uncategorized',

                    'task' => $jobCardPart->task?->title
                        ?? 'General',

                    'quantity' => $jobCardPart->quantity,

                    'unit' => $jobCardPart->part?->unit
                        ?? 'Piece',

                    'unit_price' => $jobCardPart->unit_price,

                    'total' => $jobCardPart->total,

                    'status' => $this->formatStatus(
                        $jobCardPart->status
                    ),

                    /*
                     * Request creator is not stored directly
                     * on job_card_parts.
                     */
                    'requested_by' => 'Not Available',

                    'issued_by' => $jobCardPart->issuedBy?->name,

                    'requested_at' => $jobCardPart->created_at
                        ? $jobCardPart->created_at->format('h:i A')
                        : null,

                    'issued_at' => $jobCardPart->issued_at
                        ? $jobCardPart->issued_at->format('h:i A')
                        : null,
                ];
            })
            ->toArray();
    }

    protected function formatStatus(?string $status): string
    {
        return match ($status) {
            'pending' => 'Pending',
            'requested' => 'Requested',
            'issued' => 'Issued',
            'returned' => 'Returned',
            'cancelled' => 'Cancelled',
            default => $status
                ? ucwords(str_replace('_', ' ', $status))
                : 'Unknown',
        };
    }

    public function render()
    {
        return view('livewire.job-cards.parts')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['job_card_number'] . ' - Parts',
            ]);
    }
}
