<?php

namespace App\Livewire\JobCards;

use App\Models\JobCard;
use App\Models\JobCardInvoice;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public string $dateFilter = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }
    public function updatedDateFilter(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $jobCards = JobCard::query()
            ->with([
                'customer',
                'vehicle',
                'tasks',
                'advisor',
            ])
            ->when($this->search, function ($query) {
                $search = '%' . $this->search . '%';

                $query->where(function ($query) use ($search) {
                    $query->where('job_card_number', 'ilike', $search)
                        ->orWhereHas('customer', function ($query) use ($search) {
                            $query->where('name', 'ilike', $search)
                                ->orWhere('phone', 'ilike', $search);
                        })
                        ->orWhereHas('vehicle', function ($query) use ($search) {
                            $query->where('registration_number', 'ilike', $search)
                                ->orWhere('make', 'ilike', $search)
                                ->orWhere('model', 'ilike', $search);
                        });
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->dateFilter, function ($query) {
                match ($this->dateFilter) {
                    'today' => $query->whereDate('arrived_at', today()),

                    'yesterday' => $query->whereDate(
                        'arrived_at',
                        today()->subDay()
                    ),

                    'last_7_days' => $query->whereBetween('arrived_at', [
                        now()->subDays(6)->startOfDay(),
                        now()->endOfDay(),
                    ]),

                    'this_month' => $query->whereBetween('arrived_at', [
                        now()->startOfMonth(),
                        now()->endOfMonth(),
                    ]),

                    default => null,
                };
            })
            ->latest('id')
            ->paginate(20);

        $summary = [
            'under_servicing' => JobCard::where('status', 'in_progress')->count(),

            'next_day_delivery' => JobCard::whereDate(
                'estimated_completion_at',
                today()->addDay()
            )->count(),

            'upcoming_delivery' => JobCard::whereBetween('estimated_completion_at', [
                today()->addDays(2)->startOfDay(),
                now()->addDays(30)->endOfDay(),
            ])->count(),

            'ready_for_delivery' => JobCard::where('status', 'ready')->count(),

            'payment_processing' => JobCardInvoice::query()
                ->whereHas('jobCard')
                ->withSum([
                    'payments as paid_amount' => function ($query) {
                        $query->where('status', 'success');
                    }
                ], 'amount')
                ->get()
                ->filter(function ($invoice) {
                    return (float) $invoice->total > (float) ($invoice->paid_amount ?? 0);
                })
                ->count(),

            'completed_service' => JobCard::where('status', 'completed')->count(),
        ];

        return view('livewire.job-cards.index', [
            'jobCards' => $jobCards,
            'summary' => $summary,
        ])->layout('components.layouts.management', [
            'title' => 'Job Cards',
        ]);
    }
}
