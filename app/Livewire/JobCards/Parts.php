<?php

namespace App\Livewire\JobCards;

use Livewire\Component;

class Parts extends Component
{
    public $jobCard;

    public $parts = [];

    public function mount($jobCard)
    {
        $this->jobCard = [
            'id' => $jobCard,
            'vehicle_no' => 'CH01BT9020',
            'vehicle' => 'Hyundai Creta 1.6',
            'customer' => 'Mrs. Indu Narula',
        ];

        $this->parts = [
            [
                'id' => 1,
                'part_name' => 'Engine Oil 5W30',
                'part_number' => 'EO-5W30-4L',
                'category' => 'Lubricants',
                'task' => 'Periodic Service',
                'quantity' => 1,
                'unit' => '4 L',
                'unit_price' => 2850,
                'total' => 2850,
                'status' => 'Issued',
                'requested_by' => 'Rakesh Kumar',
                'issued_by' => 'Store Manager',
                'requested_at' => '10:05 AM',
                'issued_at' => '10:20 AM',
            ],
            [
                'id' => 2,
                'part_name' => 'Oil Filter',
                'part_number' => 'OF-HY-102',
                'category' => 'Filters',
                'task' => 'Periodic Service',
                'quantity' => 1,
                'unit' => 'Piece',
                'unit_price' => 650,
                'total' => 650,
                'status' => 'Pending',
                'requested_by' => 'Rakesh Kumar',
                'issued_by' => null,
                'requested_at' => '10:08 AM',
                'issued_at' => null,
            ],
            [
                'id' => 3,
                'part_name' => 'Front Brake Pad Set',
                'part_number' => 'BP-CRETA-F',
                'category' => 'Brakes',
                'task' => 'Brake Inspection',
                'quantity' => 1,
                'unit' => 'Set',
                'unit_price' => 4250,
                'total' => 4250,
                'status' => 'Requested',
                'requested_by' => 'Amit Kumar',
                'issued_by' => null,
                'requested_at' => '11:15 AM',
                'issued_at' => null,
            ],
            [
                'id' => 4,
                'part_name' => 'AC Filter',
                'part_number' => 'ACF-CRETA-01',
                'category' => 'AC',
                'task' => 'AC Performance Check',
                'quantity' => 1,
                'unit' => 'Piece',
                'unit_price' => 850,
                'total' => 850,
                'status' => 'Pending',
                'requested_by' => 'Sandeep Singh',
                'issued_by' => null,
                'requested_at' => '11:40 AM',
                'issued_at' => null,
            ],
            [
                'id' => 5,
                'part_name' => 'Wheel Alignment Weight',
                'part_number' => 'WA-WGT-01',
                'category' => 'Wheel & Tyre',
                'task' => 'Wheel Alignment',
                'quantity' => 4,
                'unit' => 'Piece',
                'unit_price' => 80,
                'total' => 320,
                'status' => 'Returned',
                'requested_by' => 'Manoj Kumar',
                'issued_by' => 'Store Manager',
                'requested_at' => '09:10 AM',
                'issued_at' => '09:15 AM',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.job-cards.parts')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['id'] . ' - Parts',
            ]);
    }
}
