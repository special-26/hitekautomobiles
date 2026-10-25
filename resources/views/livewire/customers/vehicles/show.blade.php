<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">
            <a
                href="{{ route('customers.show', $vehicle->customer) }}"
                wire:navigate
                class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50"
            >
                ← Back
            </a>

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Vehicle Profile
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $vehicle->customer->name }}
                </p>
            </div>
        </div>

        <div class="flex gap-2">
            <a
                href="{{ route('customers.edit', $vehicle->customer) }}"
                wire:navigate
                class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
            >
                Edit Customer
            </a>

            <a
                href="{{ route('vehicles.edit', $vehicle) }}"
                wire:navigate
                class="rounded-lg bg-hitek-red px-4 py-2 text-sm font-semibold text-white hover:bg-hitek-red-hover"
            >
                Edit Vehicle
            </a>
        </div>

    </div>


    {{-- Vehicle Header Card --}}
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

            <div class="flex items-center gap-4">

                <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-slate-100 text-2xl">
                    🚗
                </div>

                <div>
                    <div class="flex flex-wrap items-center gap-3">

                        <h2 class="text-2xl font-bold text-slate-900">
                            {{ $vehicle->registration_number }}
                        </h2>

                        @if($vehicle->is_active)
                            <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                Active
                            </span>
                        @else
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">
                                Inactive
                            </span>
                        @endif

                    </div>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ $vehicle->make }} {{ $vehicle->model }}
                        @if($vehicle->variant)
                            · {{ $vehicle->variant }}
                        @endif
                    </p>

                    <p class="mt-1 text-sm text-slate-400">
                        Owner:
                        <span class="font-medium text-slate-600">
                            {{ $vehicle->customer->name }}
                        </span>
                    </p>
                </div>

            </div>

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">

                <div>
                    <p class="text-xs font-medium text-slate-400">
                        Fuel
                    </p>
                    <p class="mt-1 text-sm font-semibold text-slate-800">
                        {{ $vehicle->fuel_type ?: '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium text-slate-400">
                        Year
                    </p>
                    <p class="mt-1 text-sm font-semibold text-slate-800">
                        {{ $vehicle->manufacturing_year ?: '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium text-slate-400">
                        Odometer
                    </p>
                    <p class="mt-1 text-sm font-semibold text-slate-800">
                        {{ $vehicle->current_odometer ? number_format($vehicle->current_odometer) . ' km' : '—' }}
                    </p>
                </div>

            </div>

        </div>

    </div>


    {{-- Service / Insurance Overview --}}
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">
                Last Service
            </p>

            <p class="mt-2 text-xl font-bold text-slate-900">
                {{ $vehicle->last_service_at?->format('d M Y') ?? 'Not available' }}
            </p>

            <p class="mt-1 text-xs text-slate-400">
                Previous service date
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">
                Next Service
            </p>

            <p class="mt-2 text-xl font-bold text-slate-900">
                {{ $vehicle->next_service_at?->format('d M Y') ?? 'Not scheduled' }}
            </p>

            @if($vehicle->next_service_at)
                @if($vehicle->next_service_at->isPast())
                    <p class="mt-1 text-xs font-medium text-red-600">
                        Service overdue
                    </p>
                @elseif($vehicle->next_service_at->isToday())
                    <p class="mt-1 text-xs font-medium text-amber-600">
                        Service due today
                    </p>
                @else
                    <p class="mt-1 text-xs text-slate-400">
                        Upcoming service
                    </p>
                @endif
            @endif
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">
                Insurance Expiry
            </p>

            <p class="mt-2 text-xl font-bold text-slate-900">
                {{ $vehicle->insurance_expiry_at?->format('d M Y') ?? 'Not available' }}
            </p>

            @if($vehicle->insurance_expiry_at)
                @if($vehicle->insurance_expiry_at->isPast())
                    <p class="mt-1 text-xs font-medium text-red-600">
                        Insurance expired
                    </p>
                @elseif($vehicle->insurance_expiry_at->diffInDays(today()) <= 30)
                    <p class="mt-1 text-xs font-medium text-amber-600">
                        Expiring soon
                    </p>
                @else
                    <p class="mt-1 text-xs text-slate-400">
                        Insurance active
                    </p>
                @endif
            @endif
        </div>

    </div>


    {{-- Vehicle Details --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-slate-900">
                Vehicle Details
            </h2>
        </div>

        <div class="grid grid-cols-1 gap-x-8 gap-y-5 p-6 sm:grid-cols-2 lg:grid-cols-3">

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Registration Number
                </p>
                <p class="mt-1 text-sm font-semibold text-slate-800">
                    {{ $vehicle->registration_number }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Make
                </p>
                <p class="mt-1 text-sm text-slate-800">
                    {{ $vehicle->make ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Model
                </p>
                <p class="mt-1 text-sm text-slate-800">
                    {{ $vehicle->model ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Variant
                </p>
                <p class="mt-1 text-sm text-slate-800">
                    {{ $vehicle->variant ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Fuel Type
                </p>
                <p class="mt-1 text-sm text-slate-800">
                    {{ $vehicle->fuel_type ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Manufacturing Year
                </p>
                <p class="mt-1 text-sm text-slate-800">
                    {{ $vehicle->manufacturing_year ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Color
                </p>
                <p class="mt-1 text-sm text-slate-800">
                    {{ $vehicle->color ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    VIN
                </p>
                <p class="mt-1 break-all text-sm text-slate-800">
                    {{ $vehicle->vin ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Engine Number
                </p>
                <p class="mt-1 break-all text-sm text-slate-800">
                    {{ $vehicle->engine_number ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Current Odometer
                </p>
                <p class="mt-1 text-sm text-slate-800">
                    {{ $vehicle->current_odometer ? number_format($vehicle->current_odometer) . ' km' : '—' }}
                </p>
            </div>

        </div>

    </div>


    {{-- Service History --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">

            <div>
                <h2 class="text-base font-semibold text-slate-900">
                    Service History
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    Previous and current job cards for this vehicle
                </p>
            </div>

            <a
                href="{{ route('job-cards.create', [
                    'customer' => $vehicle->customer_id,
                    'vehicle' => $vehicle->id,
                ]) }}"
                wire:navigate
                class="rounded-lg bg-hitek-red px-4 py-2 text-sm font-semibold text-white hover:bg-hitek-red-hover"
            >
                + New Job Card
            </a>

        </div>

        @if($vehicle->jobCards->count())

            <div class="divide-y divide-slate-100">

                @foreach($vehicle->jobCards as $jobCard)

                    <div class="flex flex-col gap-3 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <p class="text-sm font-semibold text-slate-900">
                                {{ $jobCard->job_card_number ?? 'Job Card #' . $jobCard->id }}
                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                {{ $jobCard->created_at?->format('d M Y, h:i A') }}
                            </p>
                        </div>

                        <div class="flex items-center gap-4">

                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                {{ ucfirst(str_replace('_', ' ', $jobCard->status ?? 'Unknown')) }}
                            </span>

                            <span class="text-sm font-semibold text-slate-800">
                                ₹{{ number_format((float) ($jobCard->final_amount ?? $jobCard->total_amount ?? 0), 2) }}
                            </span>

                            @if(Route::has('job-cards.show'))
                                <a
                                    href="{{ route('job-cards.show', $jobCard) }}"
                                    wire:navigate
                                    class="text-sm font-semibold text-hitek-red hover:text-hitek-red-hover"
                                >
                                    View
                                </a>
                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="px-6 py-12 text-center">
                <p class="text-sm font-medium text-slate-500">
                    No service history found.
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    Job cards for this vehicle will appear here.
                </p>
            </div>

        @endif

    </div>

</div>