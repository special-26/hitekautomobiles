<?php

namespace App\Livewire\Customers\Vehicles;

use App\Models\Vehicle;
use Livewire\Component;

class Show extends Component
{
    public Vehicle $vehicle;

    public function mount(Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle->load([
            'customer',
            'jobCards' => fn($query) => $query->latest('id'),
        ]);
    }

    public function render()
    {
        return view('livewire.customers.vehicles.show')
            ->layout('components.layouts.management', [
                'title' => 'Vehicle Profile',
            ]);
    }
}
