<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-xl font-bold text-slate-900">
                Customers
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage customers and their service history.
            </p>
        </div>

        <a
            href="#"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-hitek-red-hover"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 4v16m8-8H4"/>
            </svg>

            Add Customer
        </a>

    </div>

     {{-- CRM Summary --}}
    <div class="grid grid-cols-2 gap-3 md:grid-cols-4 xl:grid-cols-7">

        {{-- All Customers --}}
        <button
            type="button"
            wire:click="setFilter('')"
            class="rounded-xl border bg-white p-4 text-left transition
                {{ $filter === ''
                    ? 'border-hitek-red ring-2 ring-hitek-red/10'
                    : 'border-slate-200 hover:border-slate-300 hover:shadow-sm' }}"
        >
            <p class="text-xs font-semibold text-slate-500">
                All Customers
            </p>

            <p class="mt-2 text-2xl font-bold text-slate-900">
                {{ number_format($summary['all']) }}
            </p>

            <p class="mt-1 text-[11px] text-slate-400">
                Total customers
            </p>
        </button>


        {{-- Service Upcoming --}}
        <button
            type="button"
            wire:click="setFilter('service_upcoming')"
            class="rounded-xl border bg-white p-4 text-left transition
                {{ $filter === 'service_upcoming'
                    ? 'border-amber-400 ring-2 ring-amber-400/10'
                    : 'border-slate-200 hover:border-slate-300 hover:shadow-sm' }}"
        >
            <p class="text-xs font-semibold text-slate-500">
                Service Upcoming
            </p>

            <p class="mt-2 text-2xl font-bold text-amber-500">
                {{ number_format($summary['service_upcoming']) }}
            </p>

            <p class="mt-1 text-[11px] text-slate-400">
                Next 7 days
            </p>
        </button>


        {{-- Service Due --}}
        <button
            type="button"
            wire:click="setFilter('service_due')"
            class="rounded-xl border bg-white p-4 text-left transition
                {{ $filter === 'service_due'
                    ? 'border-orange-400 ring-2 ring-orange-400/10'
                    : 'border-slate-200 hover:border-slate-300 hover:shadow-sm' }}"
        >
            <p class="text-xs font-semibold text-slate-500">
                Service Due
            </p>

            <p class="mt-2 text-2xl font-bold text-orange-500">
                {{ number_format($summary['service_due']) }}
            </p>

            <p class="mt-1 text-[11px] text-slate-400">
                Due today
            </p>
        </button>


        {{-- Service Overdue --}}
        <button
            type="button"
            wire:click="setFilter('service_overdue')"
            class="rounded-xl border bg-white p-4 text-left transition
                {{ $filter === 'service_overdue'
                    ? 'border-red-400 ring-2 ring-red-400/10'
                    : 'border-slate-200 hover:border-slate-300 hover:shadow-sm' }}"
        >
            <p class="text-xs font-semibold text-slate-500">
                Service Overdue
            </p>

            <p class="mt-2 text-2xl font-bold text-red-500">
                {{ number_format($summary['service_overdue']) }}
            </p>

            <p class="mt-1 text-[11px] text-slate-400">
                Needs attention
            </p>
        </button>


        {{-- Insurance 7 Days --}}
        <button
            type="button"
            wire:click="setFilter('insurance_7_days')"
            class="rounded-xl border bg-white p-4 text-left transition
                {{ $filter === 'insurance_7_days'
                    ? 'border-red-400 ring-2 ring-red-400/10'
                    : 'border-slate-200 hover:border-slate-300 hover:shadow-sm' }}"
        >
            <p class="text-xs font-semibold text-slate-500">
                Insurance 7 Days
            </p>

            <p class="mt-2 text-2xl font-bold text-red-500">
                {{ number_format($summary['insurance_7_days']) }}
            </p>

            <p class="mt-1 text-[11px] text-slate-400">
                Expiring soon
            </p>
        </button>


        {{-- Insurance 30 Days --}}
        <button
            type="button"
            wire:click="setFilter('insurance_30_days')"
            class="rounded-xl border bg-white p-4 text-left transition
                {{ $filter === 'insurance_30_days'
                    ? 'border-indigo-400 ring-2 ring-indigo-400/10'
                    : 'border-slate-200 hover:border-slate-300 hover:shadow-sm' }}"
        >
            <p class="text-xs font-semibold text-slate-500">
                Insurance 30 Days
            </p>

            <p class="mt-2 text-2xl font-bold text-indigo-500">
                {{ number_format($summary['insurance_30_days']) }}
            </p>

            <p class="mt-1 text-[11px] text-slate-400">
                Expiring soon
            </p>
        </button>


        {{-- Insurance Expired --}}
        <button
            type="button"
            wire:click="setFilter('insurance_expired')"
            class="rounded-xl border bg-white p-4 text-left transition
                {{ $filter === 'insurance_expired'
                    ? 'border-slate-500 ring-2 ring-slate-400/10'
                    : 'border-slate-200 hover:border-slate-300 hover:shadow-sm' }}"
        >
            <p class="text-xs font-semibold text-slate-500">
                Insurance Expired
            </p>

            <p class="mt-2 text-2xl font-bold text-slate-600">
                {{ number_format($summary['insurance_expired']) }}
            </p>

            <p class="mt-1 text-[11px] text-slate-400">
                Needs attention
            </p>
        </button>

    </div>

    {{-- Search --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4 grid gap-4 sm:grid-cols-1 lg:grid-cols-2 w-full">

        <div class="relative max-w-xl flex items-center">

            <svg
                class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                />
            </svg>

            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search customer, phone, email, code or car number..."
                class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-hitek-red focus:bg-white focus:ring-2 focus:ring-hitek-red/10"
            >

        </div>

        {{-- From - to date --}}
        <div class="flex flex-wrap items-end justify-end gap-3">

            <div>
                <label class="mb-1 block text-[11px] font-medium text-slate-500">
                    From
                </label>

                <input
                    type="date"
                    wire:model.live="fromDate"
                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs text-slate-700 focus:border-hitek-red focus:ring-1 focus:ring-hitek-red"
                >
            </div>

            <div>
                <label class="mb-1 block text-[11px] font-medium text-slate-500">
                    To
                </label>

                <input
                    type="date"
                    wire:model.live="toDate"
                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs text-slate-700 focus:border-hitek-red focus:ring-1 focus:ring-hitek-red"
                >
            </div>

            @if($fromDate || $toDate)
                <button
                    type="button"
                    wire:click="applyDateFilter"
                    class="rounded-lg bg-hitek-red px-3 py-2 text-xs font-semibold text-white hover:bg-hitek-red-hover"
                >
                    Apply
                </button>

                <button
                    type="button"
                    wire:click="clearDateFilter"
                    class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50"
                >
                    Clear
                </button>
                <button
                    type="button"
                    wire:click="export"
                    class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v12m0 0 4-4m-4 4-4-4M5 21h14"/>
                    </svg>

                    Export Excel
                </button>
            @endif

        </div>
    </div>

    {{-- Alert after selecting customers --}}
    <div>
        @if(count($selectedCustomers) > 0 || $selectAllResults)
            <div class="mb-3 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 flex items-center justify-between gap-3">
                @if($customers->count() > 0)
                    <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-white px-4 py-2.5">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                wire:click="toggleSelectAll"
                                @checked($selectAll)
                                wire:key="select-all-{{ $selectAll ? 'checked' : 'unchecked' }}"
                                class="h-5 w-5 rounded border-slate-300 text-hitek-red focus:ring-hitek-red"
                            />

                            <span class="text-xs font-semibold text-slate-600">
                                Select all on this page
                            </span>
                        </label>
                    </div>
                @endif

                @if($selectAllResults)

                    <div class="flex flex-wrap items-center justify-between gap-3">

                        <div class="text-sm font-semibold text-blue-900">
                            All {{ number_format($customers->total()) }} matching customers selected.
                        </div>

                        <div class="flex items-center gap-3">

                            <button
                                type="button"
                                wire:click="exportSelected"
                                class="rounded-lg bg-hitek-red px-4 py-2 text-sm font-semibold text-white hover:bg-hitek-red-hover"
                            >
                                Export Selected
                            </button>

                            <button
                                type="button"
                                wire:click="clearSelection"
                                class="text-sm font-medium text-slate-600 hover:underline"
                            >
                                Clear
                            </button>

                        </div>

                    </div>

                @else

                    <div class="flex flex-wrap items-center gap-3">

                        <span class="text-sm font-semibold text-blue-900">
                            {{ count($selectedCustomers) }} selected
                        </span>

                        @if($selectAll && $customers->total() > $customers->count())

                            <button
                                type="button"
                                wire:click="selectAllMatchingResults"
                                class="text-sm font-semibold text-blue-700 hover:underline"
                            >
                                Select all {{ number_format($customers->total()) }} matching customers
                            </button>

                        @endif

                        <button
                            type="button"
                            wire:click="clearSelection"
                            class="text-sm text-slate-100 bg-gray-800 px-3 py-1 rounded-lg hover:bg-gray-700" 
                        >
                            Clear
                        </button>

                        <button
                            type="button"
                            wire:click="exportSelected"
                            class="ml-auto rounded-lg bg-hitek-red px-4 py-2 text-sm font-semibold text-white hover:bg-hitek-red-hover"
                        >
                            Export Selected
                        </button>

                    </div>

                @endif

            </div>
        @endif
    </div>

    {{-- Customer List --}}
    <div class="space-y-2">

        @forelse($customers as $customer)

            <div class="rounded-xl border border-slate-200 bg-white px-4 py-3 transition hover:border-slate-300 hover:shadow-sm">

                <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">

                    <x-checkbox
                        color="red"
                        value="{{ $customer->id }}"
                        wire:model.live="selectedCustomers"
                        class="checkbox checkbox-sm"
                    />

                    {{-- Customer --}}
                    <div class="flex min-w-0 items-center gap-3 lg:w-[30%]">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-600">
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </div>

                        <div class="min-w-0">

                            <div class="flex items-center gap-2">

                                <p class="truncate text-sm font-bold text-slate-900">
                                    {{ $customer->name }}
                                </p>

                                @if($customer->is_active)
                                    <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-emerald-500"></span>
                                @else
                                    <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-slate-400"></span>
                                @endif

                            </div>

                            <p class="mt-0.5 text-xs text-slate-400">
                                {{ $customer->customer_code }}
                            </p>

                        </div>

                    </div>

                    {{-- Contact --}}
                    <div class="grid grid-cols-2 gap-x-6 gap-y-1 text-xs sm:grid-cols-3 lg:w-[45%]">

                        <div>
                            <span class="text-slate-400">Phone</span>
                            <p class="font-medium text-slate-700">
                                {{ $customer->phone ?: '—' }}
                            </p>
                        </div>

                        <div>
                            <span class="text-slate-400">Location</span>
                            <p class="truncate font-medium text-slate-700">
                                {{ $customer->city ?: '—' }}
                            </p>
                        </div>

                        <div>
                            <span class="text-slate-400">Activity</span>
                            <p class="font-medium text-slate-700">
                                {{ $customer->vehicles_count }} Vehicles
                                <span class="text-slate-300">·</span>
                                {{ $customer->job_cards_count }} Jobs
                            </p>
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="flex shrink-0 items-center gap-5 lg:w-[25%] lg:justify-end">

                        <div class="hidden text-right sm:block">
                            <p class="text-[11px] text-slate-400">
                                Customer Since
                            </p>

                            <p class="text-xs font-medium text-slate-600">
                                {{ $customer->created_at?->format('d M Y') ?? '—' }}
                            </p>
                        </div>

                        <a
                            href="{{ route('customers.show', $customer) }}"
                            wire:navigate
                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-hitek-red hover:text-hitek-red"
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

            <div class="rounded-xl border border-dashed border-slate-300 bg-white px-6 py-10 text-center">

                <p class="text-sm font-semibold text-slate-700">
                    No customers found
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    Try a different name, phone, customer code, or car number.
                </p>

            </div>

        @endforelse

    </div>


    {{-- Pagination --}}
    @if($customers->hasPages())
        <div>
            {{ $customers->links() }}
        </div>
    @endif

</div>