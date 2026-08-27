<?php

use Livewire\Volt\Component;
use App\Models\ServiceBooking;

new class extends Component
{
    public string $vehicle_id = '';
    public string $service_date = '';
    public string $slot_key = '';
    public string $service_type = '';
    public string $notes = '';

    public array $slots = [
        '10:00-11:00',
        '11:00-12:00',
        '12:00-13:00',
        '14:00-15:00',
        '15:00-16:00',
        '16:00-17:00',
    ];

    public function with(): array
    {
        $customer = auth()->user()->customer;

        return [
            'vehicles' => $customer
                ? $customer->vehicles()
                    ->where('is_active', true)
                    ->orderBy('registration_number')
                    ->get()
                : collect(),
        ];
    }

    public function bookService(): void
    {
        $customer = auth()->user()->customer;

        abort_if(!$customer, 404);

        $validated = $this->validate([
            'vehicle_id' => [
                'required',
                'integer',
                'exists:vehicles,id',
            ],

            'service_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'slot_key' => [
                'required',
                'string',
                'in:' . implode(',', $this->slots),
            ],

            'service_type' => [
                'required',
                'string',
                'max:255',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $vehicle = $customer->vehicles()
            ->where('is_active', true)
            ->findOrFail($validated['vehicle_id']);

        $alreadyBooked = ServiceBooking::where(
            'service_date',
            $validated['service_date']
        )
            ->where('slot_key', $validated['slot_key'])
            ->exists();

        if ($alreadyBooked) {
            $this->addError(
                'slot_key',
                'This time slot is already booked. Please select another slot.'
            );

            return;
        }

        $customer->serviceBookings()->create([
            'vehicle_id' => $vehicle->id,
            'service_date' => $validated['service_date'],
            'slot_key' => $validated['slot_key'],
            'service_type' => $validated['service_type'],
            'notes' => $validated['notes'],
            'status' => 'confirmed',
        ]);

        session()->flash(
            'success',
            'Your service booking has been confirmed.'
        );

        $this->reset([
            'vehicle_id',
            'service_date',
            'slot_key',
            'service_type',
            'notes',
        ]);
    }
};
?>

<div class="max-w-3xl mx-auto px-4 py-8">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            Book a Service
        </h1>

        <p class="mt-1 text-sm text-gray-600">
            Select your vehicle and preferred service time.
        </p>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($vehicles->count())

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

            <form wire:submit="bookService">

                <div class="space-y-6 dark:text-gray-800">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Select Vehicle *
                        </label>

                        <select
                            wire:model="vehicle_id"
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                        >
                            <option value="">
                                Select your vehicle
                            </option>

                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">
                                    {{ $vehicle->registration_number }}
                                    -
                                    {{ $vehicle->make }}
                                    {{ $vehicle->model }}
                                </option>
                            @endforeach
                        </select>

                        @error('vehicle_id')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Service Type *
                        </label>

                        <select
                            wire:model="service_type"
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                        >
                            <option value="">
                                Select service
                            </option>

                            <option value="General Service">
                                General Service
                            </option>

                            <option value="Periodic Service">
                                Periodic Service
                            </option>

                            <option value="AC Service">
                                AC Service
                            </option>

                            <option value="Brake Service">
                                Brake Service
                            </option>

                            <option value="Engine Service">
                                Engine Service
                            </option>

                            <option value="Denting & Painting">
                                Denting & Painting
                            </option>

                            <option value="Car Washing">
                                Car Washing
                            </option>

                            <option value="Other">
                                Other
                            </option>
                        </select>

                        @error('service_type')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Service Date *
                        </label>

                        <input
                            type="date"
                            wire:model="service_date"
                            min="{{ date('Y-m-d') }}"
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                        >

                        @error('service_date')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Time Slot *
                        </label>

                        <div class="mt-2 grid grid-cols-2 gap-3 md:grid-cols-3">

                            @foreach ($slots as $slot)

                                <label class="cursor-pointer">

                                    <input
                                        type="radio"
                                        wire:model="slot_key"
                                        value="{{ $slot }}"
                                        class="peer sr-only"
                                    >

                                    <div class="rounded-lg border border-gray-300 px-3 py-3 text-center text-sm peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700">
                                        {{ str_replace('-', ' - ', $slot) }}
                                    </div>

                                </label>

                            @endforeach

                        </div>

                        @error('slot_key')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Additional Notes
                        </label>

                        <textarea
                            wire:model="notes"
                            rows="4"
                            placeholder="Tell us anything we should know about your vehicle..."
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                        ></textarea>

                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="pt-2">

                        <button
                            type="submit"
                            class="w-full rounded-lg bg-blue-600 px-5 py-3 font-medium text-white hover:bg-blue-700"
                        >
                            Confirm Service Booking
                        </button>

                    </div>

                </div>

            </form>

        </div>

    @else

        <div class="rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center">

            <h2 class="text-lg font-semibold text-gray-900">
                No vehicle found
            </h2>

            <p class="mt-2 text-sm text-gray-600">
                Please add a vehicle before booking a service.
            </p>

            <a
                href="{{ route('customer.vehicles') }}"
                class="mt-5 inline-block rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700"
            >
                Add Vehicle
            </a>

        </div>

    @endif

</div>