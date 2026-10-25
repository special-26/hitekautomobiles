<div class="space-y-6">

    {{-- Back --}}
    <div>
        <a
            href="{{ route('customers.index') }}"
            wire:navigate
            class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-hitek-red"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 19l-7-7 7-7"/>
            </svg>

            Customers
        </a>
    </div>


    {{-- Customer Header --}}
    <div class="rounded-xl border border-slate-200 bg-white p-5">

        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

            {{-- Customer Identity --}}
            <div class="flex min-w-0 items-center gap-4">

                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-slate-100 text-lg font-bold text-slate-600">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>

                <div class="min-w-0">

                    <div class="flex flex-wrap items-center gap-2">

                        <h1 class="text-xl font-bold text-slate-900">
                            {{ $customer->name }}
                        </h1>

                        @if($customer->is_active)
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-1 text-[11px] font-semibold text-emerald-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-1 text-[11px] font-semibold text-slate-500">
                                Inactive
                            </span>
                        @endif

                    </div>

                    <p class="mt-1 text-xs text-slate-400">
                        Customer Code:
                        <span class="font-semibold text-slate-600">
                            {{ $customer->customer_code }}
                        </span>
                    </p>

                </div>

            </div>


            {{-- Quick Actions --}}
            <div class="flex flex-wrap items-center gap-2">

                <a
                    href="{{ route('customers.edit', $customer) }}"
                    wire:navigate
                    class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-hitek-red hover:text-hitek-red"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 7.125L16.875 4.5"/>
                    </svg>

                    Edit Customer
                </a>

                @if($customer->phone)
                    <a
                        href="tel:{{ $customer->phone }}"
                        class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-hitek-red hover:text-hitek-red"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106a1.125 1.125 0 0 0-1.173.417l-.97 1.293a11.25 11.25 0 0 1-5.432-5.432l1.293-.97c.35-.263.51-.717.417-1.173L14.955 5.75a1.125 1.125 0 0 0-1.091-.852H12.5A2.25 2.25 0 0 0 10.25 7.15v2.25"/>
                        </svg>
                        Call
                    </a>
                @endif

                <button
                    type="button"
                    class="inline-flex items-center gap-2 rounded-lg bg-hitek-red px-3 py-2 text-xs font-semibold text-white transition hover:bg-hitek-red-hover"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 4v16m8-8H4"/>
                    </svg>
                    New Job Card
                </button>

            </div>

        </div>


        {{-- Contact Information --}}
        <div class="mt-5 grid grid-cols-2 gap-4 border-t border-slate-100 pt-5 md:grid-cols-4">

            <div>
                <p class="text-[11px] font-medium text-slate-400">
                    Phone
                </p>
                <p class="mt-1 text-sm font-semibold text-slate-700">
                    {{ $customer->phone ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-[11px] font-medium text-slate-400">
                    Email
                </p>
                <p class="mt-1 truncate text-sm font-semibold text-slate-700">
                    {{ $customer->email ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-[11px] font-medium text-slate-400">
                    Location
                </p>
                <p class="mt-1 text-sm font-semibold text-slate-700">
                    {{ $customer->city ?: '—' }}
                    @if($customer->state)
                        <span class="font-normal text-slate-400">
                            , {{ $customer->state }}
                        </span>
                    @endif
                </p>
            </div>

            <div>
                <p class="text-[11px] font-medium text-slate-400">
                    Customer Since
                </p>
                <p class="mt-1 text-sm font-semibold text-slate-700">
                    {{ $customer->created_at?->format('d M Y') ?? '—' }}
                </p>
            </div>

        </div>

    </div>

    {{-- CRM Overview --}}
    <div class="grid grid-cols-2 gap-3 md:grid-cols-4">

        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-[11px] font-medium text-slate-400">
                Vehicles
            </p>

            <p class="mt-2 text-2xl font-bold text-slate-900">
                {{ $summary['vehicles'] }}
            </p>
        </div>


        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-[11px] font-medium text-slate-400">
                Total Visits
            </p>

            <p class="mt-2 text-2xl font-bold text-slate-900">
                {{ $summary['total_visits'] }}
            </p>
        </div>


        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-[11px] font-medium text-slate-400">
                Completed Services
            </p>

            <p class="mt-2 text-2xl font-bold text-emerald-600">
                {{ $summary['completed_visits'] }}
            </p>
        </div>


        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <p class="text-[11px] font-medium text-slate-400">
                Total Service Value
            </p>

            <p class="mt-2 text-xl font-bold text-slate-900">
                ₹{{ number_format($summary['total_service_value'], 0) }}
            </p>

            @if($summary['last_visit'])
                <p class="mt-1 text-[11px] text-slate-400">
                    Last visit {{ $summary['last_visit']->format('d M Y') }}
                </p>
            @endif
        </div>

    </div>

    {{-- Vehicles --}}
    <div class="space-y-3">

        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-sm font-bold text-slate-900">
                    Vehicles
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    {{ $customer->vehicles->count() }} registered vehicle(s)
                </p>
            </div>

            <a
                href="{{ route('customers.vehicles.create', $customer) }}"
                wire:navigate
                class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-hitek-red hover:text-hitek-red"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 4v16m8-8H4"/>
                </svg>

                Add Vehicle
            </a>

        </div>


        @forelse($customer->vehicles as $vehicle)

            @php
                $serviceStatus = match (true) {
                    !$vehicle->next_service_at => [
                        'label' => 'Service Not Set',
                        'class' => 'bg-slate-100 text-slate-600',
                    ],
                    $vehicle->next_service_at->lt(today()) => [
                        'label' => 'Service Overdue',
                        'class' => 'bg-red-50 text-red-700',
                    ],
                    $vehicle->next_service_at->isToday() => [
                        'label' => 'Service Due Today',
                        'class' => 'bg-orange-50 text-orange-700',
                    ],
                    $vehicle->next_service_at->lte(today()->addDays(7)) => [
                        'label' => 'Service Upcoming',
                        'class' => 'bg-amber-50 text-amber-700',
                    ],
                    default => [
                        'label' => 'Service Scheduled',
                        'class' => 'bg-emerald-50 text-emerald-700',
                    ],
                };

                $insuranceStatus = match (true) {
                    !$vehicle->insurance_expiry_at => [
                        'label' => 'Insurance Not Set',
                        'class' => 'bg-slate-100 text-slate-600',
                    ],
                    $vehicle->insurance_expiry_at->lt(today()) => [
                        'label' => 'Insurance Expired',
                        'class' => 'bg-red-50 text-red-700',
                    ],
                    $vehicle->insurance_expiry_at->lte(today()->addDays(7)) => [
                        'label' => 'Insurance ≤ 7 Days',
                        'class' => 'bg-red-50 text-red-700',
                    ],
                    $vehicle->insurance_expiry_at->lte(today()->addDays(30)) => [
                        'label' => 'Insurance ≤ 30 Days',
                        'class' => 'bg-amber-50 text-amber-700',
                    ],
                    default => [
                        'label' => 'Insurance Active',
                        'class' => 'bg-emerald-50 text-emerald-700',
                    ],
                };
            @endphp


            <div class="rounded-xl border border-slate-200 bg-white p-5 transition hover:border-slate-300 hover:shadow-sm">

                {{-- Vehicle Header --}}
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                    <div class="flex items-center gap-3">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-slate-100">
                            <svg class="h-5 w-5 text-slate-500" fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 17h14M7 17V7h10v10M5 13h14M8 7l1.5-3h5L16 7M7 20h2m6 0h2"/>
                            </svg>
                        </div>

                        <div>
                            <div class="flex flex-wrap items-center gap-2">

                                <h3 class="text-sm font-bold text-slate-900">
                                    {{ $vehicle->registration_number }}
                                </h3>

                                <span class="rounded-full px-2 py-1 text-[10px] font-semibold {{ $serviceStatus['class'] }}">
                                    {{ $serviceStatus['label'] }}
                                </span>

                            </div>

                            <p class="mt-1 text-xs text-slate-500">
                                {{ $vehicle->make }}
                                {{ $vehicle->model }}

                                @if($vehicle->variant)
                                    · {{ $vehicle->variant }}
                                @endif
                            </p>
                        </div>

                    </div>


                    <span class="rounded-full px-2 py-1 text-[10px] font-semibold {{ $insuranceStatus['class'] }}">
                        {{ $insuranceStatus['label'] }}
                    </span>

                </div>


                {{-- Vehicle Details --}}
                <div class="mt-5 grid grid-cols-2 gap-4 border-t border-slate-100 pt-4 sm:grid-cols-4">

                    <div>
                        <p class="text-[11px] text-slate-400">
                            Fuel Type
                        </p>

                        <p class="mt-1 text-xs font-semibold text-slate-700">
                            {{ $vehicle->fuel_type ?: '—' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-[11px] text-slate-400">
                            Odometer
                        </p>

                        <p class="mt-1 text-xs font-semibold text-slate-700">
                            {{ $vehicle->current_odometer ? number_format($vehicle->current_odometer) . ' km' : '—' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-[11px] text-slate-400">
                            Last Service
                        </p>

                        <p class="mt-1 text-xs font-semibold text-slate-700">
                            {{ $vehicle->last_service_at?->format('d M Y') ?? '—' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-[11px] text-slate-400">
                            Next Service
                        </p>

                        <p class="mt-1 text-xs font-semibold text-slate-700">
                            {{ $vehicle->next_service_at?->format('d M Y') ?? '—' }}
                        </p>
                    </div>

                </div>


                {{-- Insurance --}}
                <div class="mt-4 rounded-lg bg-slate-50 px-4 py-3">

                    <div class="flex flex-wrap items-center justify-between gap-3">

                        <div>
                            <p class="text-[11px] text-slate-400">
                                Insurance Expiry
                            </p>

                            <p class="mt-1 text-xs font-semibold text-slate-700">
                                {{ $vehicle->insurance_expiry_at?->format('d M Y') ?? 'Not available' }}
                            </p>
                        </div>

                        <a
                            href="{{ route('vehicles.show', $vehicle) }}"
                            wire:navigate
                            type="button"
                            class="text-xs font-semibold text-hitek-red hover:text-hitek-red-hover"
                        >
                            View Vehicle
                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="rounded-xl border border-dashed border-slate-300 bg-white px-6 py-10 text-center">

                <p class="text-sm font-semibold text-slate-700">
                    No vehicles registered
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    Add a vehicle to start tracking service history.
                </p>

            </div>

        @endforelse

    </div>

    {{-- Service History --}}
    <div class="space-y-3">

        <div>
            <h2 class="text-sm font-bold text-slate-900">
                Service History
            </h2>

            <p class="mt-1 text-xs text-slate-400">
                Previous and current workshop visits
            </p>
        </div>


        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            @forelse($customer->jobCards as $jobCard)

                <div class="border-b border-slate-100 px-5 py-4 last:border-b-0">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                        {{-- Job Card --}}
                        <div class="min-w-0">

                            <div class="flex flex-wrap items-center gap-2">

                                <span class="text-sm font-bold text-slate-900">
                                    {{ $jobCard->job_card_number ?? 'JC-' . $jobCard->id }}
                                </span>

                                <span class="rounded-full bg-slate-100 px-2 py-1 text-[10px] font-semibold uppercase text-slate-600">
                                    {{ str_replace('_', ' ', $jobCard->status) }}
                                </span>

                            </div>

                            <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-400">

                                <span>
                                    {{ $jobCard->vehicle?->registration_number ?? 'Vehicle —' }}
                                </span>

                                <span>·</span>

                                <span>
                                    {{ $jobCard->created_at?->format('d M Y') }}
                                </span>

                            </div>

                        </div>


                        {{-- Amount / Action --}}
                        <div class="flex items-center justify-between gap-4 sm:justify-end">

                            <div class="text-right">
                                <p class="text-[11px] text-slate-400">
                                    Job Value
                                </p>

                                <p class="text-sm font-bold text-slate-800">
                                    ₹{{ number_format((float) ($jobCard->final_amount ?? $jobCard->total_amount ?? 0), 2) }}
                                </p>
                            </div>

                            <a
                                href="{{ route('job-cards.show', $jobCard) }}"
                                wire:navigate
                                class="inline-flex items-center gap-1 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-hitek-red hover:text-hitek-red"
                            >
                                View

                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m9 5 7 7-7 7"/>
                                </svg>
                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <div class="px-6 py-10 text-center">

                    <p class="text-sm font-semibold text-slate-700">
                        No service history
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        This customer has no job cards yet.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>