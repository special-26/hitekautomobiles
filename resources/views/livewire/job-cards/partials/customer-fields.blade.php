<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

    {{-- Name --}}
    <div class="sm:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-slate-700">
            Customer Name <span class="text-hitek-red">*</span>
        </label>

        <input
            type="text"
            wire:model="newCustomer.name"
            placeholder="Enter customer name"
            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        >

        @error('newCustomer.name')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Phone --}}
    <div>
        <label class="mb-1.5 block text-sm font-medium text-slate-700">
            Mobile <span class="text-hitek-red">*</span>
        </label>

        <input
            type="text"
            wire:model="newCustomer.phone"
            placeholder="Enter mobile number"
            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        >

        @error('newCustomer.phone')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Email --}}
    <div>
        <label class="mb-1.5 block text-sm font-medium text-slate-700">
            Email
        </label>

        <input
            type="email"
            wire:model="newCustomer.email"
            placeholder="customer@example.com"
            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        >

        @error('newCustomer.email')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Address --}}
    <div class="sm:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-slate-700">
            Address
        </label>

        <textarea
            wire:model="newCustomer.address"
            rows="2"
            placeholder="Enter address"
            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        ></textarea>

        @error('newCustomer.address')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- City --}}
    <div>
        <label class="mb-1.5 block text-sm font-medium text-slate-700">
            City
        </label>

        <input
            type="text"
            wire:model="newCustomer.city"
            placeholder="Chandigarh"
            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        >
    </div>

    {{-- State --}}
    <div>
        <label class="mb-1.5 block text-sm font-medium text-slate-700">
            State
        </label>

        <input
            type="text"
            wire:model="newCustomer.state"
            placeholder="Punjab"
            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        >
    </div>

    {{-- Pincode --}}
    <div>
        <label class="mb-1.5 block text-sm font-medium text-slate-700">
            Pincode
        </label>

        <input
            type="text"
            wire:model="newCustomer.pincode"
            placeholder="160002"
            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        >
    </div>

    {{-- DOB --}}
    <div>
        <label class="mb-1.5 block text-sm font-medium text-slate-700">
            Date of Birth
        </label>

        <input
            type="date"
            wire:model="newCustomer.date_of_birth"
            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
        >
    </div>

</div>