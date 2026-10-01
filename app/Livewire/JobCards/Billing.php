<?php

namespace App\Livewire\JobCards;

use Livewire\Component;

class Billing extends Component
{
    public $jobCard;

    public $estimate;

    public $invoice;

    public $estimateItems = [];

    public $invoiceItems = [];

    public function mount($jobCard)
    {
        $this->jobCard = [
            'id' => $jobCard,
            'vehicle_no' => 'CH01BT9020',
            'vehicle' => 'Hyundai Creta 1.6',
            'customer' => 'Mrs. Indu Narula',
        ];

        $this->estimate = [
            'number' => 'EST-13887',
            'date' => '23 Sep 2026',
            'status' => 'Approved',
            'subtotal' => 38500,
            'discount' => 1500,
            'tax' => 6660,
            'total' => 43660,
        ];

        $this->invoice = [
            'number' => 'INV-13887',
            'date' => '26 Sep 2026',
            'status' => 'Partially Paid',
            'subtotal' => 41200,
            'discount' => 1500,
            'tax' => 7146,
            'total' => 46846,
            'paid' => 35000,
            'due' => 11846,
        ];

        $this->estimateItems = [
            [
                'type' => 'Labour',
                'description' => 'Periodic Service Labour',
                'quantity' => 1,
                'rate' => 8500,
                'amount' => 8500,
            ],
            [
                'type' => 'Labour',
                'description' => 'Brake Inspection & Service',
                'quantity' => 1,
                'rate' => 2500,
                'amount' => 2500,
            ],
            [
                'type' => 'Part',
                'description' => 'Engine Oil 5W30',
                'quantity' => 1,
                'rate' => 2850,
                'amount' => 2850,
            ],
            [
                'type' => 'Part',
                'description' => 'Oil Filter',
                'quantity' => 1,
                'rate' => 650,
                'amount' => 650,
            ],
            [
                'type' => 'Part',
                'description' => 'Front Brake Pad Set',
                'quantity' => 1,
                'rate' => 4250,
                'amount' => 4250,
            ],
        ];

        $this->invoiceItems = [
            [
                'type' => 'Labour',
                'description' => 'Periodic Service Labour',
                'quantity' => 1,
                'rate' => 8500,
                'amount' => 8500,
            ],
            [
                'type' => 'Labour',
                'description' => 'Brake Inspection & Service',
                'quantity' => 1,
                'rate' => 2500,
                'amount' => 2500,
            ],
            [
                'type' => 'Labour',
                'description' => 'Wheel Alignment',
                'quantity' => 1,
                'rate' => 1200,
                'amount' => 1200,
            ],
            [
                'type' => 'Part',
                'description' => 'Engine Oil 5W30',
                'quantity' => 1,
                'rate' => 2850,
                'amount' => 2850,
            ],
            [
                'type' => 'Part',
                'description' => 'Oil Filter',
                'quantity' => 1,
                'rate' => 650,
                'amount' => 650,
            ],
            [
                'type' => 'Part',
                'description' => 'Front Brake Pad Set',
                'quantity' => 1,
                'rate' => 4250,
                'amount' => 4250,
            ],
            [
                'type' => 'Service',
                'description' => 'AC Inspection',
                'quantity' => 1,
                'rate' => 1500,
                'amount' => 1500,
            ],
        ];
    }

    public function render()
    {
        return view('livewire.job-cards.billing')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['id'] . ' - Billing',
            ]);
    }
}
