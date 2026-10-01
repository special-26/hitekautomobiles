<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>
            <div class="flex items-center gap-3">

                <a
                    href="{{ route('job-cards.index') }}"
                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 hover:text-slate-900"
                >
                    ←
                </a>

                <div>
                    <h1 class="text-xl font-bold text-slate-900">
                        Create Job Card
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Create a new job card for customer vehicle service
                    </p>
                </div>

            </div>
        </div>


        <div class="flex items-center gap-2">

            <button
                type="button"
                class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50"
            >
                Cancel
            </button>

            <button
                type="button"
                class="rounded-lg bg-hitek-red px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-hitek-red-hover"
            >
                Save & Continue
            </button>

        </div>

    </div>


    {{-- Progress --}}
    <div class="rounded-xl border border-slate-200 bg-white px-5 py-4">

        <div class="flex items-center">

            <div class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-hitek-red text-xs font-bold text-white">
                    1
                </span>

                <span class="text-sm font-semibold text-slate-900">
                    Customer
                </span>
            </div>

            <div class="mx-4 h-px flex-1 bg-slate-200"></div>

            <div class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-500">
                    2
                </span>

                <span class="hidden text-sm font-medium text-slate-500 sm:block">
                    Vehicle
                </span>
            </div>

            <div class="mx-4 h-px flex-1 bg-slate-200"></div>

            <div class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-500">
                    3
                </span>

                <span class="hidden text-sm font-medium text-slate-500 sm:block">
                    Job Details
                </span>
            </div>

            <div class="mx-4 h-px flex-1 bg-slate-200"></div>

            <div class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-500">
                    4
                </span>

                <span class="hidden text-sm font-medium text-slate-500 sm:block">
                    Concerns
                </span>
            </div>

        </div>

    </div>


    {{-- Customer + Vehicle --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

        {{-- Customer --}}
        <div class="rounded-xl border border-slate-200 bg-white">

            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">

                <div>
                    <h2 class="font-semibold text-slate-900">
                        Customer
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Select or create the customer
                    </p>
                </div>

                <button
                    type="button"
                    wire:click="openCustomerModal"
                    class="rounded-lg border border-hitek-red px-3 py-1.5 text-xs font-semibold text-hitek-red hover:bg-red-50"
                >
                    + New Customer
                </button>

            </div>


            <div class="space-y-4 p-5">

                {{-- Search --}}
                <div class="relative">

                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                        🔍
                    </span>

                    <input
                        type="text"
                        wire:model.live.debounce.300ms="customerSearch"
                        placeholder="Search customer by name or mobile..."
                        class="w-full rounded-lg border border-slate-200 py-2.5 pl-10 pr-4 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                    @if (count($customerResults) > 0)

                        <div class="mt-2 overflow-hidden rounded-lg border border-slate-200 bg-white shadow-lg">

                            @foreach ($customerResults as $result)

                                <button
                                    type="button"
                                    wire:click="selectCustomer({{ $result['id'] }})"
                                    class="block w-full border-b border-slate-100 px-4 py-3 text-left last:border-b-0 hover:bg-slate-50"
                                >

                                    <div class="flex items-center justify-between gap-3">

                                        <div>
                                            <p class="font-semibold text-slate-800">
                                                {{ $result['name'] }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-500">
                                                {{ $result['phone'] }}

                                                @if ($result['email'])
                                                    · {{ $result['email'] }}
                                                @endif
                                            </p>
                                        </div>

                                        <span class="text-xs font-semibold text-hitek-red">
                                            Select
                                        </span>

                                    </div>

                                </button>

                            @endforeach

                        </div>

                    @endif

                </div>


                {{-- Selected Customer --}}
                @if ($customer)

                    <div class="rounded-lg border border-green-200 bg-green-50 p-4">

                        <div class="flex items-start justify-between gap-3">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white font-semibold text-green-700 shadow-sm">
                                    {{ strtoupper(substr($customer['name'], 0, 1)) }}
                                </div>

                                <div>

                                    <p class="font-semibold text-slate-900">
                                        {{ $customer['name'] }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $customer['mobile'] }}
                                    </p>

                                </div>

                            </div>

                            <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                Selected
                            </span>

                        </div>


                        <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">

                            <div>
                                <p class="text-xs text-slate-400">
                                    Email
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ $customer['email'] ?: '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">
                                    Address
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ $customer['address'] ?: '—' }}
                                </p>
                            </div>

                        </div>

                    </div>

                @else

                    <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 p-6 text-center">

                        <div class="text-2xl">
                            👤
                        </div>

                        <p class="mt-2 text-sm font-medium text-slate-700">
                            No customer selected
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Search for an existing customer or create a new one.
                        </p>

                    </div>

                @endif

            </div>

        </div>


        {{-- Vehicle --}}
        <div class="rounded-xl border border-slate-200 bg-white">

            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">

                <div>
                    <h2 class="font-semibold text-slate-900">
                        Vehicle
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Select a vehicle for this customer
                    </p>
                </div>

                <button
                    type="button"
                    wire:click="openVehicleModal"
                    @disabled(!$customer)
                    class="rounded-lg border border-hitek-red px-3 py-1.5 text-xs font-semibold text-hitek-red hover:bg-red-50"
                >
                    + New Vehicle
                </button>

            </div>


            <div class="space-y-4 p-5">

                {{-- Vehicle Search --}}
                <div class="relative">

                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                        🔍
                    </span>

                    <input
                        type="text"
                        wire:model.live.debounce.300ms="vehicleSearch"
                        placeholder="{{ $customer ? 'Search registration, make or model...' : 'Select customer first...' }}"
                        @disabled(!$customer)
                        class="w-full rounded-lg border border-slate-200 py-2.5 pl-10 pr-4 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10 disabled:cursor-not-allowed disabled:bg-slate-50"
                    >

                    @if (count($vehicleResults) > 0)

                        <div class="mt-2 overflow-hidden rounded-lg border border-slate-200 bg-white shadow-lg">

                            @foreach ($vehicleResults as $result)

                                <button
                                    type="button"
                                    wire:click="selectVehicle({{ $result['id'] }})"
                                    class="block w-full border-b border-slate-100 px-4 py-3 text-left last:border-b-0 hover:bg-slate-50"
                                >

                                    <div class="flex items-center justify-between gap-3">

                                        <div>

                                            <p class="font-semibold text-slate-800">
                                                {{ $result['registration_number'] }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-500">
                                                {{ $result['make'] }}
                                                {{ $result['model'] }}

                                                @if ($result['variant'])
                                                    · {{ $result['variant'] }}
                                                @endif

                                                · {{ $result['fuel_type'] }}
                                            </p>

                                        </div>

                                        <span class="text-xs font-semibold text-hitek-red">
                                            Select
                                        </span>

                                    </div>

                                </button>

                            @endforeach

                        </div>

                    @endif

                </div>


                {{-- Selected Vehicle --}}
                @if ($vehicle)

                    <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">

                        <div class="flex items-start justify-between gap-3">

                            <div>

                                <p class="text-lg font-bold text-slate-900">
                                    {{ $vehicle['registration_no'] }}
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ $vehicle['make'] }} {{ $vehicle['model'] }}

                                    @if (!empty($vehicle['variant']))
                                        · {{ $vehicle['variant'] }}
                                    @endif
                                </p>

                            </div>

                            <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                Selected
                            </span>

                        </div>


                        <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">

                            <div>
                                <p class="text-xs text-slate-400">
                                    Year
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ $vehicle['year'] }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">
                                    Fuel
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ $vehicle['fuel_type'] }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">
                                    Colour
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ $vehicle['colour'] }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400">
                                    Current KM
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-700">
                                    {{ number_format($vehicle['km']) }}
                                </p>
                            </div>

                        </div>

                    </div>

                @else

                    <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 p-6 text-center">

                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-400 shadow-sm">
                            🚗
                        </div>

                        <p class="mt-3 text-sm font-semibold text-slate-700">
                            No vehicle selected
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Select a vehicle belonging to the selected customer.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- Job Details --}}
    <div class="rounded-xl border border-slate-200 bg-white">

        <div class="border-b border-slate-200 px-5 py-4">

            <h2 class="font-semibold text-slate-900">
                Job Card Details
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                Basic information about the vehicle visit
            </p>

        </div>

        <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2 xl:grid-cols-4">

            {{-- Job Card Number --}}
            <div>
                <label class="text-sm font-medium text-slate-700">
                    Job Card Number
                </label>

                <input
                    type="text"
                    value="{{ $jobCard['job_card_no'] }}"
                    readonly
                    class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-500"
                >
            </div>


            {{-- Advisor --}}
            <div>
                <label class="text-sm font-medium text-slate-700">
                    Advisor
                </label>

                <select
                    wire:model="jobCard.advisor"
                    class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                >
                    <option value="Basant Joshi">Basant Joshi</option>
                    <option value="Advisor 2">Advisor 2</option>
                    <option value="Advisor 3">Advisor 3</option>
                </select>
            </div>


            {{-- Source --}}
            <div>
                <label class="text-sm font-medium text-slate-700">
                    Customer Source
                </label>

                <select
                    wire:model="jobCard.source"
                    class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                >
                    <option value="Walk-in">Walk-in</option>
                    <option value="Insurance">Insurance</option>
                    <option value="Website">Website</option>
                    <option value="Google">Google</option>
                    <option value="Referral">Referral</option>
                    <option value="Repeat Customer">Repeat Customer</option>
                </select>
            </div>


            {{-- Odometer --}}
            <div>
                <label class="text-sm font-medium text-slate-700">
                    Odometer Reading
                </label>

                <input
                    type="number"
                    min="0"
                    wire:model="jobCard.odometer"
                    placeholder="Enter KM"
                    class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                >

                @error('jobCard.odometer')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>


            {{-- Arrival Date --}}
            <div>
                <label class="text-sm font-medium text-slate-700">
                    Arrival Date
                </label>

                <input
                    type="date"
                    wire:model="jobCard.arrival_date"
                    class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                >

                @error('jobCard.arrival_date')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>


            {{-- Arrival Time --}}
            <div>
                <label class="text-sm font-medium text-slate-700">
                    Arrival Time
                </label>

                <input
                    type="time"
                    wire:model="jobCard.arrival_time"
                    class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                >

                @error('jobCard.arrival_time')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>


            {{-- Expected Delivery --}}
            <div>
                <label class="text-sm font-medium text-slate-700">
                    Expected Delivery
                </label>

                <input
                    type="date"
                    wire:model="jobCard.expected_delivery"
                    class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                >

                @error('jobCard.expected_delivery')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>


            {{-- Delivery Time --}}
            <div>
                <label class="text-sm font-medium text-slate-700">
                    Delivery Time
                </label>

                <input
                    type="time"
                    wire:model="jobCard.delivery_time"
                    class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                >

                @error('jobCard.delivery_time')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>


            {{-- Fuel --}}
            <div>
                <label class="text-sm font-medium text-slate-700">
                    Fuel Level
                </label>

                <select
                    wire:model="jobCard.fuel_level"
                    class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                >
                    <option value="Empty">Empty</option>
                    <option value="Quarter">Quarter</option>
                    <option value="Half">Half</option>
                    <option value="Three Quarter">Three Quarter</option>
                    <option value="Full">Full</option>
                </select>
            </div>

        </div>

    </div>


    {{-- Insurance --}}
    <div class="rounded-xl border border-slate-200 bg-white">

        <div class="border-b border-slate-200 px-5 py-4">

            <div class="flex items-center justify-between gap-4">

                <div>
                    <h2 class="font-semibold text-slate-900">
                        Insurance
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Add insurance details if this vehicle is being handled under insurance
                    </p>
                </div>

                <label class="inline-flex cursor-pointer items-center gap-3">

                    <span class="text-sm font-medium text-slate-600">
                        Insurance Job
                    </span>

                    <input
                        type="checkbox"
                        wire:model.live="jobCard.insurance"
                        class="h-5 w-5 rounded border-slate-200 text-hitek-red focus:ring-hitek-red"
                    >

                </label>

            </div>

        </div>


        @if ($jobCard['insurance'])

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2 xl:grid-cols-3">

                {{-- Insurance Company --}}
                <div>

                    <label class="text-sm font-medium text-slate-700">
                        Insurance Company
                    </label>

                    <input
                        type="text"
                        wire:model="jobCard.insurance_company"
                        placeholder="Enter insurance company"
                        class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                </div>


                {{-- Policy Number --}}
                <div>

                    <label class="text-sm font-medium text-slate-700">
                        Policy Number
                    </label>

                    <input
                        type="text"
                        wire:model="jobCard.policy_number"
                        placeholder="Enter policy number"
                        class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                </div>


                {{-- Claim Number --}}
                <div>

                    <label class="text-sm font-medium text-slate-700">
                        Claim Number
                    </label>

                    <input
                        type="text"
                        wire:model="jobCard.claim_number"
                        placeholder="Enter claim number"
                        class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                </div>

            </div>

        @else

            <div class="p-5">

                <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 px-4 py-5 text-center">

                    <div class="text-2xl">
                        🛡️
                    </div>

                    <p class="mt-2 text-sm font-medium text-slate-700">
                        Regular Customer Job
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Enable "Insurance Job" if this vehicle is being handled under an insurance claim.
                    </p>

                </div>

            </div>

        @endif

    </div>


    {{-- Customer Concerns --}}
    <div class="rounded-xl border border-slate-200 bg-white">

        <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="font-semibold text-slate-900">
                    Customer Concerns
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Record what the customer wants checked or repaired
                </p>
            </div>

            <button
                type="button"
                class="rounded-lg bg-hitek-red px-3 py-1.5 text-xs font-semibold text-white hover:bg-hitek-red-hover"
            >
                + Add Concern
            </button>

        </div>


        <div class="divide-y divide-slate-100">

            @foreach ($concerns as $concern)

                <div class="flex items-start gap-4 px-5 py-4">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-50 text-sm font-bold text-hitek-red">
                        {{ $loop->iteration }}
                    </div>

                    <div class="min-w-0 flex-1">

                        <div class="flex flex-wrap items-center gap-2">

                            <p class="font-medium text-slate-800">
                                {{ $concern['description'] }}
                            </p>

                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                {{ $concern['type'] }}
                            </span>

                        </div>

                    </div>

                    <button
                        type="button"
                        class="text-xs font-semibold text-slate-400 hover:text-red-600"
                    >
                        Remove
                    </button>

                </div>

            @endforeach

        </div>


        <div class="border-t border-slate-200 bg-slate-50 px-5 py-4">

            <label class="text-sm font-medium text-slate-700">
                Additional Remarks
            </label>

            <textarea
                rows="3"
                placeholder="Add any additional customer instructions or remarks..."
                class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
            >{{ $jobCard['remarks'] }}</textarea>

        </div>

    </div>


    {{-- Bottom Actions --}}
    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">

        <a
            href="{{ route('job-cards.index') }}"
            class="text-center text-sm font-semibold text-slate-500 hover:text-slate-800 sm:text-left"
        >
            Cancel
        </a>

        <div class="flex flex-col gap-2 sm:flex-row">

            <button
                type="button"
                class="rounded-lg border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
            >
                Save as Draft
            </button>

            <button
                type="button"
                class="rounded-lg bg-hitek-red px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-hitek-red-hover"
            >
                Save & Continue to Tasks
            </button>

        </div>

    </div>

    {{-- New Customer Modal --}}
    @if ($showCustomerModal)

        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4"
            wire:click.self="closeCustomerModal"
        >

            <div class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">

                {{-- Modal Header --}}
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">

                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">
                            Add New Customer
                        </h3>

                        <p class="mt-1 text-xs text-slate-500">
                            Enter customer details to create a new customer.
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="closeCustomerModal"
                        class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-700"
                    >
                        ✕
                    </button>

                </div>


                {{-- Modal Body --}}
                <div class="max-h-[75vh] overflow-y-auto px-6 py-5">

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

                </div>


                {{-- Modal Footer --}}
                <div class="flex items-center justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">

                    <button
                        type="button"
                        wire:click="closeCustomerModal"
                        class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100"
                    >
                        Cancel
                    </button>

                    <button
                        type="button"
                        wire:click="createCustomer"
                        wire:loading.attr="disabled"
                        wire:target="createCustomer"
                        class="rounded-lg bg-hitek-red px-5 py-2 text-sm font-semibold text-white hover:bg-hitek-red-hover disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <span wire:loading.remove wire:target="createCustomer">
                            Add Customer
                        </span>

                        <span wire:loading wire:target="createCustomer">
                            Adding...
                        </span>
                    </button>

                </div>

            </div>

        </div>

    @endif

    {{-- Add Vehicle Modal --}}
    @if ($showVehicleModal)

        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4"
            wire:click.self="closeVehicleModal"
        >

            <div class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">

                {{-- Modal Header --}}
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">

                    <div>
                        <h2 class="text-lg font-bold text-slate-900">
                            Add New Vehicle
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Add a vehicle for {{ $customer['name'] }}
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="closeVehicleModal"
                        class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-700"
                    >
                        ×
                    </button>

                </div>


                {{-- Modal Body --}}
                <div class="max-h-[70vh] overflow-y-auto p-6">

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

                </div>


                {{-- Modal Footer --}}
                <div class="flex items-center justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">

                    <button
                        type="button"
                        wire:click="closeVehicleModal"
                        class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                    >
                        Cancel
                    </button>

                    <button
                        type="button"
                        wire:click="createVehicle"
                        wire:loading.attr="disabled"
                        wire:target="createVehicle"
                        class="rounded-lg bg-hitek-red px-5 py-2 text-sm font-semibold text-white hover:bg-hitek-red-hover disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <span wire:loading.remove wire:target="createVehicle">
                            Add Vehicle
                        </span>

                        <span wire:loading wire:target="createVehicle">
                            Adding...
                        </span>
                    </button>

                </div>

            </div>

        </div>

    @endif

</div>