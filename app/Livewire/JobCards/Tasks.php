<?php

namespace App\Livewire\JobCards;

use Livewire\Component;

class Tasks extends Component
{
    public $jobCard;

    public $tasks = [];

    public function mount($jobCard)
    {
        $this->jobCard = [
            'id' => $jobCard,
            'vehicle_no' => 'CH01BT9020',
            'vehicle' => 'Hyundai Creta 1.6',
            'customer' => 'Mrs. Indu Narula',
        ];

        $this->tasks = [
            [
                'id' => 1,
                'task' => 'Periodic Service',
                'description' => 'Complete periodic maintenance as per service schedule.',
                'category' => 'Service',
                'priority' => 'High',
                'status' => 'In Progress',
                'mechanic' => 'Rakesh Kumar',
                'bay' => 'Bay 03',
                'estimated_time' => '2 hrs',
                'started_at' => '10:15 AM',
                'completed_at' => null,
                'parts_pending' => false,
            ],
            [
                'id' => 2,
                'task' => 'Brake Inspection',
                'description' => 'Inspect front and rear brake system and report condition.',
                'category' => 'Inspection',
                'priority' => 'Medium',
                'status' => 'Pending',
                'mechanic' => 'Amit Kumar',
                'bay' => 'Bay 05',
                'estimated_time' => '45 min',
                'started_at' => null,
                'completed_at' => null,
                'parts_pending' => false,
            ],
            [
                'id' => 3,
                'task' => 'AC Performance Check',
                'description' => 'Check cooling performance, gas pressure and AC operation.',
                'category' => 'AC',
                'priority' => 'Low',
                'status' => 'Pending Parts',
                'mechanic' => 'Sandeep Singh',
                'bay' => 'Bay 02',
                'estimated_time' => '1 hr',
                'started_at' => null,
                'completed_at' => null,
                'parts_pending' => true,
            ],
            [
                'id' => 4,
                'task' => 'Wheel Alignment',
                'description' => 'Perform wheel alignment and verify steering geometry.',
                'category' => 'Wheel & Tyre',
                'priority' => 'Medium',
                'status' => 'Completed',
                'mechanic' => 'Manoj Kumar',
                'bay' => 'Bay 01',
                'estimated_time' => '30 min',
                'started_at' => '09:20 AM',
                'completed_at' => '09:52 AM',
                'parts_pending' => false,
            ],
        ];
    }

    public function render()
    {
        return view('livewire.job-cards.tasks')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['id'] . ' - Tasks',
            ]);
    }
}
