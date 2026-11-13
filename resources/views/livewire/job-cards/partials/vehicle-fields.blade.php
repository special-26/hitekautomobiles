<div class="grid grid-cols-1 gap-5 md:grid-cols-2">

    {{-- Registration --}}
    <div>
        <label class="text-sm font-medium text-slate-700">
            Registration Number
            <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            wire:model="newVehicle.registration_number"
            placeholder="e.g. CH01AB1234"
            class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm uppercase outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        >

        @error('newVehicle.registration_number')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Make --}}
    <div>
        <label class="text-sm font-medium text-slate-700">
            Make
            <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            wire:model="newVehicle.make"
            placeholder="e.g. Hyundai"
            class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        >

        @error('newVehicle.make')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Model --}}
    <div>
        <label class="text-sm font-medium text-slate-700">
            Model
            <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            wire:model="newVehicle.model"
            placeholder="e.g. Creta"
            class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        >

        @error('newVehicle.model')
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
            wire:model="newVehicle.variant"
            placeholder="e.g. SX"
            class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        >
    </div>

    {{-- Fuel --}}
    <div>
        <label class="text-sm font-medium text-slate-700">
            Fuel Type
        </label>

        <select
            wire:model="newVehicle.fuel_type"
            class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        >
            <option value="">Select fuel type</option>
            <option value="Petrol">Petrol</option>
            <option value="Diesel">Diesel</option>
            <option value="CNG">CNG</option>
            <option value="Electric">Electric</option>
            <option value="Hybrid">Hybrid</option>
        </select>
    </div>

    {{-- Year --}}
    <div>
        <label class="text-sm font-medium text-slate-700">
            Manufacturing Year
        </label>

        <input
            type="number"
            wire:model="newVehicle.manufacturing_year"
            placeholder="e.g. 2022"
            min="1900"
            max="2100"
            class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        >
    </div>

    {{-- Colour --}}
    <div>
        <label class="text-sm font-medium text-slate-700">
            Colour
        </label>

        <input
            type="text"
            wire:model="newVehicle.color"
            placeholder="e.g. White"
            class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        >
    </div>

    {{-- Odometer --}}
    <div>
        <label class="text-sm font-medium text-slate-700">
            Current Odometer
        </label>

        <input
            type="number"
            wire:model="newVehicle.current_odometer"
            placeholder="e.g. 45000"
            min="0"
            class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        >
    </div>

    {{-- VIN --}}
    <div>
        <label class="text-sm font-medium text-slate-700">
            VIN / Chassis Number
        </label>

        <input
            type="text"
            wire:model="newVehicle.vin"
            placeholder="Enter VIN"
            class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm uppercase outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        >
    </div>

    {{-- Engine --}}
    <div>
        <label class="text-sm font-medium text-slate-700">
            Engine Number
        </label>

        <input
            type="text"
            wire:model="newVehicle.engine_number"
            placeholder="Enter engine number"
            class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm uppercase outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        >
    </div>

</div>