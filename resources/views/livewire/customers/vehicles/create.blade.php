<div class="space-y-6">

    {{-- Header --}}
    <div>
        <a
            href="{{ route('customers.show', $customer) }}"
            wire:navigate
            class="inline-flex items-center gap-2 text-xs font-medium text-slate-500 hover:text-hitek-red"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m15 19-7-7 7-7"/>
            </svg>

            {{ $customer->name }}
        </a>

        <div class="mt-2">
            <h1 class="text-xl font-bold text-slate-900">
                Add Vehicle
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Add a vehicle to {{ $customer->name }}'s profile.
            </p>
        </div>
    </div>


    {{-- Form --}}
    <form wire:submit="save" class="space-y-5">

        {{-- Vehicle Information --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">

            <div class="mb-5">
                <h2 class="text-sm font-bold text-slate-900">
                    Vehicle Information
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    Basic vehicle identification and specifications.
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">

                {{-- Registration --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Registration Number <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        wire:model="registration_number"
                        placeholder="e.g. CH01AB1234"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm uppercase text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                    @error('registration_number')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Make --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Make <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        wire:model="make"
                        placeholder="e.g. Maruti Suzuki"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                    @error('make')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Model --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Model <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        wire:model="model"
                        placeholder="e.g. Swift"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                    @error('model')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Variant --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Variant
                    </label>

                    <input
                        type="text"
                        wire:model="variant"
                        placeholder="e.g. ZXi+"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                    @error('variant')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Fuel Type --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Fuel Type
                    </label>

                    <select
                        wire:model="fuel_type"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
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
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Manufacturing Year
                    </label>

                    <input
                        type="number"
                        wire:model="manufacturing_year"
                        min="1900"
                        max="{{ now()->year }}"
                        placeholder="{{ now()->year }}"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                    @error('manufacturing_year')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Color --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Color
                    </label>

                    <input
                        type="text"
                        wire:model="color"
                        placeholder="e.g. White"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                    @error('color')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

        </div>


        {{-- Vehicle Identification --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">

            <div class="mb-5">
                <h2 class="text-sm font-bold text-slate-900">
                    Vehicle Identification
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    Optional VIN and engine details.
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-2">

                {{-- VIN --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        VIN / Chassis Number
                    </label>

                    <input
                        type="text"
                        wire:model="vin"
                        placeholder="Enter VIN / chassis number"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm uppercase text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                    @error('vin')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Engine --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Engine Number
                    </label>

                    <input
                        type="text"
                        wire:model="engine_number"
                        placeholder="Enter engine number"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm uppercase text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                    @error('engine_number')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

        </div>


        {{-- Service & Insurance --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">

            <div class="mb-5">
                <h2 class="text-sm font-bold text-slate-900">
                    Service & Insurance
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    Keep service reminders and insurance expiry up to date.
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">

                {{-- Odometer --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Current Odometer
                    </label>

                    <input
                        type="number"
                        wire:model="current_odometer"
                        min="0"
                        placeholder="e.g. 45000"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                    @error('current_odometer')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Last Service --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Last Service
                    </label>

                    <input
                        type="date"
                        wire:model.live="last_service_at"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                    @error('last_service_at')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Next Service --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Next Service
                    </label>

                    <input
                        type="date"
                        wire:model="next_service_at"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                    @error('next_service_at')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Insurance --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Insurance Expiry
                    </label>

                    <input
                        type="date"
                        wire:model="insurance_expiry_at"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                    @error('insurance_expiry_at')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

        </div>


        {{-- Actions --}}
        <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">

            <a
                href="{{ route('customers.show', $customer) }}"
                wire:navigate
                class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="inline-flex items-center justify-center rounded-lg bg-hitek-red px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-hitek-red-hover disabled:opacity-50"
            >
                <span wire:loading.remove>
                    Save Vehicle
                </span>

                <span wire:loading>
                    Saving...
                </span>
            </button>

        </div>

    </form>

</div>