<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">
            <a
                href="{{ route('vehicles.show', $vehicle) }}"
                wire:navigate
                class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50"
            >
                ← Back
            </a>

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Edit Vehicle
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $vehicle->registration_number }}
                    · {{ $vehicle->customer->name }}
                </p>
            </div>
        </div>

    </div>


    {{-- Form --}}
    <form wire:submit="save" class="space-y-6">

        {{-- Basic Vehicle Information --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-base font-semibold text-slate-900">
                    Vehicle Information
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    Basic identification details of the vehicle.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2 lg:grid-cols-3">

                {{-- Registration --}}
                <div>
                    <label class="text-sm font-medium text-slate-700">
                        Registration Number <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        wire:model="registration_number"
                        class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm uppercase focus:border-hitek-red focus:ring-hitek-red"
                        placeholder="PB65AP0331"
                    >

                    @error('registration_number')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Make --}}
                <div>
                    <label class="text-sm font-medium text-slate-700">
                        Make <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        wire:model="make"
                        class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-hitek-red focus:ring-hitek-red"
                        placeholder="Tata"
                    >

                    @error('make')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Model --}}
                <div>
                    <label class="text-sm font-medium text-slate-700">
                        Model <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        wire:model="model"
                        class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-hitek-red focus:ring-hitek-red"
                        placeholder="Nexon"
                    >

                    @error('model')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Variant --}}
                <div>
                    <label class="text-sm font-medium text-slate-700">
                        Variant
                    </label>

                    <input
                        type="text"
                        wire:model="variant"
                        class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-hitek-red focus:ring-hitek-red"
                        placeholder="XZ+"
                    >

                    @error('variant')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Fuel --}}
                <div>
                    <label class="text-sm font-medium text-slate-700">
                        Fuel Type
                    </label>

                    <select
                        wire:model="fuel_type"
                        class="mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-hitek-red focus:ring-hitek-red"
                    >
                        <option value="">Select fuel type</option>
                        <option value="Petrol">Petrol</option>
                        <option value="Diesel">Diesel</option>
                        <option value="CNG">CNG</option>
                        <option value="Electric">Electric</option>
                        <option value="Hybrid">Hybrid</option>
                    </select>

                    @error('fuel_type')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Manufacturing Year --}}
                <div>
                    <label class="text-sm font-medium text-slate-700">
                        Manufacturing Year
                    </label>

                    <input
                        type="number"
                        wire:model="manufacturing_year"
                        min="1900"
                        max="{{ now()->year }}"
                        class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-hitek-red focus:ring-hitek-red"
                        placeholder="2024"
                    >

                    @error('manufacturing_year')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Color --}}
                <div>
                    <label class="text-sm font-medium text-slate-700">
                        Color
                    </label>

                    <input
                        type="text"
                        wire:model="color"
                        class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-hitek-red focus:ring-hitek-red"
                        placeholder="White"
                    >

                    @error('color')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

        </div>


        {{-- Vehicle Identification --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-base font-semibold text-slate-900">
                    Vehicle Identification
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    VIN and engine information.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

                {{-- VIN --}}
                <div>
                    <label class="text-sm font-medium text-slate-700">
                        VIN
                    </label>

                    <input
                        type="text"
                        wire:model="vin"
                        class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm uppercase focus:border-hitek-red focus:ring-hitek-red"
                        placeholder="Vehicle Identification Number"
                    >

                    @error('vin')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Engine Number --}}
                <div>
                    <label class="text-sm font-medium text-slate-700">
                        Engine Number
                    </label>

                    <input
                        type="text"
                        wire:model="engine_number"
                        class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm uppercase focus:border-hitek-red focus:ring-hitek-red"
                        placeholder="Engine Number"
                    >

                    @error('engine_number')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

        </div>


        {{-- Service Information --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-base font-semibold text-slate-900">
                    Service & Insurance
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    Keep the vehicle's service and insurance dates updated.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2 lg:grid-cols-3">

                {{-- Odometer --}}
                <div>
                    <label class="text-sm font-medium text-slate-700">
                        Current Odometer
                    </label>

                    <div class="relative mt-1.5">
                        <input
                            type="number"
                            wire:model="current_odometer"
                            min="0"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 pr-12 text-sm focus:border-hitek-red focus:ring-hitek-red"
                            placeholder="45000"
                        >

                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400">
                            km
                        </span>
                    </div>

                    @error('current_odometer')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Last Service --}}
                <div>
                    <label class="text-sm font-medium text-slate-700">
                        Last Service
                    </label>

                    <input
                        type="date"
                        wire:model.live="last_service_at"
                        class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-hitek-red focus:ring-hitek-red"
                    >

                    @error('last_service_at')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Next Service --}}
                <div>
                    <label class="text-sm font-medium text-slate-700">
                        Next Service
                    </label>

                    <input
                        type="date"
                        wire:model="next_service_at"
                        class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-hitek-red focus:ring-hitek-red"
                    >

                    @error('next_service_at')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-1 text-xs text-slate-400">
                        You can manually adjust this date.
                    </p>
                </div>


                {{-- Insurance --}}
                <div>
                    <label class="text-sm font-medium text-slate-700">
                        Insurance Expiry
                    </label>

                    <input
                        type="date"
                        wire:model="insurance_expiry_at"
                        class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-hitek-red focus:ring-hitek-red"
                    >

                    @error('insurance_expiry_at')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

        </div>


        {{-- Status --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="flex items-center justify-between gap-4 px-6 py-5">

                <div>
                    <h2 class="text-sm font-semibold text-slate-900">
                        Vehicle Status
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        Inactive vehicles can remain in the customer's history.
                    </p>
                </div>

                <label class="flex cursor-pointer items-center gap-3">

                    <input
                        type="checkbox"
                        wire:model="is_active"
                        class="h-5 w-5 rounded border-slate-300 text-hitek-red focus:ring-hitek-red"
                    >

                    <span class="text-sm font-medium text-slate-700">
                        Active Vehicle
                    </span>

                </label>

            </div>

        </div>


        {{-- Actions --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a
                href="{{ route('vehicles.show', $vehicle) }}"
                wire:navigate
                class="rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-center text-sm font-medium text-slate-700 hover:bg-slate-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="rounded-lg bg-hitek-red px-5 py-2.5 text-sm font-semibold text-white hover:bg-hitek-red-hover disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="save">
                    Save Changes
                </span>

                <span wire:loading wire:target="save">
                    Saving...
                </span>
            </button>

        </div>

    </form>

</div>