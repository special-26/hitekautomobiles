<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;

class Show extends Component
{
    public Customer $customer;

    public function mount(Customer $customer): void
    {
        $this->customer = $customer->load([
            'vehicles',
            'jobCards' => fn($query) => $query
                ->with(['vehicle'])
                ->latest('id'),
        ]);
    }

    public function render()
    {
        $summary = [
            'vehicles' => $this->customer->vehicles->count(),

            'total_visits' => $this->customer->jobCards->count(),

            'completed_visits' => $this->customer->jobCards
                ->where('status', 'completed')
                ->count(),

            'total_service_value' => $this->customer->jobCards
                ->sum(fn($jobCard) => (float) ($jobCard->final_amount ?? $jobCard->total_amount ?? 0)),

            'last_visit' => $this->customer->jobCards->first()?->created_at,
        ];


        return view('livewire.customers.show', [
            'summary' => $summary,
        ])->layout('components.layouts.management', [
            'title' => 'Customer Profile',
        ]);
    }
}
