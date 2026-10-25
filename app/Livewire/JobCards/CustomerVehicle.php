<?php

namespace App\Livewire\JobCards;

use App\Models\JobCard;
use Livewire\Component;

class CustomerVehicle extends Component
{
    public $jobCard;

    public function mount($jobCard)
    {
        $this->loadJobCard($jobCard);
    }

    protected function loadJobCard($jobCardId): void
    {
        $jobCard = JobCard::query()
            ->with([
                'customer',
                'vehicle',
            ])
            ->findOrFail($jobCardId);

        $customer = $jobCard->customer;
        $vehicle = $jobCard->vehicle;

        $this->jobCard = [
            'id' => $jobCard->id,
            'job_card_number' => $jobCard->job_card_number,

            // Customer
            'customer_name' => $customer->name,
            'mobile' => $customer->phone,
            'email' => $customer->email,
            'address' => $customer->address,
            'customer_source' => $jobCard->customer_source,

            // Vehicle
            'vehicle' => trim(
                $vehicle->make . ' ' . $vehicle->model
                    . ($vehicle->variant ? ' ' . $vehicle->variant : '')
            ),
            'vehicle_no' => $vehicle->registration_number,
            'km' => $vehicle->current_odometer,
            'fuel' => $vehicle->fuel_type,
            'year' => $vehicle->manufacturing_year,
            'colour' => $vehicle->color,

            // RC / Vehicle Details
            'owner_name' => $customer->name,
            'chassis_no' => $vehicle->vin,
            'engine_no' => $vehicle->engine_number,
            'registration_date' => null,
            'rto' => null,
            'fuel_type' => $vehicle->fuel_type,
        ];
    }

    public function render()
    {
        return view('livewire.job-cards.customer-vehicle')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['job_card_number'],
            ]);
    }
}
