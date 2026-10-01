<?php

namespace App\Livewire\JobCards;

use Livewire\Component;

class Images extends Component
{
    public $jobCard;

    public $images = [];

    public function mount($jobCard)
    {
        $this->jobCard = [
            'id' => $jobCard,
            'vehicle_no' => 'CH01BT9020',
            'vehicle' => 'Hyundai Creta 1.6',
            'customer' => 'Mrs. Indu Narula',
        ];

        $this->images = [
            [
                'id' => 1,
                'name' => 'front-damage.jpg',
                'category' => 'Damage / Inspection',
                'uploaded_by' => 'Basant Joshi',
                'uploaded_at' => '23 Sep 2026, 09:42 AM',
                'url' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'id' => 2,
                'name' => 'left-side.jpg',
                'category' => 'Before Service',
                'uploaded_by' => 'Basant Joshi',
                'uploaded_at' => '23 Sep 2026, 09:44 AM',
                'url' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'id' => 3,
                'name' => 'engine-bay.jpg',
                'category' => 'Inspection',
                'uploaded_by' => 'Rakesh Kumar',
                'uploaded_at' => '23 Sep 2026, 10:18 AM',
                'url' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'id' => 4,
                'name' => 'brake-check.jpg',
                'category' => 'Inspection',
                'uploaded_by' => 'Amit Kumar',
                'uploaded_at' => '23 Sep 2026, 11:05 AM',
                'url' => 'https://images.unsplash.com/photo-1487754180451-c456f719a1fc?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'id' => 5,
                'name' => 'service-complete.jpg',
                'category' => 'After Service',
                'uploaded_by' => 'Rakesh Kumar',
                'uploaded_at' => '26 Sep 2026, 04:15 PM',
                'url' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'id' => 6,
                'name' => 'customer-approval.jpg',
                'category' => 'Documents',
                'uploaded_by' => 'Basant Joshi',
                'uploaded_at' => '23 Sep 2026, 12:20 PM',
                'url' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=900&q=80',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.job-cards.images')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['id'] . ' - Images',
            ]);
    }
}
