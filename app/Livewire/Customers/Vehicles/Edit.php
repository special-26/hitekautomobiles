<?php

namespace App\Livewire\Customers\Vehicles;

use App\Models\Vehicle;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public Vehicle $vehicle;

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
    public bool $is_active = true;

    public function mount(Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle;

        $this->registration_number = $vehicle->registration_number ?? '';
        $this->make = $vehicle->make ?? '';
        $this->model = $vehicle->model ?? '';
        $this->variant = $vehicle->variant ?? '';
        $this->fuel_type = $vehicle->fuel_type ?? '';
        $this->manufacturing_year = $vehicle->manufacturing_year
            ? (string) $vehicle->manufacturing_year
            : '';
        $this->color = $vehicle->color ?? '';
        $this->vin = $vehicle->vin ?? '';
        $this->engine_number = $vehicle->engine_number ?? '';
        $this->current_odometer = $vehicle->current_odometer
            ? (string) $vehicle->current_odometer
            : '';
        $this->last_service_at = $vehicle->last_service_at?->format('Y-m-d') ?? '';
        $this->next_service_at = $vehicle->next_service_at?->format('Y-m-d') ?? '';
        $this->insurance_expiry_at = $vehicle->insurance_expiry_at?->format('Y-m-d') ?? '';
        $this->is_active = (bool) $vehicle->is_active;
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

    public function save(): void
    {
        $validated = $this->validate([
            'registration_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('vehicles', 'registration_number')
                    ->ignore($this->vehicle->id),
            ],

            'make' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'variant' => ['nullable', 'string', 'max:100'],
            'fuel_type' => ['nullable', 'string', 'max:50'],

            'manufacturing_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . now()->year,
            ],

            'color' => ['nullable', 'string', 'max:50'],

            'vin' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('vehicles', 'vin')
                    ->ignore($this->vehicle->id),
            ],

            'engine_number' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('vehicles', 'engine_number')
                    ->ignore($this->vehicle->id),
            ],

            'current_odometer' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'last_service_at' => ['nullable', 'date'],
            'next_service_at' => ['nullable', 'date'],
            'insurance_expiry_at' => ['nullable', 'date'],
            'is_active' => ['boolean'],
        ]);

        // PostgreSQL: convert empty values to NULL.
        $validated['manufacturing_year'] =
            $validated['manufacturing_year'] ?: null;

        $validated['current_odometer'] =
            $validated['current_odometer'] ?: null;

        $validated['vin'] =
            $validated['vin'] ?: null;

        $validated['engine_number'] =
            $validated['engine_number'] ?: null;

        foreach (
            [
                'variant',
                'fuel_type',
                'color',
                'last_service_at',
                'next_service_at',
                'insurance_expiry_at',
            ] as $field
        ) {
            $validated[$field] = $validated[$field] ?: null;
        }

        // PostgreSQL: convert empty numeric/date values to NULL.
        $validated['manufacturing_year'] =
            $validated['manufacturing_year'] ?: null;

        $validated['current_odometer'] =
            $validated['current_odometer'] ?: null;

        foreach (
            [
                'last_service_at',
                'next_service_at',
                'insurance_expiry_at',
            ] as $field
        ) {
            $validated[$field] = $validated[$field] ?: null;
        }

        $this->vehicle->update($validated);

        session()->flash(
            'success',
            'Vehicle details updated successfully.'
        );

        $this->redirect(
            route('vehicles.show', $this->vehicle),
            navigate: true
        );
    }

    public function render()
    {
        return view('livewire.customers.vehicles.edit')
            ->layout('components.layouts.management', [
                'title' => 'Edit Vehicle',
            ]);
    }
}
