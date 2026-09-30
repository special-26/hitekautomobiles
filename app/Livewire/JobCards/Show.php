<?php

namespace App\Livewire\JobCards;

use Livewire\Component;

class Show extends Component
{
    public $jobCard;

    public function mount($jobCard)
    {
        $this->jobCard = [
            'id' => $jobCard,
            'vehicle_no' => 'CH01BT9020',
            'vehicle' => 'Hyundai Creta 1.6',
            'customer' => 'Mrs. Indu Narula',
            'phone' => '9256681776',
            'advisor' => 'Basant Joshi',
            'status' => 'Under Service',
            'km' => '138,884',
            'arrival_date' => '23 Sep 2026',
            'delivery_date' => '26 Sep 2026',
            'estimate' => '₹47,234',
            'paid' => '₹35,234',
            'due' => '₹12,000',
            'customer_source' => 'National Insurance Co. Ltd.',
            'insurance' => 'National Insurance',
        ];
    }

    public function render()
    {
        return view('livewire.job-cards.show')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['id'],
            ]);
    }
}
