<?php

namespace App\Livewire\Customers\Vehicles;

use App\Models\Customer;
use App\Models\Vehicle;
use Livewire\Component;

class Create extends Component
{
    public Customer $customer;

    public string $registration_number = '';
    public string $make = '';
    public string $model = '';
    public string $variant = '';
    public string $fuel_type = '';
    public string $manufacturing_year = '';
    public string $color = '';
    public string $vin = '';
    public string $engine_number = '';
    public string $current_odometer = '';
    public string $last_service_at = '';
    public string $next_service_at = '';
    public string $insurance_expiry_at = '';

    public function mount(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'registration_number' => ['required', 'string', 'max:50', 'unique:vehicles,registration_number'],
            'make' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'variant' => ['nullable', 'string', 'max:100'],
            'fuel_type' => ['nullable', 'string', 'max:50'],
            'manufacturing_year' => ['nullable', 'integer', 'min:1900', 'max:' . now()->year],
            'color' => ['nullable', 'string', 'max:50'],
            'vin' => ['nullable', 'string', 'max:100', 'unique:vehicles,vin'],
            'engine_number' => ['nullable', 'string', 'max:100', 'unique:vehicles,engine_number'],
            'current_odometer' => ['nullable', 'integer', 'min:0'],
            'last_service_at' => ['nullable', 'date'],
            'next_service_at' => ['nullable', 'date'],
            'insurance_expiry_at' => ['nullable', 'date'],
        ]);

        $validated['customer_id'] = $this->customer->id;

        $validated['manufacturing_year'] = $validated['manufacturing_year'] ?: null;
        $validated['current_odometer'] = $validated['current_odometer'] ?: null;

        Vehicle::create($validated);

        session()->flash('success', 'Vehicle added successfully.');

        $this->redirect(
            route('customers.show', $this->customer),
            navigate: true
        );
    }

    public function updatedLastServiceAt($value): void
    {
        if (empty($value)) {
            $this->next_service_at = '';

            return;
        }

        $this->next_service_at = \Carbon\Carbon::parse($value)
            ->addMonths(6)
            ->format('Y-m-d');
    }


    public function render()
    {
        return view('livewire.customers.vehicles.create')
            ->layout('components.layouts.management', [
                'title' => 'Add Vehicle',
            ]);
    }
}
