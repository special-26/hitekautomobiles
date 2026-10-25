<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

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
                Customer Profile
            </a>

            <h1 class="mt-2 text-xl font-bold text-slate-900">
                Edit Customer
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Update customer contact and address information.
            </p>
        </div>

        <div class="text-right">
            <p class="text-[11px] text-slate-400">
                Customer Code
            </p>

            <p class="text-sm font-bold text-slate-700">
                {{ $customer->customer_code }}
            </p>
        </div>

    </div>


    {{-- Success --}}
    @if(session('success'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
            {{ session('success') }}
        </div>
    @endif


    {{-- Form --}}
    <form wire:submit="save" class="space-y-5">

        {{-- Basic Information --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">

            <div class="mb-5">
                <h2 class="text-sm font-bold text-slate-900">
                    Basic Information
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    Customer identity and contact details.
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-2">

                {{-- Name --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Customer Name <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        wire:model="name"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Phone --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Phone
                    </label>

                    <input
                        type="text"
                        wire:model="phone"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                    @error('phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Email --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Email
                    </label>

                    <input
                        type="email"
                        wire:model="email"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Date of Birth --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Date of Birth
                    </label>

                    <input
                        type="date"
                        wire:model="date_of_birth"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                    @error('date_of_birth')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

        </div>


        {{-- Address --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">

            <div class="mb-5">
                <h2 class="text-sm font-bold text-slate-900">
                    Address
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    Customer residential or business address.
                </p>
            </div>

            <div class="space-y-4">

                {{-- Address --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Address
                    </label>

                    <textarea
                        wire:model="address"
                        rows="3"
                        class="w-full resize-none rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    ></textarea>

                    @error('address')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                <div class="grid gap-4 md:grid-cols-3">

                    {{-- City --}}
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                            City
                        </label>

                        <input
                            type="text"
                            wire:model="city"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                        >

                        @error('city')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- State --}}
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                            State
                        </label>

                        <input
                            type="text"
                            wire:model="state"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                        >

                        @error('state')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Pincode --}}
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-slate-600">
                            Pincode
                        </label>

                        <input
                            type="text"
                            wire:model="pincode"
                            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                        >

                        @error('pincode')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

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
                    Save Changes
                </span>

                <span wire:loading>
                    Saving...
                </span>
            </button>

        </div>

    </form>

</div>