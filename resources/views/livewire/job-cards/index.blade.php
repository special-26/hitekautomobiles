<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Job Cards
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Manage workshop jobs, vehicles, customers and service status.
            </p>
        </div>

        <a
            href="{{ route('job-cards.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-hitek-red-hover"
        >
            <svg
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 5v14M5 12h14"
                />
            </svg>

            New Job Card
        </a>

    </div>


    {{-- Summary Cards --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-6">

        {{-- Under Servicing --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Under Servicing
                </p>

                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.42 15.17 17.25 9.34a2.25 2.25 0 0 0-3.18-3.18l-5.83 5.83a2.25 2.25 0 0 0-.55 2.31l.4 1.2-1.59 1.59a.75.75 0 1 0 1.06 1.06l1.59-1.59 1.2.4a2.25 2.25 0 0 0 2.31-.55Z"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ number_format($summary['under_servicing']) }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                Currently in workshop
            </p>
        </div>


        {{-- Next Day Delivery --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Next Day Delivery
                </p>

                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3M4 11h16M5 21h14a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1Z"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ number_format($summary['next_day_delivery']) }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                Delivery scheduled tomorrow
            </p>
        </div>


        {{-- Upcoming Delivery --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Upcoming Delivery
                </p>

                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ number_format($summary['upcoming_delivery']) }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                Delivery after tomorrow
            </p>
        </div>


        {{-- Ready for Delivery --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Ready for Delivery
                </p>

                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m5 12 4 4L19 6"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ number_format($summary['ready_for_delivery']) }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                Vehicle ready for delivery
            </p>
        </div>


        {{-- Payment Processing --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Payment Processing
                </p>

                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-hitek-red">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 10h18M7 15h2m2 0h2m2 0h2M5 6h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Z"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ number_format($summary['payment_processing']) }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                Payment pending
            </p>
        </div>


        {{-- Completed Service --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Completed Service
                </p>

                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ number_format($summary['completed_service']) }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                Completed services
            </p>
        </div>

    </div>


    {{-- Job Card Table --}}
    <div class="overflow-hidden rounded-xl">

        {{-- Toolbar --}}
        <div class="bg-white border border-slate-200 rounded-xl p-4 mb-4">

            <div class="flex flex-col gap-3 xl:flex-row xl:items-center xl:justify-between">

                {{-- Search --}}
                <div class="relative w-full xl:max-w-md">

                    <svg
                        class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                        />
                    </svg>

                    <input
                        type="text"
                        wire:model.live.debounce.400ms="search"
                        placeholder="Search job card, vehicle or customer..."
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    />

                </div>


                {{-- Filters --}}
                <div class="flex flex-wrap gap-2">

                    {{-- Status Button --}}
                    <div class="relative" x-data="{ open: false }">

                        <button
                            type="button"
                            @click="open = !open"
                            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-xs font-medium text-slate-600 hover:bg-slate-50"
                        >
                            Status

                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m6 9 6 6 6-6"/>
                            </svg>
                        </button>

                        <div
                            x-show="open"
                            @click.outside="open = false"
                            x-cloak
                            class="absolute right-0 z-20 mt-2 w-44 rounded-lg border border-slate-200 bg-white p-1 shadow-lg"
                        >

                            <button
                                type="button"
                                wire:click="$set('status', '')"
                                @click="open = false"
                                class="block w-full rounded-md px-3 py-2 text-left text-xs text-slate-600 hover:bg-slate-50"
                            >
                                All Statuses
                            </button>

                            <button
                                type="button"
                                wire:click="$set('status', 'draft')"
                                @click="open = false"
                                class="block w-full rounded-md px-3 py-2 text-left text-xs text-slate-600 hover:bg-slate-50"
                            >
                                Draft
                            </button>

                            <button
                                type="button"
                                wire:click="$set('status', 'pending')"
                                @click="open = false"
                                class="block w-full rounded-md px-3 py-2 text-left text-xs text-slate-600 hover:bg-slate-50"
                            >
                                Pending
                            </button>

                            <button
                                type="button"
                                wire:click="$set('status', 'in_progress')"
                                @click="open = false"
                                class="block w-full rounded-md px-3 py-2 text-left text-xs text-slate-600 hover:bg-slate-50"
                            >
                                Under Service
                            </button>

                            <button
                                type="button"
                                wire:click="$set('status', 'completed')"
                                @click="open = false"
                                class="block w-full rounded-md px-3 py-2 text-left text-xs text-slate-600 hover:bg-slate-50"
                            >
                                Completed
                            </button>

                            <button
                                type="button"
                                wire:click="$set('status', 'cancelled')"
                                @click="open = false"
                                class="block w-full rounded-md px-3 py-2 text-left text-xs text-slate-600 hover:bg-slate-50"
                            >
                                Cancelled
                            </button>

                        </div>

                    </div>

                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-xs font-medium text-slate-600 hover:bg-slate-50"
                    >
                        Advisor

                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>


                    {{-- Date Filter --}}
                    <div class="relative" x-data="{ open: false }">
                        <button
                            type="button"
                            @click="open = !open"
                            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-xs font-medium text-slate-600 hover:bg-slate-50"
                        >
                            Date

                            <svg
                                class="h-3.5 w-3.5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m6 9 6 6 6-6"
                                />
                            </svg>
                        </button>

                        <div
                            x-show="open"
                            @click.outside="open = false"
                            x-cloak
                            class="absolute right-0 z-20 mt-2 w-44 rounded-lg border border-slate-200 bg-white p-1 shadow-lg"
                        >

                            <button
                                type="button"
                                wire:click="$set('dateFilter', '')"
                                @click="open = false"
                                class="block w-full rounded-md px-3 py-2 text-left text-xs text-slate-600 hover:bg-slate-50"
                            >
                                All Dates
                            </button>

                            <button
                                type="button"
                                wire:click="$set('dateFilter', 'today')"
                                @click="open = false"
                                class="block w-full rounded-md px-3 py-2 text-left text-xs text-slate-600 hover:bg-slate-50"
                            >
                                Today
                            </button>

                            <button
                                type="button"
                                wire:click="$set('dateFilter', 'yesterday')"
                                @click="open = false"
                                class="block w-full rounded-md px-3 py-2 text-left text-xs text-slate-600 hover:bg-slate-50"
                            >
                                Yesterday
                            </button>

                            <button
                                type="button"
                                wire:click="$set('dateFilter', 'last_7_days')"
                                @click="open = false"
                                class="block w-full rounded-md px-3 py-2 text-left text-xs text-slate-600 hover:bg-slate-50"
                            >
                                Last 7 Days
                            </button>

                            <button
                                type="button"
                                wire:click="$set('dateFilter', 'this_month')"
                                @click="open = false"
                                class="block w-full rounded-md px-3 py-2 text-left text-xs text-slate-600 hover:bg-slate-50"
                            >
                                This Month
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- List of Job Cards - Table --}}
        <div class="overflow-x-auto">

            {{-- Job Card Cards --}}
            <div class="space-y-4">

                @forelse($jobCards as $jobCard)

                    @php
                        $status = match ($jobCard->status) {
                            'draft' => [
                                'label' => 'Draft',
                                'class' => 'bg-slate-100 text-slate-600',
                                'dot' => 'bg-slate-400',
                                'border' => 'border-slate-200',
                            ],

                            'pending' => [
                                'label' => 'Pending',
                                'class' => 'bg-blue-50 text-blue-700',
                                'dot' => 'bg-blue-500',
                                'border' => 'border-blue-200',
                            ],

                            'in_progress' => [
                                'label' => 'Under Service',
                                'class' => 'bg-amber-50 text-amber-700',
                                'dot' => 'bg-amber-500',
                                'border' => 'border-amber-200',
                            ],

                            'ready' => [
                                'label' => 'Ready',
                                'class' => 'bg-emerald-50 text-emerald-700',
                                'dot' => 'bg-emerald-500',
                                'border' => 'border-emerald-200',
                            ],

                            'completed' => [
                                'label' => 'Completed',
                                'class' => 'bg-slate-100 text-slate-600',
                                'dot' => 'bg-slate-400',
                                'border' => 'border-slate-200',
                            ],

                            'cancelled' => [
                                'label' => 'Cancelled',
                                'class' => 'bg-red-50 text-red-700',
                                'dot' => 'bg-red-500',
                                'border' => 'border-red-200',
                            ],

                            default => [
                                'label' => ucwords(str_replace('_', ' ', $jobCard->status)),
                                'class' => 'bg-slate-100 text-slate-600',
                                'dot' => 'bg-slate-400',
                                'border' => 'border-slate-200',
                            ],
                        };
                    @endphp


                    <div
                        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:border-slate-300 hover:shadow-md"
                    >

                        {{-- ========================================================= --}}
                        {{-- TOP VEHICLE BAR --}}
                        {{-- ========================================================= --}}

                        <div class="flex flex-col gap-4 border-b border-slate-100 bg-slate-50/70 px-5 py-3 lg:flex-row lg:items-center lg:justify-between">

                            {{-- Vehicle --}}
                            <div class="flex min-w-0 items-center gap-4">

                                {{-- Status indicator --}}
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white shadow-sm ring-1 ring-slate-200">

                                    <span class="h-3 w-3 rounded-full {{ $status['dot'] }}"></span>

                                </div>


                                <div class="min-w-0">

                                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1">

                                        <span class="text-base font-bold text-slate-900">
                                            {{ $jobCard->vehicle->registration_number }}
                                        </span>

                                        <span class="text-sm font-semibold text-hitek-red">
                                            {{ $jobCard->vehicle->city ?? '' }}
                                        </span>

                                    </div>

                                    <div class="mt-0.5 flex flex-wrap items-center gap-2 text-sm text-slate-600">

                                        <span class="font-semibold text-slate-800">
                                            {{ $jobCard->vehicle->make }}
                                            {{ $jobCard->vehicle->model }}
                                        </span>

                                        @if($jobCard->vehicle->fuel_type)
                                            <span class="text-slate-400">•</span>

                                            <span>
                                                {{ $jobCard->vehicle->fuel_type }}
                                            </span>
                                        @endif

                                    </div>

                                </div>

                            </div>


                            {{-- Vehicle Meta --}}
                            <div class="flex flex-wrap items-center gap-5 text-xs">

                                <div>
                                    <p class="text-slate-400">
                                        Odometer
                                    </p>

                                    <p class="font-bold text-slate-800">
                                        {{ $jobCard->odometer ? number_format($jobCard->odometer) : '—' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-slate-400">
                                        Job Card
                                    </p>

                                    <p class="font-bold text-slate-800">
                                        #{{ $jobCard->job_card_number }}
                                    </p>
                                </div>

                                <span class="hidden h-8 w-px bg-slate-200 sm:block"></span>

                                {{-- Status --}}
                                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold {{ $status['class'] }}">

                                    <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>

                                    {{ $status['label'] }}

                                </span>

                                {{-- Progress Circle --}}
                                <div class="relative h-16 w-16 shrink-0">

                                    @php
                                        $totalTasks = $jobCard->tasks->count();

                                        $completedTasks = $jobCard->tasks
                                            ->where('status', 'completed')
                                            ->count();

                                        $progress = $totalTasks > 0
                                            ? (int) round(($completedTasks / $totalTasks) * 100)
                                            : 0;

                                        $circumference = 2 * pi() * 26;
                                        $offset = $circumference - ($progress / 100) * $circumference;

                                        $progressColor = match (true) {
                                            $progress >= 100 => '#16a34a', // green
                                            $progress >= 75  => '#22c55e', // light green
                                            $progress >= 50  => '#3b82f6', // blue
                                            $progress >= 25  => '#f59e0b', // amber
                                            default          => '#94a3b8', // slate
                                        };
                                    @endphp

                                    <svg
                                        class="h-16 w-16 -rotate-90"
                                        viewBox="0 0 64 64"
                                    >
                                        {{-- Background --}}
                                        <circle
                                            cx="32"
                                            cy="32"
                                            r="26"
                                            fill="none"
                                            stroke="{{ $progressColor }}"
                                            stroke-width="5"
                                            stroke-linecap="round"
                                            stroke-dasharray="{{ $circumference }}"
                                            stroke-dashoffset="{{ $offset }}"
                                            transform="rotate(-90 32 32)"
                                        />

                                        {{-- Progress --}}
                                        <circle
                                            cx="32"
                                            cy="32"
                                            r="26"
                                            fill="none"
                                            stroke="#e2e8f0"
                                            stroke-width="5"
                                        />
                                    </svg>

                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-sm font-black text-slate-800">
                                            {{ $progress }}%
                                        </span>
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ========================================================= --}}
                        {{-- CUSTOMER / ADVISOR / SOURCE --}}
                        {{-- ========================================================= --}}

                        <div class="grid grid-cols-1 gap-5 px-5 py-5 md:grid-cols-3">

                            {{-- Customer --}}
                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                            d="M15 19a6 6 0 00-12 0m6-8a4 4 0 100-8 4 4 0 000 8zm9 8v-1a4 4 0 00-3-3.87M18 3.13a4 4 0 010 7.75" />
                                    </svg>
                                </div>

                                <div class="min-w-0">

                                    <p class="text-xs font-medium text-slate-400">
                                        Customer
                                    </p>

                                    <p class="mt-1 truncate text-sm font-bold text-slate-900">
                                        {{ $jobCard->customer->name }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-500">
                                        {{ $jobCard->customer->phone }}
                                    </p>

                                </div>

                            </div>


                            {{-- Advisor --}}
                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                            d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2m8-10a4 4 0 100-8 4 4 0 000 8zm6 3a4 4 0 00-3-3.87M18 8a3 3 0 110-6" />
                                    </svg>
                                </div>

                                <div>

                                    <p class="text-xs font-medium text-slate-400">
                                        Advisor
                                    </p>

                                    <p class="mt-1 text-sm font-bold text-slate-900">
                                        {{ $jobCard->advisor?->name ?? 'Not Assigned' }}
                                    </p>

                                </div>

                            </div>


                            {{-- Customer Source --}}
                            <div class="flex items-start gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                            d="M12 21a9 9 0 100-18 9 9 0 000 18zm0 0c2.5-2.5 3.5-5.5 3.5-9S14.5 5.5 12 3m0 18c-2.5-2.5-3.5-5.5-3.5-9S9.5 5.5 12 3m-8 9h16" />
                                    </svg>
                                </div>

                                <div>

                                    <p class="text-xs font-medium text-slate-400">
                                        Customer Source
                                    </p>

                                    <p class="mt-1 text-sm font-bold text-slate-900">
                                        {{ $jobCard->customer_source ?: 'Not Available' }}
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- ========================================================= --}}
                        {{-- FINANCIAL / JOB SUMMARY --}}
                        {{-- ========================================================= --}}

                        <div class="border-t border-slate-100 px-5 py-4">

                            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">

                                {{-- Job Card --}}
                                <div>
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        Job Card
                                    </p>

                                    <p class="mt-1 text-sm font-bold text-slate-900">
                                        #{{ $jobCard->job_card_number }}
                                    </p>
                                </div>


                                {{-- Estimate --}}
                                <div>
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        Estimate
                                    </p>

                                    <p class="mt-1 text-sm font-bold text-slate-900">
                                        {{ $jobCard->estimated_cost !== null
                                            ? '₹' . number_format((float) $jobCard->estimated_cost, 2)
                                            : '₹0.00'
                                        }}
                                    </p>
                                </div>


                                {{-- Invoice --}}
                                <div>
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        Invoice
                                    </p>

                                    <p class="mt-1 text-sm font-bold text-slate-900">
                                        Not Available
                                    </p>
                                </div>


                                {{-- Paid --}}
                                <div>
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        Paid
                                    </p>

                                    <p class="mt-1 text-sm font-bold text-emerald-600">
                                        ₹0.00
                                    </p>
                                </div>


                                {{-- Due --}}
                                <div>
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        Due
                                    </p>

                                    <p class="mt-1 text-sm font-bold text-red-600">
                                        ₹0.00
                                    </p>
                                </div>


                                {{-- Arrived --}}
                                <div>
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        Arrived
                                    </p>

                                    <p class="mt-1 text-sm font-bold text-slate-800">
                                        {{ $jobCard->arrived_at?->format('d M Y') ?? '—' }}
                                    </p>
                                </div>

                            </div>

                        </div>


                        {{-- ========================================================= --}}
                        {{-- ACTION BAR --}}
                        {{-- ========================================================= --}}

                        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 bg-slate-50/60 px-5 py-3">

                            <div class="flex flex-wrap items-center gap-2">

                                <a
                                    href="{{ route('job-cards.show', $jobCard->id) }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                                >
                                    <x-icon name="document-text" class="h-4 w-4" outline/>
                                    JC / Est
                                </a>

                                <a
                                    href="{{ route('job-cards.show', $jobCard->id) }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                                >
                                    <x-icon name="hand-thumb-up" class="h-4 w-4" outline/>
                                    Status
                                </a>

                                <a
                                    href="{{ route('job-cards.history', $jobCard->id) }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                                >
                                    <x-icon name="arrow-path" class="h-4 w-4" outline/>
                                    History
                                </a>

                                <a
                                    href="{{ route('job-cards.payments', $jobCard->id) }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                                >
                                    <x-icon name="currency-dollar" class="h-4 w-4" outline/>
                                    Payments
                                </a>

                                <a
                                    href="{{ route('job-cards.billing', $jobCard->id) }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                                >
                                    <x-icon name="printer" class="h-4 w-4" outline/>
                                    Invoice
                                </a>

                            </div>


                            <a
                                href="{{ route('job-cards.show', $jobCard->id) }}"
                                class="inline-flex items-center gap-2 rounded-lg bg-hitek-red px-4 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-hitek-red-hover"
                            >
                                View Job Card
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">

                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                    d="M9 17v-2a4 4 0 014-4h4m0 0V7m0 4l-3-3m3 3l3-3M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <p class="mt-4 text-sm font-semibold text-slate-700">
                            No job cards found
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            There are no job cards matching your current search.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>


        {{-- Pagination --}}
        <div class="flex flex-col gap-3 bg-white rounded-xl mt-3 border-t border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

            <p class="text-xs text-slate-500">
                Showing
                <span class="font-medium text-slate-700">
                    {{ $jobCards->firstItem() ?? 0 }}
                </span>
                to
                <span class="font-medium text-slate-700">
                    {{ $jobCards->lastItem() ?? 0 }}
                </span>
                of
                <span class="font-medium text-slate-700">
                    {{ $jobCards->total() }}
                </span>
                job cards
            </p>


            <div class="flex items-center gap-1">

                {{-- Previous --}}
                @if ($jobCards->onFirstPage())

                    <button
                        type="button"
                        disabled
                        class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs text-slate-400"
                    >
                        Previous
                    </button>

                @else

                    <button
                        type="button"
                        wire:click="previousPage"
                        wire:loading.attr="disabled"
                        class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs text-slate-600 hover:bg-slate-50"
                    >
                        Previous
                    </button>

                @endif


                {{-- Page Numbers --}}
                @foreach ($jobCards->getUrlRange(
                    max(1, $jobCards->currentPage() - 2),
                    min($jobCards->lastPage(), $jobCards->currentPage() + 2)
                ) as $page => $url)

                    @if ($page == $jobCards->currentPage())

                        <button
                            type="button"
                            class="rounded-lg bg-hitek-red px-3 py-1.5 text-xs font-semibold text-white"
                        >
                            {{ $page }}
                        </button>

                    @else

                        <button
                            type="button"
                            wire:click="gotoPage({{ $page }})"
                            wire:loading.attr="disabled"
                            class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs text-slate-600 hover:bg-slate-50"
                        >
                            {{ $page }}
                        </button>

                    @endif

                @endforeach


                {{-- Next --}}
                @if ($jobCards->hasMorePages())

                    <button
                        type="button"
                        wire:click="nextPage"
                        wire:loading.attr="disabled"
                        class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs text-slate-600 hover:bg-slate-50"
                    >
                        Next
                    </button>

                @else

                    <button
                        type="button"
                        disabled
                        class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs text-slate-400"
                    >
                        Next
                    </button>

                @endif

            </div>

        </div>

    </div>

</div>