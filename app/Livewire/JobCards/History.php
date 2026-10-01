<?php

namespace App\Livewire\JobCards;

use Livewire\Component;

class History extends Component
{
    public $jobCard;

    public $history = [];

    public function mount($jobCard)
    {
        $this->jobCard = [
            'id' => $jobCard,
            'vehicle_no' => 'CH01BT9020',
            'vehicle' => 'Hyundai Creta 1.6',
            'customer' => 'Mrs. Indu Narula',
        ];

        $this->history = [
            [
                'id' => 1,
                'type' => 'Job Card',
                'action' => 'Job Card Created',
                'description' => 'Job card was created for Hyundai Creta 1.6.',
                'user' => 'Basant Joshi',
                'role' => 'Advisor',
                'date' => '23 Sep 2026',
                'time' => '09:15 AM',
                'icon' => 'plus',
            ],
            [
                'id' => 2,
                'type' => 'Customer',
                'action' => 'Customer & Vehicle Added',
                'description' => 'Customer and vehicle information was added to the job card.',
                'user' => 'Basant Joshi',
                'role' => 'Advisor',
                'date' => '23 Sep 2026',
                'time' => '09:18 AM',
                'icon' => 'user',
            ],
            [
                'id' => 3,
                'type' => 'Task',
                'action' => 'Task Added',
                'description' => 'Periodic Service task was added to the job card.',
                'user' => 'Basant Joshi',
                'role' => 'Advisor',
                'date' => '23 Sep 2026',
                'time' => '09:25 AM',
                'icon' => 'task',
            ],
            [
                'id' => 4,
                'type' => 'Assignment',
                'action' => 'Mechanic Assigned',
                'description' => 'Rakesh Kumar was assigned to Periodic Service in Bay 03.',
                'user' => 'Manoj Sharma',
                'role' => 'Mechanic Coordinator',
                'date' => '23 Sep 2026',
                'time' => '10:00 AM',
                'icon' => 'wrench',
            ],
            [
                'id' => 5,
                'type' => 'Parts',
                'action' => 'Part Requested',
                'description' => 'Engine Oil 5W30 was requested for Periodic Service.',
                'user' => 'Rakesh Kumar',
                'role' => 'Mechanic',
                'date' => '23 Sep 2026',
                'time' => '10:05 AM',
                'icon' => 'parts',
            ],
            [
                'id' => 6,
                'type' => 'Parts',
                'action' => 'Part Issued',
                'description' => 'Engine Oil 5W30 was issued from the store.',
                'user' => 'Rajesh Kumar',
                'role' => 'Store Manager',
                'date' => '23 Sep 2026',
                'time' => '10:20 AM',
                'icon' => 'check',
            ],
            [
                'id' => 7,
                'type' => 'Billing',
                'action' => 'Estimate Created',
                'description' => 'Estimate EST-13887 was created for ₹43,660.',
                'user' => 'Basant Joshi',
                'role' => 'Advisor',
                'date' => '23 Sep 2026',
                'time' => '12:10 PM',
                'icon' => 'billing',
            ],
            [
                'id' => 8,
                'type' => 'Payment',
                'action' => 'Payment Received',
                'description' => 'Advance payment of ₹15,000 received through UPI.',
                'user' => 'Basant Joshi',
                'role' => 'Advisor',
                'date' => '23 Sep 2026',
                'time' => '12:45 PM',
                'icon' => 'payment',
            ],
            [
                'id' => 9,
                'type' => 'Status',
                'action' => 'Job Card Status Updated',
                'description' => 'Job card status changed from Received to Under Service.',
                'user' => 'Basant Joshi',
                'role' => 'Advisor',
                'date' => '23 Sep 2026',
                'time' => '01:05 PM',
                'icon' => 'status',
            ],
            [
                'id' => 10,
                'type' => 'Task',
                'action' => 'Task Completed',
                'description' => 'Wheel Alignment task was marked as completed.',
                'user' => 'Manoj Kumar',
                'role' => 'Mechanic',
                'date' => '26 Sep 2026',
                'time' => '09:52 AM',
                'icon' => 'check',
            ],
            [
                'id' => 11,
                'type' => 'Billing',
                'action' => 'Final Invoice Created',
                'description' => 'Final invoice INV-13887 was generated for ₹46,846.',
                'user' => 'Basant Joshi',
                'role' => 'Advisor',
                'date' => '26 Sep 2026',
                'time' => '04:20 PM',
                'icon' => 'billing',
            ],
            [
                'id' => 12,
                'type' => 'Payment',
                'action' => 'Payment Received',
                'description' => 'Final payment of ₹10,000 received through Card.',
                'user' => 'Basant Joshi',
                'role' => 'Advisor',
                'date' => '26 Sep 2026',
                'time' => '04:35 PM',
                'icon' => 'payment',
            ],
            [
                'id' => 13,
                'type' => 'Status',
                'action' => 'Vehicle Marked Ready',
                'description' => 'Vehicle was marked ready for customer delivery.',
                'user' => 'Basant Joshi',
                'role' => 'Advisor',
                'date' => '26 Sep 2026',
                'time' => '04:45 PM',
                'icon' => 'check',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.job-cards.history')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['id'] . ' - History',
            ]);
    }
}
