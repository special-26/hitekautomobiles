<?php

use Livewire\Volt\Component;
use App\Models\Vehicle;

new class extends Component
{
    public bool $showForm = false;
    public ?int $editingVehicleId = null;

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

    public function with(): array
    {
        $customer = auth()->user()->customer;

        return [
            'vehicles' => $customer
                ? $customer->vehicles()->latest()->get()
                : collect(),
        ];
    }

    public function createVehicle(): void
    {
        $this->resetForm();

        $this->editingVehicleId = null;
        $this->showForm = true;
    }

    public function editVehicle(int $vehicleId): void
    {
        $customer = auth()->user()->customer;

        abort_if(!$customer, 404);

        $vehicle = $customer->vehicles()->findOrFail($vehicleId);

        $this->editingVehicleId = $vehicle->id;

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
        $this->current_odometer = $vehicle->current_odometer !== null
            ? (string) $vehicle->current_odometer
            : '';

        $this->showForm = true;
    }

    public function saveVehicle(): void
    {
        $customer = auth()->user()->customer;

        abort_if(!$customer, 404);

        $validated = $this->validate([
            'registration_number' => [
                'required',
                'string',
                'max:255',
            ],

            'make' => [
                'required',
                'string',
                'max:255',
            ],

            'model' => [
                'required',
                'string',
                'max:255',
            ],

            'variant' => [
                'nullable',
                'string',
                'max:255',
            ],

            'fuel_type' => [
                'nullable',
                'string',
                'max:255',
            ],

            'manufacturing_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . (date('Y') + 1),
            ],

            'color' => [
                'nullable',
                'string',
                'max:255',
            ],

            'vin' => [
                'nullable',
                'string',
                'max:255',
            ],

            'engine_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'current_odometer' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);

        if ($this->editingVehicleId) {

            $vehicle = $customer->vehicles()
                ->findOrFail($this->editingVehicleId);

            $vehicle->update($validated);

            session()->flash(
                'success',
                'Vehicle updated successfully.'
            );

        } else {

            $customer->vehicles()->create([
                ...$validated,
                'is_active' => true,
            ]);

            session()->flash(
                'success',
                'Vehicle added successfully.'
            );
        }

        $this->resetForm();
        $this->showForm = false;
        $this->editingVehicleId = null;
    }

    public function deleteVehicle(int $vehicleId): void
    {
        $customer = auth()->user()->customer;

        abort_if(!$customer, 404);

        $vehicle = $customer->vehicles()->findOrFail($vehicleId);

        $vehicle->delete();

        session()->flash(
            'success',
            'Vehicle deleted successfully.'
        );
    }

    public function cancelForm(): void
    {
        $this->resetForm();

        $this->showForm = false;
        $this->editingVehicleId = null;
    }

    private function resetForm(): void
    {
        $this->registration_number = '';
        $this->make = '';
        $this->model = '';
        $this->variant = '';
        $this->fuel_type = '';
        $this->manufacturing_year = '';
        $this->color = '';
        $this->vin = '';
        $this->engine_number = '';
        $this->current_odometer = '';

        $this->resetValidation();
    }
};
?>

<div class="max-w-6xl mx-auto px-4 py-8 dark:bg-gray-900">

    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                My Vehicles
            </h1>

            <p class="mt-1 text-sm text-gray-600">
                Manage your vehicles.
            </p>
        </div>

        @if (!$showForm)
            <button
                type="button"
                wire:click="createVehicle"
                class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700"
            >
                Add Vehicle
            </button>
        @endif

    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($showForm)

        <div class="mb-8 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

            <h2 class="mb-6 text-lg font-semibold text-gray-900">
                {{ $editingVehicleId ? 'Edit Vehicle' : 'Add Vehicle' }}
            </h2>

            <form wire:submit="saveVehicle">

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 dark:text-gray-800">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Registration Number *
                        </label>

                        <input
                            type="text"
                            wire:model="registration_number"
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                            placeholder="CH01AB1234"
                        >

                        @error('registration_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Make *
                        </label>

                        <input
                            type="text"
                            wire:model="make"
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                            placeholder="Maruti Suzuki"
                        >

                        @error('make')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Model *
                        </label>

                        <input
                            type="text"
                            wire:model="model"
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                            placeholder="Swift"
                        >

                        @error('model')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Variant
                        </label>

                        <input
                            type="text"
                            wire:model="variant"
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                            placeholder="VXi"
                        >

                        @error('variant')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Fuel Type
                        </label>

                        <select
                            wire:model="fuel_type"
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                        >
                            <option value="">Select fuel type</option>
                            <option value="Petrol">Petrol</option>
                            <option value="Diesel">Diesel</option>
                            <option value="CNG">CNG</option>
                            <option value="Electric">Electric</option>
                            <option value="Hybrid">Hybrid</option>
                        </select>

                        @error('fuel_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Manufacturing Year
                        </label>

                        <input
                            type="number"
                            wire:model="manufacturing_year"
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                            placeholder="2024"
                        >

                        @error('manufacturing_year')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Color
                        </label>

                        <input
                            type="text"
                            wire:model="color"
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                            placeholder="White"
                        >

                        @error('color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Current Odometer
                        </label>

                        <input
                            type="number"
                            wire:model="current_odometer"
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                            placeholder="25000"
                        >

                        @error('current_odometer')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            VIN
                        </label>

                        <input
                            type="text"
                            wire:model="vin"
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                        >

                        @error('vin')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Engine Number
                        </label>

                        <input
                            type="text"
                            wire:model="engine_number"
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                        >

                        @error('engine_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="mt-6 flex gap-3">

                    <button
                        type="submit"
                        class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700"
                    >
                        {{ $editingVehicleId ? 'Update Vehicle' : 'Add Vehicle' }}
                    </button>

                    <button
                        type="button"
                        wire:click="cancelForm"
                        class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Cancel
                    </button>

                </div>

            </form>

        </div>

    @endif

    @if ($vehicles->count())

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

            @foreach ($vehicles as $vehicle)

                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

                    <div class="flex items-start justify-between">

                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">
                                {{ $vehicle->registration_number }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ $vehicle->make }} {{ $vehicle->model }}
                                @if ($vehicle->variant)
                                    · {{ $vehicle->variant }}
                                @endif
                            </p>
                        </div>

                        @if ($vehicle->is_active)
                            <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                Active
                            </span>
                        @else
                            <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">
                                Inactive
                            </span>
                        @endif

                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-4 text-sm">

                        <div>
                            <p class="text-gray-500">Fuel</p>
                            <p class="font-medium text-gray-900">
                                {{ $vehicle->fuel_type ?: '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Year</p>
                            <p class="font-medium text-gray-900">
                                {{ $vehicle->manufacturing_year ?: '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Color</p>
                            <p class="font-medium text-gray-900">
                                {{ $vehicle->color ?: '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Odometer</p>
                            <p class="font-medium text-gray-900">
                                {{ $vehicle->current_odometer !== null
                                    ? number_format($vehicle->current_odometer) . ' km'
                                    : '—'
                                }}
                            </p>
                        </div>

                    </div>

                    <div class="mt-6 flex gap-3 border-t border-gray-100 pt-4">

                        <button
                            type="button"
                            wire:click="editVehicle({{ $vehicle->id }})"
                            class="text-sm font-medium text-blue-600 hover:text-blue-800"
                        >
                            Edit
                        </button>

                        <button
                            type="button"
                            wire:click="deleteVehicle({{ $vehicle->id }})"
                            wire:confirm="Are you sure you want to delete this vehicle?"
                            class="text-sm font-medium text-red-600 hover:text-red-800"
                        >
                            Delete
                        </button>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center">

            <h2 class="text-lg font-semibold text-gray-900">
                No vehicles added
            </h2>

            <p class="mt-2 text-sm text-gray-600">
                Add your vehicle to manage its service history and bookings.
            </p>

            <button
                type="button"
                wire:click="createVehicle"
                class="mt-5 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700"
            >
                Add Your First Vehicle
            </button>

        </div>

    @endif

</div>