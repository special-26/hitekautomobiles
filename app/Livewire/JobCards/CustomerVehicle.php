<?php

namespace App\Livewire\JobCards;

use Livewire\Component;

class CustomerVehicle extends Component
{
    public $jobCard;

    public function mount($jobCard)
    {
        $this->jobCard = [
            'id' => $jobCard,

            // Customer
            'customer_name' => 'Mrs. Indu Narula',
            'mobile' => '9256681776',
            'email' => 'indu.narula@example.com',
            'address' => 'Sector 17, Chandigarh',
            'customer_source' => 'National Insurance Co. Ltd.',

            // Vehicle
            'vehicle' => 'Hyundai Creta 1.6',
            'vehicle_no' => 'CH01BT9020',
            'km' => '138,884',
            'fuel' => 'Petrol',
            'year' => '2021',
            'colour' => 'White',

            // RC
            'owner_name' => 'Indu Narula',
            'chassis_no' => 'MALC381CLMM123456',
            'engine_no' => 'G4FJMN123456',
            'registration_date' => '15 Mar 2021',
            'rto' => 'Chandigarh',
            'fuel_type' => 'Petrol',
        ];
    }

    public function render()
    {
        return view('livewire.job-cards.customer-vehicle')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['id'],
            ]);
    }
}
